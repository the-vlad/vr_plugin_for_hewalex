<?php
if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if($user->roles[0] == 'user'){
        global $wpdb;
        $installations_history =  $wpdb->get_results("SELECT * FROM installation WHERE installation_email = $user->user_email LIMIT 1");

        if(!empty($installations_history)){
            wp_redirect(site_url('/strefa-uzytkownika-instalacja-istnieje'));
        }

        $args2 = array(
            'post_type' => 'installation',
            'post_status'   => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'installation_group_installation_email',
                    'value' => $user->user_email,
                    'compare' => '=='
                )
            )

        );
        $installations_posts = get_posts($args2);
        if(!empty($installations_posts)){
            wp_redirect(site_url('/strefa-uzytkownika-instalacja-istnieje'));
        }
    }
    if($user->roles[0] !== 'user' && $user->roles[0] !== 'administrator'){
        include('page-restricted-area.php');
        die();
    }
}
else {
    include('page-restricted-area.php');
    die();
}

acf_form_head();

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
<!--                    <link-->
<!--                            rel="stylesheet"-->
<!--                            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"-->
<!--                            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"-->
<!--                            crossorigin="anonymous"-->
<!--                    />-->
                    <div id="root"></div>

<!--                    <form action="" method="post">-->
<!--                        <label for="code">Kod zestawu</label>-->
<!--                        <input id="code" type="text" name="code"/>-->
<!--                        <label for="email">E-mail</label>-->
<!--                        <input id="email" type="email" name="mail"/>-->
<!--                        <input type="submit" value="step 2"/>-->
<!--                    </form>-->

                    <?php //echo do_shortcode('[acf-multiforms-installation]'); ?>
                </div>
            </div>

        </main>
    </div>
<?php
get_footer();
?>