<?php

namespace Develtio\ZonesHewalex\eDokumenty;

use SoapClient;
use SoapFault;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_ExportKonfeoToeDokumenty
 */
class ZH_ExportKonfeoToeDokumenty
{
    public function __construct()
    {
        add_action('send_data_edokumenty', array($this, 'prepareDataToExport'));
        add_action('send_data_edokumenty', array($this, 'parseDataToeDokumenty'));
        add_action('send_data_edokumenty', array($this, 'createReport'));
    }

    public function prepareDataToExport($option) : array
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'konfeo',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'konfeo_date',
                    'value'   => date("d/m/Y", strtotime($option['date'])),
                    'compare' => '='
                ),
                array(
                    'key'     => 'konfeo_type',
                    'value'   => $option['type'],
                    'compare' => '='
                ),
            ),
        );

        $records = get_posts($args);

        return $records;
    }

    public function parseDataToeDokumenty($option) : array
    {
        $records = $this->prepareDataToExport($option);
        $set = [];

        foreach($records as $record)
        {
            $userId = $record->ID;
            $date = date("Y-m-d", strtotime($option['date']));

            $set[] = [
                'konfeo' => $userId,
                'email_' => get_field('konfeo_email', $userId),
                'name_1' => get_field('konfeo_name', $userId),
                'name_2' => get_field('konfeo_name', $userId),
                'street' => get_field('konfeo_street', $userId),
                'city__' => get_field('konfeo_city', $userId),
                'code__' => get_field('konfeo_code', $userId),
                'woj___' => get_field('konfeo_province', $userId),
                'nip___' => get_field('konfeo_nip', $userId),
                'ph_num' => get_field('konfeo_phone', $userId),
                'date_training' => $date,
                'training' => get_field('konfeo_type', $userId),
                'macrtk' => 2,
                'state' => get_field('konfeo_status', $userId),
                'row'  => ''
            ];
        }

        return $set;
    }

    public function loginToEdokumenty() : array
    {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);

        $options =  [
            // 'location'  => 'https://dev-edokumenty.hewalex.net/api.php/SOAP/custom',
            'location' => EDOK_API_LOCATION,
            'uri'       => 'Training',
            'encoding'  => 'UTF-8',
            'stream_context' => $context
        ];

        return $options;
    }

    public function createReport($option)
    {
        $options = $this->loginToEdokumenty();
        $set = $this->parseDataToeDokumenty($option);

        try{
            $client = new SoapClient(null, $options);
            $results = $client->addTrainings($set);
        } catch (SoapFault $e) {
            $results = $e->getMessage();
        }

        $new_arr = json_encode($results);

        if($this->in_array_r(false, json_decode($new_arr, true))) {
            add_settings_error( 'export-notices', 'error', 'Wystąpił błąd podczas exportu', 'error' );
        } else {
            add_settings_error( 'export-notices', 'success', 'Raport został utworzony pomyślnie', 'success' );
        }
    }

    private function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
}
