<?php $baseUrl = Yii::app()->baseUrl;?>
<!--Font Awesome and Bootstrap Main css  -->


<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jqtransform.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/setting.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/customers_new.css" />

<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>

<style type="text/css">
#profileSideNav ul li a i{
    font-size:2em;  

}
#profileSideNav ul li a .glyphicon{
    font-size:2em;
}
  

</style>
<div class="row wrapper tab-content full-height">


    <!-- Contact Customers -->
    <div id="customers" class="tab-pane full-height active">
        <div class="row-fluid full-height">

            <div id="customerContent" class="content">

               

                        <!-- <div class="customerListContainer col-sm-9 col-md-9" >
                            
                        </div> -->
                    </div>    
                    <div class="clearfix"></div>
                </div>   

                <!-- Detail Customer -->
                <div id="detailCustomer" class="col-sm-12 col-md-12 col-lg-12">
                    <?php include 'accout.php' ?>
                    
                </div>


                <div class="clearfix"></div>
            </div>



        </div>
    </div>


</div>
<script type="text/javascript">

$( document ).ready(function() {

    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();

    $('#profileSideNav').height(windowHeight-header);
    $('.customerListContainer').height(windowHeight-header);
    $('#detailCustomer').height(windowHeight-header);


    $('.cal-loading').fadeOut('slow');

});


$(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();

    $('#profileSideNav').height(windowHeight-header);
    $('.customerListContainer').height(windowHeight-header);
    $('#detailCustomer').height(windowHeight-header);

});
</script>

