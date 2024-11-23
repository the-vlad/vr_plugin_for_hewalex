<?php

namespace Develtio\ZonesHewalex\Admin\templates;

if (!defined('ABSPATH')) {
    die;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Class InstallationsTable
 */
class InstallationsTable extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'history-installations',
            'plural' => 'history-installations',
            'ajax' => false
        ));
    }

    public static function get_records($per_page = 20, $page_number = 1)
    {
        global $wpdb;

        $sql = "select * from installation";
        if (isset($_REQUEST['s'])) {
            $sql.= ' where installation_id LIKE "%' . $_REQUEST['s'] . '%" or installation_kit_nr LIKE "%' . $_REQUEST['s'] . '%"';
        }
        if (!empty($_REQUEST['orderby'])) {
            $sql.= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql.= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }
        $sql.= " LIMIT $per_page";
        $sql.= ' OFFSET ' . ($page_number - 1) * $per_page;
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        return $result;
    }

    function get_columns()
    {
        $columns = [
            'cb' => '<input type="checkbox" />',
            'installation_id' => __('ID', 'zones-hewalex') ,
            'installation_kit_nr' => __('Kod promocyjny', 'zones-hewalex') ,
            'kit_type_nazwa' => __('Typ', 'zones-hewalex') ,
            'kit_type_punkty' => __('Punkty', 'zones-hewalex') ,
            'installation_installator_nip' => __('Instalator', 'zones-hewalex') ,
            'installation_updated_at' => __('Zaktualizowano', 'zones-hewalex') ,
        ];
        return $columns;
    }

    public function get_hidden_columns()
    {
        array([
            'created_at' => __('created_at','zones-hewalex'),
        ]);
        return array();
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'installation_updated_at' => array('installation_updated_at', true),
            'installation_id' => array('installation_id', true)
        );
        return $sortable_columns;
    }

    public function column_default( $item, $column_name )
    {
        switch ( $column_name ) {
            case 'installation_installator_nip':
            case 'installation_id':
            case 'installation_kit_nr':
            case 'kit_type_nazwa':
            case 'kit_type_punkty':
            case 'installation_updated_at':
                return '<span data-post-id="' . trim($item[ 'installation_id' ]) . '">' . $item[ $column_name ] . '</span>' ?? '';
            default:
                return print_r( $item, true );
        }
    }

    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['installation_id']);
    }

    function column_installation_kit_nr( $item )
    {
        $actions = array(
            'zh-edit-installation_history' => sprintf('<a class="thickbox" href="#TB_inline?&width=6--&height=550&inlineId=my-content-id">Edytuj</a>',$_REQUEST['page'],'edit',$item['installation_id']),
            //'delete' => sprintf('<a href="?page=%s&action=%s&record=%s">Usuń</a>',$_REQUEST['page'],'delete',$item['installation_id']),
        );
        return sprintf('%1$s %2$s', $item['installation_kit_nr'], $this->row_actions($actions) );
    }

    public static function delete_records($id)
    {
        global $wpdb;
        $wpdb->delete("installation", ['installation_id' => $id], ['%d']);
    }

    public static function record_count()
    {
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM installation";
        return $wpdb->get_var($sql);
    }

    public function no_items()
    {
        _e('Brak wyników.', 'zones-hewalex');
    }

    public function process_bulk_action()
    {
        if ( 'delete' === $this->current_action() ) {
            self::delete_records( absint( $_GET['record'] ) );
        }

        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )) {
            $delete_ids = esc_sql( $_POST['bulk-delete'] );
            foreach ( $delete_ids as $id ) {
                self::delete_records( $id );
            }
        }
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );
        $per_page = $this->get_items_per_page('records_per_page', 20);
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();
        $data = self::get_records($per_page, $current_page);
        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page' => $per_page,
        ]);
        $this->items = $data;
    }


}