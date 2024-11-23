<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://develtio.com
 * @since             1.1.9
 * @package           HEWALEX_Zones
 *
 * @wordpress-plugin
 * Plugin Name:       Zones Hewalex Plugin
 * Plugin URI:        https://develtio.com
 * Description:       Custom zones features
 * Version:           1.1.9
 * Author:            Develtio
 * Author URI:        https://develtio.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       zones_hewalex
 * Domain Path:       /languages
 */

use Develtio\ZonesHewalex\ZH_Init;

if (!defined('ABSPATH')) {
    die;
}

// Composer autoloader
if (is_readable(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

define('ZH_VERSION', '1.1.9');
define('ZH_DIR', plugin_dir_path(dirname(__FILE__)) . 'zones-hewalex/');
define('ZH_URL', plugin_dir_url(dirname(__FILE__)) . 'zones-hewalex/');
define('ZH_AJAX', admin_url('admin-ajax.php'));
define('ZH_WP_URL', get_site_url());
define('ZH_DATE_FORMAT', 'Y-m-d');

//Google Maps Api
define('GOOGLE_MAPS_KEY', isset(get_option( 'eDokumenty_config')['google_maps_api']) ? get_option( 'eDokumenty_config')['google_maps_api'] : '');

//eDokumenty
define('EDOK_API_LOGIN', isset(get_option( 'eDokumenty_config')['edok_login']) ? get_option( 'eDokumenty_config')['edok_login'] : '');
define('EDOK_API_PASSWORD', isset(get_option( 'eDokumenty_config')['edok_password']) ? get_option( 'eDokumenty_config')['edok_password'] : '');
define('EDOK_API_LOCATION', isset(get_option( 'eDokumenty_config' )['edok_location']) ? get_option( 'eDokumenty_config' )['edok_location'] : '');
define('DEFAULT_ENTITY_SYMBOL', isset(get_option( 'eDokumenty_config' )['edok_entity_symbol']) ? get_option( 'eDokumenty_config' )['edok_entity_symbol'] : '');

//Defines from get_option check errors if empty
//SalesManago
define('SALESMANAGO_CLIENTID', isset(get_option( 'eDokumenty_config')['client_id']) ? get_option( 'eDokumenty_config')['client_id'] : '') ;
define('SALESMANAGO_APIKEY', isset(get_option( 'eDokumenty_config')['sales_api_key']) ? get_option( 'eDokumenty_config')['sales_api_key'] : '');
define('SALESMANAGO_APISECRET', isset(get_option( 'eDokumenty_config' )['sales_secret_key']) ? get_option( 'eDokumenty_config' )['sales_secret_key'] : '');
define('SALESMANAGO_ENDPOINT', isset(get_option( 'eDokumenty_config')['sales_endpoint']) ? get_option( 'eDokumenty_config')['sales_endpoint'] : '');
define('SALESMANAGO_OWNER', isset(get_option( 'eDokumenty_config' )['sales_owner']) ? get_option( 'eDokumenty_config' )['sales_owner'] : '');

define('SYNOLOGY_HOST', isset(get_option( 'eDokumenty_config' )['synology_host']) ? get_option( 'eDokumenty_config' )['synology_host'] : '');
define('SYNOLOGY_USERNAME', isset(get_option( 'eDokumenty_config' )['synology_username']) ? get_option( 'eDokumenty_config' )['synology_username'] : '');
define('SYNOLOGY_PASSWORD', isset(get_option( 'eDokumenty_config' )['synology_password']) ? get_option( 'eDokumenty_config' )['synology_password'] : '');

$zhUploadDir = wp_upload_dir();
define('ZH_UPLOAD_DIR', $zhUploadDir['basedir']);
define('ZH_UPLOAD_URL', $zhUploadDir['baseurl']);

ZH_Init::register();