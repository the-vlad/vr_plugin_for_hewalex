<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_OrderedEdenredCards
 */
class ZH_OrderedEdenredCards
{
    private const CPT_NAME = "ordered_cards";
    private const CPT_Awards = "awards";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCpt'), 9);
        add_action( 'admin_menu', array($this, 'addSubMenuOrderedCards' ));
        add_action( 'acf/init', array($this, 'acfFieldsOrderedCards' ));

//        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_trainers_columns' ));
//        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_trainers_column' ), 10, 2 );
    }

    public function registerCpt(): void
    {
        $args = array(
            'label' => __('Zamówienie karty Edenred', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'supports' => ['custom-fields', 'author'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }

    public function addSubMenuOrderedCards():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_Awards,                 // parent slug
            'Zamówienie karty Edenred',             // page title
            'Zamówienie karty Edenred',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsOrderedCards()
    {
        $ordered_credits = new FieldsBuilder('ordered_cards', ['title' => 'Zamówienie karty Edenred']);
        $ordered_credits
            ->addText('order_category', [
                'label' => 'Category:',
            ])
            ->addText('id_order', [
                'label' => 'Numer zamówienia:',
            ])
            ->addAccordion('billing', [
                'label' => 'Dane płatności',
                'multi_expand' => 1
            ])
                ->addText('billing_company', [
                    'label' => 'Nazwa firmy'
                ])
                ->addText('billing_nip', [
                    'label' => 'NIP'
                ])
                ->addText('billing_address', [
                    'label' => 'Adres'
                ])
                ->addText('billing_postcode', [
                    'label' => 'Kod pocztowy'
                ])
                ->addText('billing_city', [
                    'label' => 'Miasto'
                ])
                ->addText('billing_province', [
                    'label' => 'Województwo'
                ])
                ->addText('billing_country', [
                    'label' => 'Kraj'
                ])
                ->addText('billing_email', [
                    'label' => 'E-mail'
                ])
                ->addText('billing_phone', [
                    'label' => 'Telefon'
                ])
            ->addAccordion('shipping', [
                'label' => 'Dane wysyłki',
                'multi_expand' => 1
            ])
                ->addText('shipping_contact_person', [
                    'label' => 'Osoba kontaktowa'
                ])
                ->addText('shipping_address', [
                    'label' => 'Adres'
                ])
                ->addText('shipping_postcode', [
                    'label' => 'Kod pocztowy'
                ])
                ->addText('shipping_city', [
                    'label' => 'Miasto'
                ])
                ->addText('shipping_province', [
                    'label' => 'Województwo'
                ])
                ->addText('shipping_country', [
                    'label' => 'Kraj'
                ])
                ->addText('shipping_phone', [
                    'label' => 'Telefon'
                ])
            ->addAccordion('data', [
                'label' => 'Ładunek',
                'multi_expand' => 1
            ])
                ->addTextarea('basket', [
                    'label' => 'Basket:',
                ])
                ->addTextarea('billing', [
                    'label' => 'Billing',
                ])
                ->addTextarea('shipping', [
                    'label' => 'Shipping',
                ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($ordered_credits->build());
    }

    public function set_custom_edit_trainers_columns($columns)
    {
        unset( $columns['title'] );
        unset( $columns['author'] );

        $n_columns = array();
        $before = 'date'; // move before this

        foreach($columns as $key => $value) {
            if ($key==$before){
                $n_columns['id_order'] = __( 'Numer zamówienia', 'hewalex-zones' );
                $n_columns['installator'] = __( 'Instalator', 'hewalex-zones' );
                $n_columns['price'] = __( 'Cena', 'hewalex-zones' );
                $n_columns['paid_status'] = __( 'Zapłacono', 'hewalex-zones' );
                $n_columns['id_invoice'] = __( 'Nr faktury', 'hewalex-zones' );
                $n_columns['status'] = __( 'Status', 'hewalex-zones' );
            }
            $n_columns[$key] = $value;
        }

        return $n_columns;
    }

    public function custom_trainers_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'id_order' :
                echo get_field( 'id_order', $post_id );
                break;
            case 'installator' :
                echo get_field( 'installator', $post_id );
                break;
            case 'price' :
                echo get_field( 'price', $post_id );
                break;
            case 'paid_status' :
                echo get_field( 'paid_status', $post_id );
                break;
            case 'id_invoice' :
                echo get_field( 'id_invoice', $post_id );
                break;
            case 'status' :
                echo get_field( 'status', $post_id );
                break;
        }
    }
}