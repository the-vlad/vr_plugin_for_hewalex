<?php

namespace Develtio\ZonesHewalex\Admin\templates;

use Develtio\ZonesHewalex\API\model\ZH_OfferForm;

if (!defined('ABSPATH')) {
    die;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Class InstallationsTable
 */
class OffersTable extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'offer_forms',
            'plural' => 'offer_forms',
            'ajax' => false
        ));
    }

    public static function get_records($per_page = 20, $page_number = 1)
    {
        global $wpdb;

        $sql = "select * from offer_forms";
        if (isset($_REQUEST['s'])) {
            $sql.= ' where offer_form_id LIKE "%' . $_REQUEST['s'] . '%" or offer_form_category LIKE "%' . $_REQUEST['s'] . '%"';
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
            'offer_form_id' => __('ID', 'zones-hewalex') ,
            'name_client' => __('Nazwa klienta', 'zones-hewalex') ,
            'offer_form_category' => __('Kategoria', 'zones-hewalex') ,
            'updated_at' => __('Zaktualizowano', 'zones-hewalex') ,
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
            'updated_at' => array('updated_at', true),
            'offer_form_id' => array('offer_form_id', true),
            'offer_form_category' => array('offer_form_category', true)
        );
        return $sortable_columns;
    }

    public function column_default( $item, $column_name )
    {
        switch ( $column_name ) {
            case 'offer_form_id':
            case 'offer_form_category':
            case 'updated_at':
                return '<span data-post-id="' . trim($item[ 'offer_form_id' ]) . '">' . $item[ $column_name ] . '</span>' ?? '';
            case 'name_client':
                $clientName = (new ZH_OfferForm())->getValueFromHistoryOffer($item[ 'offer_form_id' ], 'contact', '', 'name', 'value');
                return '<span>'. $clientName .'</span>';
            default:
                return print_r( $item, true );
        }
    }

    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['installation_id']);
    }

    function column_offer_form_category( $item )
    {
        if($item['offer_form_category'] != 'mounting') {
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&offer_forms=%s">Edit</a>',$_REQUEST['page'],'edit',$item['offer_form_id']),
//            'delete'    => sprintf('<a href="?page=%s&action=%s&offer_forms=%s">Delete</a>',$_REQUEST['page'],'delete',$item['offer_form_id']),
            );
        }

        return sprintf('%1$s %2$s', $item['offer_form_category'], $this->row_actions($actions) );
    }

    public static function delete_records($id)
    {
        global $wpdb;
        $wpdb->delete("installation", ['installation_id' => $id], ['%d']);
    }

    public static function record_count()
    {
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM offer_forms";
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