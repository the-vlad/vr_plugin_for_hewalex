<?php
namespace Develtio\ZonesHewalex\Ajax\Controller\SalesManago;

use Develtio\ZonesHewalex\SalesManago\ZH_Salesmanago;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_SalesManagoAjax
 */

class ZH_SalesManagoAjax
{
    public function saveDataNewsletter(){
        $set = $this->parseNewsletterData();
        $params = array(
            "upsertDetails" => $set,
            "owner" => SALESMANAGO_OWNER,
        );

        $data = array_merge(ZH_Salesmanago::prepareDefaultSalesData(), $params);

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $result = wp_remote_post( SALESMANAGO_ENDPOINT .'/api/contact/batchupsertv2',
            array(
                'method' => 'POST',
                'headers' => $headers,
                'sslverify' => false,
                'body' => json_encode($data)
            )
        );

        return $result;
    }

    private function parseNewsletterData(){
        $email = $_POST['email'];
        $set[0]['contact'] = array(
            'email' => $email,
        );

        return $set;
    }
}