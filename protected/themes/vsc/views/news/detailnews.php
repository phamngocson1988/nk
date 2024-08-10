<style type="text/css">
.ns_img {overflow: hidden; position: relative;}
#ns_20 {padding-left: 5px;}
#ns_2 {height: 230px;}
#ns_3 {padding-top: 5px; padding-right: 0;}

#ns_31 {padding-right: 1px; height: 235px;}
#ns_32 {padding-left: 1px; height: 235px; width: 47.8%;}
.ns_img_1 {height: 470px;}
.ns_img_2 {margin-top: -10%;height: auto;}
.ns_img_txt {position: absolute; bottom: 0; left: 15px; background: rgba(0, 0, 0, 0.3); width: 100%; height: 100%; transition: 1s;}
.ns_img_txt div {position: absolute; bottom: 13%; left: 30px;}
.ns_img_txt h4 {font-size: 22px; font-weight: normal; color: white;letter-spacing: 1.5px; margin-right: 20px;}
.ns_img_txt:hover {
background: linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d);
background: -webkit-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Safari 5.1 to 6.0 */
background: -o-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Firefox 3.6 to 15 */
}
/***********/
#ns_page {padding-top: 5px; padding-bottom: 35px;}
#ns_page h3 {text-align: left; font-size: 28px; color: #94c640; padding: 30px 0;}
.ns_box h4{font-weight: bold; margin-bottom: 0; margin-top: 15px; cursor: pointer;}
.ns_view {font-size: 12px; font-style: italic;padding: 5px 0;color: #6e6e6e}
.ns_view span{margin-right: 20px;}
.ns_box a {color: #333;display: block;overflow: hidden;
}
.ns_box img {margin-right: 6px; -webkit-transition: all 0.7s ease;transition: all 0.7s ease;
}
.ns_box img:hover{-moz-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-transform:scale(1.3);transform:scale(1.3);}
.ns_box_img {height: 158px;border: 1px solid rgba(204, 204, 204, 1.46);padding: 0px}
#ns_str .ns_box {margin-bottom: 50px;}
#ns_str .ns_box h4 {margin: 0;}
#ns_srch #ns_srch_tt h4 {background: #19a8e0;padding: 12px;margin: 0;text-align: center;font-weight: bold;color: white;}
#ns_srch .panel-body {border: 0;}
#ns_srch .panel-heading {border: 0; border-radius: 0;}
#ns_srch .panel-heading:hover {background: #c5c4c4; color: white;}
#ns_srch .panel-body {padding: 0 0 0 40px;}
#ns_tag {background: #f6f6fb; padding: 20px;}
#ns_tag hr {border: 1px solid #797877;}
.ns_tg_tags {margin: 8px 0px; display: inline-block;}
.ns_tg_tags a{padding: 7px 5px; border: 1px solid #ddd; color: #797877;}
.xem{width: 20px;text-align: center;}
.cmt{width: 15px;text-align: center;display: none;}
.ns_box a {color: #333;display: block;overflow: hidden;}
.ns_box img {margin-right: 6px; border: 1px solid rgba(204, 204, 204, 0.46);-webkit-transition: all 0.7s ease;transition: all 0.7s ease;}
.ns_box img:hover{-moz-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-transform:scale(1.3);transform:scale(1.3);}
.ns_view {font-size: 12px; font-style: italic;padding: 5px 0;}
.ns_view span{margin-right: 20px;}
.text{font-size: 14px;font-style: italic;line-height: 28px;}
.default_padding{padding: 0px;}
.default_padding_left{padding-left: 0px;}
.default_padding_right{padding-right: 0px;}
.font_date{font-style: italic;font-size: 10px;}
.title_news{font-weight: bold;font-size: 14px;}
.marign_default_news{margin: 10px 0px;}
.style_tin_pho_bien{font-size: 13px;color: #fff; border: 1px solid #66686a; background: #66686a;padding: 5px; text-align: center;width: 50%;position: absolute;top: -17px;left: 0px;}
#news_content img {/*max-width: 100% !important;*/}
</style>
<?php   $baseUrl = Yii::app()->getBaseUrl(); 
        $controller = Yii::app()->getController()->getAction()->controller->id;
        $action     = Yii::app()->getController()->getAction()->controller->action->id;
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
	<div style="margin-top: 30px;">
		<div class="row ">
			<div class="col-md-8"  id="content_news">
				<p style="font-size: 25px;font-weight: bold;">
					<?php if($lang=='vi'){echo $detail['title'];}else{echo $detail['title_en'];} ?>
				</p>
				<div class="ns_view">
					<span><?php echo $detail['createdate']; ?></span>
					<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem"><?php echo $detail['total_view']; ?></span>
				</div>
				<div style="margin-bottom: 30px;" id="news_content">
					<?php if($lang=='vi'){echo $detail['content'];}else{echo $detail['content_en'];} ?>
				</div>
			</div>

			<div class="col-md-4">
				<h4><b><?php echo Yii::t('translate','search'); ?></b></h4>
				<div class="col-md-12" style="padding-left: 0px;">
					<input id="key_search" style="float:left;width:100%;height:41px;" type="text" class="form-control" placeholder="<?php echo Yii::t('translate','enter_keyword'); ?>">
					<img id="img_search" style="z-index: 10;right: 0%;cursor:pointer;width:43px;position:absolute;padding:10px;background-color: #94c640;" src="<?php echo Yii::app()->params['image_url']; ?>/images/icon_search.png" alt="Search">
				</div>
				<div id="tin-pho-bien" class="col-md-12 default_padding_left">
					<div class="style_tin_pho_bien"><?php echo Yii::t('translate','news_highlights'); ?></div>
					<div style="border: 1px solid #66686a; width: 105%"></div>
				</div>
				<div class="col-md-12 default_padding" style="margin: 15px 0px">
					<img src="<?php echo Yii::app()->params['image_url']; ?>/images/news/2.jpg" class="img-responsive">
				</div>
				
				<?php foreach ($newsLine as $key => $item): ?>
					<div class="col-md-12 default_padding marign_default_news">
						<div class="col-md-6 default_padding ns_box">
						<?php 
							$name_line = NewsLine::model()->findByPK($item['id_news_line']);
							$str_line = $this->convert_vi_to_en($name_line['name']);
							$str_title = $this->convert_vi_to_en($item['title']);
							$img = $item['image'] ? "sm/".$item['image'] : "no_image.png";
						?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line ?>/<?php echo $str_title ?>-<?php echo $item['id']?>/lang/<?php echo $lang;?>">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/new/<?php echo $img; ?>" alt="" class="img-responsive ">
						</div>
						<div class="col-md-6 default_padding_right">
							<p class="title_news"><?php if($lang=='vi'){echo $item['title'];}else{echo $item['title_en'];} ?></p>
							<p class="font_date"><?php echo $item['createdate']; ?></p>
						</div>
						</a>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){ // khai báo chạy khi load trang
	$('#img_search').click(function(){
		var keyword = $('#key_search').val();
		search(keyword);
	});
 	
}); 
$('#key_search').keypress(function(event) {
    if (event.keyCode == 13) {
        var keyword = $('#key_search').val();
		search(keyword);
    }
});
function search(keyword){
	var lang = '<?php echo $lang;?>';
	var curpage=1;  
	$.ajax({ 
		type        : "POST",
        url         :"<?php echo CController::createUrl('news/SearchNews')?>",
        data        : {
                          "keyword"   : keyword,
                          'curpage'	  : curpage,
                          'lang'	  :lang
                      },
        success     : function(data){
        	console.log(data);
        	//return;

        	$('#content_news').fadeOut(200, function(){
            $('#content_news').html('<div class="col-md-offset-5 col-xs-offset-4" id="loading"><img src="<?php echo Yii::app()->params['image_url']; ?>/images/ajax-loader (2).gif"></div>');
            });
            $('#content_news').fadeIn(900, function(){
                $('#content_news').html(data);
            });
        }
    });
}
function pagination(curpage){  
    $('.cal-loading').fadeIn('fast');  
     var keyword = $('#key_search').val(); 
     var lang = '<?php echo $lang;?>';   
    $.ajax({
        type:'POST',
        url: "<?php echo CController::createUrl('news/SearchNews')?>",
        data:{"curpage": curpage,"keyword": keyword, 'lang':lang},
        success:function(data){
            $('#content_news').html(data);
            $('.cal-loading').fadeOut('slow');
        },
        error: function(data){
            console.log("error");
            console.log(data);
        }
    });      
}
</script>