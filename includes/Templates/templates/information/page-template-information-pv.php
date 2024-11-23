<?php
use Develtio\ZonesHewalex\eDokumenty\ZH_eDokumentyMethods;
use Develtio\ZonesHewalex\API\model\ZH_Installers;

$edok_id = (new ZH_Installers())->getEdokIdFromLoggedId();
$edocsContactData = (new ZH_eDokumentyMethods)->getContactfromEdokById($edok_id);

$pcco_information_mono = $edocsContactData['features']['521']['txtval'] ?? null;
$pcco_information_split = $edocsContactData['features']['516']['txtval'] ?? null;
$pv = $edocsContactData['features']['514']['txtval'] ?? null;
$pcwb = $edocsContactData['features']['519']['txtval'] ?? null;
$ekontrol = $edocsContactData['features']['522']['txtval'] ?? null;

if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if( $user->roles[0] === 'administrator' ) { }
    else {
        if ($user->roles[0] === 'installator'){
            if (empty($pv)) {
                include('page-restricted-area.php');
                die();
            }
        }
        else {
            include('page-restricted-area.php');
            die();
        }
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

        <section id="info-section" class="container">
            <?php 
            $args = array(
                'post_type' => 'pv',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => -1
                );
            // $query = new WP_Query( $args ); 
        ?>

            <?php $posts = get_posts($args); ?>
            <?php if($posts) :?>
            <div class="info-row taxonomy-custom__grid">
                <?php foreach($posts as $post) : ?>
                <div class="item">
                    <div class="item_block--left">

                        <?php 
                        $postDay = get_the_date( 'j' );
                        $postMonth = get_the_date( 'F' );
                        ?>
                        <div class="datebox">
                            <h4><?php echo $postDay;?></h4>
                            <p><?php echo $postMonth;?></p>
                        </div>

                    </div>


                    <div class="item_block--right">
                        <h5 class="item__title">
                            <?php echo $post->post_title; ?>
                        </h5>
                        <div class="item__cta toggle-item">
                            <a>
                                <span class="the-more"> <?php echo __('więcej','hewalex') ?> </span>
                                <span class="the-less"> <?php echo __('mniej','hewalex') ?> </span>
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/arrow-up-gold.svg" />
                            </a>
                        </div>
                        <?php  $id = get_the_ID(); ?>

                        <div class="toggle-content">
                            <p class="toggle-desc">
                                <?php echo the_field('pv_desc',$id); ?>
                            </p>

                            <div class="addfile-row">
                                <?php if( have_rows('pv_add-file',$id) ): ?>
                                <?php while( have_rows('pv_add-file',$id) ): the_row(); ?>

                                <div class="card--attachments__item">

                                    <div>
                                        <a class="card--attachments__link" href="<?php the_sub_field('pv_file'); ?>"
                                            download="">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/dist/images/download.svg'; ?>"
                                                alt="">
                                            <?php echo __('Pobierz', 'hewalex'); ?>
                                        </a>
                                        <a class="card--attachments__link" href="<?php the_sub_field('pv_file'); ?>"
                                            target="_blank">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/dist/images/view.svg'; ?>"
                                                alt="">
                                            <?php echo __('Podgląd', 'hewalex'); ?>
                                        </a>
                                    </div>
                                </div>

                                <?php
                                endwhile;
                                else :
                                endif;
                                  ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <?php endforeach; ?>
</div>
<?php endif; ?>

</section>

</main>
</div>


<?php
get_footer();
?>