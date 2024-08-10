<style type="text/css">
.ns_view {font-size: 12px; font-style: italic;padding: 5px 0;}
.ns_view span{margin-right: 20px;}
.xem{width: 20px;text-align: center;}
.cmt{width: 15px;text-align: center;display: none;}
.text{font-size: 14px;font-style: italic;line-height: 28px;}
.default_padding{padding: 0px;}
.default_padding_left{padding-left: 0px;}
.default_padding_right{padding-right: 0px;}
.font_date{font-style: italic;font-size: 14px;}
.title_news{font-weight: bold;font-size: 17px;}
.marign_default_news{margin: 10px 0px;}
.style_tin_pho_bien{font-size: 13px;color: #fff; border: 1px solid #66686a; background: #66686a;padding: 5px; text-align: center;width: 50%;position: absolute;top: -17px;left: 0px; text-transform: uppercase;}
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
	<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 30px;">
		<div class="row">
			<div class="col-md-8" id="content_news">
				<p style="font-size: 25px;font-weight: bold;">
					<?php if($lang=='vi'){echo $career['title'];}else{echo $career['title_en'];}?>
				</p>
				<div class="ns_view">
					<span><?php echo $career['createdate'];?></span>
					<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem"><?php echo $career['total_view'];?></span>
				</div>
				<div style="margin-bottom: 20px;">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/recruitment/lg/<?php echo $career['image'];?>" alt="" class="img-responsive">
				</div>
				<div style="margin-bottom: 20px;">
					<?php if($lang=='vi'){echo $career['content'];}else{echo $career['content_en'];}?>
				</div>
			</div>
			<div class="col-md-4">
				<h4><b><?php echo Yii::t('translate','search'); ?></b></h4>
				<div class="col-md-12" style="padding-left: 0px;">
					<input id="key_search" style="float:left;width:100%;height:41px;" type="text" class="form-control" placeholder="<?php echo Yii::t('translate','enter_keyword'); ?>">
					<img id="img_search" style="z-index: 10;right: 0%;cursor:pointer;width:43px;position:absolute;padding:10px;background-color: #94c640;" src="<?php echo Yii::app()->params['image_url']; ?>/images/icon_search.png" alt="Search">
				</div>
				<div class="col-md-12 default_padding_left" style="margin-top: 35px;margin-bottom: 35px;">
					<div class="style_tin_pho_bien"><?php echo Yii::t('translate','news_highlights'); ?></div>
					<div style="border: 1px solid #66686a; width: 105%"></div>
				</div>
				<div class="col-md-12 default_padding" style="margin: 15px 0px">
					<img src="<?php echo Yii::app()->params['image_url']; ?>/images/news/2.jpg" class="img-responsive">
				</div>
				<?php 
				foreach ($list_total_view as $key => $hot) { 
				$str_title = $this->convert_vi_to_en($hot['title']); ?>
				<div class="col-md-12 default_padding marign_default_news">
					<div class="col-md-6 default_padding">
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/nghe-nghiep/<?php echo $str_title;?>-<?php echo $hot['id'];?>/lang/<?php echo $lang;?>">
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/recruitment/lg/<?php echo $hot['image']?>" class="img-responsive">
						</a>
					</div>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/nghe-nghiep/<?php echo $str_title;?>-<?php echo $hot['id'];?>/lang/<?php echo $lang;?>">
						<div class="col-md-6 default_padding_right">
							<p class="title_news"><?php if($lang=='vi'){echo $hot['title'];}else{echo $hot['title_en'];}?></p>
							<p class="font_date"><?php echo $hot['createdate'];?></p>
						</div>
					</a>
				</div>
			    <?php }?>
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){ // khai báo chạy khi load trang
	$('#img_search').click(function(){
		var lang = '<?php echo $lang; ?>';
		var keyword = $('#key_search').val();
		if(lang=='vi'){
			search(keyword);
		}else{
			searchEN(keyword);
		}
	});
 	
}); 
$('#key_search').keypress(function(event) {
        if (event.keyCode == 13) {
        var lang = '<?php echo $lang; ?>';
		var keyword = $('#key_search').val();
		if(lang=='vi'){
			search(keyword);
		}else{
			searchEN(keyword);
		}
        }
});
function search(keyword){
	var curpage=1;  
	$.ajax({ 
		type        : "POST",
        url         :"<?php echo CController::createUrl('career/SearchCareer')?>",
        data        : {
                          "keyword"   : keyword,
                          'curpage'	  : curpage
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
    $.ajax({
        type:'POST',
        url: "<?php echo CController::createUrl('career/SearchCareer')?>",
        data:{"curpage": curpage,"keyword": keyword},
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
function searchEN(keyword){
	var curpage=1;  
	$.ajax({ 
		type        : "POST",
        url         :"<?php echo CController::createUrl('career/SearchCareerEN')?>",
        data        : {
                          "keyword"   : keyword,
                          'curpage'	  : curpage
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
function paginationEN(curpage){  
    $('.cal-loading').fadeIn('fast');  
     var keyword = $('#key_search').val();    
    $.ajax({
        type:'POST',
        url: "<?php echo CController::createUrl('career/SearchCareerEN')?>",
        data:{"curpage": curpage,"keyword": keyword},
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