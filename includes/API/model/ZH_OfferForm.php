<?php

namespace Develtio\ZonesHewalex\API\model;

use Develtio\ZonesHewalex\SalesManago\ZH_Salesmanago;
use Develtio\ZonesHewalex\Synology\ZH_Synology;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_OfferForm
 */
class ZH_OfferForm
{
    private $_exactModel = null;
    private $offers = null;
    private $_storage = null;
    private $offer_id = null;

    public function __construct()
    {
        if(isset($_GET['hash']))
        {
            $this->offer_id = $this->searchByHash($_GET['hash']);
            $this->initExactModel($this->offer_id);
        }
        $this->offers = $this->getDatasetItem($this->_exactModel);
        $this->_storage = new ZH_Synology(ZH_Synology::OFFER_FORMS_PATH);
    }

    /**
     * @param $hash
     * @return string|null
     */
    public function searchByHash($hash)
    {
        global $wpdb;

        $id_offer = $wpdb->get_var(
            $wpdb->prepare(
                "
                    SELECT post_id
                    FROM $wpdb->postmeta
                    WHERE `meta_value` = %s AND `meta_key` = 'hash'
                ",
                $hash
            )
        );

        return $id_offer;
    }

    /**
     * @param $offer_id
     */
    private function initExactModel($offer_id)
    {
        $offerForm = get_field('category_calc', $offer_id);
        if (!$offerForm) {
            $this->_exactModel = null;
            return;
        }

        switch ($offerForm) {
            case 'calcpv':
                $this->_exactModel = new ZH_OfferFormPv();
                break;
            case 'pcco':
                $this->_exactModel = new ZH_OfferFormPCCO();
                break;
            case 'pcwb':
                $this->_exactModel = new ZH_OfferFormPCWB();
                break;
            case 'shopOffer':
                $this->_exactModel = new ZH_OfferFormShop();
                break;
        }

        if (!$this->_exactModel) {
            return;
        }

        if (method_exists($this->_exactModel, 'setExactOffer')) {
            $this->_exactModel->setExactOffer($offerForm);
        }
    }

    public function getExactModel()
    {
        return $this->_exactModel;
    }

    public function offerForm()
    {
        $hash = wp_generate_password( 32, false, false );

        $result = array(
            'offerHash'     => $hash,
            'reportHash'    => null
        );

        $data = json_decode(file_get_contents('php://input', true), true);

        switch($data['offer_form_category'])
        {
            case 'calcpv':
                ZH_OfferFormPv::insert($data, $hash);
                (new ZH_Salesmanago)->upsertSalesManago($data);
                break;
            case 'pcco':
                ZH_OfferFormPCCO::insert($data, $hash);
                (new ZH_Salesmanago)->upsertSalesManago($data);
                break;
            case 'pcwb':
                ZH_OfferFormPCWB::insert($data, $hash);
                break;
//            case 'shopOffer':
//                $this->_exactModel = new ZH_OfferFormShop();
//                break;
        }

        return $result;
    }

    /**
     * @param \WP_REST_Request $request
     * @return null
     */
    public function generateFormByHash(\WP_REST_Request $request)
    {
        $reportHash = $request->get_param('reportHash');

        switch ($reportHash) {
            case 'bc1xhzxu':
                /* calcpv ankiet summary */
                $previewContent = $this->getExactModel()->getPreparedClientAnkietForPrint();
                break;
            case '8zc9av26':
                /* calcpv client offer */
                $previewContent = $this->getExactModel()->getPreparedClientOfferForPrint();
                break;
            case 'o9ob73zd':
                /* calcpv installer offer */
                $previewContent = $this->getExactModel()->getPreparedInstallerOfferForPrint();
                break;
            case 'r76swpv8':
                /* pcco ankiet summary */
                $previewContent = $this->getExactModel()->getPreparedClientAnkietForPrint();
                break;
            case '4dty74si':
//                $previewContent = (new ZH_OfferFormShop)->getPreparedClientOfferForPrint();
//                $model = (new OfferFormShop())->setExactOffer($offerForm);
                $data =  (new ZH_OfferFormShop)->getPreparedClientOfferForPrint();
                $mpdf = new \Mpdf\Mpdf([
                    'setAutoTopMargin' => 'stretch',
                    'setAutoBottomMargin' => 'stretch',
                    'default_font_size' => 10,
                ]);
                $mpdf->SetHTMLHeader($data['header']);
                $mpdf->SetHTMLFooter($data['footer']);
                $mpdf->WriteHTML($data['content']);
                $previewContent = base64_encode($mpdf->Output());
                break;
            case 'wp305b23':
                /* pcwb report / offer */
                $previewContent = $this->getExactModel()->getPreparedClientOfferForPrint();
                break;
            case 'wp305b23TEST':
                 $this->prepareHeaders();
                 $this->getExactModel()->getTest();
                break;
            case '54Kspw429r7':
                /* pcwb ankiet summary */
                $previewContent = $this->getExactModel()->getPreparedClientAnkietForPrint();
                break;
            default:
                return null;
        }

        return $previewContent;
    }

