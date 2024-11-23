<div id="orderCreditsContainer" class="col-md-12 pt-sm pb-xlg">
    <div class="row pb-xlg">
        <h4 style="line-height:35px;" class="color-green mb-xlg">
            <img src="<?php echo ZH_URL . '/public/images/ico/ico_karta.svg' ?>" height="35" class="mr-lg"/> Zasilenie karty płatniczej
        </h4>
    </div>

    <form class="form-horizontal mb-xlg" id="formAddCredit" method="post">
        <section class="row">
            <div>
                <div class="form-group">
                    <label class="col-md-3 control-label control-label-installer" for="avalaible_credits">Dostępna premia punktowa:</label>
                    <div class="col-md-2">
                        <input type="text" value="<?php echo (new \Develtio\ZonesHewalex\Shop\MyAccount\ZH_Points)->calculateTotalsPoints(); ?> zł" name="avalaible_credits" id="avalaible_credits" class="form-control form-control-installer" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label control-label-installer" for="credits">Podaj wartość zasilenia:</label>
                    <div class="col-md-2">
                        <input type="text" value="" name="credits"
                               class="form-control form-control-installer" id="credits" required="">
                    </div>
                    <div class="col-md-3" style="text-align: left;">
                        <button type="submit" class="btn btn-link color-green" onclick="installerOrderCredits.submit(this);" data-toggle="modal" data-loading-text="trwa wysyłanie danych">
                            Generuj formularz zasilenia
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </form>

</div>
<div class="clearfix"></div>

<script type="text/javascript" >
    jQuery(window).on("load", function() {
        installerOrderCredits.initialize();
    });
</script>
