<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_SolarSet
 */
class ZH_SolarSet
{

    private const CPT_NAME = "solar_set";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptInterestedUsers'));
        //add_action( 'acf/init', array($this, 'acfFieldsInterestedUsers' ));
        add_action( 'admin_menu', array($this, 'hideSubmenu'));
    }

    public function hideSubmenu()
    {
        remove_submenu_page( 'edit.php?post_type=solar_set', 'edit.php?post_type=solar_set' );
        remove_submenu_page( 'post-new.php?post_type=solar_set', 'post-new.php?post_type=solar_set' );
    }


    public function registerCptInterestedUsers(): void
    {
        $args = array(
            'label' => __('Zestawy SOL', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'supports' => ['title', 'custom-fields'],
            'has_archive' => true,
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

    public function acfFieldsInterestedUsers()
    {
        $interested = new FieldsBuilder('interested-users', ['title' => 'Zainteresowany ofertą']);
        $interested
            ->addText('carts_hash', [
                'label' => 'Hash:',
            ])
            ->addTextarea('carts_products', [
                'label' => 'Produkty:',
            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($interested->build());
    }
}