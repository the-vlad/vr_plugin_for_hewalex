<?php

namespace Develtio\ZonesHewalex\API\model;

use Develtio\ZonesHewalex\eDokumenty\ZH_eDokumentyMethods;
use SoapClient;
use SoapFault;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Installers
 */
class ZH_Installers
{
    public function getInstallerData()
    {
        if (!(is_user_logged_in() ?? null) || get_user_meta(get_current_user_id(), 'installation_group1_installation_hewalex_worker')[0]) {
            return new \WP_REST_Response( 'Not authorization', 401 );
        }
        return new \WP_REST_Response( ZH_Installers::modelInstaller(wp_get_current_user()), 200 );
    }

    public function getIdInstallator()
    {
        if(!is_user_logged_in()){
            return;
        }

        $user = wp_get_current_user();
        return $user->ID;
    }

    public function modelInstaller($installer_user) : array
    {
        return array(
            'installers_id' => $installer_user->ID,
            'installers_name' => $installer_user->display_name,
            'installers_email' => $installer_user->user_email,
            'installers_phone' => get_user_meta($installer_user->ID, 'installation_group1_installation_phone_installer')[0],
            'installers_nip' => get_user_meta($installer_user->ID, 'installation_group1_installation_nip')[0],
            'installers_address' => get_user_meta($installer_user->ID, 'installation_group1_installation_address_installer')[0],
            'installers_zip' => get_user_meta($installer_user->ID, 'installation_group1_installation_post_code_installer')[0],
            'installers_city' => get_user_meta($installer_user->ID, 'installation_group1_installation_city_installer')[0],
            'installers_mailing' => '',
            'installers_updated' => $installer_user->user_updated,
            'installers_registered' => $installer_user->user_registered,
            'users_id' => get_user_meta($installer_user->ID, 'installation_group1_installation_user_id')[0],
            'edoc_contid' => get_user_meta($installer_user->ID, 'installation_group1_installation_id_edok')[0]
        );
    }

    /**
     * @param int $installer_user
     * @return array
     */
    public function installerPrepaidCardGet() : array
    {
        $edok_id = $this->getEdokIdFromLoggedId();
        $edocsContactData = (new ZH_eDokumentyMethods)->getContactfromEdokById($edok_id);

        return array(
            'number' => $edocsContactData['features']['495']['txtval'] ?? null,
            'validDate' => $edocsContactData['features']['496']['txtval'] ?? null,
            'status' => $edocsContactData['features']['497']['txtval'] ?? null,
            'isSent' => ($edocsContactData['features']['497']['txtval'] ?? null) === 'Wysłana',
            'isActive' => ($edocsContactData['features']['497']['txtval'] ?? null) === 'Zarejestrowana'
        );
    }

    public function installerPrepaidCardPatch()
    {
        $edok_id = $this->getEdokIdFromLoggedId();

        $body = $_POST;

        $paramsCollection = array_get($body, 'params');

        $params = [];
        foreach ($paramsCollection as $param) {
            $params[$param['name']] = $param['value'];
        }

        $paramsAvailableToModify = ['number', 'validDate', 'status'];
        $paramsToSet = array_only($params, $paramsAvailableToModify);

        $map = ['number' => '495', 'validDate' => '496', 'status' => '497'];
        $client = (new ZH_eDokumentyMethods)->connectClient();

        foreach ($paramsToSet as $key => $value) {
            if (!$map[$key]) {
                continue;
            }

            $client->setFeatureValue($map[$key], 'contacts', $edok_id, $value);
        }
        wp_send_json([], 200);
    }

    public function getEdokIdFromLoggedId()
    {
        $user_id = get_current_user_id();
        $email_sso = get_user_meta($user_id, 'installation_group1_installation_email_installer');

        try {
            $client = new SoapClient(null, ZH_eDokumentyMethods::getOps());
            $params = array(
                //'name_1' => !null,
                'email_' => $email_sso['0']
            );

            $response = $client->searchContacts($params);

            foreach ($response as $contact_details => $val) {
                $contact_details = $client->getContact($val, false);

                update_user_meta($user_id, 'installation_group1_installation_id_edok', $contact_details['contid']);
            }
        } catch (SoapFault $e) {
            print_r('connection failed');
            exit();
        }

        $edok_id = get_user_meta($user_id, 'installation_group1_installation_id_edok');
        return $edok_id['0'] ?? null;
    }

    public function installerInstallationsGet()
    {
        $user_id = get_current_user_id();

        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'installation',
            'author' => $user_id,
            'post_status' =>  'publish'
        );

        $installations = get_posts($args);

        $arr = array();

        if(!isset($installations)){
            return new \WP_REST_Response('not found');
        }
        else {
            foreach($installations as $key => $installation)
            {
                $arr[$key] = array(
                    'installation_id' => $installation->ID,
                );
            }
            return $arr;
        }
    }

    public function orderCardPost()
    {
        $installer = get_current_user_id();

        $count = $this->countPostByAuthor('ordered_cards', get_current_user_id());

        $args = array(
            'post_type' => 'ordered_cards',
            'post_title' => 'Zamówienie karty dla ' . $installer,
            'post_author' => $installer,
            'post_status' =>  'publish',
            'meta_input' => array(
                'id_order' => $count + 1 . '/' . date('Y'),
                'billing_company' => $_POST['billing']['0']['value'],
                'billing_nip' => $_POST['billing']['1']['value'],
                'billing_address' => $_POST['billing']['2']['value'],
                'billing_postcode' => $_POST['billing']['4']['value'],
                'billing_city' => $_POST['billing']['3']['value'],
                'billing_province' => '',
                'billing_country' => '',
                'billing_email' => $_POST['billing']['6']['value'],
                'billing_phone' => $_POST['billing']['5']['value'],
                'shipping_contact_person' => $_POST['shipping']['4']['value'],
                'shipping_address' => $_POST['shipping']['0']['value'],
                'shipping_postcode' => $_POST['shipping']['1']['value'],
                'shipping_city' => $_POST['shipping']['2']['value'],
                'shipping_province' => '',
                'shipping_country' => '',
                'shipping_phone' => $_POST['shipping']['3']['value'],
                'order_category' => $_POST['category'],
                'basket' => json_encode($_POST['basket']),
                'billing' => json_encode($_POST['billing']),
                'shipping' => json_encode($_POST['shipping']),
            )
        );

        $result = wp_insert_post($args);

        if($result){
            return array(
                'id' => $result,
                'orderPaid' => true,
                'permalink' => get_permalink($result)
            );
        }
    }

    public function countPostByAuthor($post_type, $id)
    {
        $args = array(
            'post_type' => $post_type,
            'author' => $id,
            'posts_per_page' => -1
        );
        $result = get_posts($args);
        return count($result);
    }

    public function orderCardGet()
    {
        $installer = get_current_user_id();

        $args = array(
            'post_type' => 'ordered_cards',
            'author' => $installer,
            'post_status' =>  'publish',
        );
        $results = get_posts($args);

        foreach ($results as $result) {
            return array(
                'order_id' => $result->ID,
                'order_category' => get_field('order_category', $result->ID),
                'order_number' => '',
                'contact_path' => get_user_meta($installer, 'installation_group1_installation_user_id')[0],
                'installer_id' => $installer,
                'basket' => json_decode(get_field('basket', $result->ID), true),
                'billing' => json_decode(get_field('billing', $result->ID), true),
                'shipping' => json_decode(get_field('shipping', $result->ID), true),
                'permalink' => get_permalink($result->ID)
            );
        }

        if(isset($results)) {
            return [];
        }
    }
}