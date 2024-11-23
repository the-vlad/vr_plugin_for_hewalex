<?php
namespace Develtio\ZonesHewalex\Ajax\Controller\InstallationForm;

use Develtio\ZonesHewalex\PDF\ZH_GenerateWarrantyPdf;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_SaveForm
 */

class ZH_SaveForm
{

    public function saveForm()
    {
        $data = $_POST;

        if (!is_user_logged_in()) wp_send_json_error(__("You are not logged in!", "zones-hewalex"));

        $installator_nip = isset($_POST['nip']) ? trim($_POST['nip']) : "";
        $installator_postcode = isset($_POST['installator_postcode']) ? trim($_POST['installator_postcode']) : "";
        $installator_phone = isset($_POST['installator_phone']) ? trim($_POST['installator_phone']) : "";
        $installator_name = isset($_POST['installator_name']) ? trim($_POST['installator_name']) : "";
        $installator_city = isset($_POST['installator_city']) ? trim($_POST['installator_city']) : "";
        $installator_email = isset($_POST['installator_email']) ? trim($_POST['installator_email']) : "";
        $installator_address = isset($_POST['installator_address']) ? trim($_POST['installator_address']) : "";
        $installator_province = $_POST['installator_province'];
        $installator_connect = $_POST['installator'];
       
        $client_email = isset($_POST['email']) ? trim($_POST['email']) : "";
        $client_address = isset($_POST['address']) ? trim($_POST['address']) : "";
        $client_province = $_POST['province'];
        $client_name = isset($_POST['name']) ? trim($_POST['name']) : "";
        $client_postcode = isset($_POST['postcode']) ? trim($_POST['postcode']) : "";
        $client_phone = isset($_POST['phone']) ? trim($_POST['phone']) : "";
        $client_surname = isset($_POST['surname']) ? trim($_POST['surname']) : "";
        $client_city = isset($_POST['city']) ? trim($_POST['city']) : "";

        $product_number_set = isset($_POST['number_set']) ? trim($_POST['number_set']) : "";
        $product_number_colector_1 = isset($_POST['number_colector_1']) ? trim($_POST['number_colector_1']) : "";
        $product_number_colector_2 = isset($_POST['number_colector_2']) ? trim($_POST['number_colector_2']) : "";
        $product_type_set = isset($_POST['type_set']) ? trim($_POST['type_set']) : "";
        $product_number_solar = isset($_POST['number_solar']) ? trim($_POST['number_solar']) : "";
        $product_number_solar_pump = isset($_POST['number_solar_pump']) ? trim($_POST['number_solar_pump']) : "";
        $product_source_pay = isset($_POST['source_pay']) ? trim($_POST['source_pay']) : "";
        $product_number_driver = isset($_POST['number_driver']) ? trim($_POST['number_driver']) : "";
        $product_date_pay = isset($_POST['date_pay']) ? trim($_POST['date_pay']) : "";
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $id_number_set = isset($_POST['id_number_set']) ? $_POST['id_number_set'] : null;

        $points = isset($_POST['points']) ? trim($_POST['points']) : "";

        $true = 'agree';
        $success = 'true';
        $update_message = 'updated';

        $args_installations = [
            'post_status'=> 'publish',
            'post_type'=>'installation',
            'meta_query' => array(
                array(
                    'key' => 'installation_code',
                    'value' => $product_number_set,
                    'compare' => '='
                )
            )
        ];

        // Override checkbox states
        $agree_set_solar = $_POST['user_set_solar_agree'];
        $agree_terms = $_POST['terms_and_condition_agree'];
        $agree_cookies = $_POST['cookies_agree'];
        $agree_newsletter = $_POST['newsletter_agree'];

        $results = get_posts($args_installations);

        // Jak uzytkownik rejestruje sobie instalacje ktora juz istnieje istnieje ale ma zaznaczonego chechboxa to wtedy na 1 kroku ma komunikat o tym ze taka instalacja istnieje 
        // Uzytkownik + checkbox Uzytkonik => false
        // Uzytkownik + unchecked Uzytkownik => true
        

        if($id === 'null' || $id === null && empty($results)) {
    
            $args = array(
                'post_title'    => $product_number_set,
                'post_type'     => 'installation',
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'meta_input'    => array(
                    'installation_code'                         => $product_number_set,
                    'user'                                      => $agree_set_solar,
                    'terms'                                     => $agree_terms,
                    'condition'                                 => $agree_cookies,
                    'newsletter'                                => $agree_newsletter,
                    'installation_email_step1'                  => $client_email,
                    'installation_group_installation_email'     => $client_email,
                    'installation_group_installation_address'   => $client_address,
                    'installation_group_installation_province'  => $client_province,
                    'installation_group_installation_name'      => $client_name,
                    'installation_group_installation_post_code' => $client_postcode,
                    'installation_group_installation_phone'     => $client_phone,
                    'installation_group_installation_surname'   => $client_surname,
                    'installation_group_installation_city'      => $client_city,

                    'installation_group2_installation_code_product'      => $product_number_set,
                    'installation_group2_installation_number_collector1' => $product_number_colector_1,
                    'installation_group2_installation_number_collector2' => $product_number_colector_2,
                    'installation_group2_installation_type'              => $product_type_set,
                    'installation_group2_installation_number_heater'     => $product_number_solar,
                    'installation_group2_installation_number_set'        => $product_number_solar_pump,
                    'installation_group2_installation_number_driver'     => $product_number_driver,
                    'installation_group2_installation_source'            => $product_source_pay,
                    'installation_group2_installation_date'              => $product_date_pay,

                    'installation_group3_installation_nip_installer'        => $installator_nip,
                    'installation_group3_installation_post_code_installer'  => $installator_postcode,
                    'installation_group3_installation_phone_installer'      => $installator_phone,
                    'installation_group3_installation_name_installer'       => $installator_name,
                    'installation_group3_installation_city_installer'       => $installator_city,
                    'installation_group3_installation_email_installer'      => $installator_email,
                    'installation_group3_installation_address_installer'    => $installator_address,
                    'installation_group3_installation_province_installer'   => $installator_province,
                    'installation_group3_installation_connect'              => $installator_connect,
                    'installation_group4_installation_points_active'  => $points,
                    'installation_group4_installation_client'  => array($true),
                    'installation_group4_installation_status' => 0
                )

            );

            $insert = wp_insert_post($args);

            $pdf = (new ZH_GenerateWarrantyPdf)->generatePdfFile($insert, $id_number_set);

            echo $success;
            die();
        }

        if(!empty($results)) {
         
            $args = array(
                'ID'            => $id,
                'post_type'     => 'installation',
                'post_status'   => 'publish',
                'meta_input'    => array(
                    'user'                                      => $agree_set_solar,
                    'terms'                                     => $agree_terms,
                    'condition'                                 => $agree_cookies,
                    'newsletter'                                => $agree_newsletter,
                    'installation_email_step1'                  => $client_email,
                    'installation_group_installation_email'     => $client_email,
                    'installation_group_installation_address'   => $client_address,
                    'installation_group_installation_province'  => $client_province,
                    'installation_group_installation_name'      => $client_name,
                    'installation_group_installation_post_code' => $client_postcode,
                    'installation_group_installation_phone'     => $client_phone,
                    'installation_group_installation_surname'   => $client_surname,
                    'installation_group_installation_city'      => $client_city,

                    'installation_group2_installation_number_collector1' => $product_number_colector_1,
                    'installation_group2_installation_number_collector2' => $product_number_colector_2,
                    'installation_group2_installation_type'              => $product_type_set,
                    'installation_group2_installation_number_heater'     => $product_number_solar,
                    'installation_group2_installation_number_set'        => $product_number_solar_pump,
                    'installation_group2_installation_number_driver'     => $product_number_driver,
                    'installation_group2_installation_source'            => $product_source_pay,
                    'installation_group2_installation_date'              => $product_date_pay,
                    'installation_group4_installation_client'           => array($true),
                    'installation_group3_installation_connect'              => $installator_connect,
                )
            );

            $update = wp_update_post($args);
            echo $update_message;
        
        }
        // die();
    }
}