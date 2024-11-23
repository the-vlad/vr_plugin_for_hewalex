<?php

namespace Develtio\ZonesHewalex\Utils;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Enqueue
 */
class ZH_Enqueue
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts',  array( $this, 'enqueueScripts' ));
        add_action( 'admin_enqueue_scripts',  array( $this, 'enqueueScriptsAdmin' ));
    }

    public function enqueueScriptsAdmin()
    {
        $screen = get_current_screen();

        if ( in_array( $screen->id, array( 'toplevel_page_history-installations' ) ) ) {
            wp_enqueue_style( 'admin-edit-installation-css', ZH_URL . 'dist/admin/css/index.css' );
            wp_enqueue_script( 'admin-edit-installation-js', ZH_URL . 'dist/admin/js/index.js', array(), '1.0' );
            wp_deregister_script('heartbeat');

            wp_localize_script( 'admin-edit-installation-js', 'custom_scripts',

                array(
                    'ajax_url'  => admin_url( 'admin-ajax.php' ),
                    'nonce' => wp_create_nonce( 'wp_rest' ),
                )
            );
        }
    }

    public function enqueueScripts()
    {
        wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAPS_KEY . '&sensor=false&amp;libraries=places');
        wp_enqueue_script( 'jquery-min', ZH_URL. '/public/js/common/jquery.min.js');

        wp_enqueue_script( 'jquery-ui', ZH_URL. '/public/js/common/jquery-ui.min.js');
        wp_enqueue_style( 'jquery-ui-style', ZH_URL. '/public/css/common/jquery-ui.css');
        wp_enqueue_script( 'moment-js', ZH_URL. '/public/js/common/moment-with-locales.min.js');
        wp_enqueue_script( 'instalator-template', ZH_URL.'dist/scripts/main.js', '', '', false);
        wp_enqueue_script( 'distributor-template', ZH_URL.'dist/scripts/main.js', '', '', false);

        wp_enqueue_style( 'map-style', ZH_URL.'dist/css/index.css');

        wp_enqueue_script( 'main-react', ZH_URL.'/dist/react_dist/js/index.js', '', '', true);
        wp_localize_script( 'main-react', 'wp_object', array(
            'ajax_url' => ZH_AJAX,
            'user_email' => wp_get_current_user()->user_email,
        ) );

        $id = get_the_ID();
        $template_name = basename(get_page_template_slug($id));

        /**
         * Narzędzia doboru (Kalkulatory)
         */
        if ( ($template_name === 'page-template-instalator-calculator-pv.php') ||
             ($template_name === 'page-template-instalator-calculator-mount.php') ||
             ($template_name === 'page-template-instalator-calculator-pcco.php') ||
             ($template_name === 'page-template-instalator-calculator-pcwb.php') ||
             ($template_name === 'page-template-instalator-offers-edit.php') ||
             ($template_name === 'page-template-instalator-edenred-charge.php')||
             ($template_name === 'page-template-instalator-oze.php')
        ) {
                wp_enqueue_script( 'commons', ZH_URL. '/public/js/common/common-functions.js?v=2');
                wp_enqueue_style( 'bootstrap-css', ZH_URL. '/public/css/common/bootstrap.min.css');
                wp_enqueue_style( 'theme-admin-extension', ZH_URL. '/public/css/common/theme-admin-extension.css');
                wp_enqueue_style( 'extension', ZH_URL. '/public/css/common/extension.css');
                wp_enqueue_style( 'font-awesome', ZH_URL. '/public/css/common/all.min.css');
                wp_enqueue_style( 'theme-elements-css', ZH_URL. '/public/css/common/theme-elements.css');
                wp_enqueue_style( 'default-css', ZH_URL. '/public/css/common/default.css');
                wp_enqueue_style( 'theme-animate', ZH_URL. '/public/css/common/theme-animate.css');
                wp_enqueue_style( 'simple-line-css', ZH_URL. '/public/css/common/simple-line-icons.min.css');
                wp_enqueue_script( 'bootstrap-js', ZH_URL. '/public/js/common/bootstrap.min.js');
                wp_enqueue_script( 'bootstrap-wizard', ZH_URL. '/public/js/common/jquery.bootstrap.wizard.js');
                wp_enqueue_script( 'masked-input', ZH_URL. 'public/js/common/jquery.maskedinput.js');
                wp_enqueue_script( 'jquery-validator', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js');
        }

        /**
         * Kalkulator mocowań
         */
        if( ($template_name === 'page-template-instalator-calculator-mount.php') )
        {
            wp_enqueue_style( 'chunk-vendors-css', ZH_URL. '/public/css/mounting/chunk-vendors.5c0a3bbe.css');
            wp_enqueue_style( 'app-css', ZH_URL. '/public/css/mounting/app.3f30f96a.css');
            wp_enqueue_style( 'app-fix-css', ZH_URL. '/public/css/mounting/app-fix.css');
            wp_enqueue_script( 'chunk-vendors-js', ZH_URL. '/public/js/mounting/chunk-vendors.7c3c5b82.js', '', '', true);
            wp_enqueue_script( 'pdf-js', ZH_URL. '/public/js/mounting/jspdf.min.js');
            wp_enqueue_script( 'pdf-autotable-js', ZH_URL. '/public/js/mounting/jspdf.plugin.autotable.js');
            wp_enqueue_script( 'pdf-opensans-js', ZH_URL. '/public/js/mounting/OpenSans-Regular-normal.js');
        }

        /**
         * Kalkulator PCWB
         */
        if( ($template_name === 'page-template-instalator-calculator-pcwb.php') )
        {
//            wp_enqueue_script( 'jquery-stellar', ' ZH_URL. porto/vendor/jquery.stellar/jquery.stellar.js');
        }


        /*
         Prepaid Edenred
         */
        if( ($template_name === 'page-template-instalator-oze.php') )
        {
          wp_enqueue_script( 'awn', 'https://cdnjs.cloudflare.com/ajax/libs/awesome-notifications/3.1.0/index.var.js');
          wp_enqueue_style( 'awn', 'https://cdnjs.cloudflare.com/ajax/libs/awesome-notifications/3.1.0/style.min.css');
          wp_enqueue_script( 'prepaid-card', ZH_URL . '/public/js/installer/prepaid-card.js');
          wp_enqueue_script( 'match-height', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js');

          wp_localize_script( 'prepaid-card', 'prepaid',
          array(
              'nonce' => wp_create_nonce( 'wp_rest' ),
          )
         );
        }

        if($template_name === 'page-template-instalator-map.php') {
            wp_enqueue_script( 'installer-map', ZH_URL. '/dist/scripts/map/installer/map.js');
           }
    
           if($template_name === 'page-template-distributor.php') {
            wp_enqueue_script( 'distributor-map', ZH_URL. '/dist/scripts/map/distributor/map.js');
           }

        if( ($template_name === 'page-template-instalator-edenred-charge.php') )
        {
            wp_enqueue_script( 'awn', 'https://cdnjs.cloudflare.com/ajax/libs/awesome-notifications/3.1.0/index.var.js');
            wp_enqueue_style( 'awn', 'https://cdnjs.cloudflare.com/ajax/libs/awesome-notifications/3.1.0/style.min.css');
//            wp_enqueue_script( 'order-credits', ZH_URL . '/public/js/installer/order-credits.js');
            wp_enqueue_script( 'order-credits', ZH_URL . '/public/js/installer/order-credits.js');
            // wp_enqueue_script( 'prepaid-card', ZH_URL . '/public/js/installer/prepaid-card.js');
            wp_enqueue_script( 'jquery-mask', ZH_URL . '/public/js/common/jquery.mask.min.js');
            wp_enqueue_script( 'masked-input', ZH_URL. '/public/js/common/jquery.maskedinput.js');
            wp_enqueue_script( 'match-height', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js');

            wp_localize_script( 'order-credits', 'credits',
                array(
                    'ajax' => ZH_AJAX,
                )
            );

            wp_localize_script( 'prepaid-card', 'prepaid',
                array(
                    'nonce' => wp_create_nonce( 'wp_rest' ),
                )
            );


//            wp_enqueue_script( 'jquery-stellar', ' ZH_URL. porto/vendor/jquery.stellar/jquery.stellar.js');
        }

             /* Load calculator styles scripts depends on template */
             switch ($template_name) {
                case "page-template-instalator-calculator-pv.php":
                  wp_enqueue_script( 'angular-script', ZH_URL . 'dist/scripts/calculators/angular-pack/angular.js');
                  wp_enqueue_script( 'angular-slider', ZH_URL . 'dist/scripts/calculators/angular-pack/sliders.js');
                  wp_enqueue_style( 'calculator-pv', ZH_URL.'dist/css/_calculator-pv.css');
                  wp_enqueue_script( 'pv-script', ZH_URL . 'dist/scripts/calculators/pvslctool.js');

                  break;
                case "page-template-instalator-calculator-pcwb.php":
                  wp_enqueue_script( 'angular-script', ZH_URL . 'dist/scripts/calculators/angular-pack/angular.js');
                 //   wp_enqueue_script( 'angular-slider', ZH_URL . 'dist/scripts/calculators/angular-pack/sliders.js');
                  wp_enqueue_style( 'calculator-pcwb', ZH_URL.'dist/css/_calculator-pcwb.css');
                  wp_enqueue_script( 'pcwb-script', ZH_URL . 'dist/scripts/calculators/pcwbtool.js');

                  
                  break;
                case "page-template-instalator-calculator-pcco.php":
                  wp_enqueue_script( 'angular-script', ZH_URL . 'dist/scripts/calculators/angular-pack/angular.js');
                 //   wp_enqueue_script( 'angular-slider', ZH_URL . 'dist/scripts/calculators/angular-pack/sliders.js');
                  wp_enqueue_style( 'calculator-pcco', ZH_URL.'dist/css/_calculator-pcco.css');
                  wp_enqueue_script( 'pcwb2-script', ZH_URL . 'dist/scripts/calculators/pcwbtool.js');
                  wp_enqueue_script( 'pcco-script', ZH_URL . 'dist/scripts/calculators/pumpsform.js');


                  break;
                  case "page-template-instalator-calculator-mount.php":
                    wp_enqueue_script( 'angular-script', ZH_URL . 'dist/scripts/calculators/angular-pack/angular.js');
                    wp_enqueue_script( 'app2-mount', ZH_URL . 'dist/scripts/calculators/app-2.js');
                    wp_enqueue_script( 'offerform-script', ZH_URL . 'dist/scripts/calculators/offerform.js');
                    wp_enqueue_style( 'calculator-mount', ZH_URL.'dist/css/_calculator-mount.css');

                    break;
                default:
            }
    

        wp_localize_script( 'instalator-template', 'instalator_template_rest',
            array(
                'api' => home_url( 'wp-json/hewalex-zones/v2/contacts' ),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'ajaxUrl' => ZH_AJAX,
                'ajaxnonce' => wp_create_nonce('ajax-nonce'),
                'theajax' => admin_url('admin-ajax.php'),
                'zh_url' => ZH_URL,
            )
        );

        /* @Instalator */
        wp_localize_script( 'instalator-template', 'installer_collectorsun',
        array(
            'path' => ( ZH_URL . 'mapsearch/installer/collectorsun.json' ),
        )
        );

        wp_localize_script( 'instalator-template', 'installer_pompheat',
        array(
            'path' => ( ZH_URL . 'mapsearch/installer/pompheat.json' ),
        )
        );

        wp_localize_script( 'instalator-template', 'installer_pompheatwater',
        array(
        'path' => ( ZH_URL . 'mapsearch/installer/pompheatwater.json' ),
            )
        );

        wp_localize_script( 'instalator-template', 'installer_pompheatpool',
        array(
            'path' => ( ZH_URL . 'mapsearch/installer/pompheatpool.json' ),
        )
        );

        wp_localize_script( 'instalator-template', 'installer_optiener',
        array(
            'path' => ( ZH_URL . 'mapsearch/installer/optiener.json' ),
        )
        );

        wp_localize_script( 'instalator-template', 'installer_sunheat',
        array(
            'path' => ( ZH_URL . 'mapsearch/installer/sunheat.json' ),
        )
        );


        /* @Distributor */
        wp_localize_script( 'distributor-template', 'distributor_collectorsun',
            array(
                'path' => ( ZH_URL . 'mapsearch/distributor/collectorsun.json' ),
            )
        );

        wp_localize_script( 'distributor-template', 'distributor_pompheat',
            array(
                'path' => ( ZH_URL . 'mapsearch/distributor/pompheat.json' ),
            )
        );

        wp_localize_script( 'distributor-template', 'distributor_pompheatwater',
        array(
            'path' => ( ZH_URL . 'mapsearch/distributor/pompheatwater.json' ),
            )
        );

        wp_localize_script( 'distributor-template', 'distributor_pompheatpool',
            array(
                'path' => ( ZH_URL . 'mapsearch/distributor/pompheatpool.json' ),
            )
        );

        wp_localize_script( 'distributor-template', 'distributor_optiener',
            array(
                'path' => ( ZH_URL . 'mapsearch/distributor/pompheatpool.json' ),
            )
        );

        wp_localize_script( 'distributor-template', 'distributor_sunheat',
            array(
                'path' => ( ZH_URL . 'mapsearch/distributor/sunheat.json' ),
            )
        );

    }
}