<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_RegisterCPT
 */
class ZH_RegisterKonfeoCPT
{
    private const CPT_NAME = "trainers";
    private const CPT_KONFEO = "konfeo";

    public function __construct()
    {
        add_action( 'init', array($this, 'register_konfeo' ));
        add_filter( 'manage_'. self::CPT_KONFEO .'_posts_columns', array($this, 'set_custom_edit_konfeo_columns' ));
        add_action( 'manage_'. self::CPT_KONFEO .'_posts_custom_column' , array($this, 'custom_konfeo_column'), 10, 2 );
        add_action( 'acf/init', array($this, 'acfFieldsKonfeo' ));
        add_action( 'admin_menu', array($this, 'addSubMenuKonfeo' ));
    }

    public function register_konfeo(): void
    {
        $args = array(
            'label' => __('Konfeo', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'supports' => ['title', 'custom-fields'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_KONFEO
            ],
        );
        register_post_type(self::CPT_KONFEO, $args);
    }

    public function addSubMenuKonfeo():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_NAME,                 // parent slug
            'Konfeo',             // page title
            'Konfeo',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_KONFEO, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsKonfeo() {
        $cpt_single = new FieldsBuilder('trainers-konfeo', ['title' => 'Dane użytkownika']);
        $cpt_single
            ->addText('konfeo_date', [
                'label' => 'Data',
            ])
            ->addText('konfeo_type', [
                'label' => 'Typ',
            ])
            ->addText('konfeo_email', [
                'label' => 'E-mail',
            ])
            ->addText('konfeo_phone', [
                'label' => 'Telefon',
            ])
            ->addText('konfeo_name', [
                'label' => 'Nazwa instalatora',
            ])
            ->addText('konfeo_nip', [
                'label' => 'NIP',
            ])
            ->addText('konfeo_city', [
                'label' => 'Miasto',
            ])
            ->addText('konfeo_code', [
                'label' => 'Kod pocztowy',
            ])
            ->addText('konfeo_street', [
                'label' => 'Ulica',
            ])
            ->addText('konfeo_province', [
                'label' => 'Województwo',
            ])
            ->addText('konfeo_status', [
                'label' => 'Status szkolenia',
            ])
            ->addText('konfeo_status_edokumenty', [
                'label' => 'Status eDokumenty',
            ])
            ->addText('konfeo_umowa_pv', [
                'label' => 'Umowa PV',
            ])
            ->addText('konfeo_pcco', [
                'label' => 'Umowa PCCO',
            ])
            ->addText('konfeo_guardian', [
                'label' => 'Opiekun',
            ])
            ->addText('konfeo_ph', [
                'label' => 'PH',
            ])
            ->setLocation('post_type', '==', 'konfeo');

        acf_add_local_field_group($cpt_single->build());
    }

    public function set_custom_edit_konfeo_columns($columns) {
        unset( $columns['title'] );
        unset( $columns['date'] );
        $columns['konfeo_date'] = __( 'Data szkolenia', 'hewalex-zones' );
        $columns['konfeo_type'] = __( 'Rodzaj szkolenia', 'hewalex-zones' );
        $columns['konfeo_name'] = __( 'Instalator', 'hewalex-zones' );
        $columns['konfeo_nip'] = __( 'NIP', 'hewalex-zones' );
        $columns['konfeo_city'] = __( 'Miasto', 'hewalex-zones' );
        $columns['konfeo_province'] = __( 'Województwo', 'hewalex-zones' );
        $columns['konfeo_status'] = __( 'Status szkolenia', 'hewalex-zones' );
        $columns['konfeo_status_edokumenty'] = __( 'Status eDokumenty', 'hewalex-zones' );
        $columns['konfeo_umowa_pv'] = __( 'Umowa PV', 'hewalex-zones' );
        $columns['konfeo_pcco'] = __( 'Umowa PCCO', 'hewalex-zones' );
        $columns['konfeo_guardian'] = __( 'Opiekun', 'hewalex-zones' );
        $columns['konfeo_ph'] = __( 'PH', 'hewalex-zones' );

        return $columns;
    }

    public function custom_konfeo_column( $column, $post_id ) {
        switch ( $column ) {

            case 'konfeo_date' :
                echo get_field( 'konfeo_date', $post_id );
                break;
            case 'konfeo_type' :
                echo get_field( 'konfeo_type', $post_id );
                break;
            case 'konfeo_name' :
                echo get_field( 'konfeo_name', $post_id );
                break;
            case 'konfeo_nip' :
                echo get_field( 'konfeo_nip', $post_id );
                break;
            case 'konfeo_city' :
                echo get_field( 'konfeo_city', $post_id );
                break;
            case 'konfeo_province' :
                echo get_field( 'konfeo_province', $post_id );
                break;
            case 'konfeo_status' :
                echo get_field( 'konfeo_status', $post_id );
                break;
            case 'konfeo_status_edokumenty' :
                echo get_field( 'konfeo_status_edokumenty', $post_id );
                break;
            case 'konfeo_umowa_pv' :
                echo get_field( 'konfeo_umowa_pv', $post_id );
                break;
            case 'konfeo_pcco' :
                echo get_field( 'konfeo_pcco', $post_id );
                break;
            case 'konfeo_guardian' :
                echo get_field( 'konfeo_guardian', $post_id );
                break;
            case 'konfeo_ph' :
                echo get_field( 'konfeo_ph', $post_id );
                break;
        }
    }
}