<div id="prepaidCardContainer" class="bg-default rounded p-sm pl-lg pr-lg mt-md"
    data-loading-overlay=""
    data-loading-overlay-options="{ &quot;startShowing&quot;: true, &quot;css&quot;: { &quot;backgroundColor&quot;: &quot;#ebebeb&quot; } }">
    <div class="content"></div>
    <div class="modal fade" id="prepaidCardModal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
</div>

<script>
    window.zh_url = '<?php echo ZH_URL ?>';
    jQuery(window).on("load", function() {
        prepaidCard.initialize();
    });
</script>