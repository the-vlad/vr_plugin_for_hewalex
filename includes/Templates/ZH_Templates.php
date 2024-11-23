<?php

namespace Develtio\ZonesHewalex\Templates;

use WP_Error;
use WP_Query;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Templates
 */
class ZH_Templates
{
    public function __construct()
    {
        add_filter( 'theme_page_templates', array( $this, 'pageTemplates' ) );
        add_filter( 'template_include', array( $this, 'savePageTemplates'), 99 );
        add_shortcode('recent_trainers', array($this, 'recent_posts_trainers'));
        add_filter( 'template_include', array($this, 'overrideSingleTrainer'));
        add_action('wp_ajax_nopriv_fetch_cases', array($this, 'fetch_cases'));
        add_action('wp_ajax_fetch_cases',array($this, 'fetch_cases'));
    }

    /**
     * Change the page template to the selected template on the dropdown
     *
     * @param $template
     *
     * @return mixed
     */
    public function savePageTemplates( $template )
    {
        if (is_page()) {
            $meta = get_post_meta(get_the_ID());

            if ( isset($meta['_wp_page_template'][0]) ) {
                $theme_file = locate_template( array ( $meta['_wp_page_template'][0] ) );

                if ($theme_file ) {
                    $template = $theme_file;
                }
                else {
                    $template = $meta['_wp_page_template'][0];
                }
            }
        }

        return $template;
    }

    /**
     * Add page templates.
     *
     * @param  array  $templates  The list of page templates
     *
     * @return array  $templates  The modified list of page templates
     */
    public function pageTemplates( $templates )
    {
        $templates[plugin_dir_path( __FILE__ ) . '/templates/designer/page-template-designer.php'] = __( 'Designer page', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator.php'] = __( 'Instalator page', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-map.php'] = __( 'Instalator page / map', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-calculator-pv.php'] = __( 'Instalator page / Calculator PV', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-offers.php'] = __( 'Instalator page / List offers by user', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-calculator-mount.php'] = __( 'Instalator page / Calculator Mount', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-calculator-pcco.php'] = __( 'Instalator page / Calculator PCCO', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-calculator-pcwb.php'] = __( 'Instalator page / Calculator PCWB', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-offers-edit.php'] = __( 'Instalator page / Cart item edit', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-oze.php'] = __( 'Instalator page / Program OZE', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-edenred-charge.php'] = __( 'Instalator page / Program OZE Zasil kartę', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-bonus.php'] = __( 'Instalator page / Premia punktowa', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-oze-products.php'] = __( 'Instalator page / Produkty', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-oze-checkout.php'] = __( 'Instalator page / Strona zamówienia', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-oze-thankyou.php'] = __( 'Instalator page / Podziękowanie', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-oze-your-orders.php'] = __( 'Instalator page / Twoje zamówienia', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-oze-your-points.php'] = __( 'Instalator page / Twoje punkty', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-list-installation.php'] = __( 'Instalator page / Lista instalacji', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/instalator/page-template-instalator-supervised-installations.php'] = __( 'Instalator page / Nadzorowane instalacje', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/user/page-template-user.php'] = __( 'User page', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/distributor/page-template-distributor.php'] = __( 'Distributor', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/user/page-template-user-register.php'] = __( 'User page / Rejestracja zestawu solarnego', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/trainers/page-template-trainers.php'] = __( 'Trainers / Szkolenia', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/information/page-template-information-pv.php'] = __( 'Strefa informacyjna / PV template', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/information/page-template-information-pcwb.php'] = __( 'Strefa informacyjna / PCWB template', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/information/page-template-information-pcco.php'] = __( 'Strefa informacyjna / PCCO template', 'hewalex' );
        $templates[plugin_dir_path( __FILE__ ) . '/templates/information/page-template-information-ekontrol.php'] = __( 'Strefa informacyjna / Ekontrol template', 'hewalex' );
        return $templates;
    }

    // Override single .php for Szkolenia

    public function overrideSingleTrainer( $template ) {
        $post_types = array( 'trainers' );

        if ( is_post_type_archive( $post_types ) && file_exists( plugin_dir_path(__FILE__) . 'templates/trainers/archive-trainers.php' ) ){
            $template = plugin_dir_path(__FILE__) . 'templates/trainers/archive_trainers.php';
        }

        if ( is_singular( $post_types ) && file_exists( plugin_dir_path(__FILE__) . 'templates/trainers/single-trainers.php' ) ){
            $template = plugin_dir_path(__FILE__) . 'templates/trainers/single-trainers.php';
        }

        return $template;
    }

        // Fetch trainer data
        public function fetch_cases(){

            $args = array (

            'post_type'              => 'trainers',
            'post_status'            => 'publish',
            'name'                   => $_GET["info"],

            );

            $loop = new WP_Query( $args );
            $info = [];
            //the loop
            while ( $loop->have_posts() ) : $loop->the_post();


                $info[] = array(
                'name' => get_the_title(),
                'thumbnail' => get_field('trainers_img'),
                'date' => get_field('trainers_date'),
                'time' => get_field('trainers_time'),
                'avaliable' => get_field('trainers_avaliable'),
                'type' => get_field('trainers_type'),
                'comment' => get_field('trainers_comment'),
                'location' => get_field('trainers_location'),
                'price' => get_field('trainers_price'),
                'permalink' => get_the_permalink()


                );

            endwhile;

            wp_reset_query();
            echo json_encode($info);
            die();
        }


    // Add shortcode  recent szkolenia

     public function recent_posts_trainers() { ?>

    <section class="cta-recent-posts">
        <div class="cta-recent-posts__row">

        <?php
                $args = array(
                'post_type' => 'trainers',
                'posts_per_page' => 3,
                'orderby' => 'meta_value',
                'meta_key' => 'trainers_date',
                'order' => 'ASC'
                );

                $post_query = new WP_Query($args);

                if($post_query->have_posts() ) {
                while($post_query->have_posts() ) {
                    $post_query->the_post();
                    $post_id = get_the_id();
                    $trainersThumbnail = get_field('trainers_img', $post_id);
                    $trainers_date = get_field('trainers_date',$post_id);
                    $trainers_time = get_field('trainers_time',$post_id);
                ?>


        <a href="<?php echo the_permalink();?>" class="cta-card">
            <div class="feature-img">
                <img src="<?php echo $trainersThumbnail ?>" />
            </div>

            <div class="cta-datetime">
                <?php
                    if($trainers_date){ ?>
                <span class="cta-date">
                    <img src="<?php echo ZH_URL ?>/assets/img/date.svg" />
                    <?php echo str_replace('/','-', $trainers_date);?>
                </span>
                <?php } ?>

                <?php 
                    if($trainers_time){ ?>
                <span class="cta-time">
                    <img src="<?php echo ZH_URL ?>/assets/img/time.svg" />
                    <?php echo $trainers_time ?>
                </span>
                <?php } ?>
            </div>

            <h5><?php the_title(); ?></h5>
            <button class="btn-readmore"
                href="<?php echo the_permalink(); ?>"><?php echo 'Dowiedz się więcej' ?></button>
        </a>

        <?php
             }
          }
         wp_reset_query();

         ?>

    </div>

</section>

<?php }

}