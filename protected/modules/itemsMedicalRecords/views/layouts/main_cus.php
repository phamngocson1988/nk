<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<?php $this->beginContent('//layouts/layouts_menu'); ?>
<?php
    $controller = Yii::app()->getController()->getAction()->controller->id;
    $action     = Yii::app()->getController()->getAction()->controller->action->id;
?>

<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jqtransform.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/setting.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/customers_new.css" />
<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>
<div class="row wrapper tab-content full-height">
    
    <div  id="rightsidebar" class="col-sm-12 col-md-12">
        <div class="row">
            <?php echo $content; ?>
        </div>
    </div>

</div>

<script type="text/javascript">
$( document ).ready(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    $('#profileSideNav').height(windowHeight-header);
});


$(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    $('#profileSideNav').height(windowHeight-header);
});
</script>

<?php $this->endContent(); ?>