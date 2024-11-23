<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}
use StoutLogic\AcfBuilder\FieldsBuilder;
/**
 * Class ZH_RegisterTrainerTypeCPT
 */
class ZH_RegisterInformationPCWB
{
    private const CPT_NAME = "information";
    private const CPT_INFO_TYPE = "pcwb";

    public function __construct()
    {
        add_action('init', array($this, 'register_pcwb_type'));
        add_action( 'admin_menu', array($this, 'addSubMenuPCWB' ));
        add_action('acf/init', array($this, 'acfFieldsPCWB'));
    }

    public function register_pcwb_type(): void
    {
        $args = array(
            'label' => __('PCWB', 'hewalex-zones'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'supports' => ['title', 'custom-fields'],
            'has_archive' => true,
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_INFO_TYPE
            ],
        );
        register_post_type(self::CPT_INFO_TYPE, $args);

    }



    public function addSubMenuPCWB():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_NAME,                 // parent slug
            'PCWB',             // page title
            'PCWB',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_INFO_TYPE, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsPCWB() {
        $cpt_single = new FieldsBuilder('PCWB fields');
        $cpt_single
        ->addWysiwyg('pcwb_desc', [
            'label' => 'Main description'
        ])
        ->addRepeater('pcwb_add-file', [
            'label' => 'Add file',
            'layout' => 'block',
        ])
           
        ->addFile('pcwb_file', [
            'label' => 'File Field',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => [],
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'return_format' => 'url',
            'library' => 'all',
            'min_size' => '',
            'max_size' => '',
            'mime_types' => '',
        ])
      
        ->endRepeater()
            
            ->setLocation('post_type', '==', 'pcwb');

        acf_add_local_field_group($cpt_single->build());
    }

}