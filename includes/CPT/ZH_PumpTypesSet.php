<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_PumpTypesSet
 */
class ZH_PumpTypesSet
{

    private const CPT_NAME = "pump_types_set";
    private const CPT_SolarSet = "pump_set";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptPumpTypesSet'));
        add_action( 'admin_menu', array($this, 'addSubMenuTypesSet' ));
        add_action( 'acf/init', array($this, 'acfFieldsTypesSet' ));
    }

    public function registerCptPumpTypesSet(): void
    {
        $args = array(
            'label' => __('Typy zestawów Pompy', 'hewalex-zones'),
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
            'Typy zestawów Pompy',             // page title
            'Typy zestawów Pompy',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsTypesSet()
    {
        $form_pcco = new FieldsBuilder('pump-types-set', ['title' => 'Typ zestawu Pompy']);
        $form_pcco
            ->addSelect('category', [
                'label' => 'Kategoria:',
                'choices' => array(
                    'Brak kategorii',
                    'Bieżąca oferta',
                    'Archiwum',
                )
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