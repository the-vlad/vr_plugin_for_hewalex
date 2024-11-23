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
                    <?php echo do_shortcode('[installations_installer]'); ?>
                    <?php echo do_shortcode('[history_installations_installer]'); ?>
                </div>
            </div>
        </main>
    </div>
<?php
get_footer();
?>