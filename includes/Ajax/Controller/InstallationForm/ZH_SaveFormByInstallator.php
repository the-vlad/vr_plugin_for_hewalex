<?php
namespace Develtio\ZonesHewalex\Ajax\Controller\InstallationForm;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_SaveFormByInstallator
 */
class ZH_SaveFormByInstallator
{

    public function saveFormByInstallator() {

        $number_solar = $_POST['post_details']['post_title'];
        $type_solar = $this->getTypeByNumberSolar($number_solar);
        $solar_or_pump_type = $this->searchByNumber($number_solar);
        $title_solar_set = $type_solar->post_title;

        $args_points = array(
            'post_type' => $solar_or_pump_type,
            'post_status'   => 'publish',
            'post_title' => $title_solar_set,
            'posts_per_page' => 1
        );

        $points_result = get_posts($args_points);
        $points = get_field('points', $points_result[0]->ID);

        $args_installations = [
            'post_status'=> 'publish',
            'post_type'=>'installation',
            'meta_query' => array(
                array(
                    'key' => 'installation_code',
                    'value' => $number_solar,
                    'compare' => '='
                )
            )
        ];

        $results = get_posts($args_installations);

        $user = wp_get_current_user();
        $nip = get_user_meta( $user->ID, 'installation_group1_installation_nip', true );
        $phone = get_user_meta( $user->ID, 'installation_group1_installation_phone_installer', true );
        $email = get_user_meta( $user->ID, 'installation_group1_installation_email_installer', true );
        $name = get_user_meta( $user->ID, 'installation_group1_installation_name_installer', true );
        $city = get_user_meta( $user->ID, 'installation_group1_installation_city_installer', true );
        $postcode = get_user_meta( $user->ID, 'installation_group1_installation_post_code_installer', true );
        $address = get_user_meta( $user->ID, 'installation_group1_installation_address_installer', true );
        $province = get_user_meta( $user->ID, 'installation_group1_installation_province_installer', true );
        $true = 'agree';

        // RESULTS
        if($results) {
            foreach ($results as $result){

                $id = $result->ID;      
                $checked_installator = get_post_meta( $id, 'installation_group4_installation_instalator' );
                $checked_user = get_post_meta( $id, 'installation_group4_installation_client' );

                // CASE #1 Registered by user and instalator registered - false points
                if(!empty($checked_installator[0])){
                    $checked_installator_state ='falsePoints';
                    echo $checked_installator_state;
                }

                // CASE #2 Registered by user but instalator is empty  - true points + meta fields updated
                if(empty($checked_installator[0]) && !empty($checked_user[0]) ){
                    $checked_installator_state = 'truePoints';
                    echo $checked_installator_state;
             
               
                 $args_update = [
                  'ID'=> $id,
                  'post_title'=> $number_solar,
                  'post_status'=> 'publish',
                  'post_type'=>'installation',
                  'meta_input' => array(
                      'installation_code' => $number_solar,
                      'installation_group2_installation_type' => $title_solar_set,
                      'installation_group2_installation_code_product' => $number_solar,
                      'installation_group3_installation_nip_installer' => $nip,
                      'installation_group3_installation_post_code_installer' => $postcode,
                      'installation_group3_installation_phone_installer' => $phone,
                      'installation_group3_installation_name_installer' => $name,
                      'installation_group3_installation_city_installer' => $city,
                      'installation_group3_installation_email_installer' => $email,
                      'installation_group3_installation_address_installer' => $address,
                      'installation_group3_installation_province_installer' => $province,
                      'installation_group4_installation_instalator'  => array($true),
                  )
              ];

              $update = wp_update_post($args_update);
            }
            //   die();
          }

      // CASE #3 Installation doesnt exist - Insert new post 
    } else {
            $args = [
                'post_title'=> $number_solar,
                'post_status'=> 'publish',
                'post_type'=>'installation',
                'meta_input' => array(
                    'installation_code' => $number_solar,
                    'installation_group2_installation_type' => $title_solar_set,
                    'installation_group2_installation_code_product' => $number_solar,
                    'installation_group3_installation_nip_installer' => $nip,
                    'installation_group3_installation_post_code_installer' => $postcode,
                    'installation_group3_installation_phone_installer' => $phone,
                    'installation_group3_installation_name_installer' => $name,
                    'installation_group3_installation_city_installer' => $city,
                    'installation_group3_installation_email_installer' => $email,
                    'installation_group3_installation_address_installer' => $address,
                    'installation_group3_installation_province_installer' => $province,
                    'installation_group4_installation_instalator'  => array($true),
                    'installation_group4_installation_points_active'  => $points,
                    'installation_group4_installation_status' => 0
                )
            ];
            wp_insert_post($args);
        }

        die();
    }


  // Checkbox zostaje byc zaznaczonym w tym przypadku jezeli instalator wpisal kod ktory 

    public function getTypeByNumberSolar($number){
        $args = [
            'post_status'=> 'publish',
            'post_type'=>'solar_numbers_set',
            'meta_query' => array(
                array(
                    'key' => 'number_set',
                    'value' => $number,
                    'compare' => '='
                )
            )
        ];

        $args2 = [
            'post_status'=> 'publish',
            'post_type'=>'installation',
            'meta_query' => array(
                array(
                    'key' => 'installation_code',
                    'value' => $number,
                    'compare' => '='
                )
            )
        ];

        $args3 = [
            'post_status'=> 'publish',
            'post_type'=>'pump_numbers_set',
            'meta_query' => array(
                array(
                    'key' => 'pump_set',
                    'value' => $number,
                    'compare' => '='
                )
            )
        ];

        $number_set = get_posts($args);
        $pump_set = get_posts($args3);
        $number_compare = get_posts($args2);

         if (empty($number_set) && empty($pump_set)){
             wp_die('' , 400);
         }
      
         if( empty($number_compare)  && (!empty($number_set) || !empty($pump_set)) ) {
             $code_good = 'success';
             echo $code_good;
         }

         if(!empty($number_compare)){
            $code_good = 'warning';
            echo $code_good;
         }

         if( !empty($number_compare)  && !empty($number_set) || !empty($pump_set) ) {
            $code_used_exist = 'warning';
            echo $code_good;
         }

         if(empty($number_set))
         {
             foreach($pump_set as $item){
                 $type = get_field('type_set', $item->ID);
             }
         } else {
             foreach($number_set as $item){
                 $type = get_field('type_set', $item->ID);
             }
         }

        return $type ?? null;
    }

    public function searchByNumber($number) {
        $args = [
            'post_status'=> 'publish',
            'post_type'=>'solar_numbers_set',
            'meta_query' => array(
                array(
                    'key' => 'number_set',
                    'value' => $number,
                    'compare' => '='
                )
            )
        ];

        $args2 = [
            'post_status'=> 'publish',
            'post_type'=>'pump_numbers_set',
            'meta_query' => array(
                array(
                    'key' => 'pump_set',
                    'value' => $number,
                    'compare' => '='
                )
            )
        ];

        $number_set = get_posts($args);
        $pump_set = get_posts($args2);

        if(count($number_set) > 0) {
            return 'solar_types_set';
        }
        else if(count($pump_set) > 0) {
            return 'pump_types_set';
        }
        else {
            return null;
        }
    }
}