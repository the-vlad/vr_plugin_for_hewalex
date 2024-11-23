<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_RegisterCPT
 */
class ZH_RegisterTrainerCPT
{
    private const CPT_NAME = "trainers";

    public function __construct()
    {
        add_action('init', array($this, 'register_cpt'), 9);
        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_trainers_columns' ));
        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_trainers_column'), 10, 2 );
        add_action('acf/init', array($this, 'acfFieldsTrainers'));
    }

    public function register_cpt(): void
    {
        $args = array(
            'label' => __('Szkolenia', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'supports' => ['title', 'custom-fields','thumbnail'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }

    public function acfFieldsTrainers() {
        $cpt_single = new FieldsBuilder('trainers-single');
        $cpt_single
        ->addWysiwyg('trainers_desc', [
            'label' => 'Opis'
        ])
        ->addImage('trainers_img', [
            'label' => 'block image',
            'return_format' => 'url',
            'preview_size' => 'thumbnail',
        ])
        ->addDatePicker('trainers_date', [
            'label' => 'Data szkolenia',
        ])
        ->addTimePicker('trainers_time', [
            'label' => 'Czas szkolenia',
            'instructions' => '',
            'required' => 0,
            'display_format' => 'H:i',
            'return_format' => 'H:i',
            'default_value' => '',
        ])
        ->addText('trainers_price', [
            'label' => 'Cena',
        ])
        ->addText('trainers_location', [
            'label' => 'Miejsce',
        ])
        ->addTrueFalse('trainers_avaliable', [
            'label' => 'Dostępny kurs',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => [],
        ])
       
        ->addText('trainers_type', [
            'label' => 'Typ',
        ])
        ->addText('trainers_comment', [
            'label' => 'Komentarz',
        ])
        ->addWysiwyg('trainers_program', [
            'label' => 'Program szkolenia'
        ])
        ->addRepeater('trainers_row', ['min' => 1, 'layout' => 'block'])  
            ->addTrueFalse('trainers_reverse', [
                'label' => 'Make reverse',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => [],
            ])
            ->addColorPicker('trainers_color', [
                'label' => 'Color',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => [],
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
            ])
        ->addImage('trainers_row_img', [
                'label' => 'image',
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
            ])   
            ->addWysiwyg('trainers_row_desc', [
                'label' => 'Tekst opisu'
            ])
        ->endRepeater()
            ->addImage('trainers_cta_img', [
                'label' => 'image',
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
            ])  
            ->addText('trainers_cta_title', [
                'label' => 'CTA tytuł',
            ])
            ->addWysiwyg('trainers_cta_desc', [
                'label' => 'CTA opis'
            ])
            ->addText('trainers_course_url', [
                'label' => 'Zapisz się URL',
            ])
            ->addText('trainers_course_url_reserve', [
                'label' => 'Rezerwacja online URL',
            ])
            ->setLocation('post_type', '==', 'trainers');

        acf_add_local_field_group($cpt_single->build());
    }

    public function set_custom_edit_trainers_columns($columns) {
        unset( $columns['date'] );
        $columns['trainers_date'] = __( 'Data szkolenia', 'hewalex-zones' );
        $columns['trainers_type'] = __( 'Rodzaj szkolenia', 'hewalex-zones' );
        $columns['trainers_comment'] = __( 'Komentarz', 'hewalex-zones' );

        return $columns;
    }

    public function custom_trainers_column( $column, $post_id ) {
        switch ( $column ) {
            case 'trainers_date' :
                echo get_field( 'trainers_date', $post_id );
                break;
            case 'trainers_type' :
                echo get_field( 'trainers_type', $post_id );
                break;
            case 'trainers_comment' :
                echo get_field( 'trainers_comment', $post_id );
                break;
        }
    }
}