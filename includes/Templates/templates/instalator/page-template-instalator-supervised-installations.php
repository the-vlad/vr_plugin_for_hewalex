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
                    <?php echo do_shortcode('[supervised_installations]'); ?>
                </div>
            </div>

            <script>
                function removeTempAccess(e, id) {
                    var myHeaders = new Headers();
                    myHeaders.append('Accept', 'application/json');

                    var requestOptions = {
                    method: 'GET',
                    headers: myHeaders,
                    redirect: 'follow'
                    };
                    
                    if (confirm("Czy napewno usunąć dostęp do instalacji:")) {
                        fetch('/api/supervision/remove-temp-acces?id=' + id, requestOptions)
                            .then(response => response.json())
                            .then(json => {
                                if (json.success) {
                                    $(e).closest( "tr" ).remove(); 
                                }
                            })
                    } else {
                    } 
    
                }
                   
                function tempAccess(user,installer) {
                    var myHeaders = new Headers();
                    myHeaders.append('Accept', 'application/json');

                    var requestOptions = {
                        method: 'GET',
                        headers: myHeaders,
                        redirect: 'follow'
                    };

                    fetch('https://ekontrol.pl/api/supervision/access?installer_id=' + installer +'&user_id=' + user, requestOptions)
                        .then(response => response.json())
                        .then(json => {
                            if (json.status && json.url) {
                                window.open(json.url, '_blank');
                            }
                        })
                }

                function tempAccessReport(user,installer,serial) {
                    var myHeaders = new Headers();
                    myHeaders.append('Accept', 'application/json');

                    var requestOptions = {
                        method: 'GET',
                        headers: myHeaders,
                        redirect: 'follow'
                    };

                    fetch('https://ekontrol.pl/api/supervision/access?installer_id=' + installer +'&user_id=' + user + '&serial=' + serial, requestOptions)
                        .then(response => response.json())
                        .then(json => {
                            if (json.status && json.url) {
                                window.open(json.url, '_blank');
                            }
                        })
                }

                function renameAccess(e, id, cur) {
                    var name;
                    while(true){
                        var name = prompt('Podaj nową nazwę dla "' + cur + '"', cur);
                        if (!name) {
                            break;
                        } else if(name.length >= 10){
                            //@TODO query to API
                            $(e).parent().children('span').first().text(name);
                            break;
                        } else {
                            alert("Nazwa musi się składać z przynajmniej 10 znaków.");
                        }
                    }
                }

            </script>
        </main>
    </div>
<?php
get_footer();
?>