<?php
namespace Develtio\ZonesHewalex\Ajax\Controller\Edenred;

use Develtio\ZonesHewalex\eDokumenty\ZH_eDokumentyMethods;
use Develtio\ZonesHewalex\Shop\MyAccount\ZH_Points;
use SoapClient;
use SoapFault;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_EdenredAddCredits
 */

class ZH_EdenredAddCredits
{
    public function addCredit()
    {
        if (!is_user_logged_in()) wp_send_json_error(__("You are not logged in!", "zones-hewalex"));

        $count = $this->countPostByAuthor('ordered_credits', get_current_user_id());

        $edok_id = $this->getEdokIdFromLoggedId();
        $edocsContactData = (new ZH_eDokumentyMethods)->getContactfromEdokById($edok_id);

        $prepaid =  array(
            'isActive' => $edocsContactData['features']['497']['txtval'],
            'validDate' => $edocsContactData['features']['496']['txtval'],
        );

        $currentDateTime = date('Y-m-d');

        $credits = (new ZH_Points)->calculateTotalsPoints();

        if (!$prepaid['isActive']) {
            wp_send_json([
                'state' => 'error',
                'message' => 'Karta nie aktywna',
            ], 422);
        }

        if ($prepaid['validDate'] <= $currentDateTime) {
            wp_send_json([
                'state' => 'error',
                'message' => 'Karta jest nieaktywna',
            ], 422);
        }

        if($credits < $_POST['credits']) {
            wp_send_json([
                'state' => 'error',
                'message' => 'Brak wymaganych punktów na koncie',
            ], 422);
        }

        $args = array(
            'post_author' => $this->getIdInstaller(),
            'post_type' => 'ordered_credits',
            'post_title' => 'Zasilenie karty dla ' . $this->getIdInstaller(),
            'post_status' =>  'publish',
            'meta_input' => array(
                'order_category' => 'credits',
                'credits' => $_POST['credits'],
                'id_order' => $count + 1 . '/' . date('Y'),
                'billing_company' => get_user_meta($this->getIdInstaller(), 'installation_group1_installation_name_installer')[0],
                'billing_nip' => get_user_meta($this->getIdInstaller(), 'installation_group1_installation_nip')[0],
                'billing_address' => get_user_meta($this->getIdInstaller(), 'installation_group1_installation_address_installer')[0],
                'billing_postcode' => get_user_meta($this->getIdInstaller(), 'installation_group1_installation_post_code_installer')[0],
                'billing_city' => get_user_meta($this->getIdInstaller(), 'installation_group1_installation_city_installer')[0],
                'billing_email' => get_user_meta($this->getIdInstaller(), 'installation_group1_installation_email_installer')[0],
                'billing_phone' => get_user_meta($this->getIdInstaller(), 'installation_group1_installation_phone_installer')[0],
                'billing_validDate' => $edocsContactData['features']['496']['txtval'] ?? null,
                'shipping_number' => $edocsContactData['features']['495']['txtval'] ?? null,
                'shipping_validDate' => $edocsContactData['features']['496']['txtval'] ?? null,
            )
        );

        $insert = wp_insert_post($args);

        if((new ZH_Points())->prepareOldPoints() > 0) {
            $this->updatePointsPurchaseOldSystem($_POST['credits']);
        } else {
            $this->updatePointsPurchase($_POST['credits']);
        }

        $array = array(
            'id' => $insert,
            'permalink' => get_permalink($insert) . '?format=pdf&id='. $insert,
        );
        echo json_encode($array);

        die();
    }