    /**
     * @param \WP_REST_Request $request
     * @return null
     */
    public function generateFormByHashHistory(\WP_REST_Request $request)
    {
        $reportHash = $request->get_param('reportHash');

        switch ($reportHash) {
            case 'bc1xhzxu':
                /* calcpv ankiet summary */
                $previewContent = (new ZH_OfferFormPv())->getPreparedClientAnkietHistoryForPrint();
                break;
            case '8zc9av26':
                /* calcpv client offer */
                $previewContent = (new ZH_OfferFormPv())->getPreparedClientOfferHistoryForPrint();
                break;
            case 'o9ob73zd':
                /* calcpv installer offer */
                $previewContent = (new ZH_OfferFormPv())->getPreparedInstallerOfferHistoryForPrint();
                break;
            case 'r76swpv8':
                /* pcco ankiet summary */
                $previewContent = (new ZH_OfferFormPCCO())->getPreparedClientAnkietHistoryForPrint();
                break;
            case '4dty74si':
                $data =  (new ZH_OfferFormShop)->getPreparedClientOfferHistoryForPrint();
                $mpdf = new \Mpdf\Mpdf([
                    'setAutoTopMargin' => 'stretch',
                    'setAutoBottomMargin' => 'stretch',
                    'default_font_size' => 10,
                ]);
                $mpdf->SetHTMLHeader($data['header']);
                $mpdf->SetHTMLFooter($data['footer']);
                $mpdf->WriteHTML($data['content']);
                $previewContent = base64_encode($mpdf->Output());
                break;
            case 'wp305b23':
                /* pcwb report / offer */
                $previewContent = (new ZH_OfferFormPCWB())->getPreparedClientOfferHistoryForPrint();
                break;
            case '54Kspw429r7':
                /* pcwb ankiet summary */
                $previewContent = (new ZH_OfferFormPCWB())->getPreparedClientAnkietHistoryForPrint();
                break;
            default:
                return null;
        }

        return $previewContent;
    }

    public function prepareHeaders()
    {
        header('Content-Type: text/html');
    }

    public function getContactValue($name)
    {
        $arr = array_column($this->offers, 'ID');
        $id = array_shift($arr);
        return get_field($name, $id);
    }

    public function getIdOffer()
    {
        $arr = array_column($this->offers, 'ID');
        $id = array_shift($arr);
        return $id;
    }

    public function getDatasetItem($model) : ?array
    {
        if(isset($_GET['hash'])) {
            $hash = $_GET['hash'];
        }

        if($model) {
            $category = $model->getCategoryModel();
        }
        else {
            $category = null;
        }

        switch($category)
        {
            case 'calcpv':
                $dataset = ZH_OfferFormPv::getDataset($hash);
                break;
            case 'pcwb':
                $dataset = ZH_OfferFormPCWB::getDataset($hash);
                break;
            case 'pcco':
                $dataset = ZH_OfferFormPCCO::getDataset($hash);
                break;
            case 'shopOffer':
                $dataset = ZH_OfferFormShop::getDataset($hash);
                break;
            default:
                return null;
        }

        return $dataset;
    }

    public function getIdInstallator()
    {
        if(!is_user_logged_in()){
            return;
        }

        $user = wp_get_current_user();
        return $user->ID;
    }

