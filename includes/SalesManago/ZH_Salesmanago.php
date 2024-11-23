<?php

namespace Develtio\ZonesHewalex\SalesManago;

use Develtio\ZonesHewalex\API\model\ZH_OfferForm;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Salesmanago
 */
class ZH_Salesmanago
{
    public function __construct()
    {
        add_action('send_data_salesmanago', array($this, 'prepareDataToExport'));
        add_action('send_data_salesmanago', array($this, 'parseDataToExport'));
        add_action('send_data_salesmanago', array($this, 'contactUpsert'));
    }

    public static function prepareDefaultSalesData()
    {
        $clientId = SALESMANAGO_CLIENTID;
        $apiKey = SALESMANAGO_APIKEY;
        $apiSecret = SALESMANAGO_APISECRET;

        $data = [
            'clientId' => $clientId,
            'apiKey' => $apiKey,
            'requestTime' => time(),
            'sha' => sha1($apiKey . $clientId . $apiSecret),
        ];

        return $data;
    }

    public function prepareDataToExport($option)
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'konfeo',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'konfeo_date',
                    'value'   => date("d/m/Y", strtotime($option['date']))
                ),
                array(
                    'key'     => 'konfeo_type',
                    'value'   => $option['type']
                ),
            ),
        );

        $results = get_posts($args);

        return $results;
    }

    public function parseDataToExport($option)
    {

        $results = $this->prepareDataToExport($option);
        $set = [];

        foreach ($results as $key => $result) {

            $set[$key]['contact'] = array(
                'email' => $result->konfeo_email,
                'name' => $result->konfeo_name,
                'ulica' => $result->konfeo_street,
                'miasto' => $result->konfeo_city,
                'kod pocztowy' => $result->konfeo_code,
                'wojewodztwo' => $result->konfeo_province,
                'nip' => $result->konfeo_nip,
                'phone' => $result->konfeo_phone,
                'opt-in e-mail' => true,
            );

            $set[$key]['tags'] = [
                $option['type']
            ];
        }

        return $set;
    }

    public function contactUpsert($option)
    {
        $set = $this->parseDataToExport($option);

        $params = array(
            "upsertDetails" => $set,
            "owner" => SALESMANAGO_OWNER,
        );

        $data = array_merge($this->prepareDefaultSalesData(), $params);

        $headers = [
            'Content-Type'  => 'application/json'
        ];

        $result = wp_remote_post( SALESMANAGO_ENDPOINT .'/api/contact/batchupsertv2',
            array(
                'method' => 'POST',
                'headers' => $headers,
                'sslverify' => false,
                'body' => json_encode($data)
            )
        );

        if ( is_wp_error( $result ) || wp_remote_retrieve_response_code($result) != 200) {
            add_settings_error( 'export-notices', 'error', 'Wystąpił błąd podczas exportu', 'error' );
        } else {
            add_settings_error( 'export-notices', 'success', 'Export został wykonany pomyślnie', 'success' );
            return $result;
        }

        return null;
    }

    public function upsertSalesManago($data)
    {
        $email = (new ZH_OfferForm)->searchArray('email', 'id', 'value', $data['contact']);
        $phone = (new ZH_OfferForm)->searchArray('phone', 'id', 'value', $data['contact']);
        $offer_accept = (new ZH_OfferForm)->searchArray('complexApproach', 'id', 'selectedId', $data['form_options']['options']);

        switch($data['offer_form_category']) {
            case 'calcpv':
                !empty($phone) ? $tag = ["KALKULATORPV_OFERTA", "POSIADA_NUMER"] : $tag = ["KALKULATORPV_OFERTA"];
                $this->insertTagSalesManago($email, $tag);
                break;
            case 'pcco':
                ($offer_accept === 'y') ? $tag = ["FORMULARZ_PCCO_OFERTA", "FORMULARZ_PCCO"] : $tag = ["FORMULARZ_PCCO"];
                $this->insertTagSalesManago($email, $tag);
                break;
        }

        return null;
    }

    public function insertTagSalesManago($email, $tag)
    {
        $params = array(
            "contact" => [
                "email" => $email,
            ],
            "tags" => $tag,
            "owner" => SALESMANAGO_OWNER,
        );

        $data = array_merge(self::prepareDefaultSalesData(), $params);

        $result = wp_remote_post( SALESMANAGO_ENDPOINT .'/api/contact/upsert',
            array(
                'method' => 'POST',
                'headers' => [
                    'Content-Type'  => 'application/json',
                ],
                'sslverify' => false,
                'body' => json_encode($data)
            )
        );

        return $result;
    }
}