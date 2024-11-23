<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use Develtio\ZonesHewalex\API\model\ZH_OfferForm;
use Develtio\ZonesHewalex\API\model\ZH_OfferFormShop;
use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_InterestedListUsersShop
 */
class ZH_InterestedListUsersShop
{
    private const CPT_NAME = "users_shop";
    private const CPT_InterestedListUsers = "interested_users";

    private $readOnly = array(
        'hash',
//        'category_calc',
//        'pcco_options',
//        'pcco_contact'
    );

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCpt'), 9);
        add_action( 'admin_menu', array($this, 'addSubMenuInsterestedUsersShop' ));
        add_action( 'acf/init', array($this, 'acfFieldsInterestedUsersShop' ));

        add_shortcode( 'carts_installator', array($this, 'shortcodeCarts') );

        add_filter( 'acf/load_field', array($this, 'acfReadOnly' ));
//        add_action('add_meta_boxes',array($this, 'selectionDataMetabox'));
        add_action('add_meta_boxes',array($this, 'hewalexDataMetabox'));

        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_trainers_columns' ));
        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_trainers_column' ), 10, 2 );
    }

    public function registerCpt(): void
    {
        $args = array(
            'label' => __('Koszyki ze sklepu', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'supports' => ['title', 'custom-fields', 'author'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }

    public function addSubMenuInsterestedUsersShop():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_InterestedListUsers,                 // parent slug
            'Shop',             // page title
            'Shop',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsInterestedUsersShop()
    {
        /**
         * @TODO
         * Dodac pola takie jak w ładunku mamy w akcji - updateoffer
         */
        $shop = new FieldsBuilder('form-shop', ['title' => 'Formularz doboru Shop']);
        $shop
            ->addText('hash', [
                'label' => 'Offer Hash:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('user_id', [
                'label' => 'User ID:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('category_calc', [
                'label' => 'Kategoria:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('contact_name', [
                'label' => 'Nazwa:',
            ])
            ->addText('contact_phone', [
                'label' => 'Telefon:',
            ])
            ->addText('contact_address', [
                'label' => 'Adres:',
            ])
            ->addText('contact_zip', [
                'label' => 'Kod pocztowy:',
            ])
            ->addText('contact_city', [
                'label' => 'Miasto:',
            ])
            ->addTextarea('comment', [
                'label' => 'Uwagi:',
            ])
            ->addText('profitType', [
                'label' => 'Typ profitu:',
            ])
            ->addText('profitCost', [
                'label' => 'Wielkość marży:',
            ])
            ->addText('taxRate', [
                'label' => 'VAT:',
            ])
            ->addText('installationCost', [
                'label' => 'Koszt instalacji:',
            ])
            ->addText('deliveryCost', [
                'label' => 'Koszt dostawy:',
            ])
            ->addText('totalPrice', [
                'label' => 'Wartość netto produktów hewalex:',
            ])
            ->addText('totalPriceOffer', [
                'label' => 'Suma netto:',
            ])
            ->addText('totalPriceOfferWithTax', [
                'label' => 'Suma brutto:',
            ])
            ->addTextarea('products_shop', [
                'label' => 'Produkty:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('contact_array', [
                'label' => 'Kontakt:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('offer_array', [
                'label' => 'Oferta:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('options_array', [
                'label' => 'Opcje:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('custom_products', [
                'label' => 'Dodatkowe Produkty:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('additional_shop', [
                'label' => 'Dodatkowe dane:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('response_from_shop', [
                'label' => 'Cały ładunek:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($shop->build());
    }

    public function acfReadOnly( $field ) : array
    {
        global $post;

        foreach ($this->readOnly as $item) {
            if ($item === $field['name']) {
                $field['disabled'] = true;
                $field['value'] = get_field($item, $post->ID);
                $field['default_value'] = get_field($item, $post->ID);
            }
        }
        return $field;
    }

    public function hewalexDataMetabox() {
        add_meta_box(
            'hewalex-data',
            __( 'Panel Hewalex', 'zones-hewalex' ),
            array($this, 'noticeMetaboxHewalexCallback'),
            'users_shop',
            'side',
            'core'
        );
    }

    public function noticeMetaboxHewalexCallback($post) {
        echo '<a target="_blank" href="/strefa-instalatora/edycja-koszyka/?hash='.get_field('hash', $post->ID).'">Przejdź do kompleksowej edycji</a>';
    }

    public function set_custom_edit_trainers_columns($columns)
    {
        $n_columns = array();
        $before = 'author'; // move before this

        foreach($columns as $key => $value) {
            if ($key==$before){
                $n_columns['hash'] = __( 'Hash', 'hewalex-zones' );
                $n_columns['category_calc'] = __( 'Kategoria', 'hewalex-zones' );
            }
            $n_columns[$key] = $value;
        }

        return $n_columns;
    }

    public function custom_trainers_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'hash' :
                echo get_field( 'hash', $post_id );
                break;
            case 'category_calc' :
                echo get_field( 'category_calc', $post_id );
                break;
        }
    }

    public function shortcodeCarts()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'users_shop',
            'author'         => $this->getIdInstallator()
        );

        $cartsInstallator = get_posts($args);

        $nonce = wp_create_nonce('deleteCart_nonce');
        $nonceHistory = wp_create_nonce('deleteHistoryCart_nonce');

        if(count($cartsInstallator) > 0)
        {
            echo '<table style="border: 1px solid #000; border-collapse: collapse; width: 100%;">';
            foreach ($cartsInstallator as $cart)
            {
                $generatedOffer = get_field('contact_array', $cart->ID) !== null ? true : false;
                $offerName = json_decode(get_field('additional_shop', $cart->ID), true)[1]['value'];

                if($generatedOffer === true){
                    echo '
                         <tr class="offer-id">
                                <td>' . $offerName. '</td>
                                <td style="display: flex; justify-content: flex-end; gap: 15px;"><a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='. get_field('hash', $cart->ID) .'&reportHash=4dty74si">Pobierz</a>
                                    <a target="_blank" href="https://sklep.hewalex.pl/hewalex-order/'. get_field('hash', $cart->ID) .'">Wyślij do sklepu</a>
                                    <a href="/strefa-instalatora/edycja-koszyka?hash='. get_field('hash', $cart->ID) .'">Edytuj</a>
                                    <button data-id="'. $cart->ID .'" data-nonce="'. $nonce .'" class="delete-cart">Usuń</button>
                                </td>
                            </tr>            
                    ';
                } else {
                    echo '
                         <tr class="offer-id">
                                <td>' . $offerName. '</td>
                                <td style="display: flex; justify-content: flex-end; gap: 15px;"><button disabled target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='. get_field('hash', $cart->ID) .'&reportHash=4dty74si">Pobierz</button>
                                    <a target="_blank" href="https://sklep.hewalex.pl/hewalex-order/'. get_field('hash', $cart->ID) .'">Wyślij do sklepu</a>
                                    <a href="/strefa-instalatora/edycja-koszyka?hash='. get_field('hash', $cart->ID) .'">Wygeneruj ofertę</a>
                                    <button data-id="'. $cart->ID .'" data-nonce="'. $nonce .'" class="delete-cart">Usuń</button>
                                </td>    
                            </tr>            
                    ';
                }

            }
            echo '</table>';
        }
        else
        {
            echo __('brak wygenerowanych ofert', 'hewalex-zones');
        }

        echo '<h3 style="margin-top: 30px;">Koszyki historyczne</h3>';

        $user_id = get_user_meta($this->getIdInstallator(), 'installation_group1_installation_user_id')[0];

        global $wpdb;
        $offers = "select * from offer_forms where user_id LIKE {$user_id}";
        $offers_arr = $wpdb->get_results($offers, 'ARRAY_A');

        if(count($offers_arr) > 0) {
            echo '<table style="border: 1px solid #000; border-collapse: collapse; width: 100%;">';
            foreach ($offers_arr as $offer)
            {
                $additional = (new ZH_OfferForm())->getArrayFromFormOptionsHistoryOffer($offer['offer_form_id'], 'form_options', 'additional');
                $offerName = (new ZH_OfferForm())->searchArray('offerName', 'id', 'value', $additional);

                if($offer['offer_form_category'] === 'shopOffer' ){
                    echo '
                     <tr class="offer-id" style="border: 1px solid #000;">
                            <td>' . $offerName. '</td>
                            <td style="display: flex; justify-content: flex-end; gap: 15px;">
                                <a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='.$offer['offer_form_id'].'&reportHash=4dty74si">Pobierz</a>
                                <a target="_blank" href="https://sklep.hewalex.pl/hewalex-order/'. $offer['hash'] .'">Wyślij do sklepu</a>
                                <a href="/strefa-instalatora/edycja-koszyka?hash='. $offer['hash'] .'">Edytuj</a>
                                <button data-id="'. $offer['offer_form_id'] .'" data-nonce="'. $nonceHistory .'" class="delete-history-cart">Usuń</button>
                            </td>    
                        </tr>            
                    ';
                }
            }
            echo '</table>';
        } else {
            echo __('brak historycznych ofert', 'hewalex-zones');
        }
    }

    private function getIdInstallator()
    {
        if(!is_user_logged_in()){
            return;
        }

        $user = wp_get_current_user();
        return $user->ID;
    }
}