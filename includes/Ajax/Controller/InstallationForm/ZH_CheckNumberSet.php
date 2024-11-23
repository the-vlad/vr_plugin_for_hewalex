<?php
namespace Develtio\ZonesHewalex\Ajax\Controller\InstallationForm;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_CheckNumberSet
 */

class ZH_CheckNumberSet
{

    public function checkNumberSet()
    {
        if (!is_user_logged_in()) wp_send_json_error(__("You are not logged in!", "zones-hewalex"));

        $installation_code = isset($_POST['number_set']) ? trim($_POST['number_set']) : "";
        
        $args = array(
            'post_type' => 'solar_numbers_set',
            'post_status'   => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'number_set',
                    'value' => $installation_code,
                    'compare' => '=='
                )
            )
        );

        $results = get_posts($args);

        foreach ($results as $result) {
            $id_number = $result->ID;
            $code = get_field('number_set', $result->ID);
            $type = get_field('type_set', $result->ID);
        }

        $args2 = array(
            'post_type' => 'installation',
            'post_status'   => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'installation_code',
                    'value' => $installation_code,
                    'compare' => '=='
                )
            )
        );

        $results_installation = get_posts($args2);
        
        foreach($results_installation as $result)
        {
            $id = $result->ID;
            $id_installator = $result->post_author;
        }

        $args_points = array(
            'post_type' => 'solar_types_set',
            'post_status'   => 'publish',
            'post_title' => $type,
        );

        $points_result = get_posts($args_points);

        $points = get_field('points', $points_result[0]->ID);

         /*
          * @SCENARIO 
           * Dane instolatora nie znikaja dla uzytkownika 
             kiedy instalacja nie istnieje => first

           * Jesli istnieje zaciaga dane instolatora ktory zarejestrowal instalacje
             adress nazwa firmy
         */

        $userchecked = get_post_meta( $id, 'installation_group4_installation_client');
        $installatorchecked = get_post_meta( $id, 'installation_group4_installation_instalator');
        $installatorState = $installatorchecked[0];
        $userState = $userchecked[0];
    
        /*  @CASE 
            #1 Puszcza jezeli instalacja nie byla zarejestrowana przez uzytkownika 
            nie zaciaga zadnych danych instolatora jest do wypelnienia
        */
        if ($userState == null) {
        // if($id) {
            $array = array(
                'code'  => $code ?? null,
                'type'  => $type ?? null,
                'points'  => $points ?? null,
                'id'    => $id ?? null,
                'id_number_set'  => $id_number ?? null,
                'load_nip' => false,
                'userchecked' => $userState,
                'instalatorchecked' => $installatorState,
            );
         }

        /*  @CASE #2 
            Puszcza jezeli instalacja nie byla zarejestrowana (userchekbox = false ) przez uzytkownika wczesniej a byla zarejestrowana przez instolatora (instalatorchekbox = true ) 
            zaciaga dane instolatora na 2 kroku
        */

         if ($userState == null && $installatorState[0] == 'agree') {
                $array = array(
                    'code'  => $code ?? null,
                    'type'  => $type ?? null,
                    'id'    => $id ?? null,
                    'id_number_set'  => $id_number ?? null,
                    'points'  => $points ?? null,
                    'nip'   => (!empty(get_user_meta($id_installator, 'installation_group1_installation_nip'))) ?
                                get_user_meta($id_installator, 'installation_group1_installation_nip', true) :
                                '',
                    'adres' => get_user_meta( $id_installator, 'installation_group1_installation_address_installer', true),
                    'companyname' => get_user_meta( $id_installator, 'installation_group1_installation_name_installer', true),
                    'userchecked' => false,
                    // 'instalatorchecked' => $installatorState,
                    'load_nip' => true,

                );
            }

            if (!$userState == null){
                $array = array(
                    'code'  => $code ?? null,
                    'type'  => $type ?? null,
                    'id_number_set'  => $id_number ?? null,
                    'points'  => $points ?? null,
                    'id'    => $id ?? null,
                    'load_nip' => false,
                    'userchecked' => true,
                    'instalatorchecked' => $installatorState,
                );
            }

        if ($array) {
            echo json_encode($array) ?? null;
        }
      
        die();
    }
}