<style>
h2{text-transform: uppercase;  }
#pr .pr_ct {padding: 0 30px 30px; text-align: center;}
#pr .pr_ct h3 {padding-bottom: 5px;}
#pr .pr_cir {padding-bottom: 5px; color: #9f9fa0}
.pr_cir span{font-size: 12px;}
#scroll {   position: absolute;top: 65%;width: 100%;height: 10px;}
#banner {position: relative;}
#pr h2.line {color: #14a9de; font-weight: bold; margin: 50px 0; margin-right: 20px;}
#pr .line:before {border-color: #14a9de; top:80%;}
#hdnk{height:193px;}
.ns_img {overflow: hidden;position: relative;}
.pagination>.active>a{color: #fff !important;background-color: #808285 !important;}
.paging .pagination li a {margin-right: 5px;border: 1px solid #808285 !important;color: #808285;border-radius: 0;}
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
<div class="container" id="pr" style="background: no-repeat; ">
	<div>
		<div class="col-xs-12">
				<h2 class="line"><span><?php echo Yii::t('translate','promotion'); ?> </span></h2>
				<div id="pr_box" class="row">
				<!-- for -->
				<?php foreach($show_km as $gt){ ?>
					<?php $str_title = $this->convert_vi_to_en($gt['title']);?>
					<div class="col-sm-6 col-md-4 ">
						<div class="grid-item">
						<div class="ns_img" id="hdnk">
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/khuyen-mai/<?php echo $str_title; ?>-<?php echo $gt['id'];?>/lang/<?php echo $lang;?>">
								<img  src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/promotion/lg/<?php echo $gt['image']?>" class="img-responsive" alt="" style="width:100%;">
							</a>
						</div>
							<div class="pr_ct">
							<?php 
								if($lang=='vi'){
									$title = strip_tags($gt['title']);
									if (strlen($title) > 100) {
									    $stringCut = substr($title, 0, 100);
									    $title = substr($stringCut, 0, strrpos($stringCut, ' ')); 
									} 
								}else{
									$title = strip_tags($gt['title_en']);
									if (strlen($title) > 100) {
									    $stringCut = substr($title, 0, 100);
									    $title = substr($stringCut, 0, strrpos($stringCut, ' ')); 
									} 
								}
							?> 
								<h3><?php echo $title;?></h3>
								<div class="pr_cir col-xs-12">
									<span>&#9679</span>
									<span>&#9679</span>
									<span>&#9679</span>
								</div>
								<?php 
									if($lang=='vi'){
										$description = strip_tags($gt['description']);
										if (strlen($description) > 100) {
										    $stringCut = substr($description, 0, 100);
										    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
										} 
									}else{
										$description = strip_tags($gt['description_en']);
										if (strlen($description) > 100) {
										    $stringCut = substr($description, 0, 100);
										    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
										}
									}
								?> 

								<p style="color: #919190; height:90px;"><?php echo $description; ?></p>
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/khuyen-mai/<?php echo $str_title; ?>-<?php echo $gt['id'];?>/lang/<?php echo $lang;?>">
									<button type="button" class="btn btn_green" style="margin-top: 15px;"><?php echo Yii::t('translate','see_more'); ?></button>
								</a>
							</div>
						</div>
					</div>
				<?php }?>
				<!-- end for -->
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="paging">
						<ul class="pagination pull-right">
							<?php echo $lst?>
						</ul>
					</div>
				</div>
			</div>
	</div>

</div>