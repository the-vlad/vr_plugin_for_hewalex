<?php

namespace Develtio\ZonesHewalex\SSO;

use Develtio\ZonesHewalex\eDokumenty\ZH_eDokumentyMethods;
use SoapClient;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_SSO
 */
class ZH_SSO
{
    public function __construct()
    {
        //add_action('onelogin_saml_attrs', array($this, 'register_add_meta'), 10);
        //add_action('register_user_sso', array($this, 'add_user_to_installators'), 10);
        add_action('onelogin_saml_attrs', array($this, 'after_onelogin_saml'), 15);
        //add_action('wp_login', array($this, 'first_user_login'), 10, 2);
       // add_filter( 'login_redirect', array($this, 'redirectAfterLogin'), 20, 3 );
        add_action( 'wp_login', array($this, 'redirectOnLogin'), 20, 2 );
    }

    public function after_onelogin_saml( $attrs ){
        $mailMapping = get_option('onelogin_saml_attr_mapping_mail');
        if (!empty($mailMapping) && isset($attrs[$mailMapping]) && !empty($attrs[$mailMapping][0])){
            $user_id = email_exists($attrs[$mailMapping][0]);
        }

        if ($user_id && isset($attrs['HEWALEX_USER'])) {
            $user_sso = json_decode($attrs['HEWALEX_USER'][0], true);
            update_user_meta($user_id, 'installation_group1_installation_user_id', $user_sso['id']);
        }

        $roleMapping = get_option('onelogin_saml_attr_mapping_role');
        $roleMappingInstaller = get_option('onelogin_saml_role_mapping_installator');
        $roleMappingDesigner = get_option('onelogin_saml_role_mapping_designer');
        $roleMappingUser = get_option('onelogin_saml_role_mapping_user');

        $status = false;

        if ($user_id && !empty($roleMapping)){
            $user = new \WP_User($user_id);
            foreach ((array) $user->roles as $role) {
                if (in_array($role, $this->protectedRoles)) {
                    continue;
                }
                $user->remove_role($role);
            }

            foreach ($attrs[$roleMapping] ?? [] as $samlRole) {
                $samlRole = trim($samlRole);

                if($samlRole == $roleMappingInstaller) {
                    $user->add_role('installator');
                    $status = true;
                    $redirect = '/strefa-instalatora';
                }

                if($samlRole == $roleMappingDesigner) {
                    $user->add_role('designer');
                    $status = true;
                    $redirect = '/strefa-designer';
                }

                if($samlRole == $roleMappingUser) {
                    $user->add_role('user');
                    $status = true;
                    $redirect = '/strefa-uzytkownika';
                }
            }
        }

        if ($user_id && isset($attrs['HEWALEX_USER'])) {
            $metas = [];
            $hewalexUser = json_decode($attrs['HEWALEX_USER'][0], true);

            $isInstaller = $hewalexUser['installer']['installers_id'] ?? false;
            if ($isInstaller) {
                $installer = $hewalexUser['installer'];
                $region = $this->selectRegion($installer['installers_region_id']);
                $metas = [
                    'installation_group1_installation_name_installer'   => $installer['installers_name'] ?? '',
                    'installation_group1_installation_nip'       => $installer['installers_nip'] ?? '',
                    'installation_group1_installation_address_installer' => $installer['installers_address'] ?? '',
                    'installation_group1_installation_city_installer'      => $installer['installers_city'] ?? '',
                    'installation_group1_installation_post_code_installer'  => $installer['installers_zip'] ?? '',
                    'installation_group1_installation_phone_installer'  => $installer['installers_phone'] ?? '',
                    'installation_group1_installation_email_installer'  => $installer['installers_email'] ?? '',
                    'installation_group1_installation_province_installer'  => $region ?? '',
                ];
            }

            $metas['installation_group1_installation_user_id'] = $hewalexUser['id'];

            foreach ($metas as $key => $value) {
                if ($value) {
                    update_user_meta($user_id, $key, $value);
                }
            }
        }

        if($status === true) {
            echo '<script type="text/javascript">';
                echo 'window.location.href = '. $redirect;
            echo '</script>';
        }
    }

    function redirectOnLogin($login, $user) {
        if ( isset( $user->roles ) && is_array( $user->roles ) ) {
            if ( in_array( 'administrator', $user->roles ) ) {
                $redirect_to = admin_url(); ; // Your redirect URL
            }
            elseif ( in_array( 'designer', $user->roles ) ) {
                $redirect_to = site_url('/strefa-projektanta');
            }
            elseif ( in_array( 'user', $user->roles ) ) {
                $user_mail = $user->user_email;
                
                $args2 = array(
                    'post_type' => 'installation',
                    'post_status'   => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => 'installation_group_installation_email',
                            'value' => $user_mail,
                            'compare' => '=='
                        )
                    )
      
                );
                $installations_posts = get_posts($args2);
                if(!empty($installations_posts)){
                    $redirect_to = site_url('/strefa-uzytkownika-instalacja-istnieje');
                    $redirect_from = site_url('/strefa-uzytkownika');
              
                    if (site_url($redirect_from) ) { 
                        wp_redirect( $redirect_to, 301 );
                        exit;
                    }
                }

                global $wpdb;;
                $installations_history =  $wpdb->get_results("SELECT * FROM installation WHERE installation_email = $user->user_email LIMIT 1");
            
                if(!empty($installations_history)){
                    wp_redirect(site_url('/strefa-uzytkownika-instalacja-istnieje'));
                }

                else{
                    $redirect_to = site_url('/strefa-uzytkownika');
                }
            }

            elseif ( in_array( 'installator', $user->roles ) ) {
                $redirect_to = site_url('/strefa-instalatora');
            }
         }
        wp_redirect( $redirect_to );
        exit;
    }

    private function selectRegion($region)
    {
        switch($region){
            case '3':
                return 'dolnośląskie';
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
}