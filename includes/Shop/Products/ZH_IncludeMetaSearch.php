<?php

namespace Develtio\ZonesHewalex\Shop\Products;

use WP_Error;
use WP_Query;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;


/**
 * Class ZH_Search
 */
class ZH_IncludeMetaSearch
{
 
    /**
     * Hooks search
     */
    
    public function __construct()
    {
        add_action('wp_head', array($this,'get_template'));
    }

    public function get_template() 
    {
        global $template;
        $template_name = basename($template);

        if($template_name === 'page-template-instalator-oze-products.php'){
        add_filter('posts_join', array($this,'cf_search_join'));
        add_filter( 'posts_distinct', array($this,'cf_search_distinct') );
        add_filter( 'posts_where', array($this,'cf_search_where') );
        }
    }



    public function cf_search_join( $join) 
    {
        global $wpdb;
        
        if ( is_search()){
            $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
        }
        return $join;
    }

    function cf_search_where( $where ) 
    {
        global $pagenow, $wpdb;
      
            $where = preg_replace(
                "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
                "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
        
        return $where;
    }
  

    public function cf_search_distinct( $where ) 
    {    
        global $wpdb;
        if ( is_search() ) {
            return "DISTINCT";
        }
        return $where;
    }
}

