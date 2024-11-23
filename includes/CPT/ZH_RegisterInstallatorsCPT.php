<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_RegisterCPT
 */
class ZH_RegisterInstallatorsCPT
{
    private const CPT_NAME = "installators";

    public function __construct()
    {
        add_action( 'acf/init', array($this, 'acfFieldsTrainers' ));
        //add_action( 'admin_init', array($this, 'addStyle'));
    }

    public function addStyle() {
        echo '<style>';
            echo '#your-profile .acf-field-group .acf-label:first-child { display: none }';
            echo '#your-profile .acf-input { padding: 0 !important}';
            echo '#your-profile .acf-input .acf-label{ display: block !important}';
        echo '</style>';
    }

    public function acfFieldsTrainers() {
        $cpt_single = new FieldsBuilder('installator-single', ['title' => 'Dane instalatora']);
        $cpt_single
            ->addGroup('installation_group1', [
                'label' => '',
                'wrapper' => [
                    'width' => 100
                ],
                'layout' => 'block',
            ])
            ->addText('installation_nip', [
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
                'label' => 'Numer telefonu',
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
                'wrapper' => [
                    'width' => '33'
                ]
            ])
            ->addCheckbox('installation_connect', [
                'label' => 'Zgoda',
                'required' => 0,
                'choices' => array(
                    'agree'          => 'Chcę powiązać moje konto z kontem instalatora',
                ),
                'return_format' => 'value',
            ])
            ->endGroup()
            ->setLocation('user_form', '==', 'edit');

        acf_add_local_field_group($cpt_single->build());
    }
}