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

        <div id="filters"></div>

        <section class="map-content container">

            <!-- init string variables -->
            <?php 
                $marker_string = 'GRUPY PRODUKTOWE'; 
                $search_string = 'Podaj nazwę miasta, województwa lub kod pocztowy aby wyszukać dystrybutorów w danym rejonie:';
             ?>

            <div class="map-content__top">

            <p class="search-string"><?php echo $search_string ?></p>
                <div class="search-area">
                    <input id="search-input" class="controls" type="text" placeholder="Wyszukaj">
                      <div class="range">
                          <div class="range-control">
                        <span type="button" value="+" class="plus"><p>+</p></span>
                        <span type="button" class="minus"><p>-</p></span>
                        </div>
                        <input type="number" value="20" min="5" max="50" id="range" onKeyDown="return false">
                        <strong>km</strong>
                    </div>
                    <button id="search_button">
                        <img src="<?php echo ZH_URL ?>/assets/img/search.svg" /><span>Szukaj</span>
                    </button>
                </div>
                
                <div class="marker-bar disableState desk-marker-bar">

              
                    <!-- All -->
                    <p class="filter-title">
                        <span class="default_string"><?php echo $marker_string ?></span>
                        <span class="reset_all">Zresetuj wszystkie  &#x2715;</span>
                    </p>
                    <div id="filter_all" class="the-filter">
                        <input type="radio" id="filter_all" class="allradio" name="customfilters" value="Dowolny" checked>
                        <label id="filter_all_label" for="filter_all">Dowolny</label>
                    </div>

                    <!-- Kolektory słoneczne -->
                    <div class="the-filter">
                        <input type="radio" id="collectorSun" class="allradio" name="customfilters" value="Nie" class="active_check">
                        <label for="collectorSun">Kolektory słoneczne</label>
                    </div>

                    <!-- Pompy ciepła do wody użytkowej -->
                    <div class="the-filter">
                        <input type="radio" id="pompHeatWater" class="allradio" name="customfilters" value="Nie">
                        <label for="pompHeatWater">Pompy ciepła PCWU</label>
                    </div>

                    <!-- Pompy ciepla do ogrzewania -->
                    <div class="the-filter">
                        <input type="radio" id="pompHeat" class="allradio" name="customfilters" value="Nie">
                        <label for="pompHeat">Pompy ciepła PCCO</label>
                    </div>


                    <!-- Pompy ciepła do basenów kąpielowych -->
                    <div class="the-filter">
                        <input type="radio" id="pompHeatPool" class="allradio" name="customfilters" value="Nie">
                        <label for="pompHeatPool">Pompy ciepła PCWB</label>
                    </div>

                    <!-- Fotowoltaika -->
                    <div class="the-filter">
                        <input type="radio" id="sunHeat" class="allradio" name="customfilters" value="Nie">
                        <label for="sunHeat">Fotowoltaika</label>
                    </div>

                    <!-- OPTI-ENER -->
                    <div class="the-filter">
                        <input type="radio" id="optiEner" class="allradio" name="customfilters" value="Nie">
                        <label for="optiEner">OPTI-ENER</label>
                    </div>

                </div>
                <!-- mobile view -->

            </div>
            <div class="google-row">
                <div id="loader" class="loader"></div>
                <!-- <div id="leftdata" class="loadopacity"></div> -->
             
                <div class="leftdata loadopacity">
                    <div id="append-clients""></div>
                 </div>
                <div id="map"></div>
                </div>
            </div>
        </section>
    </main>
</div>



<script>
    window.zh_url = '<?php echo ZH_URL ?>';

</script>


<?php
get_footer();
?>