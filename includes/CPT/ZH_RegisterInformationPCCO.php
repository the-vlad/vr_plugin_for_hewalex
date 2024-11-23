<?php

namespace Develtio\ZonesHewalex\CPT;

if (!defined('ABSPATH')) {
    die;
}
use StoutLogic\AcfBuilder\FieldsBuilder;
/**
 * Class ZH_RegisterTrainerTypeCPT
 */
class ZH_RegisterInformationPCCO
{
    private const CPT_NAME = "information";
    private const CPT_INFO_TYPE = "pcco";

    public function __construct()
    {
        add_action('init', array($this, 'register_pcco_type'));
        add_action( 'admin_menu', array($this, 'addSubMenuPCCO' ));
        add_action('acf/init', array($this, 'acfFieldsPCCO'));
    }

    public function register_pcco_type(): void
    {
        $args = array(
            'label' => __('PCCO', 'hewalex-zones'),
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

    public function addSubMenuPCCO():void
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_NAME,                 // parent slug
            'PCCO',             // page title
            'PCCO',             // sub-menu title
            'edit_posts',                 // capability
            'edit.php?post_type='. self::CPT_INFO_TYPE, // your menu menu slug
            '',
            1
        );
    }

    public function acfFieldsPCCO() {
        $cpt_single = new FieldsBuilder('PCCO fields');
        $cpt_single
        ->addWysiwyg('pcco_desc', [
            'label' => 'Main description'
        ])
        ->addRepeater('pcco_add-file', [
            'label' => 'Add file',
            'layout' => 'block',
        ])
           
        ->addFile('pcco_file', [
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
            
        ->setLocation('post_type', '==', 'pcco');

        acf_add_local_field_group($cpt_single->build());
    }

}