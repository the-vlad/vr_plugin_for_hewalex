<?php
get_header();
        $page_id = get_queried_object_id();   
         // init global variables
        $title = get_the_title( $page_id ); 
        $desc = get_field('trainers_desc',$page_id);
        $date = get_field('trainers_date',$page_id);
        $time = get_field('trainers_time',$page_id);
        $price = get_field('trainers_price',$page_id);
        $location = get_field('trainers_location',$page_id);
        $url = wp_get_attachment_url( get_post_thumbnail_id($page_id), 'thumbnail' ); 
        $program = get_field('trainers_program',$page_id);
        $cta_img = get_field('trainers_cta_img',$page_id);
        $cta_title = get_field('trainers_cta_title',$page_id);
        $cta_desc = get_field('trainers_cta_desc',$page_id);
        $course_url = get_field('trainers_course_url',$page_id);
        $course_url_reserve = get_field('trainers_course_url_reserve',$page_id);
        function trainers_breadcrumbs() {
            $the_id = get_queried_object_id();
            $postObjectType = get_post_type($the_id);
            $getTrainer = get_page_by_title( 'Szkolenia' ); 
            $trainerID = $getTrainer->ID;
            $parentID = wp_get_post_parent_id($trainerID);
            $firstParent = get_the_title($parentID);
            $secondParent = get_the_title($trainerID);
            $currentPage = '<span class="current">' . get_the_title( $the_id) . '</span>'; 
            $separator = '&nbsp;&nbsp;/&nbsp;&nbsp;';
            $output = ' ' . $firstParent . ' ' . $separator . ' ' . $secondParent . ' ' . $separator . ' ' .$currentPage;
        
            echo $output;
        }
?>

<section class="section section--banner--header">
    <div class="container">
        <div class="section--banner--header__wrapper">
            <div class="breadcrumbs section--banner--header__breadcrumbs">
                <?php trainers_breadcrumbs(); ?>
            </div>
            <div class="section--banner--header__content">
                <h1 class="section--banner--header__title"><?php echo $title ?></h1>
                <div class="section--banner--header__description" style="color: #fff">
                    <p><?php echo $desc ?></p>

                </div>
            </div>
            <div class="section--banner--header__bg-image" style="background-image: url(<?php echo $url ?>);">
            </div>
        </div>
    </div>
</section>

<section class="trainers_subscribe container">
    <div class="subscribe_box">
        <div class="sub-row">
            <div class="subscribe_box__col">
                <img class="imgdate" src="<?php echo ZH_URL ?>/assets/img/date.svg" />
                <div class="subcol_right">
                    <p class="subtitle">
                        <?php echo 'DATA' ?>
                    </p>
                    <p class="subcontent">
                        <?php echo $date ?>
                    </p>
                </div>
            </div>

            <div class="subscribe_box__col">
                <img class="imgtime" src="<?php echo ZH_URL ?>/assets/img/time.svg" />
                <div class="subcol_right">
                    <p class="subtitle">
                        <?php echo 'GODZINA' ?>
                    </p>
                    <p class="subcontent">
                        <?php echo $time ?>
                    </p>
                </div>
            </div>

            <div class="subscribe_box__col">
                <img class="imgdollar" src="<?php echo ZH_URL ?>/assets/img/dollar.svg" />
                <div class="subcol_right">
                    <p class="subtitle">
                        <?php echo 'CENA' ?>
                    </p>
                    <p class="subcontent">
                        <?php echo $price ?>
                    </p>
                </div>

            </div>

            <div class="subscribe_box__col">
                <img class="imgmarker" src="<?php echo ZH_URL ?>/assets/img/marker.svg" />
                <div class="subcol_right">
                    <p class="subtitle">
                        <?php echo 'MIEJSCE' ?>
                    </p>
                    <p class="subcontent">
                        <?php echo $location ?>
                    </p>
                </div>
            </div>
        </div>
        <a id="btn-subscribe_course" href="<?php echo $course_url ?>" class="
            btn-primary"><?php echo 'ZAPISZ SIĘ NA SZKOLENIE'?></a>

    </div>
</section>


<section class="trainers_program container">
    <h2><?php echo 'Program szkolenia'; ?></h2>
    <div class="program_row">
        <?php echo $program ?>
    </div>
</section>

<section class="trainers-desc">
    <?php if( have_rows('trainers_row',$page_id) ): ?>
    <?php while( have_rows('trainers_row',$page_id) ): the_row(); ?>

    <?php 
        // init local variables
        $isReverse = get_sub_field('trainers_reverse',$page_id);
        $gotColor = get_sub_field('trainers_color',$page_id);
        $gotImage = get_sub_field('trainers_row_img',$page_id);
        $gotText = get_sub_field('trainers_row_desc',$page_id);
        ?>


    <div class="trainers-row" style="background-color:<?php echo $gotColor ?>">
        <?php if($gotImage){ ?>
        <div class="trainers-row__image <?php if ($isReverse){ echo 'the-reverse'; }?>">
            <img src="<?php echo $gotImage ?>" />
        </div>
        <?php } ?>
        <div class="container <?php if ($isReverse){ echo 'the-reverse'; } ?>">
            <div class="placeholder"></div>
            <div class="trainers-row__txt">
                <?php echo $gotText ?>
            </div>
        </div>
    </div>

    <?php
        endwhile;
        else :
        endif;
    ?>
</section>

<div class="trainers-featured container" style="background-image: url(<?php echo $cta_img ?>)">
    <div class="featured-section__title">
        <h2><?php echo $cta_title ?> </h2>
    </div>

    <div class="featured-section__desc">
        <p> <?php echo $cta_desc ?></p>
    </div>

    <div class="featured-section__cta">
        <a class="btn-primary" href="<?php echo $course_url_reserve ?> "><?php echo 'REZERWACJA ONLINE'?></a>
    </div>
</div>

<?php get_footer();?>