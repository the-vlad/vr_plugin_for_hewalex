<?php 

namespace Develtio\ZonesHewalex\EdenredPrepaid;

if (!defined('ABSPATH')) {
    die;
}

class ZH_Prepaid {

    public function __construct()
    {
      add_shortcode('edenred_status', array($this, 'displayPrepaidStatus'));
    }

    public function displayPrepaidStatus(){
        include('edenred-status.php');
    }
}