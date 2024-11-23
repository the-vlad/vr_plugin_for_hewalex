<?php

namespace Develtio\ZonesHewalex\API\model;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_OfferFormShop
 */
class ZH_OfferFormShop extends ZH_OfferFormBase
{
    public $SHOP_DESTINATION = 'shopOffer';

    public function getCategoryModel()
    {
        return $this->SHOP_DESTINATION;
    }

    public function getCartFromShop(\WP_REST_Request $data)
    {
        $arr = $data->get_json_params();

        global $wpdb;

        $category =  $arr['category'];
        $user_id =  $arr['user_id'];
        $products =  $arr['form_options']['products'];
        $additional =  $arr['form_options']['additional'];
        $data = $arr;

        $installator_id = $wpdb->get_results( "SELECT user_id FROM {$wpdb->prefix}usermeta WHERE `meta_value` = {$user_id} LIMIT 1" );

        $args = array(
            'post_author' => $installator_id['0']->user_id,
            'post_type' => 'users_shop',
            'post_status' =>  'publish',
            'post_title' => $additional[1]['value'],
            'meta_input' => array(
                'hash' => $this->generateHash(),
                'category_calc' => $category,
                'user_id' => $user_id,
                'products_shop' => json_encode($products, JSON_UNESCAPED_UNICODE),
                'additional_shop' => json_encode($additional, JSON_UNESCAPED_UNICODE),
                'response_from_shop' => json_encode($data, JSON_UNESCAPED_UNICODE),
            )
        );

        $result = wp_insert_post($args);

        $products_to_save = $this->prepareCartsToSave($products);

        $hash = get_field('hash', $result);

        $args_cart = array(
            'post_title'    => $hash,
            'post_type'     => 'carts',
            'post_status'   => 'publish',
            'meta_input'    => array(
                'carts_hash'        => $hash,
                'carts_products'    => $products_to_save,
            )
        );

        $result_cart = wp_insert_post($args_cart);

        if($result && $result_cart)
        {
            echo 'sukces';
            die();
        }
    }

    public function prepareCartsToSave($products)
    {
        $array = [];
        foreach ($products as $el )
        {
            $array[$el['code']] = $el['sum'];
        }

        $json = json_encode($array, JSON_FORCE_OBJECT);

        return $json;
    }

    public function updateCartFromShop()
    {
        $data = json_decode(file_get_contents('php://input', true), true);
        //var_dump($data['hash']);

        if(!isset($data['hash']) || empty($data['hash'])){
            return json_encode(["success" => false, "message" => 'Invalid hash param']);
        }
        else {
            $token = $data['hash'];

            $args = array(
                'post_type'     => 'users_shop',
                'post_status'   => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'hash',
                        'value' => $token,
                        'compare' => '=='
                    )
                )
            );
            $products = get_posts($args);

            foreach ($products as $product){
                $id = $product->ID;
            }

