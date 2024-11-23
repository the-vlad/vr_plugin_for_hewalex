<?php
namespace Develtio\ZonesHewalex\Ajax\Controller\Cart;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_DeleteCart
 */

class ZH_DeleteCart
{
    public function deleteCart(){
        $permission = check_ajax_referer( 'deleteCart_nonce', 'nonce', false );
        if( $permission == false ) {
            echo 'error';
        }
        else {
            wp_delete_post( $_REQUEST['id'] );
            echo 'success';
        }
        die();
    }

    public function deleteHistoryCart(){
        $permission = check_ajax_referer( 'deleteHistoryCart_nonce', 'nonce', false );
        if( $permission == false ) {
            echo 'error';
        }
        else {
            global $wpdb;

            $delete_cart = "DELETE FROM offer_forms WHERE offer_form_id = {$_REQUEST['id']}";
            $delete_action = $wpdb->query($delete_cart);

            if($delete_action) {
                echo 'success';
            } else {
                echo 'nie udało się usunąć koszyka';
            }
        }
        die();
    }
}