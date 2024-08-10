
<style>
/** tin tức nổi bật **/
.ns_img {overflow: hidden; position: relative;}
#ns_20 {padding-left: 5px;}
#ns_2 {height: 230px;}
#ns_3 {padding-top: 5px; padding-right: 0;}
#ns_31 {padding-right: 1px; height: 235px;}
#ns_32 {padding-left: 1px; height: 235px; width: 47.8%;}
.ns_img_1 {height: 470px;}
.ns_img_2 {margin-top: -10%;height: auto;}
.ns_img_txt {position: absolute; bottom: 0; left: 15px;  width: 100%; height: 100%; transition: 1s;} /*background: rgba(0, 0, 0, 0.3);*/
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
.ns_box a {color: #333;display: block;overflow: hidden;}
.ns_box img {margin-right: 6px; -webkit-transition: all 0.7s ease;transition: all 0.7s ease;}
.ns_box img:hover{-moz-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-transform:scale(1.3);transform:scale(1.3);}
.ns_box_img {height: 158px;border: 1px solid rgba(204, 204, 204, 1.46);padding: 0px}
#ns_str .ns_box {margin-bottom: 2em;}
#ns_str .ns_box h4 {margin: 0;}
#ns_str .ns_box h4 p {margin: 0;}
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
<div id="ns_page">

	<div  class="container  hidden-xs" id="ns_main">
		<div>
			<div class="col-sm-5 ns_img" >
			<?php if (isset($hot[0])): ?>
				<?php
					$name_line_0 = NewsLine::model()->findByPK($hot[0]['id_news_line']);
					$str_line_0 = $this->convert_vi_to_en($name_line_0['name']);
					$str_title_0 = $this->convert_vi_to_en($hot[0]['title']);
					$img_0 = $hot[0]['image'] ? "lg/".$hot[0]['image'] : "no_image.png";
				?>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line_0; ?>/<?php echo $str_title_0; ?>-<?php echo $hot[0]['id']?>/lang/<?php echo $lang;?>">
					<img src="<?php echo Yii::app()->request->baseUrl.'/upload/post/new/'. $img_0; ?>" alt="" class="ns_img_1">
					<div class="ns_img_txt">
						<div>
							<h4><?php if($lang=='vi'){echo $hot[0]['title'];}else{echo $hot[0]['title_en'];} ?></h4>
								<button type="button" class="btn btn_green"><?php echo Yii::t('translate','research'); ?></button>
						</div>
					</div>
				</a>
			<?php endif ?>
			</div>

			<div class="col-sm-7" style="padding-left: 5px;">
				<div class="row">
					<div class="col-md-12 ns_img" id="ns_2">
					<?php if (isset($hot[1])): ?>
						<?php
							$name_line_1 = NewsLine::model()->findByPK($hot[1]['id_news_line']);
							$str_line_1 = $this->convert_vi_to_en($name_line_1['name']);
							$str_title_1 = $this->convert_vi_to_en($hot[1]['title']);
							$img_1 = $hot[1]['image'] ? "lg/".$hot[1]['image'] : "no_image.png";
						?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line_1; ?>/<?php echo $str_title_1; ?>-<?php echo $hot[1]['id']?>/lang/<?php echo $lang;?>">			
							<img src="<?php echo Yii::app()->request->baseUrl.'/upload/post/new/'. $img_1; ?>" alt="" class="ns_img_2">
							<div class="ns_img_txt">
								<div>
									<h4><?php if($lang=='vi'){echo $hot[1]['title'];}else{echo $hot[1]['title_en'];} ?></h4>
										<button type="button" class="btn btn_green"><?php echo Yii::t('translate','research'); ?></button>
								</div>
							</div>
						</a>
					<?php endif ?>
					</div>

					<div class="col-md-12" id="ns_3">
						<div class="row">
							<div class="col-sm-6 ns_img" id="ns_31">
							<?php if (isset($hot[2])): ?>
								<?php
									$name_line_2 = NewsLine::model()->findByPK($hot[2]['id_news_line']);
									$str_line_2 = $this->convert_vi_to_en($name_line_2['name']);
									$str_title_2 = $this->convert_vi_to_en($hot[2]['title']);
									$img_2 = $hot[2]['image'] ? "md/".$hot[2]['image'] : "no_image.png";
								?>
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line_2; ?>/<?php echo $str_title_2; ?>-<?php echo$hot[2]['id']?>/lang/<?php echo $lang;?>">
									<img src="<?php echo Yii::app()->request->baseUrl.'/upload/post/new/'. $img_2; ?>" alt="" class="">
									<div class="ns_img_txt">
										<div>
											<h4><?php if($lang=='vi'){echo $hot[2]['title'];}else{echo $hot[2]['title_en'];} ?></h4>
												<button type="button" class="btn btn_green"><?php echo Yii::t('translate','research'); ?></button>
										</div>
									</div>
									</a>
							<?php endif ?>
							</div>

							<div class="col-sm-6 ns_img" id="ns_32">
								
							<?php if (isset($hot[3])): ?>
								<?php
									$name_line_3 = NewsLine::model()->findByPK($hot[3]['id_news_line']);
									$str_line_3 = $this->convert_vi_to_en($name_line_3['name']);
									$str_title_3 = $this->convert_vi_to_en($hot[3]['title']);
									$img_3 = $hot[3]['image'] ? "md/".$hot[3]['image'] : "no_image.png";
								?>
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line_3; ?>/<?php echo $str_title_3; ?>-<?php echo $hot[3]['id']?>/lang/<?php echo $lang;?>">
									<img src="<?php echo Yii::app()->request->baseUrl.'/upload/post/new/'. $img_3; ?>" alt="" class="">
									<div class="ns_img_txt" style="left:3px;">
										<div>
											<h4><?php if($lang=='vi'){echo $hot[3]['title'];}else{echo $hot[3]['title_en'];} ?></h4>
												<button type="button" class="btn btn_green"><?php echo Yii::t('translate','research'); ?></button>
										</div>
									</div>
								</a>
							<?php endif ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<div  class="container" id="ns_str">
		<div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="row">
					<div class="col-md-8" id="content_news">
						<?php include('listnews.php'); ?>
					</div>
					<div class="col-md-4" id="ns_sr" style="padding-right: 0px">
						<h4><b><?php echo Yii::t('translate','search'); ?></b></h4>
						<div class="col-md-12" style="padding-left: 0px;">
							<input id="key_search" style="float:left;width:100%;height:41px;" type="text" class="form-control" placeholder="<?php echo Yii::t('translate','enter_keyword'); ?>">
							<img id="img_search" style="z-index: 10;right: 0%;cursor:pointer;width:43px;position:absolute;padding:10px;background-color: #94c640;" src="<?php echo Yii::app()->params['image_url']; ?>/images/icon_search.png" alt="Search">
						</div>
						<div class="clearfix"></div>
						<h4><b>Clip <?php echo Yii::t('translate','special_subject');?></b></h4>
						<div class="col-md-12" style="padding: 0px;">
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/introduce/clipchuyende">
                                <img src="<?php echo Yii::app()->params['image_url']; ?>/images/introduce/background_clip.jpg" style="height: 240px;width: 100%">
                          	</a>
						</div>
						
						<div class="col-md-12" id="ns_srch">
							<div class="row">
								<div id="ns_srch_tt">
									<h4>- <?php echo Yii::t('translate','category');?> -</h4>
								</div>
								<div>
						<dl>
						<?php $newstype = NewsLine::model()->findAll();
							foreach($newstype as $type){
								$str = $type['name'];
								$str = $this->convert_vi_to_en($str);
						?>
							<dt>
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str;?>-<?php echo $type['id']; ?>/lang/<?php echo $lang;?>">
									<?php if($lang=='vi'){echo $type['name'];}else{echo $type['name_en'];} ?>
								</a>
							</dt>
					<?php } ?>	
						</dl>
					</div>
							</div>
						</div>
						<div class="col-md-12" id="ns_tag">
							<h4><i>Tags</i></h4>
							<hr>
							<div>
							<?php foreach($tags as $item){
								$str = $this->convert_vi_to_en($item['name']);
							?>
								<div class="ns_tg_tags"><a href="<?php echo Yii::app()->request->baseUrl; ?>/tags/<?php echo $str; ?>/lang/<?php echo $lang;?>">&#9679 <?php echo $item['name'] ?></a></div>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
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