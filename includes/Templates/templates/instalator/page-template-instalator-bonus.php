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

         <?php
            $catalog_url = home_url() . '/strefa-instalatora/program-oze/zamow-nagrode/';
            $card_charge_url = home_url() . '/strefa-instalatora/program-oze/zasil-karte';
          ?>


         <!-- hyperlinks --> 
         <div class="container">
            <section class="bonus-section">
                <div class="bonus_links"> 
                   <a href="<?php echo $catalog_url; ?>" class="bonus_links--btn"><span>KATALOG HEWALEX</span><img src="<?php echo ZH_URL ?>/assets/img/ico_katalog_hewalex.svg"/></a>
                   <a href="<?php echo $card_charge_url; ?>" class="bonus_links--btn"><span>ZASIL KARTĘ</span><img src="<?php echo ZH_URL?>/assets/img/ico_karta.svg"/></a>
                </div>
            </section>
        </div>
          
        </main>
    </div>
<?php
get_footer();
?>