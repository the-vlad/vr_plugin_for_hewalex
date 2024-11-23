<?php

namespace Develtio\ZonesHewalex\Cron;
use Develtio\ZonesHewalex\eDokumenty\ZH_eDokumentyMethods;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Cron
 */
class ZH_Cron
{
    function __construct() {
        add_action( 'init', array ( $this, 'onceDay' ) );
        add_action( 'actionOnceDaySchedule', array ( $this, 'onceDaySchedule' ) );
        add_action( 'actionOnceDayEdokumenty', array ( $this, 'edokumentySchedule' ) );
    }

    //+2h
    public function onceDay() {


        if ( ! wp_next_scheduled( 'actionOnceDaySchedule' ) ) {
            wp_schedule_event(  strtotime('01:00:00'), 'daily', 'actionOnceDaySchedule' );
        }

        if ( ! wp_next_scheduled( 'actionOnceDayEdokumenty' ) ) {
            wp_schedule_event(  strtotime('01:00:00'), 'daily', 'actionOnceDayEdokumenty' );
        }
    }
    


    public function edokumentySchedule() {

        $path = ZH_DIR . 'mapsearch';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            $path3 = ZH_DIR . 'mapsearch/distributor';
            $path2 = ZH_DIR . 'mapsearch/installer';
            mkdir($path2, 0777, true);
            mkdir($path3, 0777, true);
        }

        if (file_exists($path)) {
        /* Installer */
        $installer_1 = (new ZH_eDokumentyMethods())->contactsFilter('392');
        $collectorsun = json_encode($installer_1->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/installer/collectorsun.json', $collectorsun);

        $installer_2 = (new ZH_eDokumentyMethods())->contactsFilter('394');
        $pompheat = json_encode($installer_2->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/installer/pompheat.json', $pompheat);

        $installer_3 = (new ZH_eDokumentyMethods())->contactsFilter('393');
        $pompheatwater = json_encode($installer_3->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/installer/pompheatwater.json', $pompheatwater);

        $installer_4 = (new ZH_eDokumentyMethods())->contactsFilter('395');
        $pompheatpool = json_encode($installer_4->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/installer/pompheatpool.json', $pompheatpool);

        $installer_5 = (new ZH_eDokumentyMethods())->contactsFilter('397');
        $optiener = json_encode($installer_5->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/installer/optiener.json', $optiener);

        $installer_6 = (new ZH_eDokumentyMethods())->contactsFilter('396');
        $sunheat = json_encode($installer_6->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/installer/sunheat.json', $sunheat);

        /* Distributor */
        $distributor_1 = (new ZH_eDokumentyMethods())->contactsFilterDistributor('392');
        $collectorsun = json_encode($distributor_1->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/distributor/collectorsun.json', $collectorsun);

        $distributor_2 = (new ZH_eDokumentyMethods())->contactsFilterDistributor('394');
        $pompheat = json_encode($distributor_2->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/distributor/pompheat.json', $pompheat);

        $distributor_3 = (new ZH_eDokumentyMethods())->contactsFilterDistributor('393');
        $pompheatwater = json_encode($distributor_3->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/distributor/pompheatwater.json', $pompheatwater);

        $distributor_4 = (new ZH_eDokumentyMethods())->contactsFilterDistributor('395');
        $pompheatpool = json_encode($distributor_4->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/distributor/pompheatpool.json', $pompheatpool);

        $distributor_5 = (new ZH_eDokumentyMethods())->contactsFilterDistributorr('397');
        $optiener = json_encode($distributor_5->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/distributor/optiener.json', $optiener);

        $distributor_6 = (new ZH_eDokumentyMethods())->contactsFilterDistributor('396');
        $sunheat = json_encode($distributor_6->data, JSON_PRETTY_PRINT);
        file_put_contents(ZH_DIR . 'mapsearch/distributor/sunheat.json', $sunheat);
        }
    }


    public function onceDaySchedule() {
        $this->deletePointsOlderThan3Years();
    }

    public function deletePointsOlderThan3Years() {
        global $wpdb;
        $table = 'points_installer_old';

        $points = $this->queryPostOlderThan3Years();
        $oldPoints = $this->queryPostOlderThan3YearsOldSystem();

        foreach($oldPoints as $k => $item) {
            $update = $wpdb->update( $table, array( 'archive' =>  1), array( 'id' => $item->id));

            if($update) {
                wp_send_json('success', 200);
            }
        }

        foreach($points as $point)
        {
            update_post_meta($point->ID, 'installation_group4_installation_status', 1);
        }
    }

    public function queryPostOlderThan3YearsOldSystem()
    {
        global $wpdb;

        $data = $wpdb->get_results("SELECT * FROM points_installer_old WHERE `date` < '01-08-2019'");

        return $data;
    }

    public function queryPostOlderThan3Years()
    {
        $args = array(
            'post_type' => 'installation',
            'posts_per_page' => -1,
            'date_query' => array(
                'column'  => 'post_date',
                'before'   => '- 3 years'
            )
        );
        $installations = get_posts($args);

        return $installations;
    }
}