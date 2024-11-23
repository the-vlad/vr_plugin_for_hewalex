<?php

namespace Develtio\ZonesHewalex\Options;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Options
 */
class ZH_Options
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'addPluginPage' ) );
        add_action( 'admin_init', array( $this, 'pagePluginInit' ) );
        add_action( 'wp_head', array( $this, 'addScriptsHead' ) );
        add_action( 'wp_footer', array( $this, 'addScriptsBody' ) );
    }

    /**
     * Add options page
     */
    public function addPluginPage()
    {
        add_menu_page(
            'Plugin Configuration',
            'Plugin Configuration',
            'manage_options',
            'plugin-configuration',
            array( $this, 'createAdminPage' ),
            '',
            66
        );
    }

    /**
     * Options page callback
     */
    public function createAdminPage()
    {
        // Set class property
        $this->options = get_option( 'eDokumenty_config' );
        ?>
        <div class="wrap">
            <h1>Plugin Configuration</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'eDokumenty_config_group' );
                do_settings_sections( 'plugin-configuration' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function pagePluginInit()
    {
        register_setting(
            'eDokumenty_config_group', // Option group
            'eDokumenty_config', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'eDokumentyConfig', // ID
            'Plugin Configuration', // Title
            array( $this, 'printSectionInfo' ), // Callback
            'plugin-configuration' // Page
        );

        add_settings_field(
            'edok_login', // ID
            'eDokumenty Login', // Title
            array( $this, 'edokLogin' ), // Callback
            'plugin-configuration', // Page
            'eDokumentyConfig' // Section
        );

        add_settings_field(
            'edok_password', // ID
            'eDokumenty Password', // Title
            array( $this, 'edokPassword' ), // Callback
            'plugin-configuration', // Page
            'eDokumentyConfig' // Section
        );

        add_settings_field(
            'edok_entity_symbol',
            'eDokumenty Entity Symbol',
            array( $this, 'edokSymbol' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'edok_location',
            'eDokumenty Location',
            array( $this, 'edokLocation' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'google_maps_api',
            'Google Maps API Key',
            array( $this, 'map_api_key' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'client_id',
            'SalesManago - CLIENT ID',
            array( $this, 'salesManagoCliendID' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'sales_api_key',
            'SalesManago - API KEY',
            array( $this, 'salesManagoAPIKey' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'sales_secret_key',
            'SalesManago - SECRET KEY',
            array( $this, 'salesManagoSecretKey' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'sales_endpoint',
            'SalesManago - ENDPOINT',
            array( $this, 'salesManagoEndPoint' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'sales_owner',
            'SalesManago - OWNER',
            array( $this, 'salesManagoOwner' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'synology_host',
            'SYNOLOGY - HOST',
            array( $this, 'synologyHost' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'synology_username',
            'SYNOLOGY - USERNAME',
            array( $this, 'synologyUsername' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'synology_password',
            'SYNOLOGY - PASSWORD',
            array( $this, 'synologyPassword' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'google_tag_manager_head',
            'Google Tag Manager - HEAD',
            array( $this, 'googleTagManagerHead' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'google_tag_manager_body',
            'Google Tag Manager - BODY',
            array( $this, 'googleTagManagerBody' ),
            'plugin-configuration',
            'eDokumentyConfig'
        );

        add_settings_field(
            'google_analytics',
            'Google Analytics',
            array( $this, 'googleAnalytics' ),
            'plugin-configuration',
            'eDokumentyConfig'
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
        if( isset( $input['edok_login'] ) )
            $new_input['edok_login'] = sanitize_text_field( $input['edok_login'] );

        if( isset( $input['edok_password'] ) )
            $new_input['edok_password'] = sanitize_text_field( $input['edok_password'] );

        if( isset( $input['edok_entity_symbol'] ) )
            $new_input['edok_entity_symbol'] = sanitize_text_field( $input['edok_entity_symbol'] );

        if( isset( $input['edok_location'] ) )
            $new_input['edok_location'] = sanitize_text_field( $input['edok_location'] );

        if( isset( $input['google_maps_api'] ) )
            $new_input['google_maps_api'] = sanitize_text_field( $input['google_maps_api'] );

        if( isset( $input['client_id'] ) )
            $new_input['client_id'] = sanitize_text_field( $input['client_id'] );

        if( isset( $input['sales_api_key'] ) )
            $new_input['sales_api_key'] = sanitize_text_field( $input['sales_api_key'] );

        if( isset( $input['sales_secret_key'] ) )
            $new_input['sales_secret_key'] = sanitize_text_field( $input['sales_secret_key'] );

        if( isset( $input['sales_endpoint'] ) )
            $new_input['sales_endpoint'] = sanitize_text_field( $input['sales_endpoint'] );

        if( isset( $input['sales_owner'] ) )
            $new_input['sales_owner'] = sanitize_text_field( $input['sales_owner'] );

        if( isset( $input['synology_host'] ) )
            $new_input['synology_host'] = sanitize_text_field( $input['synology_host'] );

        if( isset( $input['synology_username'] ) )
            $new_input['synology_username'] = sanitize_text_field( $input['synology_username'] );

        if( isset( $input['synology_password'] ) )
            $new_input['synology_password'] = sanitize_text_field( $input['synology_password'] );

        if( isset( $input['google_tag_manager_head'] ) )
            $new_input['google_tag_manager_head'] = $input['google_tag_manager_head'];

        if( isset( $input['google_tag_manager_body'] ) )
            $new_input['google_tag_manager_body'] = $input['google_tag_manager_body'];

        if( isset( $input['google_analytics'] ) )
            $new_input['google_analytics'] = $input['google_analytics'];

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function printSectionInfo()
    {
        //print 'Enter your eDokumenty settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function edokLogin()
    {
        printf(
            '<input type="text" id="edok_login" name="eDokumenty_config[edok_login]" value="%s" />',
            isset( $this->options['edok_login'] ) ? esc_attr( $this->options['edok_login']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function edokPassword()
    {
        printf(
            '<input type="password" id="edok_password" name="eDokumenty_config[edok_password]" value="%s" />',
            isset( $this->options['edok_password'] ) ? esc_attr( $this->options['edok_password']) : ''
        );
    }

     /**
     * Get the settings option array and print one of its values
     */
    public function edokLocation()
    {
        printf(
            '<input type="text" id="edok_location" name="eDokumenty_config[edok_location]" value="%s" />',
            isset( $this->options['edok_location'] ) ? esc_attr( $this->options['edok_location']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function edokSymbol()
    {
        printf(
            '<input type="text" id="edok_entity_symbol" name="eDokumenty_config[edok_entity_symbol]" value="%s" />',
            isset( $this->options['edok_entity_symbol'] ) ? esc_attr( $this->options['edok_entity_symbol']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function map_api_key()
    {
        printf(
            '<input type="text" id="google_maps_api" name="eDokumenty_config[google_maps_api]" value="%s" />',
            isset( $this->options['google_maps_api'] ) ? esc_attr( $this->options['google_maps_api']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function salesManagoCliendID()
    {
        printf(
            '<input type="text" id="client_id" name="eDokumenty_config[client_id]" value="%s" />',
            isset( $this->options['client_id'] ) ? esc_attr( $this->options['client_id']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function salesManagoAPIKey()
    {
        printf(
            '<input type="text" id="sales_api_key" name="eDokumenty_config[sales_api_key]" value="%s" />',
            isset( $this->options['sales_api_key'] ) ? esc_attr( $this->options['sales_api_key']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function salesManagoSecretKey()
    {
        printf(
            '<input type="text" id="sales_secret_key" name="eDokumenty_config[sales_secret_key]" value="%s" />',
            isset( $this->options['sales_secret_key'] ) ? esc_attr( $this->options['sales_secret_key']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function salesManagoEndPoint()
    {
        printf(
            '<input type="text" id="sales_endpoint" name="eDokumenty_config[sales_endpoint]" value="%s" />',
            isset( $this->options['sales_endpoint'] ) ? esc_attr( $this->options['sales_endpoint']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function salesManagoOwner()
    {
        printf(
            '<input type="text" id="sales_owner" name="eDokumenty_config[sales_owner]" value="%s" />',
            isset( $this->options['sales_owner'] ) ? esc_attr( $this->options['sales_owner']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function synologyHost()
    {
        printf(
            '<input type="text" id="synology_host" name="eDokumenty_config[synology_host]" value="%s" />',
            isset( $this->options['synology_host'] ) ? esc_attr( $this->options['synology_host']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function synologyUsername()
    {
        printf(
            '<input type="text" id="synology_username" name="eDokumenty_config[synology_username]" value="%s" />',
            isset( $this->options['synology_username'] ) ? esc_attr( $this->options['synology_username']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function synologyPassword()
    {
        printf(
            '<input type="text" id="synology_password" name="eDokumenty_config[synology_password]" value="%s" />',
            isset( $this->options['synology_password'] ) ? esc_attr( $this->options['synology_password']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function googleTagManagerHead()
    {
        printf(
            '<textarea id="google_tag_manager_head" name="eDokumenty_config[google_tag_manager_head]">%s</textarea>',
            isset( $this->options['google_tag_manager_head'] ) ? esc_attr( $this->options['google_tag_manager_head']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function googleTagManagerBody()
    {
        printf(
            '<textarea id="google_tag_manager_body" name="eDokumenty_config[google_tag_manager_body]">%s</textarea>',
            isset( $this->options['google_tag_manager_body'] ) ? esc_attr( $this->options['google_tag_manager_body']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function googleAnalytics()
    {
        printf(
            '<textarea id="google_analytics" name="eDokumenty_config[google_analytics]">%s</textarea>',
            isset( $this->options['google_analytics'] ) ? esc_attr( $this->options['google_analytics']) : ''
        );
    }

    /**
     * Add scripts to head
     */
    public function addScriptsHead()
    {
        echo get_option( 'eDokumenty_config')['google_analytics'] . PHP_EOL;
        echo get_option( 'eDokumenty_config')['google_tag_manager_head'] . PHP_EOL;
    }

    /**
     * Add scripts to body
     */
    public function addScriptsBody()
    {
        echo get_option( 'eDokumenty_config')['google_tag_manager_body'] . PHP_EOL;
    }
}