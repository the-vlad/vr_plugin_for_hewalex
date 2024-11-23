<?php

namespace Develtio\ZonesHewalex\API\model;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_HewalexPVWorker
 */
class ZH_HewalexPVWorker
{
    public function getHewalexWorkerData()
    {
        if (!(is_user_logged_in() ?? null) || !get_user_meta(get_current_user_id(), 'installation_group1_installation_hewalex_worker')[0]) {
            return new \WP_REST_Response('Not authorization', 401);
        }
        else {
            return new \WP_REST_Response($this->modelHewalexWorker(wp_get_current_user()), 200);
        }
    }

    public function modelHewalexWorker($installer_user): array
    {
        return array(
            'isAuthorizedWorker' => 1
        );
    }
}