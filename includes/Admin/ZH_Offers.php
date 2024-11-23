<?php

namespace Develtio\ZonesHewalex\Admin;

if (!defined('ABSPATH')) {
    die;
}

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Class ZH_Installations_History
 */
class ZH_Offers
{
    public function __construct()
    {
        add_action('admin_menu', array( $this, 'registerOffers') );
        add_action('in_admin_footer', array( $this, 'popupEditPostOffers') );
        add_action( 'wp_ajax_edit_update_offer_forms',  array( $this, 'edit_update_offer_forms') );
    }



    public function registerOffers()
    {
        add_menu_page('offer_forms','Oferty i koszyki (historyczne)','manage_options','offer_forms',array($this, 'offer_forms_callback'),'dashicons-media-text',33);
    }

    public function offer_forms_callback()
    {
        $action = isset($_GET['action']) ? trim($_GET['action']) : '';
        $page = isset($_GET['page']) ? trim($_GET['page']) : '';

        if ( $action === 'edit' && $page === 'offer_forms') {
            require_once( ZH_DIR . 'includes/Admin/templates/edit-offers.php');
        } else {
            require_once( ZH_DIR . 'includes/Admin/templates/offers.php');
        }
    }

    function custom_meta_box_markup()
    {

    }

    function add_custom_meta_box()
    {
        add_meta_box("demo-meta-box", "Custom Meta Box", "custom_meta_box_markup", "post", "side", "high", null);
    }

    public function getOffersbyId(\WP_REST_Request $request)
    {
        global $wpdb;

        $sql = "SELECT * FROM offer_forms WHERE installation_id LIKE {$request->get_param('installation_id')} LIMIT 1";
        $data = $wpdb->get_results($sql, ARRAY_A);

        if($data[0]['installation_installator_nip']) {
            $sql1 = "SELECT * FROM installers WHERE installers_nip LIKE {$data[0]['installation_installator_nip']} LIMIT 1";
            $data1 = $wpdb->get_results($sql1, ARRAY_A);
        }

        if(!empty($data1)) {
            return array_merge($data[0], $data1[0]);
        }

        return array_merge($data[0]);
    }

    public function popupEditPostOffers()
    {
        add_thickbox();

        echo '
        <div id="my-content-id" style="display: none">
            <div id="loading-image">ładuje ...</div>
             <fieldset style="padding: 20px 0; display: block; border: 1px groove #000; margin: 20px 0px">
                <legend>Dane klienta:</legend>
                <table>
                    <tr>
                        <td><strong>'. __('Numer zestawu: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-number-kit"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Numer pompy: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-number-pump"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('E-mail: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-mail"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Nazwa: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-name"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Adres: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-address"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Telefon: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-phone"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Data instalacji: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-date-ins"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Numer podgrzewacza: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-number-podgrzewacza"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Numer zespołu pompowego-sterowniczego: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-number-zespolu-pompowego"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Numery kolektorów: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-number-collectors"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Typ zestawu: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-type-set"></div></td>
                    </tr>
                </table>
            </fieldset>
            
             <fieldset style="padding: 20px 0; display: block; border: 1px groove #000; margin: 20px 0px">
                <legend>Dane instalatora:</legend>
                <table>
                    <tr>
                        <td><strong>'. __('ID instalatora: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-id-installator"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('E-mail instalatora: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-email-installator"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Instalator: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-installator"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('NIP: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-installator-nip"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Telefon: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-installator-phone"></div></td>
                    </tr>
                    <tr>
                        <td><strong>'. __('Adres: ', 'zones-hewalex') .'</strong></td>
                        <td><div class="edit-post-installator-address"></div></td>
                    </tr>
                </table>
            </fieldset>
            
             <fieldset style="padding: 20px 0; display: block; border: 1px groove #000; margin: 20px 0px">
                <legend>Uwagi klienta:</legend>
                <table>
                    <tr>
                        <td colspan="2">
                            <div class="edit-post-client-comments"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
            
           <fieldset style="padding: 20px 0; display: block; border: 1px groove #000; margin: 20px 0px">
                <legend>Komentarze Hewalex:</legend>
                <table>
                    <tr>
                        <td><strong>'. __('Komentarz: ', 'zones-hewalex') .'</strong></td>
                        <td><textarea class="edit-post-comment"></textarea></td>
                    </tr>
                </table>
            </fieldset>
            
            <input class="zh-update-history-installation button-primary" type="button" value="'. __('Zaktualizuj', 'zones-hewalex') .'"/>
        </div>
        ';

    }

    public function edit_update_offer_forms()
    {
        var_dump($_POST);
        wp_die();


//        $post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;
//        $post_content = isset( $_POST['post_content'] ) ? sanitize_textarea_field( $_POST['post_content'] ) : '';
//        $post_name = isset( $_POST['post_name'] ) ? sanitize_text_field( $_POST['post_name'] ) : '';
//
//        $data = array(
//            'ID'              => $post_id,
//            'post_title'      => $post_name,
//            'post_content'    => $post_content,
//        );
//
//        wp_update_post( $data );
//
//        wp_die();
    }
}