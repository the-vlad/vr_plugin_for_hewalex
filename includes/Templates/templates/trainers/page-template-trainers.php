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
         the_content();
        ?>
        </div>
        <?php
        endwhile;
    ?>


        <?php get_footer(); ?>

        <script>
        $(document).ready(function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php');?>',
                data: {
                    action: "fetch_cases"
                },

                success: function(data) {
                    const obj = JSON.parse(data);
                    // ajaxResult.push(obj);
                    function addDate(ev) {

                    }

                    var calendar = new Calendar('#calendar', obj);
                },

            });
        });
        </script>