<?php

namespace Develtio\ZonesHewalex\Shop\Products;

use WP_Error;
use WP_Query;


if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_Archive
 */
class ZH_Archive
{
    /**
     * Hooks archive
     */
    public function __construct()
    {
        add_shortcode('hewalex_products', array($this, 'displayProducts'));
        add_shortcode('back_to_shop', array($this, 'backToShop'));
        add_shortcode('back_to_previous', array($this, 'backToPrevious'));

    }
 
    public function backToShop()
    {
      $back_to_shop_url = get_home_url() . '/strefa-instolatora/zamow-nagrode';
      $backToShop = '<div class="backtoshop"><a href="'.$back_to_shop_url . '">Wroć do katalogu</a></div>';    
      echo $backToShop;
    }

     
    public function backToPrevious()
    {
      $previous = "javascript:history.go(-1)";
      $goBack = '<div class="backtoshop"><a href="'. $previous . '">Wroć</a></div>';    
      echo $goBack;
    }
    
    public function displayProducts()
    {

        if (!function_exists('ic_custom_posts_pagination')) :
            function ic_custom_posts_pagination($the_query=NULL, $paged=1){

                global $wp_query;
                $the_query = !empty($the_query) ? $the_query : $wp_query;

                if ($the_query->max_num_pages > 1) {
                    $big = 999999999; // need an unlikely integer
                    $items = paginate_links(apply_filters('adimans_posts_pagination_paginate_links', array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'prev_next' => TRUE,
                        'current' => max(1, $paged),
                        'total' => $the_query->max_num_pages,
                        'type' => 'array',
                        'prev_text' => ' <i class="fas fa-angle-double-left"></i> ',
                        'next_text' => ' <i class="fas fa-angle-double-right"></i> ',
                        'end_size' => 1,
                        'mid_size' => 1
                    )));

                    $pagination = "<div class=\"col-sm-12 text-center\"><div class=\"ic-pagination\"><ul><li>";
                    $pagination .= join("</li><li>", (array)$items);
                    $pagination .= "</li></ul></div></div>";

                    echo apply_filters('ic_posts_pagination', $pagination, $items, $the_query);
                }
            }
        endif;
       
        $currency = '<span class="currency">zł</span>';

        // Pagination and post display
        $property_per_page = 12;
        $paged = get_query_var('paged') ?? get_query_var('page') ?? 1;
        $args = array(
          'post_type'  => 'awards_products',
          'posts_per_page'  => $property_per_page ? (int)$property_per_page : 6,
          'paged' 		=> $paged,
     
        );
   
        $property_query = new WP_Query( $args );
        if ( $property_query->have_posts() ) : ?>
        
        <div class="archive-products__wrapper archive-oze__content">
          <div class="row" id="datafetch_products">
            <!-- the loop -->
            <?php while ( $property_query->have_posts() ) : $property_query->the_post(); ?>
          <?php  
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
             endwhile; ?>
            <!-- end of the loop -->
          </div>
        
          <!-- pagination here -->
          <div id="products_pagination" class="row">
            <div class="paginate">
              <?php ic_custom_posts_pagination($property_query, $paged); ?>
            </div>
          </div>
        </div><!-- end content -->
        
          <?php wp_reset_postdata(); ?>
                        
        <?php else : ?>
            <p class="text-warning"><?php esc_html_e( 'Przepraszamy, nie znaleziono żadnych produktów', 'hewalex' ); ?></p>
        <?php endif; 

      echo '<div class="hewalex-single-product__sidebar">';
      do_action('cart');
      echo '</div>';

    }

}