<?php

namespace Develtio\ZonesHewalex\Utils;

use Develtio\ZonesHewalex\Admin\ZH_Installations_History;
use Develtio\ZonesHewalex\API\model\ZH_HewalexPVWorker;
use Develtio\ZonesHewalex\API\model\ZH_Installers;
use Develtio\ZonesHewalex\API\model\ZH_OfferForm;
use Develtio\ZonesHewalex\API\model\ZH_OfferFormPCWB;
use Develtio\ZonesHewalex\API\model\ZH_OfferFormShop;
use Develtio\ZonesHewalex\API\ZH_HewalexInternal;
use Develtio\ZonesHewalex\API\ZH_Mounting;
use Develtio\ZonesHewalex\eDokumenty\ZH_eDokumentyMethods;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Rest
 */
class ZH_Rest
{
    public function __construct()
    {
        // add_action( 'rest_api_init', array( $this, 'rest_endpoint_contacts'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_collectorsun'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_pompheat'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_pompheatwater'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_pompheatpool'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_optiener'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_sunheat'));
        add_action( 'rest_api_init', array( $this, 'rest_distributor_endpoint_sunheat'));
        add_action( 'rest_api_init', array( $this, 'rest_distributor_endpoint_collectorsun'));
        add_action( 'rest_api_init', array( $this, 'rest_distributor_endpoint_pompheatpool'));
        add_action( 'rest_api_init', array( $this, 'rest_distributor_endpoint_pompheatwater'));
        add_action( 'rest_api_init', array( $this, 'rest_distributor_endpoint_pompheat'));
        add_action( 'rest_api_init', array( $this, 'rest_distributor_endpoint_optiener'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_mounting_cart_wc'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_mounting_cart_wc_offers'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_mounting_cart_wc_carts_order'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_offer_form'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_offer_form2'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_offer_form_preview'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_resources'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_installer_auth'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_hewalex_worker_auth'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_get_cart'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_update_cart'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_installer_prepaid_card'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_installer_installations'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_order_card_add'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_order_card_get'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_get_history_installation'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_installer_prepaid_card_patch'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_hewalex_internal'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_offer_pcwb'));
        add_action( 'rest_api_init', array( $this, 'rest_endpoint_offer_form_preview_history'));
    }

    /**
     * Endpoint for resources with params
     */
    public function rest_endpoint_resources() {
        register_rest_route('hewalex-zones/v2', '/resources', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferForm(), 'getResources')
        ));
    }

