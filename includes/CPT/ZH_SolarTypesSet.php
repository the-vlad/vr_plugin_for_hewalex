<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_SolarTypesSet
 */
class ZH_SolarTypesSet
{

    private const CPT_NAME = "solar_types_set";
    private const CPT_SolarSet = "solar_set";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptSolarTypesSet'));
        add_action( 'admin_menu', array($this, 'addSubMenuTypesSet' ));
        add_action( 'acf/init', array($this, 'acfFieldsTypesSet' ));
    }

    public function registerCptSolarTypesSet(): void
    {
        $args = array(
            'label' => __('Typy zestawów', 'hewalex-zones'),
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

    public function addSubMenuTypesSet():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_SolarSet,                 // parent slug
            'Typy zestawów',             // page title
            'Typy zestawów',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsTypesSet()
    {
        $form_pcco = new FieldsBuilder('types-set', ['title' => 'Typ zestawu']);
        $form_pcco
            ->addSelect('category', [
                'label' => 'Kategoria:',
                'choices' => array(
                    'Brak kategorii',
                    'Bieżąca oferta',
                    'Archiwum',
                )
            ])
            ->addText('numbers_collectors', [
                'label' => 'Ilość kolektorów:'
            ])
            ->addText('type_collectors', [
                'label' => 'Typ kolektorów:'
            ])
            ->addText('type_solar', [
                'label' => 'Typ podgrzewacza:'
            ])
            ->addText('type_zps', [
                'label' => 'Typ ZPS:'
            ])
            ->addText('points', [
                'label' => 'Punkty - stary program:'
            ])
            ->addText('ecology_effect', [
                'label' => 'Efekt ekologiczny kgCO2:	'
            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($form_pcco->build());
    }
}