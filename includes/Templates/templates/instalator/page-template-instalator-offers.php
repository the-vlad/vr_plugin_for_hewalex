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

        <div class="gutenberg-content">
            <div class="container">
                <div id="offer-wrapper">
                    <div class="buttonWrapper">
                        <button class="tab-button offer-basket-btn active" data-id="offer-basket"><?php echo __('Koszyk', 'zones-hewalex'); ?></button>
                        <button class="tab-button offer-creator-btn" data-id="offer-creator"><?php echo __('Kreator PV', 'zones-hewalex'); ?></button>
                    </div>
                    <div class="contentWrapper">
                        <div class="offer-content active" id="offer-basket">
                            <?php echo do_shortcode('[carts_installator]'); ?>
                        </div>
                        <div class="offer-content" id="offer-creator">
                            <?php echo do_shortcode('[offers_installator]'); ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
</div>

</main>
</div>
<?php
get_footer();
?>