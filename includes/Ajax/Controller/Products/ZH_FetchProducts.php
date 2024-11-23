<?php

namespace Develtio\ZonesHewalex\Ajax\Controller\Products;


use WP_Error;
use WP_Query;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_FetchProducts
 */
class ZH_FetchProducts
{

public function fetchProducts() {
    
    $the_query = new WP_Query( 
        array( 
            'posts_per_page' => -1, 
            's' => esc_attr( $_POST['keyword_products'] ), 
            'post_type' => 'awards_products',
            'meta_key' => 'product_model',
            'meta_query'    => array(
                'relation'      => 'OR',
                array(
                    'key'       => 'product_model',
                    'compare'   => 'like',
                    'value'     => $_POST['keyword_products'],
                ),
            )
        )
    );

    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post();

            $id = get_the_ID();
            $image = get_field('product_image', $id);

            echo '
            <div class="archive-oze__product">
            <a class="archive-oze__product--item" href="'. get_permalink($id) .'">';
                if($image['url']){
                echo '
                <div class="product-thumbnail"><img src="' . $image['url'] . '" alt="' . $image['alt'] . '"/></div>';
                }
                else{
                    echo '<img class="empty_img" src="' . ZH_URL . 'assets/img/logo.svg">';
                 }
                echo '<div class="product-info">';
                echo '<h6 class="product-title">' . get_field('product_model', $id) . '</h6>';
                echo '<span class="product-price">' . get_field('price_brutto', $id) . $currency . '<span>
                </div>';
            echo '</a>
            </div>';

       endwhile;
        wp_reset_postdata();  
    endif;

    die();
}

}