<?php
if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if($user->roles[0] !== 'installator' && $user->roles[0] !== 'administrator'){
        include('page-restricted-area.php');
        die();
    }
}
else {
    include('page-restricted-area.php');
    die();
}

global $post;
$id = $post->ID;


get_header();
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div style="height: 150px"></div>
      
         

            <div class="gutenberg-content">
                <div class="container">
                    <?php echo do_shortcode('[back_to_shop]'); ?>
                    <div class="hewalex-single-product">
                    <div class="hewalex-single-product__content"> 
                    <div class="hewalex-single-product__content--row">

                    <div class="hewalex-single-product__image">
                         
                         <?php
                            /**
                             * Hook: Single image product
                             * 10 - single_image
                             */
                            do_action('single_product_image', $id);
                            ?>
                        </div>
                        <div class="hewalex-single-product__summary">
                            <?php
                            /**
                             * Hook: Summary product
                             * 5 - product_title
                             * 10 - product_price
                             * 15 - product_excerpt
                             */
                            do_action('single_product_summary', $id);

                            /**
                             * Hook Product actions
                             * 10 - product_quantity
                             * 20 - product_add_to_cart
                             */
                            do_action('single_product_actions', $id);

                            /**
                             * Hook: Product meta
                             * 10 - product_sku
                             */
                            do_action('single_product_meta', $id);
                            ?>
                           </div>
                        </div>
                        <div class="hewalex-single-product__tabs">
                            <?php
                            /**
                             * Hook: Product tabs
                             * 10 - product_content
                             * 20 - product_additional_information
                             */
                            do_action('single_product_tabs', $id);
                            ?>
                        </div>
                        </div>
                        <div class="hewalex-single-product__sidebar">
                            <?php
                            /**
                             * Hook: Cart
                             * 10 - cart
                             */
                            do_action('cart');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
<?php
get_footer();
?>