<?php

namespace Develtio\ZonesHewalex\API;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Mounting
 */
class ZH_Mounting
{
    /**
     * @return array
     * Insert result to Carts CPT
     */
    public function getHash() : array
    {
        $hash = wp_generate_password( 32, false, false );

        $result = array(
            'hash' => $hash
        );

        if($result)
        {
            $data = json_decode(file_get_contents('php://input', true), true);

            $array = [];
            foreach ($data as $el )
            {
                $array[$el['code']] = $el['sum'];
            }

            $json = json_encode($array, JSON_FORCE_OBJECT);

            $args = array(
                'post_title'    => $hash,
                'post_type'     => 'carts',
                'post_status'   => 'publish',
                'meta_input'    => array(
                    'carts_hash'        => $hash,
                    'carts_products'    => $json,
                )
            );
            $insert = wp_insert_post($args);
        }

        return $result;
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
                'post_type'     => 'carts',
                'post_status'   => 'publish',
                'posts_per_page' => -1
            );
            $products = get_posts($args);

            foreach ($products as $product){
                if($token === $product->post_title){
                    $json_products = get_field('carts_products', $product->ID);
                }
            }

            if(empty($json_products)){
                global $wpdb;

                $offers = 'SELECT * FROM offer_forms WHERE hash = "' . $token . '"';
                $offers_arr = $wpdb->get_results($offers, 'ARRAY_A');

                $products = json_decode($offers_arr[0]['form_options'], true)['products'];

                $array = [];
                foreach ($products as $el )
                {
                    $array[$el['code']] = $el['sum'];
                }

                $json = json_encode($array, JSON_FORCE_OBJECT);

                if(count($offers_arr) > 0) {
                    echo $json;
                } else {
                    echo json_encode(["success" => false, "message" => 'Invalid hash param']);
                }
            }
            else {
                echo $json_products;
            }
        }
    }
}