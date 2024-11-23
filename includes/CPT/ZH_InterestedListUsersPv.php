<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use Develtio\ZonesHewalex\API\model\ZH_OfferFormPv;
use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_InterestedListUsersPv
 */
class ZH_InterestedListUsersPv
{
    private const CPT_NAME = "users_pv";
    private const CPT_InterestedListUsers = "interested_users";

    private $readOnly = array(
        'hash',
        'parent_hash',
        'category_calc',
        'pv_results',
        'pv_options',
        'pv_products',
        'pv_cproducts',
        'pv_cterms'
    );

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCpt'), 9);
        add_action( 'admin_menu', array($this, 'addSubMenuInsterestedUsersPv' ));
        add_shortcode( 'offers_installator', array($this, 'shortcodeOffers') );
        add_action( 'acf/init', array($this, 'acfFieldsInterestedUsersPv' ));

        add_filter( 'acf/load_field', array($this, 'acfReadOnly' ));
        add_action('add_meta_boxes',array($this, 'selectionDataMetabox'));
        add_action('add_meta_boxes',array($this, 'hewalexDataMetabox'));

        add_action( 'wp_ajax_deleteOffer', array($this, 'deleteOffer' ));
        add_action( 'wp_ajax_nopriv_deleteOffer', array($this, 'deleteOffer' ));

        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_trainers_columns' ));
        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_trainers_column' ), 10, 2 );

