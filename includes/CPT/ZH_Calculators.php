<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_Calculators
 */
class ZH_Calculators
{

    private const CPT_NAME = "carts";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptCarts'));
        add_action( 'acf/init', array($this, 'acfFieldsCarts' ));
        add_filter( 'acf/load_field', array($this, 'acfReadOnlyCarts' ));
    }

    public function acfReadOnlyCarts( $field ) : array
    {
        global $post;
        if( 'carts_code' === $field['name']  && ! is_admin() ) {
            $field['disabled']       = true;
            $field['value']          = get_field('carts_code', $_GET['post_id']);
            $field['default_value']  = get_field('carts_code', $_GET['post_id']);
        }

        return $field;

    }

    public function registerCptCarts(): void
    {
        $args = array(
            'label' => __('Koszyki WooCommerce', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
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

    public function acfFieldsCarts()
    {
        $carts = new FieldsBuilder('calculators-carts', ['title' => 'Koszyki']);
        $carts
            ->addText('carts_hash', [
                'label' => 'Hash:',
            ])
            ->addTextarea('carts_products', [
                'label' => 'Produkty:',
            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($carts->build());
    }
}