    public function selectRegion($region)
    {
        switch($region){
            case '3':
                return 'dolnoslaskie';
            case '4':
                return 'kujawsko-pomorskie';
            case '6':
                return 'lubelskie';
            case '7':
                return 'lubuskie';
            case '5':
                return 'łódzkie';
            case '1':
                return 'małopolskie';
            case '8':
                return 'mazowieckie';
            case '9':
                return 'opolskie';
            case '10':
                return 'podkarpackie';
            case '11':
                return 'podlaskie';
            case '12':
                return 'pomorskie';
            case '2':
                return 'śląskie';
            case '13':
                return 'świętokrzyskie';
            case '14':
                return 'warmińsko-mazurskie';
            case '15':
                return 'wielkopolskie';
            case '16':
                return 'zachodniopomorskie';
            default:
                return null;
        }
    }

    public function searchArray($value, $key, $return, $array) {
        foreach ($array as $val) {
            if ($val[$key] == $value) {
                return $val[$return];
            }
        }
        return null;
    }

    public function filterArray($array_to_filter)
    {
        return array_filter($array_to_filter, function ($item) {
            return in_array('analyzeSummary', $item['group'] ?? []);
        });
    }

    public function getParentHash(\WP_REST_Request $request){
        //return $request->get_param('hash');
        $hash = $request->get_param('hash');
        $id_offer = $this->searchByHash($hash);
        $category = get_field('category_calc', $id_offer);

        if($request->get_param('history') == 1) {
            return $this->prepareArrayEditCalculatorHistory($request->get_param('offer_forms'));
        } else {
            switch($category) {
                case 'calcpv':
                    $calc = 'pv';
                    return $this->prepareArrayEditCalculator($calc, $hash, $id_offer);
                    break;
                case 'pcwb':
                    return $this->prepareArrayEditCalculator($category, $hash, $id_offer);
                    break;
                case 'pcco':
                    return $this->prepareArrayEditCalculator($category, $hash, $id_offer);
                    break;
                default:
                    return null;
            }
        }
    }

    public function prepareArrayEditCalculator($calc, $hash, $id_offer)
    {
        $options = json_decode(get_field($calc . '_options', $id_offer), true);
        $results = json_decode(get_field($calc . '_results', $id_offer), true);
        $products = json_decode(get_field($calc . '_products', $id_offer), true);
        $cproducts = json_decode(get_field($calc. '_cproducts', $id_offer), true);
        $cterms = json_decode(get_field($calc . '_cterms', $id_offer), true);
        $contact = json_decode(get_field($calc . '_contact', $id_offer), true);
        $attachment = get_field($calc . '_attachment', $id_offer);
        $comment = get_field($calc . '_comment', $id_offer);

        return array(
            'comment' => $comment ?? '',
            'contact' => $contact ?? [],
            'created_at' => get_the_modified_date('Y-m-d', $id_offer),
            'edoc_prc_id' => null,
            'edoc_prc_symbol' => null,
            'form_options' => array(
                'attachment' => $attachment ?? [],
                'customProducts' => $cproducts ?? [],
                'customTerms' => $cterms ?? [],
                'options' => $options ?? [],
                'products' => $products ?? [],
                'results' => $results ?? [],
            ),
            'hash' => $hash,
            'offer_form_id' => $id_offer,
            'offer_form_category' => ($calc === 'pv') ? 'calcpv' : $calc,
            'headers' => "{\"HTTP_USER_AGENT\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/100.0.4896.127 Safari\\/537.36\"}",
            'is_unique' => '1',
            'mails_sent' => [],
            'offer_generated' => "1",
            'offer_status' => "0",
            'offer_verified' => "1",
            'parent_hash' => null,
            'representative_id' => null,
            'representative_name' => null,
            'representative_surname' => null,
            'root_hash' => null,
            'sent_to_representative_date' => null,
            'updated_at' => get_the_modified_date('Y-m-d', $id_offer),
            'user_id' => null
        );
    }