        add_action( 'acf/save_post', array($this, 'saveField' ), 20);
    }

    public function registerCpt(): void
    {
        $args = array(
            'label' => __('Formularz doboru PV', 'hewalex-zones'),
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

    public function addSubMenuInsterestedUsersPv():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_InterestedListUsers,                 // parent slug
            'PV',             // page title
            'PV',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsInterestedUsersPv()
    {
        $form_pv = new FieldsBuilder('form-pv', ['title' => 'Formularz doboru PV']);
        $form_pv
            ->addText('hash', [
                'label' => 'Offer Hash:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('parent_hash', [
                'label' => 'Parent hash (Offer edited):',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('category_calc', [
                'label' => 'Kategoria formularza:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('pv_name', [
                'label' => 'Imię i nazwisko:',
            ])
            ->addNumber('pv_phone', [
                'label' => 'Telefon:',
            ])
            ->addText('pv_phone_area', [
                'label' => 'Numer kierunkowy:',
            ])
            ->addEmail('pv_mail', [
                'label' => 'E-mail:',
            ])
            ->addText('pv_city', [
                'label' => 'Miasto:',
            ])
            ->addText('pv_postcode', [
                'label' => 'Kod pocztowy:',
            ])
            ->addText('pv_street', [
                'label' => 'Ulica i nr budynku:',
            ])
            ->addSelect('pv_province', [
                'label' => 'Województwo:',
                'choices' => array(
                    ''      => 'wybierz',
                    '3'     => 'dolnośląskie',
                    '4'     => 'kujawsko-pomorskie',
                    '6'     => 'lubelskie',
                    '7'     => 'lubuskie',
                    '5'     => 'łódzkie',
                    '1'     => 'małopolskie',
                    '8'     => 'mazowieckie',
                    '9'     => 'opolskie',
                    '10'    => 'podkarpackie',
                    '11'    => 'podlaskie',
                    '12'    => 'pomorskie',
                    '2'     => 'śląskie',
                    '13'    => 'świętokrzyskie',
                    '14'    => 'warmińsko-mazurskie',
                    '15'    => 'wielkopolskie',
                    '16'    => 'zachodniopomorskie',
                )
            ])
            ->addTextarea('pv_comment', [
                'label' => 'Komentarz zgłaszającego:',
            ])
            ->addText('pv_agree_1', [
                'label' => 'Zgoda mail:',
            ])
            ->addText('pv_agree_2', [
                'label' => 'Zgoda dane:',
            ])
            ->addTextarea('pv_attachment', [
                'label' => 'Załącznik:',
            ])
            ->addTextarea('pv_results', [
                'label' => 'Results:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('pv_options', [
                'label' => 'Options:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('pv_products', [
                'label' => 'Products:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('pv_cproducts', [
                'label' => 'Custom Products:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('pv_cterms', [
                'label' => 'Custom Terms:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('pv_contact', [
                'label' => 'Contact:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($form_pv->build());
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
            'users_pv',
            'side',
            'core'
        );
    }

    public function selectionDataMetabox() {
        add_meta_box(
            'selection-data',
            __( 'Dane doboru', 'zones-hewalex' ),
            array($this, 'noticeMetaboxCallback'),
            'users_pv',
            'side',
            'default'
        );
    }

    public function noticeMetaboxCallback($post){
        $optionsArr = get_field('pv_options', $post->ID);
        $arrOptions = json_decode($optionsArr, true);
        $contactArr = get_field('pv_contact', $post->ID);
        $arrContacts = json_decode($contactArr, true);
        $offerFormWithModelsTree = (new ZH_OfferFormPv())->getExactFormWithModels($arrOptions, $arrContacts, ['grouped' => true]);

        $formContent = '';
        $this->renderPrintableOfferForm($offerFormWithModelsTree, $formContent);
        echo $formContent;
    }

    public function noticeMetaboxHewalexCallback($post) {
        echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='.get_field('hash', $post->ID).'&reportHash=bc1xhzxu">Ankieta Klient</a>' . '</br>';
        echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='.get_field('hash', $post->ID).'&reportHash=8zc9av26">Oferta dla klienta</a>' . '</br>';
        echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='.get_field('hash', $post->ID).'&reportHash=o9ob73zd">Oferta instalatora</a>' . '</br>';
        if(get_field('parent_hash', $post->ID)){
            echo '<a target="_blank" href="' . admin_url() . 'post.php?post='. $this->getIDParentHash(get_field('parent_hash', $post->ID)) .'&action=edit">Zobacz poprzednią wersję oferty</a>' . '</br>';
        }
        echo '<a target="_blank" href="/kalkulator-fotowoltaiki?offerHash='.get_field('hash', $post->ID).'">Przejdź do kompleksowej edycji</a>';
    }

    public function getIDParentHash($parentHash)
    {
        if ($parentHash) {
            $args = array(
                'post_type' => 'users_pv',
                'post_status'   => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'hash',
                        'value' => $parentHash,
                        'compare' => '=='
                    )
                )
            );
            $offers = get_posts($args);
            foreach($offers as $offer) {
                $id = $offer->ID;
            }
        }
        return $id ?? null;
    }

    public function set_custom_edit_trainers_columns($columns)
    {
        $n_columns = array();
        $before = 'date'; // move before this

        foreach($columns as $key => $value) {
            if ($key==$before){
                $n_columns['pv_phone'] = __( 'Telefon', 'hewalex-zones' );
                $n_columns['pv_mail'] = __( 'E-mail', 'hewalex-zones' );
                $n_columns['pv_city'] = __( 'Miasto', 'hewalex-zones' );
            }
            $n_columns[$key] = $value;
        }

        return $n_columns;
    }

    public function custom_trainers_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'pv_phone' :
                echo get_field( 'pv_phone', $post_id );
                break;
            case 'pv_mail' :
                echo get_field( 'pv_mail', $post_id );
                break;
            case 'pv_city' :
                echo get_field( 'pv_city', $post_id );
                break;
        }
    }

    public function saveField()
    {
        $copy_arr = json_decode(get_field('pv_contact'), true);

        if($_POST['acf']['field_form-pv_pv_agree_1'] === 'Tak') {
            $_POST['acf']['field_form-pv_pv_agree_1'] = true;
        } else {
            $_POST['acf']['field_form-pv_pv_agree_1'] = false;
        }

        if($_POST['acf']['field_form-pv_pv_agree_2'] === 'Tak') {
            $_POST['acf']['field_form-pv_pv_agree_2'] = true;
        } else {
            $_POST['acf']['field_form-pv_pv_agree_2'] = false;
        }

        $replace = [
            2 => [
                'id' => 'name',
                'value' => $_POST['acf']['field_form-pv_pv_name'],
            ],
            3 => [
                'id' => 'email',
                'value' => $_POST['acf']['field_form-pv_pv_mail'],
            ],
            4 => [
                'id' => 'areaCode',
                'value' => $_POST['acf']['field_form-pv_pv_phone_area'],
            ],
            5 => [
                'id' => 'phone',
                'value' => $_POST['acf']['field_form-pv_pv_phone'],
            ],
            6 => [
                'id' => 'address',
                'value' => $_POST['acf']['field_form-pv_pv_street'],
            ],
            7 => [
                'id' => 'city',
                'value' => $_POST['acf']['field_form-pv_pv_city'],
            ],
            8 => [
                'id' => 'zip',
                'value' => $_POST['acf']['field_form-pv_pv_postcode'],
            ],
            9 => [
                'id' => 'accept_mailing',
                'value' => $_POST['acf']['field_form-pv_pv_agree_1'],
            ],
            10 => [
                'id' => 'accept_data',
                'value' => $_POST['acf']['field_form-pv_pv_agree_2'],
            ],
        ];

        $new_array = array_replace($copy_arr, $replace);

        update_field('pv_contact', json_encode($new_array, JSON_UNESCAPED_UNICODE), get_the_ID());
    }

    public function renderPrintableOfferForm($group, &$content, $heading = 1) {
        if ($group['hidden']['print'] ?? $group['hidden'] ?? false) {
            return;
        }
        if ($group['label'] ?? null) {
            $margins = [
                3 => 'mb-lg mt-xl',
                5 => 'mb-xs mt-sm'
            ];
            $content .= '<h'.$heading.' class="text-primary text-center '.($margins[$heading] ?? '').'">
            <strong>'. $group['label'] .':</strong>
        </h'.$heading.'>';
        }
        if ($group['groups'] ?? null) {
            $subHeading = $heading+2;
            foreach ($group['groups'] as $subGroup) {
                $this->renderPrintableOfferForm($subGroup, $content, $subHeading);
            }
        }
        if ($group['models'] ?? null) {
            $groupContent = '<table width="100%">';
            foreach ($group['models'] as $model) {
                if ($model['hidden']['print'] ?? $model['hidden'] ?? false) {
                    continue;
                }

                $value = $model['value'];
                $selectedId = $model['selectedId'] ?? null;
                if ($selectedId) {
                    $valueModel = array_first($model['options'], function ($option) use ($selectedId) {
                        return $option['id'] === $selectedId;
                    });
                    $value = $valueModel['displayName'] ?? "<span class='error'>{$model['value']}</span>";
                }
                if (($model['type'] ?? null) === 'checkbox') {
                    $value = $value == 1 ? 'Tak' : 'Nie';
                }
                $name = $model['label']['print'] ?? $model['label'] ?? "<span class='error'>{$model['paramId']}</span>";
                $unit = $model['unit'] ?? '';

                $groupContent .= ''
                    . '<tr>'
                    . '<td class="va-top">'. $name .':</td>'
                    . '<td width="35%" class="va-top">'. $value .' '. $unit .'</td>'
                    . '</tr>';
            }
            $groupContent .= '</table>';
            $content .= $groupContent;
        }
    }

    public function shortcodeOffers()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'users_pv',
            'author'         => $this->getIdInstallator()
        );

        $offersInstallator = get_posts($args);

        $nonce = wp_create_nonce('deleteOffer_nonce');

        if(count($offersInstallator) > 0)
        {
            echo '<table style="border: 1px solid #000; border-collapse: collapse; width: 100%;">';
            foreach ($offersInstallator as $offer)
            {
                echo '
                     <tr class="offer-id" style="border: 1px solid #000;">
                            <td style="border: 1px solid #000;">' . $offer->post_title . '</td>
                            <td style="border: 1px solid #000;"><a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='. get_field('hash', $offer->ID) .'&reportHash=o9ob73zd">Pobierz</a></td>
                            <td style="border: 1px solid #000;"><a href="/kalkulator-fotowoltaiki?offerHash='. get_field('hash', $offer->ID) .'">Edytuj</a></td>
                            <td style="border: 1px solid #000;"><button data-id="'. $offer->ID .'" data-nonce="'. $nonce .'" class="delete-post">Usuń</button></td>
                        </tr>            
                ';
            }
            echo '</table>';
        }
        else
        {
            echo __('brak wygenerowanych ofert', 'hewalex-zones');
        }

        echo '<h3 style="margin-top: 30px;">Oferty historyczne</h3>';

        $user_id = get_user_meta($this->getIdInstallator(), 'installation_group1_installation_user_id')[0];

        global $wpdb;
        $offers = "select * from offer_forms where user_id LIKE {$user_id}";
        $offers_arr = $wpdb->get_results($offers, 'ARRAY_A');

        if(count($offers_arr) > 0) {
            echo '<table style="border: 1px solid #000; border-collapse: collapse; width: 100%;">';
            foreach ($offers_arr as $offer)
            {
                /**
                 * @TODO
                 * dorobić usuwanie
                 * zmienić title na liście historycznej
                 */
                if($offer['offer_form_category'] === 'calcpv'){
                    echo '
                     <tr class="offer-id" style="border: 1px solid #000;">
                            <td style="border: 1px solid #000;">' . $offer['offer_form_id'] . '</td>
                            <td style="border: 1px solid #000;"><a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='. $offer['offer_form_id'] .'&reportHash=o9ob73zd">Pobierz</a></td>
                            <td style="border: 1px solid #000;"><a href="/kalkulator-fotowoltaiki?offerHash='. $offer['hash'] .'&history=1&offer_forms='. $offer['offer_form_id'] .'">Edytuj</a></td>
                            <td style="border: 1px solid #000;"><button data-id="'. $offer->ID .'" data-nonce="'. $nonce .'" class="delete-post">Usuń</button></td>
                        </tr>            
                    ';
                }
            }
            echo '</table>';
        } else {
            echo __('brak historycznych ofert', 'hewalex-zones');
        }

    }

    public function deleteOffer(){
        $permission = check_ajax_referer( 'deleteOffer_nonce', 'nonce', false );
        if( $permission == false ) {
            echo 'error';
        }
        else {
            wp_delete_post( $_REQUEST['id'] );
            echo 'success';
        }
        die();
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