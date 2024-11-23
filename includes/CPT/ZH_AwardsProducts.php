<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_AwardsProducts
 */
class ZH_AwardsProducts
{
    private const CPT_NAME = "awards_products";
    private const CPT_Awards = "awards";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCpt'), 9);
        add_action( 'admin_menu', array($this, 'addSubMenuAwardsProducts' ));
        add_action( 'acf/init', array($this, 'acfFieldsAwardsProducts' ));

        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_trainers_columns' ));
        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_trainers_column' ), 10, 2 );

        add_filter( 'template_include', array($this, 'overrideSingleProduct'));
    }

    public function registerCpt(): void
    {
        $args = array(
            'label' => __('Produkty', 'hewalex-zones'),
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

    public function addSubMenuAwardsProducts():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_Awards,                 // parent slug
            'Produkty',             // page title
            'Produkty',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsAwardsProducts()
    {
        global $post;
        $post_id = $_GET['post'] ?? null;
        $awards_products = new FieldsBuilder('awards_product', ['title' => 'Produkt']);
        $awards_products
            ->addSelect('category_main', [
                'label' => 'Kategoria główna:',
                'choices' => array(
                    'hewalex'      => 'HEWALEX',
                )
            ])
            ->addText('ref_number', [
                'label' => 'Numer referencyjny:',
            ])
            ->addText('product_model', [
                'label' => 'Model:',
            ])
            ->addText('price_brutto', [
                'label' => 'Cena brutto:',
            ])
            ->addText('price_shipping', [
                'label' => 'Cena transportu:',
            ])
            ->addText('prod_id', [
                'label' => 'ID',
                'value' => $post_id,
                'readonly' => 1,
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('price_brutto_with_shipping', [
                'label' => 'Cena z transportem brutto:',
            ])
            ->addText('weight', [
                'label' => 'Waga:',
            ])
         
            ->addWysiwyg('product_desc', [
                'label' => 'Opis:',
            ])
            ->addTrueFalse('display', [
                'label' => 'Pokazać:',
                'ui' => 1,
            ])
            ->addImage('product_image', [
                'label' => 'Zdjęcie:',
            ])
            ->addTrueFalse('additional_size', [
                'label' => 'Dodatkowe rozmiary:',
                'ui' => 1,
            ])
            ->addRadio('radio_size', [
                'label' => 'Jak wyświetlić rozmiary?',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => [],
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'choices' => [
                    'textable' => 'Słownie',
                    'numerical' => 'Numerycznie'
                ],
                'return_format' => 'value',
            ])
            
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($awards_products->build());
    }

    public function set_custom_edit_trainers_columns($columns)
    {
        unset( $columns['title'] );

        $n_columns = array();
        $before = 'date'; // move before this

        foreach($columns as $key => $value) {
            if ($key==$before){
                $n_columns['category_main'] = __( 'Kategoria główna', 'hewalex-zones' );
                $n_columns['ref_number'] = __( 'Numer referencyjny', 'hewalex-zones' );
                $n_columns['product_model'] = __( 'Model', 'hewalex-zones' );
                $n_columns['price_brutto'] = __( 'Cena', 'hewalex-zones' );
                $n_columns['price_shipping'] = __( 'Transport', 'hewalex-zones' );
                $n_columns['display'] = __( 'Status', 'hewalex-zones' );
            }
            $n_columns[$key] = $value;
        }

        return $n_columns;
    }

    public function custom_trainers_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'category_main' :
                echo get_field( 'category_main', $post_id );
                break;
            case 'ref_number' :
                echo get_field( 'ref_number', $post_id );
                break;
            case 'product_model' :
                echo get_field( 'product_model', $post_id );
                break;
            case 'price_brutto' :
                echo get_field( 'price_brutto', $post_id );
                break;
            case 'price_shipping' :
                echo get_field( 'price_shipping', $post_id );
                break;
            case 'display' :
                echo get_field( 'display', $post_id );
                break;

        }
    }

    public function overrideSingleProduct( $template ) {
        $post_types = self::CPT_NAME;

        if ( is_singular( $post_types ) && file_exists( plugin_dir_path( __DIR__ ). 'Templates/templates/instalator/single-awards_products.php' ) ){
            $template = plugin_dir_path( __DIR__ ). 'Templates/templates/instalator/single-awards_products.php';
        }

        return $template;
    }
}