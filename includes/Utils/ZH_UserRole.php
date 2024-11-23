<?php

namespace Develtio\ZonesHewalex\Utils;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_UserRole
 */
class ZH_UserRole
{
    /**
     * ZH_UserRole constructor.
     */
    public function __construct()
    {
        add_action( 'admin_init', array($this, 'addRoles') );
    }

    /**
     * Get Current Logged User Role
     */
    public static function getCurrentLoggedUserRole() : string
    {
        $currentUserRole = '';
        if(is_user_logged_in())
        {
            $currentUser = get_userdata(get_current_user_id());
            $currentUserRole = $currentUser->roles[0];
        }
        return $currentUserRole;
    }

    public function addRoles() : void {
        add_role(
            'designer',
            __( 'Projektant'  ),
            array(
                'read'  => true,
            )
        );

        add_role(
            'installator',
            __( 'Instalator'  ),
            array(
                'read'  => true,
            )
        );

        add_role(
            'user',
            __( 'Użytkownik'  ),
            array(
                'read'  => true,
            )
        );
    }
}