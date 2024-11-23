<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_RegisterCPT
 */
class ZH_RegisterInformationCPT
{
    private const CPT_NAME = "information";

    public function __construct()
    {
        add_action('init', array($this, 'register_cpt'), 9);
    }

    public function register_cpt(): void
    {
        $args = array(
            'label' => __('Strefa Informacyjna', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'supports' => [],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }
    

}