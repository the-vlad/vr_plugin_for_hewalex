<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_PumpNumbersSet
 */
class ZH_PumpNumbersSet
{

    private const CPT_NAME = "pump_numbers_set";
    private const CPT_SolarSet = "pump_set";

    private $readOnly = array(
        'pump_set'
    );

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptPumpNumbersSet'));
        add_action( 'admin_menu', array($this, 'addSubMenuTypesSet' ));
        add_action( 'acf/init', array($this, 'acfFieldsNumbersSet' ));

        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_number_set_columns' ));
        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_pump_number_set_column' ), 10, 2 );

        add_action( 'acf/save_post', array($this, 'saveMultiple' ), 5);
    }

    public function saveMultiple()
    {
        $type_set = $_POST['acf']['field_pump-numbers-set_type_set'];
        $quantity = $_POST['acf']['field_pump-numbers-set_quantity'];

        if($quantity > 1) {
            foreach (range(1, $quantity - 1) as $i) {
                $number_set = wp_generate_password(7, false, false);

                $args = [
                    'post_title' => $number_set,
                    'post_type' => 'pump_numbers_set',
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                    'meta_input' => array(
                        'type_set' => $type_set,
                        'pump_set' => $number_set,
                    )
                ];

                $postid = wp_insert_post($args);

                update_field('type_set', $type_set, $postid);
            }
        }
    }

    public function registerCptPumpNumbersSet(): void
    {
        $args = array(
            'label' => __('Numery zestawów Pompy', 'hewalex-zones'),
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
            'Numery zestawów Pompy',             // page title
            'Numery zestawów Pompy',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_NAME, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsNumbersSet()
    {
        $number_set = wp_generate_password(7, false, false);
        $form_pcco = new FieldsBuilder('pump-numbers-set', ['title' => 'Numery zestawów Pompy']);
        $form_pcco
            ->addPostObject('type_set', [
                'label' => 'Typ',
                'required' => 0,
                'post_type' => 'pump_types_set',
                'allow_null' => 0,
                'return_format' => 'object',
                'ui' => 1
            ])
            ->addSelect('quantity', [
                'label' => 'Ilość:',
                'choices' => array(
                    '1',
                    '2',
                    '3',
                    '4',
                    '5',
                    '6',
                    '7',
                    '8',
                    '9',
                    '10',
                    '11',
                    '12',
                    '13',
                    '14',
                    '15',
                    '16',
                    '17',
                    '18',
                    '19',
                    '20',
                    '21',
                    '22',
                    '23',
                    '24',
                    '25'
                ),
                'ui' => 1,
            ])
            ->addDatePicker('date', [
                'label' => 'Data'
            ])
            ->addTextarea('comment', [
                'label' => 'Komentarz/nazwa firmy',
            ])
            ->addText('pump_set', [
                'label' => 'Numer',
                'default_value' => $number_set,
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->setLocation('post_type', '==', self::CPT_NAME);

        acf_add_local_field_group($form_pcco->build());
    }

    public function set_custom_edit_number_set_columns($columns)
    {
        unset( $columns['title'] );
        $n_columns = array();
        $before = 'date'; // move before this

        foreach($columns as $key => $value) {
            if ($key==$before){
                $n_columns['pump_set'] = __( 'Numer pompy', 'hewalex-zones' );
            }
            $n_columns[$key] = $value;
        }

        return $n_columns;
    }

    public function custom_pump_number_set_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'pump_set' :
                echo get_field( 'pump_set', $post_id );
                break;
        }
    }
}