            if(empty($id)){
                echo json_encode(["success" => false, "message" => 'Invalid hash param']);
            }
        }

        $searcher = new ZH_OfferForm();

        $args = array(
            'ID'            => $id,
            'post_status'   => 'publish',
            'post_type'     => 'users_shop',
            'meta_input' => array(
                'contact_name' => $searcher->searchArray('name', 'id', 'value', $data['contact']) ?? '',
                'contact_phone' => $searcher->searchArray('phone', 'id', 'value', $data['contact']) ?? '',
                'contact_address' => $searcher->searchArray('address', 'id', 'value', $data['contact']) ?? '',
                'contact_zip' => $searcher->searchArray('zip', 'id', 'value', $data['contact']) ?? '',
                'contact_city' => $searcher->searchArray('city', 'id', 'value', $data['contact']) ?? '',
                'comment' => $data['comment'] ?? '',
                'custom_products' => json_encode($data['form_options']['customProducts'],JSON_UNESCAPED_UNICODE) ?? [],
                'contact_array' => json_encode($data['contact'],JSON_UNESCAPED_UNICODE) ?? [],
                'offer_array' => json_encode($data['form_options']['offer'],JSON_UNESCAPED_UNICODE) ?? [],
                'options_array' => json_encode($data['form_options']['options'],JSON_UNESCAPED_UNICODE) ?? [],
                'profitType' => $searcher->searchArray('profitType', 'id', 'value', $data['form_options']['options']) ?? '',
                'profitCost' => $searcher->searchArray('profitCost', 'id', 'value', $data['form_options']['options']) ?? '',
                'taxRate' => $searcher->searchArray('taxRate', 'id', 'value', $data['form_options']['options']) ?? '',
                'installationCost' => $searcher->searchArray('instalationCost', 'id', 'value', $data['form_options']['options']) ?? '',
                'deliveryCost' => $searcher->searchArray('deliveryCost', 'id', 'value', $data['form_options']['options']) ?? '',
                'totalPrice' => $searcher->searchArray('totalPrice', 'id', 'value', $data['form_options']['offer']) ?? '',
                'totalPriceOffer' => $searcher->searchArray('totalPriceOffer', 'id', 'value', $data['form_options']['offer']) ?? '',
                'totalPriceOfferWithTax' =>  $searcher->searchArray('totalPriceOfferWithTax', 'id', 'value', $data['form_options']['offer']) ?? '',
            )
        );
        $update = wp_update_post( $args );

        $temp_arr = array('number' => $id);

        $arr2 = array_merge($data, $temp_arr);
        if($update) {
            echo json_encode($arr2);
        }
    }

    public function generateHash()
    {
        $hash = wp_generate_password( 32, false, false );

        return $hash;
    }

    /**
     * @return false|string|void
     * Pass products from hash (API Sklep Hewalex) - Response
     */
    public function getProducts()
    {
        if(!isset($_GET['hash']) || empty($_GET['hash'])){
            return json_encode(["success" => false, "message" => 'Invalid hash param']);
        }
        else {
            $token = $_GET['hash'];

            $args = array(
                'post_type'     => 'users_shop',
                'post_status'   => 'publish',
                'posts_per_page' => -1
            );
            $products = get_posts($args);

            foreach ($products as $product){
                if($token === get_field('hash', $product->ID)){
                    $json_products = json_encode(array(
                        'contact' => json_decode(get_field('contact_array', $product->ID)),
                        'form_options' => array(
                            'additional' => json_decode(get_field('additional_shop', $product->ID)),
                            'customProducts' => json_decode(get_field('custom_products', $product->ID)),
                            'products' => json_decode(get_field('products_shop', $product->ID)),
                            'offer' => json_decode(get_field('offer_array', $product->ID)),
                            'options' => json_decode(get_field('options_array', $product->ID)),
                        ),
                        'comment' => get_field('comment', $product->ID),
                        'offer_form_category' => get_field('category_calc', $product->ID),
                        'user_id' => get_field('user_id', $product->ID),
                        'hash' => get_field('hash', $product->ID),
                        'requestType' => 'order',
                    ), JSON_UNESCAPED_UNICODE);
                }
            }

            if(empty($json_products)){
                global $wpdb;

                $hash = $_GET['hash'];

                $offers = 'SELECT * FROM offer_forms WHERE hash = "' . $hash . '"';
                $offers_arr = $wpdb->get_results($offers, 'ARRAY_A');

                if(count($offers_arr) > 0) {
                    echo json_encode(array(
                        'contact' => json_decode($offers_arr[0]['contact']),
                        'form_options' => json_decode($offers_arr[0]['form_options']),
                        'comment' => $offers_arr[0]['comment'],
                        'offer_form_category' => $offers_arr[0]['offer_form_category'],
                        'user_id' => $offers_arr[0]['user_id'],
                        'hash' => $offers_arr[0]['hash'],
                        'requestType' => 'order',
                    ), JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(["success" => false, "message" => 'Invalid hash param']);
                }
            }
            else {
                echo $json_products;
            }
        }
    }

    public function getPreparedClientOfferForPrint()
    {
        /**
         * Zrobić metody do ściągania danych
         */
//        $price = number_format(
//            OfferForm::getDatasetItemValue($offerForm, 'form_options.offer', 'totalPriceOfferWithTax')
//            , 2, ',', ' ');
//        $contactHtml = $this->getContactForPrint($offerForm);
        $productsHtml = $this->getProductsForPrint();
//        $companyHtml = $this->getCompanyForPrint($offerForm['user_id']);


        $id = (new ZH_OfferForm)->getIdOffer();
        $price = (new ZH_OfferForm)->getContactValue('totalPriceOfferWithTax');
        $comment = (new ZH_OfferForm)->getContactValue('comment');

        $dateCreated = get_the_modified_date('d.m.Y', $id);

        $clientName = (new ZH_OfferForm)->getContactValue('contact_name');

        $html = '
               <table width="100%" style="margin-bottom:10px; padding-bottom:10px;">
                    <tr>
                        <td width="50%">
                            <h3>OFERTA NR ' . $id . '/'. $dateCreated .'</h3>
                        </td>
                        <td width="50%" valign="top" style="text-align: right;">
                            Data utworzenia: ' . $dateCreated . '
                        </td>
                    </tr>
                    <tr><td colspan="2" height="30"></td></tr>
                    <tr>
                        <td>
                            <p><strong>Oferta dla:</strong></p>
                            ' . $clientName . '
                        </td>
                        <td style="text-align: right; font-size:14px">
                            Wartość brutto: <strong style="font-size:16px;">' . $price . ' zł</strong>
                        </td>
                    </tr>
                </table>';

        $html .= $productsHtml;

        if ($comment) {
            $html .= '<p style="margin-top:40px;"><strong>UWAGI:</strong><br/>' . $comment . '</p>';
        }

        return [
//            'header' => $companyHtml,
            'header' => '',
            'footer' => '
                <table width="100%" style="margin-bottom:10px">
                    <tr>
                        <td width="100%" align="center"></td>
                    </tr>
                </table>',
            'content' => $html
        ];
    }

    public function getPreparedClientOfferHistoryForPrint()
    {
        global $wpdb;
        $offer_form_id = isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';
        $optionsArray = (new ZH_OfferForm)->getArrayFromFormOptionsHistoryOffer($offer_form_id, 'form_options', 'additional');

        $productsHtml = $this->getProductsHistoryForPrint();

        $id =  isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';
        $price = (new ZH_OfferForm())->searchArray('totalPrice', 'id', 'value', $optionsArray);
        $comment = (new ZH_OfferForm)->getValueFromColumnHistory($offer_form_id, 'comment');

        $dateCreated = date('d.m.Y', strtotime((new ZH_OfferForm)->getValueFromColumnHistory($offer_form_id, 'created_at')));

        $clientName = (new ZH_OfferForm)->getValueFromHistoryOffer($offer_form_id, 'contact', '', 'name', 'value');


        $html = '
               <table width="100%" style="margin-bottom:10px; padding-bottom:10px;">
                    <tr>
                        <td width="50%">
                            <h3>OFERTA NR ' . $id . '/'. $dateCreated .'</h3>
                        </td>
                        <td width="50%" valign="top" style="text-align: right;">
                            Data utworzenia: ' . $dateCreated . '
                        </td>
                    </tr>
                    <tr><td colspan="2" height="30"></td></tr>
                    <tr>
                        <td>
                            <p><strong>Oferta dla:</strong></p>
                            ' . $clientName . '
                        </td>
                        <td style="text-align: right; font-size:14px">
                            Wartość brutto: <strong style="font-size:16px;">' . $price . ' zł</strong>
                        </td>
                    </tr>
                </table>';

        $html .= $productsHtml;

        if ($comment) {
            $html .= '<p style="margin-top:40px;"><strong>UWAGI:</strong><br/>' . $comment . '</p>';
        }

        return [
            'header' => '',
            'footer' => '
                <table width="100%" style="margin-bottom:10px">
                    <tr>
                        <td width="100%" align="center"></td>
                    </tr>
                </table>',
            'content' => $html
        ];
    }

    public function getProductsForPrint()
    {
        $productsData = (new ZH_PV)->getProducts();

        $products = json_decode((new ZH_OfferForm)->getContactValue('products_shop'), true) ?? [];
        $customItems = json_decode((new ZH_OfferForm)->getContactValue('custom_products'), true) ?? [];

        $tax = (new ZH_OfferForm)->getContactValue('taxRate') . '%';
        $lp = 1;

        $html = '<table width="100%" style="font-size:11px; margin-top:20px; 
margin-bottom:10px; border-collapse: collapse;" cellpadding="5" cellspacing="0" border="1">
                    <thead>
                        <tr>
                            <td width="5%"></td>
                            <td width="10%"><strong>SKU</strong></td>
                            <td><strong>Produkt</strong></td>
                            <td width="10%" align="center"><strong>Ilość</strong></td>
                            <td width="10%" align="center"><strong>Stawka VAT</strong></td>
                        </tr>
                    </thead>';

        foreach ($products as $value) {
            $storeUrl = 'https://sklep.hewalex.pl';
//          $storeUrl = env('HEWALEX_STORE_URL', 'https://sklep.hewalex.pl');
            $productUrl = ($value['code'] ?? null)
                ? '<a href="'. $storeUrl .'/pl/produkt/sku/'.$value['code'].'">' .$value['code']. '</a>'
                : '';

            $html .= '<tr>
                    <td align="center">' . $lp++ . '</td>
                    <td>'.$productUrl.'</td>
                    <td>' . ($value['name'] ?? $productsData[$value['id']]['name']) . '</td>
                    <td align="center">' . $value['sum'] . '</td>
                    <td align="center">' . $tax . '</td>
                    </tr>';
        }

        foreach ($customItems as $value) {
            $html .= '<tr>
                <td align="center">' . $lp++ . '</td>
                <td></td>
                <td>' . $value['id'] . '</td>
                <td align="center">' . $value['value'] . '</td>
                <td align="center">' . $tax . '</td>
                </tr>';
        }
        $html .= '</table>';

        return $html;
    }

    public function getProductsHistoryForPrint()
    {
        $productsData = (new ZH_PV)->getProducts();

        $offer_form_id = isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';

        $products = (new ZH_OfferForm)->getArrayFromFormOptionsHistoryOffer($offer_form_id, 'form_options', 'products');
        $customItems = (new ZH_OfferForm)->getArrayFromFormOptionsHistoryOffer($offer_form_id, 'form_options', 'customProducts');
        $options = (new ZH_OfferForm)->getArrayFromFormOptionsHistoryOffer($offer_form_id, 'form_options', 'options');

        $tax = (new ZH_OfferForm())->searchArray('taxRate', 'id', 'value', $options) . '%';

        $lp = 1;

        $html = '<table width="100%" style="font-size:11px; margin-top:20px; 
margin-bottom:10px; border-collapse: collapse;" cellpadding="5" cellspacing="0" border="1">
                    <thead>
                        <tr>
                            <td width="5%"></td>
                            <td width="10%"><strong>SKU</strong></td>
                            <td><strong>Produkt</strong></td>
                            <td width="10%" align="center"><strong>Ilość</strong></td>
                            <td width="10%" align="center"><strong>Stawka VAT</strong></td>
                        </tr>
                    </thead>';

        foreach ($products as $value) {
            $storeUrl = 'https://sklep.hewalex.pl';
//          $storeUrl = env('HEWALEX_STORE_URL', 'https://sklep.hewalex.pl');
            $productUrl = ($value['code'] ?? null)
                ? '<a href="'. $storeUrl .'/pl/produkt/sku/'.$value['code'].'">' .$value['code']. '</a>'
                : '';

            $html .= '<tr>
                    <td align="center">' . $lp++ . '</td>
                    <td>'.$productUrl.'</td>
                    <td>' . ($value['name'] ?? $productsData[$value['id']]['name']) . '</td>
                    <td align="center">' . $value['sum'] . '</td>
                    <td align="center">' . $tax . '</td>
                    </tr>';
        }

        foreach ($customItems as $value) {
            $html .= '<tr>
                <td align="center">' . $lp++ . '</td>
                <td></td>
                <td>' . $value['id'] . '</td>
                <td align="center">' . $value['value'] . '</td>
                <td align="center">' . $tax . '</td>
                </tr>';
        }
        $html .= '</table>';

        return $html;
    }

    public static function getDataset($hash)
    {
        $args = array(
            'post_type' => 'users_shop',
            'post_status'   => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'hash',
                    'value' => $hash,
                    'compare' => '=='
                )
            )
        );

        $offers = get_posts($args);

        return $offers;
    }
}