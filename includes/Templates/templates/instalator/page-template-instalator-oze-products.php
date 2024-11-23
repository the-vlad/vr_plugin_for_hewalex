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

get_header();
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <div class="gutenberg-content">
                    <?php
                    the_content();
                    ?>
                </div>
            <?php
            endwhile;
            ?>

            <!-- <input type="hidden" name="post_type" value="awards_products" /> -->

            <div class="gutenberg-content">
                <div class="container">
                 <div class="archive-product__search">
                    <input type="text" placeholder="Wyszukaj produkt" name="keyword_products" id="keyword_products"></input>
                    <span class="search_ico"></span>
                 </div>
                    <div class="archive-oze">          
                    <?php echo do_shortcode('[hewalex_products]'); ?>
                     </div>
                </div>
            </div>
        </main>
    </div>
<?php
get_footer();
?>

