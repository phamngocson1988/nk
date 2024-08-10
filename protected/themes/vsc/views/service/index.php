<style type="text/css">
	#ns_srch {border: 1px solid #19a8e0; margin-bottom: 30px;}
#ns_srch #ns_srch_tt h4 {background: #19a8e0;
    padding: 12px;
    margin: 0;
    text-align: center;
    font-weight: bold;
    color: white;}
#ns_srch .panel-body {border: 0;}
#ns_srch .panel-heading {border: 0; border-radius: 0;}
#ns_srch .panel-heading:hover {background: #c5c4c4; color: white;}
#ns_srch .panel-body {padding: 0 0 0 40px;}

.active_show {text-align: center;position: absolute; bottom: 0; width: 99%;background: rgba(0, 0, 0, 0.1); height: 100%; transition: 1s;}
.active_show div {position: absolute; bottom: 5%; left: 30px;}
.active_show h4 {font-size: 15px; font-weight: bold; color: white;}
.active_show:hover {
    background: linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d);
    background: -webkit-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Firefox 3.6 to 15 */
}
.title_img_banner{
	text-align: center;
	position: absolute;
	bottom: 0px;
	width: 99%;
	height: 15%;
	background: rgba(0, 0, 0, 0.4);
}
.title_img_banner:hover{
	background: linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d);
    background: -webkit-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Firefox 3.6 to 15 */
}
.title_img_banner h4{
	font-size: 15px; 
	font-weight: bold; 
	color: white;
	margin-top: -30px;
    margin-bottom: 25px;
}
.title_img_full_banner {position: absolute; bottom: 0; width: 100%;background: rgba(0, 0, 0, 0.1); height: 100%; transition: 1s;}
.title_img_full_banner h4{font-size: 20px; font-weight: bold; color: white;}
.title_img_full_banner div {position: absolute; bottom: 20%; right: 30px;}
/*.title_img_full_banner:hover {
	padding-right: 5px;
    background: linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d);
    background: -webkit-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); 
    background: -o-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d);
    background: -moz-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d);
}*/
.padding-right-left{
    padding-right: 2px;
    padding-bottom: 2px;
}
.full_size_1{
	width: 100%;
	height: auto;
}
.title_pp{
	font-size: 15px;
	font-weight: bold;
}
.port-1{float: left; width: 100%; position: relative; overflow: hidden; text-align: center}
.port-1 .text-desc{opacity: 0.9; top: -100%; transition: 0.5s; color: #000; padding: 45px 20px 20px;}
.port-1 img{transition: 0.7s;}
/*.port-1:hover img{transform: scale(1.2);}*/
.port-1.effect-2 .text-desc{top: auto; bottom: -82%;}
.port-1.effect-2:hover .text-desc{
	bottom: 0;
}
.port-1.effect-2:hover .title_img_banner h4{
	
}
.content_text{text-align: center;color: #fff;margin: 25px 0px;}
.text-desc{position: absolute; left: 0; top: 50%; height: 100%; opacity: 0; width: 100%; padding: 20px;}
.banner_last .bx-wrapper{
	box-shadow: none;
	border: none;
	background: none;
	margin: 0 auto 40px;
}
.bx-wrapper .bx-pager.bx-default-pager a{
	background: #94c640 ;
	width: 7px;
    height: 7px;
}
.banner_last .bx-wrapper .bx-pager{
	text-align: right;
}
h4{ text-transform: uppercase;}
</style>
<?php   $baseUrl = Yii::app()->getBaseUrl(); 
        $controller = Yii::app()->getController()->getAction()->controller->id;
        $action     = Yii::app()->getController()->getAction()->controller->action->id;
        $lang = Yii::app()->request->getParam('lang','');
        if ($lang != '') {
	        Yii::app()->session['lang'] = $lang;
	    } else {
	        if (isset(Yii::app()->session['lang'])) {
	            $lang = Yii::app()->session['lang'];
	        } else {
	            $lang = 'vi';
	        }
	    }  
	    Yii::app()->setLanguage($lang);
?>
<div class="container">

	<div class="row" style="margin-right: -2px">
       <?php $country = ServiceType::model()->findAll();
	   foreach($country as $gt){
	   ?>
		<div class="col-md-4 padding-right-left">
			<div class="port-1 effect-2">
				<div class="image-box">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/serviceType/lg/<?php echo $gt['image']?>" class="full_size_1">
				</div>
				<div class="text-desc title_img_banner">
						<h4 onclick="chuyen_nd(<?php echo $gt['id'];?>)" ><?php if($lang=='vi'){echo $gt['name'];}else{echo $gt['name_en'];}?></h4>

					
							<button type="button" class="btn btn_green"  onclick="chuyen_nd(<?php echo $gt['id'];?>)"><?php echo Yii::t('translate','research'); ?></button>

							<p class="content_text" onclick="chuyen_nd(<?php echo $gt['id'];?>)" ><?php if($lang=='vi'){echo $gt['description'];}else{echo $gt['description_en'];}?></p>
					
				</div>
			</div>
		</div>
        <?php }?>
		
	
	</div>

	<div style="margin-top: 2.5em" class="row margin-top-15">

		<div class="col-md-12" id="nd_datail">
				<?php include('detailservice_1.php'); ?>
		</div>

	</div>
</div>
<script>
$(document).ready(function(){
	
  $('.bxslider').bxSlider({
  	auto:true,
  	pause: 10000,
  });

});
function chuyen_nd(id){
	var lang = '<?php echo $lang;?>';
	jQuery.ajax({
        type:"POST",
        url:"<?php echo CController::createUrl('service/detailservice')?>",
		data        : { 
                          "id": id, 
                          'lang':lang         
                      },
        success:function(data){

           $("#nd_datail").html(data);  
        } 
    });
}

</script>