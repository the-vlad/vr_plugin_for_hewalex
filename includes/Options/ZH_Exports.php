<?php

namespace Develtio\ZonesHewalex\Options;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Options
 */
class ZH_Exports
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private const CPT_NAME = "trainers";

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'addExportsPage' ) );
        add_action( 'admin_init', array( $this, 'pageExportsInit' ) );
        add_action( 'send_api_data', array( $this, 'sendApiData' ));
    }

    public function sendApiData($new_input)
    {
        if($new_input['salesmanago'] == 1)
        {
            do_action('send_data_salesmanago', $new_input);
        }

        if($new_input['edokumenty'] == 1)
        {
            do_action('send_data_edokumenty', $new_input);
        }
    }


    /**
     * Add options page
     */
    public function addExportsPage()
    {
        add_submenu_page(
            'edit.php?post_type='.self::CPT_NAME,
            'Exports',
            'Exports',
            'manage_options',
            'export-configuration',
            array( $this, 'createExportsPage' ),
            2
        );
    }

    /**
     * Options page callback
     */
    public function createExportsPage()
    {
        // Set class property
        $this->options = get_option( 'exports_config' );
        ?>
        <div class="wrap">
            <h1>Exports Configuration</h1>
            <form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>">
                <?php
                settings_errors('export-notices');
                settings_fields( 'exports_group' );
                do_settings_sections( 'export-configuration' );
                submit_button('Export');
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function pageExportsInit()
    {
        register_setting(
            'exports_group', // Option group
            'exports_config', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'exportsConfig', // ID
            'Export Configuration', // Title
            array( $this, 'printSectionInfo' ), // Callback
            'export-configuration' // Page
        );

        add_settings_field(
            'date', // ID
            'Data szkolenia', // Title
            array( $this, 'date' ), // Callback
            'export-configuration', // Page
            'exportsConfig' // Section
        );

        add_settings_field(
            'type', // ID
            'Rodzaj szkolenia', // Title
            array( $this, 'type' ), // Callback
            'export-configuration', // Page
            'exportsConfig' // Section
        );

        add_settings_field(
            'edokumenty', // ID
            'Export do eDokumenty', // Title
            array( $this, 'edokumenty' ), // Callback
            'export-configuration', // Page
            'exportsConfig' // Section
        );

        add_settings_field(
            'salesmanago', // ID
            'Export do Sales Manago', // Title
            array( $this, 'salesmanago' ), // Callback
            'export-configuration', // Page
            'exportsConfig' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        isset($input['edokumenty']) ?
            $new_input['edokumenty'] = true :
            $new_input['edokumenty'] = false;

        isset($input['salesmanago']) ?
            $new_input['salesmanago'] = true :
            $new_input['salesmanago'] = false;

        if( isset( $input['date'] ) )
            $new_input['date'] = date("d-m-Y", strtotime($input['date']));

        if( isset( $input['type'] ) )
            $new_input['type'] = sanitize_text_field($input['type']);

        do_action('send_api_data', $new_input);

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function printSectionInfo()
    {
        print 'Details for exports';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function date()
    {
        printf(
            '<input type="date" id="date" name="exports_config[date]" value="%s" />',
            isset( $this->options['date'] ) ? date('Y-m-d', strtotime($this->options['date'])) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function type()
    {
        $args = array(
            'post_type'         => 'trainer_type',
            'posts_per_page'    => -1
        );
        $typesTrainer = get_posts($args);

        echo '<select name="exports_config[type]">';
        foreach($typesTrainer as $type)
        {
            echo '<option value="'.$type->post_title.'">'.$type->post_title.'</option>';
        }
        echo '</select>';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function edokumenty()
    {
        printf(
            '<input type="checkbox" id="edokumenty" name="exports_config[edokumenty]" %s />',
            isset( $this->options['edokumenty'] ) ? checked( 1, $this->options['edokumenty'], false ) : checked( 0, $this->options['edokumenty'], false )
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function salesmanago()
    {
        printf(
            '<input type="checkbox" id="salesmanago" name="exports_config[salesmanago]" %s />',
            isset( $this->options['salesmanago'] ) ? checked( 1, $this->options['salesmanago'], false ) : checked( 0, $this->options['salesmanago'], false )
        );
    }
}
