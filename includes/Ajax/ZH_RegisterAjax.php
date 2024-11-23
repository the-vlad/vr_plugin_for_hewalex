<?php
namespace Develtio\ZonesHewalex\Ajax;

use Develtio\ZonesHewalex\Ajax\Controller\Cart\ZH_DeleteCart;
use Develtio\ZonesHewalex\Ajax\Controller\InstallationForm\ZH_CheckNumberSet;
use Develtio\ZonesHewalex\Ajax\Controller\InstallationForm\ZH_SaveForm;
use Develtio\ZonesHewalex\Ajax\Controller\InstallationForm\ZH_SaveFormByInstallator;
use Develtio\ZonesHewalex\Ajax\Controller\Products\ZH_FetchProducts;
use Develtio\ZonesHewalex\Ajax\Controller\Edenred\ZH_EdenredAddCredits;
use Develtio\ZonesHewalex\Ajax\Controller\SalesManago\ZH_SalesManagoAjax;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_RegisterAjax
 */
class ZH_RegisterAjax
{
    public function __construct()
    {
        add_action('wp_ajax_SaveForm', [new ZH_SaveForm(), 'saveForm']);
        add_action('wp_ajax_nopriv_SaveForm', [new ZH_SaveForm(), 'saveForm']);

        add_action('wp_ajax_CheckNumberSet', [new ZH_CheckNumberSet(), 'checkNumberSet']);
        add_action('wp_ajax_nopriv_CheckNumberSet', [new ZH_CheckNumberSet(), 'checkNumberSet']);

        add_action('wp_ajax_nopriv_SaveFormByInstallator', [new ZH_SaveFormByInstallator(), 'saveFormByInstallator']);
        add_action('wp_ajax_SaveFormByInstallator', [new ZH_SaveFormByInstallator(),  'saveFormByInstallator']);

        add_action('wp_ajax_FetchProducts' , [new ZH_FetchProducts(), 'fetchProducts']);
        add_action('wp_ajax_nopriv_FetchProducts' , [new ZH_FetchProducts(), 'fetchProducts']);

        add_action('wp_ajax_nopriv_addCredit', [new ZH_EdenredAddCredits(), 'addCredit']);
        add_action('wp_ajax_addCredit', [new ZH_EdenredAddCredits(),  'addCredit']);

        add_action('wp_ajax_newsletter', [new ZH_SalesManagoAjax(), 'saveDataNewsletter']);
        add_action('wp_ajax_nopriv_newsletter', [new ZH_SalesManagoAjax(), 'saveDataNewsletter']);

        add_action( 'wp_ajax_deleteCart', [new ZH_DeleteCart(), 'deleteCart' ]);
        add_action( 'wp_ajax_nopriv_deleteCart', [new ZH_DeleteCart(), 'deleteCart' ]);

        add_action( 'wp_ajax_deleteHistoryCart', [new ZH_DeleteCart(), 'deleteHistoryCart' ]);
        add_action( 'wp_ajax_nopriv_deleteHistoryCart', [new ZH_DeleteCart(), 'deleteHistoryCart' ]);
    }
}