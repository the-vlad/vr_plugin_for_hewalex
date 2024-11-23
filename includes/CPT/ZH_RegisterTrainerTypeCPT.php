<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_RegisterTrainerTypeCPT
 */
class ZH_RegisterTrainerTypeCPT
{
    private const CPT_NAME = "trainers";
    private const CPT_TRAINER_TYPE = "trainer_type";

    public function __construct()
    {
        add_action('init', array($this, 'register_trainer_type'));
        add_filter( 'manage_'. self::CPT_TRAINER_TYPE .'_posts_columns', array($this, 'set_custom_edit_konfeo_columns' ));
        add_action( 'manage_'. self::CPT_TRAINER_TYPE .'_posts_custom_column' , array($this, 'custom_konfeo_column'), 10, 2 );
        add_action( 'admin_menu', array($this, 'addSubMenuTrainerType' ));
    }

    public function register_trainer_type(): void
    {
        $args = array(
            'label' => __('Typ szkolenia', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'supports' => ['title', 'custom-fields'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_TRAINER_TYPE
            ],
        );
        register_post_type(self::CPT_TRAINER_TYPE, $args);
    }

    public function addSubMenuTrainerType():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_NAME,                 // parent slug
            'Typ szkolenia',             // page title
            'Typ szkolenia',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_TRAINER_TYPE, // your menu menu slug
            '',
            1
        );
    }

    public function set_custom_edit_konfeo_columns($columns) {
        unset( $columns['date'] );

        return $columns;
    }
}