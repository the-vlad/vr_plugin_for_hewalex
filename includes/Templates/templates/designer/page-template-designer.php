<?php
if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if($user->roles[0] !== 'designer' && $user->roles[0] !== 'administrator'){
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

<?php if(is_user_logged_in()) : ?>
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
            <div class="notices notices--success"></div>
        </main>
    </div>
<?php endif; ?>

<?php
get_footer();
?>