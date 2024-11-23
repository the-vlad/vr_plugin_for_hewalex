<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_RegisterInstallationCPT
 */
class ZH_RegisterInstallationCPT
{
    private const CPT_NAME = "installation";
    private const CPT_INSTALLATORS = "installators";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCpt'), 9);
//        add_filter( 'manage_'. self::CPT_NAME .'_posts_columns', array($this, 'set_custom_edit_trainers_columns' ));
//        add_action( 'manage_'. self::CPT_NAME .'_posts_custom_column' , array($this, 'custom_trainers_column' ), 10, 2 );
        add_action( 'acf/init', array($this, 'acfFieldsTrainersStep1' ));
        add_action( 'acf/init', array($this, 'acfFieldsTrainersStep2' ));
        //add_action( 'admin_menu', array($this, 'addSubMenuInstallation' ));
        add_filter( 'acf/load_field', array($this, 'acfReadOnly' ));
    }

    public function acfReadOnly( $field ) : array
    {
        global $post;
        if( 'installation_email' === $field['name']  && ! is_admin() ) {
            $field['disabled']       = true;
            $field['value']          = get_field('installation_email_step1', $_GET['post_id']);
            $field['default_value']  = get_field('installation_email_step1', $_GET['post_id']);
        }
        elseif( 'installation_email' === $field['name']  && is_admin() ) {
            $field['value']          = get_field('installation_email_step1', $post->ID);
            $field['default_value']  = get_field('installation_email_step1', $post->ID);
        }

        return $field;

    }

    public function registerCpt(): void
    {
        $args = array(
            'label' => __('Instalacje', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'supports' => ['title', 'author', 'custom-fields'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }

    public function acfFieldsTrainersStep1()
    {
        $step1 = new FieldsBuilder('installation-single-step-1', ['title' => 'Krok 1']);
        $step1
            ->addText('installation_code', [
                'label' => 'Numer zestawu:',
            ])
            ->addEmail('installation_email_step1', [
                'label' => 'E-mail',
            ])
            ->addTrueFalse('user', [
                'label' => 'Akceptuję regulamin programu PPG',
                'required' => 1,
                'default_value' => 0,
            ])
            ->addTrueFalse('terms', [
                'label' => 'Zapoznałem się z informacją o administratorze i przetwarzaniu danych.',
                'required' => 1,
                'default_value' => 0,
            ])
            ->addTrueFalse('condition', [
                'label' => 'Zapoznałem się z informacją o administratorze i przetwarzaniu danych.',
                'required' => 1,
                'default_value' => 0,
            ])
            ->addTrueFalse('newsletter', [
                'label' => 'Chcę otrzymywać newsletter',
                'required' => 0,
                'default_value' => 0,
            ])
            ->setLocation('post_type', '==', 'installation');

        acf_add_local_field_group($step1->build());
    }

    public function acfFieldsTrainersStep2()
    {
        $step2 = new FieldsBuilder('installation-single-step-2', ['title' => 'Krok 2']);
        $step2
            ->addGroup('installation_group', ['label' => 'Dane klienta'])
                ->addEmail('installation_email', [
                    'label' => 'Adres e-mail',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_address', [
                    'label' => 'Adres',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addSelect('installation_province', [
                    'label' => 'Województwo',
                    'choices' => [
                        'slaskie'            => "Śląskie",
                        'dolnoslaskie'       => 'Dolnośląskie',
                        'kujawskopomorskie'  => 'Kujawsko-Pomorskie',
                        'lubelskie'          => 'Lubelskie',
                        'lubuskie'           => 'Lubuskie',
                        'lodzkie'            => 'Łódzkie',
                        'malopolskie'        => 'Małopolskie',
                        'mazowieckie'        => 'Mazowieckie',
                        'opolskie'           => 'Opolskie',
                        'podkarpackie'       => 'Podkarpackie',
                        'podlaskie'          => 'Podlaskie',
                        'pomorskie'          => 'Pomorskie',
                        'swietokrzyskie'     => 'Świętokrzyskie',
                        'warminskomazurskie' => 'Warmińsko-Mazurskie',
                        'wielkopolskie'      => 'Wielkopolskie',
                        'zachodniopomorskie' => 'Zachodniopomorskie'
                    ],
                    'default_value' => 'key',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_name', [
                    'label' => 'Imię',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_post_code', [
                    'label' => 'Kod pocztowy',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_phone', [
                    'label' => 'Numer telefonu',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_surname', [
                    'label' => 'Nazwisko',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_city', [
                    'label' => 'Miejscowość',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->endGroup()
            ->addGroup('installation_group2', ['label' => 'Dane produktu'])
                ->addText('installation_code_product', [
                    'label' => 'Numer zestawu',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_number_collector1', [
                    'label' => 'Numer kolektora 1',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_number_collector2', [
                    'label' => 'Numer kolektora 2',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_type', [
                    'label' => 'Typ zestawu',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_number_heater', [
                    'label' => 'Numer podgrzewacza',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_number_set', [
                    'label' => 'Numer zespołu pompowego',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addSelect('installation_source', [
                    'label' => 'Żródło zakupu',
                    'choices' => [
                        'hurtownia'    => "Hurtownia",
                        'instalator'   => 'Instalator',
                        'internet'     => 'Internet',
                    ],
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_number_driver', [
                    'label' => 'Numer sterownika',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addDatePicker('installation_date', [
                    'label' => 'Data zakupu',
                    'wrapper' => [
                        'width' => '33'
                    ],
                    'display_format' => 'd/m/Y',
                    'return_format' => 'd/m/Y',
                ])
                ->endGroup()
            ->addGroup('installation_group3', ['label' => 'Dane instalatora'])
                ->addText('installation_nip_installer', [
                    'label' => 'NIP',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_post_code_installer', [
                    'label' => 'Kod pocztowy',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_phone_installer', [
                    'label' => 'Numer telefonu',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_name_installer', [
                    'label' => 'Nazwa',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_city_installer', [
                    'label' => 'Miejscowość',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addEmail('installation_email_installer', [
                    'label' => 'Adres e-mail',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addText('installation_address_installer', [
                    'label' => 'Adres',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addSelect('installation_province_installer', [
                    'label' => 'Adres',
                    'choices' => [
                        'slaskie'            => "Śląskie",
                        'dolnoslaskie'       => 'Dolnośląskie',
                        'kujawskopomorskie'  => 'Kujawsko-Pomorskie',
                        'lubelskie'          => 'Lubelskie',
                        'lubuskie'           => 'Lubuskie',
                        'lodzkie'            => 'Łódzkie',
                        'malopolskie'        => 'Małopolskie',
                        'mazowieckie'        => 'Mazowieckie',
                        'opolskie'           => 'Opolskie',
                        'podkarpackie'       => 'Podkarpackie',
                        'podlaskie'          => 'Podlaskie',
                        'pomorskie'          => 'Pomorskie',
                        'swietokrzyskie'     => 'Świętokrzyskie',
                        'warminskomazurskie' => 'Warmińsko-Mazurskie',
                        'wielkopolskie'      => 'Wielkopolskie',
                        'zachodniopomorskie' => 'Zachodniopomorskie'
                    ],
                    'default_value' => 'key',
                    'wrapper' => [
                        'width' => '33'
                    ]
                ])
                ->addTrueFalse('installation_connect', [
                    'label' => 'Chcę powiązać moje konto z kontem instalatora',
                    'required' => 0,
                    'default_value' => 0,
                ])
//                ->addCheckbox('installation_connect', [
//                    'label' => 'Zgoda',
//                    'required' => 0,
//                    'choices' => array(
//                        'agree'          => 'Chcę powiązać moje konto z kontem instalatora',
//                    ),
//                    'return_format' => 'value',
//                ])
                ->endGroup()
            ->addGroup('installation_group4', ['label' => 'Komentarz'])
                ->addTextarea('installation_comment', [
                    'label' => 'Komentarz',
                ])
                ->addText('installation_points_active', [
                    'label' => 'Zdobyte punkty',
                ])
                ->addText('installation_points_purchase', [
                    'label' => 'Wydane punkty',
                ])
                ->addTrueFalse('installation_status', [
                    'label' => 'Status (Przedawniony?)',
                    'required' => 0,
                    'default_value' => 0,
                ])
                ->addTrueFalse('installation_client', [
                    'label' => 'Zarejestrował klient',
                    'required' => 0,
                    'default_value' => 0,
                ])
                ->addTrueFalse('installation_instalator', [
                    'label' => 'Zarejestrował instalator',
                    'required' => 0,
                    'default_value' => 0,
                ])
                ->endGroup()
            ->setLocation('post_type', '==', 'installation');

        acf_add_local_field_group($step2->build());
    }

    public function set_custom_edit_trainers_columns($columns)
    {
        unset( $columns['title'] );
        $columns['installation_code'] = __( 'Kod zestawu', 'hewalex-zones' );
        $columns['installation_email'] = __( 'E-mail', 'hewalex-zones' );

        return $columns;
    }

    public function custom_trainers_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'installation_code' :
                echo get_field( 'installation_code', $post_id );
                break;
            case 'installation_email_step1' :
                echo get_field( 'installation_email_step1', $post_id );
                break;
        }
    }
}