    public function updatePointsPurchaseOldSystem($credits)
    {
        global $wpdb;
        $table = 'points_installer_old';
        $points = (new ZH_Points())->prepareOldPoints();

        $user_id = get_current_user_id();
        $nip = get_user_meta($user_id, 'installation_group1_installation_nip', true);

        $old_value_purchase = $wpdb->get_results("SELECT * FROM points_installer_old WHERE `nip` = {$nip} AND `archive` = 0 LIMIT 1");

        if($credits >= $points) {
            if($old_value_purchase[0]->purchase) {
                $wpdb->update( $table, array( 'purchase' =>  $points + $old_value_purchase[0]->purchase), array( 'nip' => $nip));
                $credits = $credits - $points;

                if($credits > 0) {
                    $this->updatePointsPurchase($credits);
                }
            }
        }
        else {
            $new_value = $old_value_purchase[0]->purchase + $credits;
            $wpdb->update( $table, array( 'purchase' =>  $new_value), array( 'nip' => $nip));
        }
    }

    public function updatePointsPurchase($credits)
    {
        $arr = [];
        foreach($this->getAllInstallationsFromInstallator() as $k => $installation) {
            $arr[$k]['date'] = date("Y-m-d", strtotime($installation->post_date));
            $arr[$k]['id'] = $installation->ID;
            $arr[$k]['points_received'] = get_field('installation_group4_installation_points_active', $installation->ID) ? get_field('installation_group4_installation_points_active', $installation->ID) : 0;
            $arr[$k]['points_purchase'] = get_field('installation_group4_installation_points_purchase', $installation->ID) ? get_field('installation_group4_installation_points_purchase', $installation->ID) : 0;
            $arr[$k]['sum'] = get_field('installation_group4_installation_points_active', $installation->ID) - get_field('installation_group4_installation_points_purchase', $installation->ID);
        }
        sort($arr);

        $points = $credits;

        foreach($arr as $k => $v) {
            if($v['sum'] == $v['points_received']){
                if($points > $v['points_received']) {
                    update_post_meta($v['id'], 'installation_group4_installation_points_purchase', $v['points_received']);
                    $points = $points - $v['points_received'];
                } else {
                    update_post_meta($v['id'], 'installation_group4_installation_points_purchase', $points);
                    $points = 0;
                }
                if($points === 0) {
                    break;
                }
            } else {
                $old_value_purchase = get_field('installation_group4_installation_points_purchase', $v['id']);
                $sum_points_if_old_value = $v['points_received'] - $old_value_purchase;

                if($sum_points_if_old_value >= $points) {
                    update_post_meta($v['id'], 'installation_group4_installation_points_purchase', $points + $old_value_purchase);
                    $points = 0;
                } else {
                    update_post_meta($v['id'], 'installation_group4_installation_points_purchase', $v['points_received']);
                    $points = $points - $sum_points_if_old_value;
                }
            }
        }
    }

    public function getAllInstallationsFromInstallator()
    {
        $args = [
            'post_type' => 'installation',
            'author' =>  $this->getIdInstaller(),
            'post_per_page' => -1,
            'post_status' =>  'publish',
        ];

        return get_posts($args);
    }

    private function countPostByAuthor($post_type, $id)
    {
        $args = array(
            'post_type' => $post_type,
            'author' => $id,
            'posts_per_page' => -1
        );
        $result = get_posts($args);
        return count($result);
    }

    private function getEdokIdFromLoggedId()
    {
        $user_id = get_current_user_id();
        $email_sso = get_user_meta($user_id, 'installation_group1_installation_email_installer');

        try {
            $client = new SoapClient(null, ZH_eDokumentyMethods::getOps());
            $params = array(
                'email_' => $email_sso['0']
            );

            $response = $client->searchContacts($params);

            foreach ($response as $contact_details => $val) {
                $contact_details = $client->getContact($val, false);

                update_user_meta($user_id, 'installation_group1_installation_id_edok', $contact_details['contid']);
            }
        } catch (SoapFault $e) {
            print_r('connection failed');
            wp_logout();
            exit();
        }

        $edok_id = get_user_meta($user_id, 'installation_group1_installation_id_edok');
        return $edok_id['0'] ?? null;
    }

    /**
     * @return int
     */
    private function getIdInstaller()
    {
        $user = wp_get_current_user();
        return $user->ID;
    }
}