    /**
     * Endpoint for offerForm
     */
    public function rest_endpoint_offer_form() {
        register_rest_route('hewalex-zones/v2', '/offerForm', array(
            'methods'             => 'POST',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferForm(), 'offerForm')
        ));
    }

    public function rest_endpoint_offer_form2() {
        register_rest_route('hewalex-zones/v2', '/offerForm', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferForm(), 'getParentHash'),
        ));
    }

    public function rest_endpoint_offer_form_preview() {
        register_rest_route('hewalex-zones/v2', '/offerFormPreview', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferForm(), 'generateFormByHash')
        ));
    }

    public function rest_endpoint_offer_form_preview_history() {
        register_rest_route('hewalex-zones/v2', '/offerFormPreviewHistory', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferForm(), 'generateFormByHashHistory')
        ));
    }

    /**
     * Endpoint installer authorization
     */
    public function rest_endpoint_installer_auth() {
        register_rest_route('hewalex-zones/v2', '/installer', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Installers(), 'getInstallerData'),
        ));
    }

    public function rest_endpoint_hewalex_worker_auth() {
        register_rest_route('hewalex-zones/v2', '/hewalexPVWorker', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_HewalexPVWorker(), 'getHewalexWorkerData'),
        ));
    }

    /**
     * Endpoint for generate cart in WooCommerce sklep.hewalex.pl
     */
    public function rest_endpoint_mounting_cart_wc_offers() {
        register_rest_route('hewalex-zones/v2', '/products', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Mounting(), 'getProducts')
        ));
    }

    /**
     * Endpoint for generate cart in WooCommerce sklep.hewalex.pl
     */
    public function rest_endpoint_mounting_cart_wc_carts_order() {
        register_rest_route('hewalex-zones/v2', '/products_carts', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferFormShop(), 'getProducts')
        ));
    }

    /**
     * Endpoint to generate hash
     */
    public function rest_endpoint_mounting_cart_wc() {
        register_rest_route('hewalex-zones/v2', '/mounting', array(
            'methods'             => 'POST',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Mounting(), 'getHash')
        ));
    }

    /**
     * return REST route
     * wp-json/hewalex-zones/v2/contacts
     */
    public function rest_endpoint_contacts() {
        register_rest_route('hewalex-zones/v2', '/contacts', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getContacts')
        ));
    }

    /**
     * Endpoint for get products from cart and add to CPT
     */
    public function rest_endpoint_get_cart()
    {
        register_rest_route('hewalex-zones/v2', '/getCartFromShop', array(
            'methods'             => 'POST',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferFormShop(), 'getCartFromShop')
        ));
    }

    /**
     * Endpoint for update cart
     */
    public function rest_endpoint_update_cart()
    {
        register_rest_route('hewalex-zones/v2', '/updateCartFromShop', array(
            'methods'             => 'POST',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferFormShop(), 'updateCartFromShop')
        ));
    }

    /**
     * Endpoints for Edenred Statuses
     * wp-json/hewalex-zones/v2/installerprepaidcard
     */
    public function rest_endpoint_installer_prepaid_card()
    {
        register_rest_route('hewalex-zones/v2', '/installerprepaidcard', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Installers(), 'installerPrepaidCardGet')
        ));
    }

    public function rest_endpoint_installer_prepaid_card_patch()
    {
        register_rest_route('hewalex-zones/v2', '/installerprepaidcardpatch', array(
            'methods'             => 'POST',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Installers(), 'installerPrepaidCardPatch')
        ));
    }

    public function rest_endpoint_installer_installations()
    {
        register_rest_route('hewalex-zones/v2', '/installerinstallations', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Installers(), 'installerInstallationsGet')
        ));
    }

    public function rest_endpoint_order_card_add()
    {
        register_rest_route('hewalex-zones/v2', '/addOrderCard', array(
            'methods'             => 'POST',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Installers(), 'orderCardPost')
        ));
    }

    public function rest_endpoint_order_card_get()
    {
        register_rest_route('hewalex-zones/v2', '/getOrderCard', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Installers(), 'orderCardGet')
        ));
    }

    public function rest_endpoint_get_history_installation()
    {
        register_rest_route('hewalex-zones/v2', '/history_installation', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_Installations_History(), 'getInstallationbyId')
        ));
    }

    /**
     * API HewalexInternal for Files OfferForm
     */
    public function rest_endpoint_hewalex_internal()
    {
        register_rest_route('hewalex-zones/v2', '/hewalexinternal', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_HewalexInternal(), 'getGeneratedForm')
        ));
    }

    /**
     * PrepareFastOffer for PCWB
     */
    public function rest_endpoint_offer_pcwb()
    {
        register_rest_route('hewalex-zones/v2', '/prepareOffer', array(
            'methods'             => 'POST',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_OfferFormPCWB(), 'getPreparedClientOfferForJson')
        ));
    }


    /* @Installer */
    public function rest_endpoint_collectorsun() {
        register_rest_route('hewalex-zones/v2/', 'contacts/installer/collectorsun', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getCollectorSun')
        ));
        
    }

    public function rest_endpoint_pompheat() {
        register_rest_route('hewalex-zones/v2/', 'contacts/installer/pompheat', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getPompHeat')
        ));
    }

    public function rest_endpoint_pompheatwater() {
        register_rest_route('hewalex-zones/v2/', 'contacts/installer/pompheatwater', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getPompHeatWater')
        ));
    }

    public function rest_endpoint_pompheatpool() {
        register_rest_route('hewalex-zones/v2/', 'contacts/installer/pompheatpool', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getPompHeatPool')
        ));
    }

    public function rest_endpoint_optiener() {
        register_rest_route('hewalex-zones/v2/', 'contacts/installer/optiener', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getOptiEner')
        ));
    }

    public function rest_endpoint_sunheat() {
        register_rest_route('hewalex-zones/v2/', 'contacts/installer/sunheat', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getSunHeat')
        ));
    }




    /* @Distributor */

    public function rest_distributor_endpoint_sunheat() {
        register_rest_route('hewalex-zones/v2/', 'contacts/distributor/sunheat', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getSunHeatDistributor')
        ));
    }


    public function rest_distributor_endpoint_collectorsun() {
        register_rest_route('hewalex-zones/v2/', 'contacts/distributor/collectorsun', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getCollectorSunDistributor')
        ));
    }



    public function rest_distributor_endpoint_pompheat() {
        register_rest_route('hewalex-zones/v2/', 'contacts/distributor/pompheat', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getPompHeatDistributor')
        ));
    }
    

    public function rest_distributor_endpoint_pompheatwater() {
        register_rest_route('hewalex-zones/v2/', 'contacts/distributor/pompheatwater', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getPompHeatWaterDistributor')
        ));
    }


    public function rest_distributor_endpoint_pompheatpool() {
        register_rest_route('hewalex-zones/v2/', 'contacts/distributor/pompheatpool', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getPompHeatPoolDistributor')
        ));
    }

    public function rest_distributor_endpoint_optiener() {
        register_rest_route('hewalex-zones/v2/', 'contacts/distributor/optiener', array(
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => array(new ZH_eDokumentyMethods(), 'getOptiEnerDistributor')
        ));
    }
    


}