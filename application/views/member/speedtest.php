<style>
    .speedtest-wrapper {
        width: 100%;
        background-color: #ffffff;
        position: relative;
        overflow: hidden;
    }
    .speedtest-iframe {
        width: 100%;
        height: 1000px;
        min-height: 1000px;
        border: none;
        display: block;
    }
    @media (max-width: 991.98px) {
        .speedtest-iframe {
            height: 1060px;
            min-height: 1060px;
        }
    }
    @media (max-width: 767.98px) {
        .speedtest-iframe {
            height: 1140px;
            min-height: 1140px;
        }
    }
    @media (max-width: 480px) {
        .speedtest-iframe {
            height: 1200px;
            min-height: 1200px;
        }
    }
</style>

<?php if (!empty($company['speedtest'])) { ?>
    <div class="speedtest-wrapper">
        <iframe class="speedtest-iframe" width="100%" frameborder="0" src="<?= $company['speedtest'] ?>" title="Speedtest <?= htmlspecialchars($company['company_name'] ?? 'GayuhNet') ?>"></iframe>
    </div>
<?php } ?>

<!--OST Widget code start-->
<?php if (empty($company['speedtest'])) { ?>
    <div style="text-align:right;">
        <div style="min-height:360px;">
            <div style="width:100%;height:0;padding-bottom:50%;position:relative;">
                <iframe style="border:none;position:absolute;top:0;left:0;width:100%;height:100%;min-height:360px;border:none;overflow:hidden !important;" src="//openspeedtest.com/Get-widget.php" title="OpenSpeedTest Widget"></iframe>
            </div>
        </div>
    </div>
<?php } ?>
<!-- OST Widget code end -->