    public function prepareArrayEditCalculatorHistory($id_offer)
    {
        global $wpdb;
        $offer = "select * from offer_forms where offer_form_id LIKE {$id_offer} LIMIT 1";
        $offer_arr = $wpdb->get_results($offer, 'ARRAY_A');

        return array(
            'comment' => $comment ?? '',
            'contact' => json_decode($offer_arr[0]['contact'], true) ?? [],
            'created_at' => $offer_arr[0]['created_at'],
            'edoc_prc_id' => null,
            'edoc_prc_symbol' => null,
            'form_options' => array(
                'attachment' => json_decode($offer_arr[0]['form_options'], true)['attachment'] ?? [],
                'customProducts' => json_decode($offer_arr[0]['form_options'], true)['cproducts'] ?? [],
                'customTerms' => json_decode($offer_arr[0]['form_options'], true)['cterms'] ?? [],
                'options' => json_decode($offer_arr[0]['form_options'], true)['options'] ?? [],
                'products' => json_decode($offer_arr[0]['form_options'], true)['products'] ?? [],
                'results' => json_decode($offer_arr[0]['form_options'], true)['results'] ?? [],
            ),
            'hash' => $offer_arr[0]['hash'],
            'offer_form_id' => $id_offer,
            'offer_form_category' => $offer_arr[0]['offer_form_category'],
            'headers' => "{\"HTTP_USER_AGENT\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/100.0.4896.127 Safari\\/537.36\"}",
            'is_unique' => '1',
            'mails_sent' => [],
            'offer_generated' => "1",
            'offer_status' => "0",
            'offer_verified' => "1",
            'parent_hash' => null,
            'representative_id' => null,
            'representative_name' => null,
            'representative_surname' => null,
            'root_hash' => null,
            'sent_to_representative_date' => null,
            'updated_at' => $offer_arr[0]['updated_at'],
            'user_id' => null
        );
    }

    public function getResources()
    {
        $category = $_GET['category'] ?? "";

        if (!$category) {
            return new \WP_REST_Response( "The Category field is required", 404 );
        }

        switch ($category) {
            case 'pcwb':
                return new \WP_REST_Response( (new ZH_OfferFormPCWB())->getResources(), 200 );
            case 'calcpv':
                return new \WP_REST_Response( (new ZH_OfferFormPv())->getResources(), 200 );
        }
        return null;
    }

    public function getOfferFormWithModelsTree($category, $offer_form_id)
    {
        global $wpdb;

        $options = "select form_options from offer_forms where offer_form_id LIKE {$offer_form_id}";
        $contact = "select contact from offer_forms where offer_form_id LIKE {$offer_form_id}";

        $options_arr = $wpdb->get_results($options, 'ARRAY_A');
        $contact_arr = $wpdb->get_results($contact, 'ARRAY_A');

        $optionsArrNew = json_decode($options_arr[0]['form_options'], true);

        $arrOptions = $optionsArrNew['options'];
        $arrContacts = json_decode($contact_arr[0]['contact'], true);

        switch($category) {
            case 'calcpv';
                return (new ZH_OfferFormPv())->getExactFormWithModels($arrOptions, $arrContacts, ['grouped' => true]);
                break;
            case 'pcwb';
                return (new ZH_OfferFormPCWB())->getExactFormWithModels($arrOptions, $arrContacts, ['grouped' => true]);
                break;
            case 'pcco';
                return (new ZH_OfferFormPCCO())->getExactFormWithModels($arrOptions, $arrContacts, ['grouped' => true]);
                break;
            case 'shopOffer';
                return (new ZH_OfferFormShop())->getExactFormWithModels($arrOptions, $arrContacts, ['grouped' => true]);
                break;
        }
    }

    public function getValueFromHistoryOffer($offer_form_id, $column_name, $column_name_2, $id_column_result, $return_value)
    {
        global $wpdb;

        $column_result = "select {$column_name} from offer_forms where offer_form_id LIKE {$offer_form_id}";
        $results = $wpdb->get_results($column_result, 'ARRAY_A');

        $arr = json_decode($results[0][$column_name], true);

        if(!empty($column_name_2)) {
            $arr = $arr[$column_name_2];
        }

        $key_where_is_search_key = array_search($id_column_result, array_column($arr, 'id'));

        return $arr[$key_where_is_search_key][$return_value];
    }

    public function getArrayFromFormOptionsHistoryOffer($offer_form_id, $column_name, $column_name_2)
    {
        global $wpdb;

        $column_result = "select {$column_name} from offer_forms where offer_form_id LIKE {$offer_form_id}";
        $results = $wpdb->get_results($column_result, 'ARRAY_A');

        $arr = json_decode($results[0][$column_name], true);

        if(!empty($column_name_2)) {
            $arr = $arr[$column_name_2];
        }

        return $arr;
    }

    public function getValueFromColumnHistory($offer_form_id, $column_name)
    {
        global $wpdb;

        $column_result = "select {$column_name} from offer_forms where offer_form_id LIKE {$offer_form_id} LIMIT 1";
        $results = $wpdb->get_results($column_result, 'ARRAY_A');

        return $results[0][$column_name];
    }
}