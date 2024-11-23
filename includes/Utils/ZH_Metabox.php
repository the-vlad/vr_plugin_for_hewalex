<?php

namespace Develtio\ZonesHewalex\Utils;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Metabox
 */
class ZH_Metabox
{
    /**
     * ZH_MetaboxManager constructor.
     */
    public function __construct()
    {
        add_action( 'add_meta_boxes', array($this, 'role_metabox_selection') );
        add_action( 'save_post', array($this, 'save_metabox' ) );
    }

    public function role_metabox_selection() : void
    {
        $screens = ['page', 'post'];
        foreach( $screens as $screen ) {
            add_meta_box(
                'access_role',
                'Przypisz rolę dla strefy',
                array($this, 'role_metabox'),
                $screen,
                'side',
                'low',
                array(
                    '__block_editor_compatible_meta_box' => true,
                    '__back_compat_meta_box'             => false,
                )
            );
        }
    }

    public function role_metabox() : void
    {
        $currentRole = $this->getSelectedRole();
        echo '<select name="access_user_role" style="width: 90%;">';
            echo '<option value=""> --- </option>';
            foreach( $this->getRoles() as $role ) :
                $current = $currentRole === $role ? 'selected' : '';
                echo '<option value="' . $role . '"' . $current . '>' . $role . '</option>';
            endforeach;
        echo '</select>';
    }

    public function save_metabox( $post_id ) : void
    {
        if( isset( $_POST['access_user_role'] ) ) {
            update_post_meta( $post_id, 'access_user_role', $_POST['access_user_role'] );
        }
    }

    /**
     * getRoles method
     */
    public function getRoles() : array
    {
        $roles = wp_roles()->get_names();
        return $roles;
    }

    /**
     * Get Selected Role method
     */
    public function getSelectedRole() : string
    {
        $currentRole = get_post_meta( get_the_ID(), 'access_user_role', true);
        return $currentRole;
    }
}