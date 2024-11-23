<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use Develtio\ZonesHewalex\API\model\ZH_OfferFormPCWB;
use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_InterestedListUsersPCWB
 */
class ZH_InterestedListUsersPCWB
{
    private const CPT_NAME = "users_pcwb";
    private const CPT_InterestedListUsers = "interested_users";

    private $readOnly = array(
        'hash',
        'parent_hash',
        'category_calc',
    );

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCpt'), 9);
        add_action( 'admin_menu', array($this, 'addSubMenuInsterestedUsersPcwb' ));
        add_action( 'acf/init', array($this, 'acfFieldsInterestedUsersPcwb' ));

        add_filter( 'acf/load_field', array($this, 'acfReadOnly' ));
        add_action('add_meta_boxes',array($this, 'selectionDataMetabox'));
        add_action('add_meta_boxes',array($this, 'hewalexDataMetabox'));

        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_trainers_columns' ));
        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_trainers_column' ), 10, 2 );

        add_action( 'acf/save_post', array($this, 'saveField' ), 20);
    }

    public function registerCpt(): void
    {
        $args = array(
            'label' => __('Formularz doboru PCWB', 'hewalex-zones'),
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

    public function addSubMenuInsterestedUsersPcwb():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_InterestedListUsers,                 // parent slug
            'PCWB',             // page title
            'PCWB',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsInterestedUsersPcwb()
    {
        $form_pcwb = new FieldsBuilder('form-pcwb', ['title' => 'Formularz doboru PCWB']);
        $form_pcwb
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
            ->addText('pcwb_name', [
                'label' => 'Imię i nazwisko:',
            ])
            ->addNumber('pcwb_phone', [
                'label' => 'Telefon:',
            ])
            ->addEmail('pcwb_mail', [
                'label' => 'E-mail:',
            ])
            ->addText('pcwb_postcode', [
                'label' => 'Kod pocztowy:',
            ])
            ->addTextarea('pcwb_comment', [
                'label' => 'Komentarz zgłaszającego:',
            ])
            ->addText('pcwb_agree_1', [
                'label' => 'Zgoda mail:',
            ])
            ->addText('pcwb_agree_2', [
                'label' => 'Zgoda dane:',
            ])
            ->addTextarea('pcwb_options', [
                'label' => 'Options:',
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addTextarea('pcwb_contact', [
                'label' => 'Contact:',
//                'wrapper' => [
//                    'class' => 'hidden'
//                ]
            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($form_pcwb->build());
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
            'users_pcwb',
            'side',
            'core'
        );
    }

    public function selectionDataMetabox() {
        add_meta_box(
            'selection-data',
            __( 'Dane doboru', 'zones-hewalex' ),
            array($this, 'noticeMetaboxCallback'),
            'users_pcwb',
            'side',
            'default'
        );
    }

    public function noticeMetaboxCallback($post){
        $optionsArr = get_field('pcwb_options', $post->ID);
        $arrOptions = json_decode($optionsArr, true);
        $contactArr = get_field('pcwb_contact', $post->ID);
        $arrContacts = json_decode($contactArr, true);
        $offerFormWithModelsTree = (new ZH_OfferFormPCWB())->getExactFormWithModels($arrOptions, $arrContacts, ['grouped' => true]);

        $formContent = '';
        $this->renderPrintableOfferForm($offerFormWithModelsTree, $formContent);
        echo $formContent;
    }

    public function noticeMetaboxHewalexCallback($post) {
        echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='.get_field('hash', $post->ID).'&reportHash=54Kspw429r7">Ankieta Klient</a>' . '</br>';
        echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='.get_field('hash', $post->ID).'&reportHash=wp305b23">Raport klient</a>' . '</br>';
        echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreview?hash='.get_field('hash', $post->ID).'&reportHash=wp305b23TEST">Raport klient - TEST</a>' . '</br>';
        if(get_field('parent_hash', $post->ID)){
            echo '<a target="_blank" href="' . admin_url() . 'post.php?post='. $this->getIDParentHash(get_field('parent_hash', $post->ID)) .'&action=edit">Zobacz poprzednią wersję oferty</a>' . '</br>';
        }
        echo '<a target="_blank" href="/formularz-doboru-pomp-ciepla-pcwb?offerHash='.get_field('hash', $post->ID).'">Przejdź do kompleksowej edycji</a>';
    }

    public function getIDParentHash($parentHash)
    {
        if ($parentHash) {
            $args = array(
                'post_type' => 'users_pcwb',
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
                $n_columns['pcwb_phone'] = __( 'Telefon', 'hewalex-zones' );
                $n_columns['pcwb_mail'] = __( 'E-mail', 'hewalex-zones' );
            }
            $n_columns[$key] = $value;
        }

        return $n_columns;
    }

    public function custom_trainers_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'pcwb_phone' :
                echo get_field( 'pcwb_phone', $post_id );
                break;
            case 'pcwb_mail' :
                echo get_field( 'pcwb_mail', $post_id );
                break;
        }
    }

    public function saveField()
    {
        $replace = [
            0 => [
                'id' => 'name',
                'value' => $_POST['acf']['field_form-pcwb_pcwb_name'],
            ],
            1 => [
                'id' => 'email',
                'value' => $_POST['acf']['field_form-pcwb_pcwb_mail'],
            ],
            2 => [
                'id' => 'phone',
                'value' => $_POST['acf']['field_form-pcwb_pcwb_phone'],
            ],
            3 => [
                'id' => 'accept_mailing',
                'value' => $_POST['acf']['field_form-pcwb_pcwb_agree_1'],
            ],
            4 => [
                'id' => 'accept_data',
                'value' => $_POST['acf']['field_form-pcwb_pcwb_agree_2'],
            ],
            5 => [
                'id' => 'zip',
                'value' => $_POST['acf']['field_form-pcwb_pcwb_postcode'],
            ],
        ];

        update_field('pcwb_contact', json_encode($replace), get_the_ID());
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

                $value = $model['value'] ?? '';
                $selectedId = $model['selectedId'] ?? null;
                if ($selectedId) {
                    $valueModel = array_first($model['options'], function ($option) use ($selectedId) {
                        return $option['id'] === $selectedId;
                    });

                    $value = $valueModel['displayName']['form'] ?? $valueModel['displayName'] ?? "<span class='error'>{$model['value']}</span>";
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
}