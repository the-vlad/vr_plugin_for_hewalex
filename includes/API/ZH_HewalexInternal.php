<?php

namespace Develtio\ZonesHewalex\API;

use Develtio\ZonesHewalex\API\model\ZH_OfferForm;
use Develtio\ZonesHewalex\Synology\ZH_Synology;
use Mpdf\Mpdf;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_HewalexInternal
 */
class ZH_HewalexInternal
{
    /**
     * @var ZH_Synology
     */
    private $_storage = null;

    public function __construct()
    {
        $this->_storage = new ZH_Synology(ZH_Synology::OFFER_FORMS_PATH);
    }

    public function getGeneratedForm()
    {
        $offer_id = $_GET['id'];
        $report_hash = $_GET['reportHash'];

        $id_user = get_post_field( 'post_author', $offer_id );

        $form = array(
//            'offer_form_id' => 125 ?? null,
            'offer_form_id' => $offer_id ?? null,
            'offer_form_category' => get_field('category_calc', $offer_id) ?? '',
            'user_id' => get_user_meta($id_user, 'installation_group1_installation_user_id')[0],
            'contact' => json_decode(get_field('pcco_contact', $offer_id), true) ?? [],
            'form_options' => array(
                'options' => json_decode(get_field('pcco_options', $offer_id), true) ?? []
            ),
            'comment' => get_field('pcco_comment', $offer_id) ?? '',
            'hash' => get_field('hash', $offer_id) ?? null,
            'root_offer' => array(
                'offer_form_id' => $offer_id ?? null,
                'hash' =>  get_field('hash', $offer_id) ?? null,
                'parent_hash' => get_field('parent_hash', $offer_id),
                'created_at' => get_the_date($offer_id)
            ),
        );

        $fileInfo = $this->getReportByHash($report_hash, $form);
        if (!$fileInfo) {
            return null;
        }

        if ($this->storageHasFile($fileInfo, $form)) {
            echo $this->getFileFromStorage($fileInfo, $form);
        }

        return null;
    }

    public function getFilePath($fileInfo, $form)
    {
        $path = $this->getPath($form);
        if (!$path) {
            return false;
        }

        return $path . $fileInfo['label'] . '.' . $fileInfo['ext'];
    }

    public function storageHasFile($fileInfo, $form)
    {
        $file = $this->getFilePath($fileInfo, $form);

        if (!$file) {
            return false;
        }

        return $this->_storage->has($file);
    }

    public function getFileFromStorage($fileInfo, $form)
    {
        $file = $this->getFilePath($fileInfo, $form);

        if (!$file) {
            return false;
        }

        if (!$this->_storage->has($file)) {
            return null;
        }

        $data = [
            'name' => $fileInfo['filename'] . '.' . $fileInfo['ext'],
            'size' => $this->_storage->getSize($file),
            'content' => base64_encode($this->_storage->read($file)),
            'contentType' => $fileInfo['contentType'],
            'disposition' => 'attachment'
        ];

        $this->prepareHeaders($data);
        ob_end_clean();
        ob_start();
        echo base64_decode($data['content']);
        exit;
    }

    public function prepareHeaders(array $fileData)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: '. $fileData['contentType']);
        header('Content-Disposition: '. $fileData['disposition'] .'; filename="'. $fileData['name'] .'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        if ($fileData['size']) {
            header('Content-Length: '. $fileData['size']);
        }
    }

    private function getAllReports()
    {
        $reports = [
            [
                'hash' => 'r76swpv8',
                'category' => 'pcco',
                'type' => 'clientFormSummary',
                'author' => 'hewalex',
                'label' => 'Ankieta Klient',
                'ext' => 'pdf',
                'contentType' => 'application/pdf',
                'location' => 'generic',
                'edok_document_hash' => '8ig4s83o',
            ],
            [
                'hash' => 'mp6z2kwg',
                'category' => 'pcco',
                'type' => 'clientOffer',
                'author' => 'hewalex',
                'label' => 'Raport Klient',
                'ext' => 'pdf',
                'contentType' => 'application/pdf',
                'location' => 'storage',
                'edok_document_hash' => '633td30sW'
            ],
            [
                'hash' => 'xi8m6thc',
                'category' => 'pcco',
                'author' => 'hewalex',
                'label' => 'Ankieta Serwis',
                'ext' => 'xls',
                'contentType' => 'application/vnd.ms-excel',
                'location' => 'storage',
                'edok_document_hash' => '5wimu953'
            ],
            [
                'hash' => 'x258crl2',
                'category' => 'pcco',
                'author' => 'hewalex',
                'label' => 'Bilans roczny Serwis',
                'ext' => 'pdf',
                'contentType' => 'application/pdf',
                'location' => 'storage',
                'edok_document_hash' => '5wimu953'
            ],
            [
                'hash' => 'o2lxv3ii',
                'category' => 'pcco',
                'author' => 'hewalex',
                'label' => 'Wybrane dane Serwis',
                'ext' => 'xls',
                'contentType' => 'application/vnd.ms-excel',
                'location' => 'storage',
                'edok_document_hash' => '5wimu953'
            ],
        ];

        return $reports;
    }

    private function getReportByHash($hash, $offerForm)
    {
        $report = $this->getReports([
            'first' => true,
            'hash' => $hash
        ]);
        if (!$report) {
            return null;
        }

        $specificReport = $this->prepareReportForSpecificOfferForm($report, $offerForm);
        return $specificReport;
    }

    private function prepareReportForSpecificOfferForm($report, $offerForm)
    {
        switch ($report['hash']) {
            case 'mp6z2kwg':
                //$clientName = self::getContactValue($offerForm, 'name');
                $clientName = (new ZH_OfferForm())->getContactValue('pcco_name');
                $report['filename'] = $clientName ? "{$clientName} - {$report['label']}" : $report['label'];
                break;
            default:
                $report['filename'] = $report['label'];
        }

        return $report;
    }

    public function getReports(array $params = [])
    {
        $reports = array_filter($this->getAllReports(), function ($report) use ($params) {
            $filter = true;
            if ($params['hash'] ?? null) {
                $filter = $filter && $report['hash'] === $params['hash'];
            }
            if ($params['category'] ?? null) {
                $filter = $filter && $report['category'] === $params['category'];
            }
            if ($params['type'] ?? null) {
                $filter = $filter && $report['type'] === $params['type'];
            }
            if ($params['author'] ?? null) {
                $filter = $filter && $report['author'] === $params['author'];
            }
            return $filter;
        });

        if ($params['first'] ?? null) {
            return array_first($reports);
        }
        return $reports;
    }

    public function getPath($form)
    {
        if (!($form['offer_form_category'] ?? null)) {
            return null;
        }

        $subPath = '';
        return $form['offer_form_category'] . '/' . $subPath . $form['offer_form_id'] . '/';
    }
}