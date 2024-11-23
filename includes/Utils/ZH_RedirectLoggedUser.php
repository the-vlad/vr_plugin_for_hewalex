<?php

namespace Develtio\ZonesHewalex\Utils;

use Develtio\ZonesHewalex\Utils\ZH_UserRole;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_RedirectLoggedUser
 */
class ZH_RedirectLoggedUser
{
    /**
     * ZH_RedirectLoggedUser constructor.
     */
    public function __construct()
    {
        add_action( 'zone_current_profile_redirect', array($this, 'redirectAssignedZone') );
        add_action( 'admin_init', array($this, 'restrictedAdminPanel'), 1 );
        add_action('zone_current_profile_logout', array($this, 'logout'));
    }

    public function redirectAssignedZone()
    {
        $login_page = 'wp-login.php';
        $redirect_to = isset($_GET['redirect_to']) ? '&redirect_to='.$_GET['redirect_to'] : '';

        switch(ZH_UserRole::getCurrentLoggedUserRole()) {
            case 'designer':
                $output = site_url('/strefa-projektanta');
                break;
            case 'user':
                $output = site_url('/strefa-uzytkownika');
                break;
            case 'installator':
                $output = site_url('/strefa-instalatora');
                break;
            default:
//                $output = wp_login_url();
//                $output = site_url('/wp-login.php?saml_sso');
                $output = esc_url( get_site_url().'/'.$login_page.'?saml_sso'.$redirect_to);
        }
        echo $output;
    }

    public function restrictedAdminPanel()
    {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return;
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_redirect( home_url() );
            exit;
        }
    }

    public function logout()
    {
        if ( is_user_logged_in() ) {
            echo '<a class="logout-btn" href=' . wp_logout_url(home_url()) . '> <img alt="logout" src="'. ZH_URL .'assets/img/logout_user.svg' . '"/></a>';
        }
 
    }
}