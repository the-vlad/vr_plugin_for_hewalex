<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_Awards
 */
class ZH_Awards
{

    private const CPT_NAME = "awards";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptAwards'));
        add_action( 'admin_menu', array($this, 'hideSubmenu'));
    }

    public function hideSubmenu()
    {
        remove_submenu_page( 'edit.php?post_type='. self::CPT_NAME , 'edit.php?post_type='. self::CPT_NAME );
        remove_submenu_page( 'post-new.php?post_type='. self::CPT_NAME, 'post-new.php?post_type='. self::CPT_NAME );
    }


    public function registerCptAwards(): void
    {
        $args = array(
            'label' => __('Nagrody', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'supports' => ['title', 'custom-fields'],
            'has_archive' => false,
            'capabilities' => array(
                'create_posts' => false,
            ),
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }
}