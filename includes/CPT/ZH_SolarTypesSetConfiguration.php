<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_SolarTypesSetConfiguration
 */
class ZH_SolarTypesSetConfiguration
{

    private const CPT_NAME = "solar_types_conf";
    private const CPT_SolarSet = "solar_set";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptSolarTypesSetConfiguration'));
        add_action( 'admin_menu', array($this, 'addSubMenuTypesSetConfiguration' ));
        add_action( 'acf/init', array($this, 'acfFieldsTypesSetConfigurator' ));
    }

    public function registerCptSolarTypesSetConfiguration(): void
    {
        $args = array(
            'label' => __('Typy zestawów Konfiguratora', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'supports' => ['title', 'custom-fields'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }

    public function addSubMenuTypesSetConfiguration():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_SolarSet,                 // parent slug
            'Typy zestawów konfiguratora',             // page title
            'Typy zestawów konfiguratora',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsTypesSetConfigurator()
    {
        $type_configurator = new FieldsBuilder('types-set-configurator', ['title' => 'Typ zestawu konfiguratora']);
        $type_configurator
//            ->addText('test', [
//                'label' => 'Test:'
//            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($type_configurator->build());
    }
}