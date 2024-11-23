<?php
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
                echo __('To jest zabezpieczona strefa', 'zones-hewalex');
                //the_content();
                ?>
            </div>
        <?php
        endwhile;
        ?>
        <div class="notices notices--error"></div>
    </main>
</div>
<?php
get_footer();
?>