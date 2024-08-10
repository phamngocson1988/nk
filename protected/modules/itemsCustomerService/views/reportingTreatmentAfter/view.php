<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.table2excel.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.tabletoCSV.js" charset="utf-8"></script>
<?php $baseUrl = Yii::app()->baseUrl; ?>

<?php include_once('style.php'); ?>

<div style="height: 100vh; overflow: auto;">
    <div id="oSrchBar" class="col-md-12">
        <?php include_once('_frmSearch.php'); ?>
    </div>

    <div id="idwaiting_search"></div>

    <div class="margin-top-20" id="sumarize_wrapper"></div>
    <div class="col-md-12 margin-top-20" id="return_content" style="overflow: auto;"></div>
</div>

<script type="text/javascript">
    $(window).resize(function() {
        var w_ct = $("#return_content").width();
        var h_ct = $(".statsTabContent").height();

        $('#return_content .no-data').css('width', w_ct);
        $('#return_content .no-data').css('height', h_ct - 90);
    });

    $(document).ready(function() {
        var w_ct = $("#return_content").width();
        var h_ct = $(".statsTabContent").height();

        $('#return_content .no-data').css('width', w_ct);
        $('#return_content .no-data').css('height', h_ct - 90);
    });
</script>