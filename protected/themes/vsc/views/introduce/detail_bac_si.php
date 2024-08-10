<style type="text/css">
	.img_bs{
		background-color: #f4f5f5;
	}
	.padding_img_bs{
		padding: 15px
	}
	.padding_img_bs img{
		width: 100%;
	}
	.description_bs{
		text-align: center;
	}
	.description_bs .name {
		font-size: 18px; 
		font-family: Helvativa-Bold, Helvetica, Arial, sans-serif;
		margin-bottom: 0px;
	}
	.description_bs .technique{
		padding-bottom: 10px;
	}
	.info .title{
		font-size: 20px;
	    color: green;
	    font-weight: bold;
	}
	.info .title-child{
		font-size: 17px;
    	font-weight: bold;
    	margin-top: 10px;
	}
	.info .content p{
		margin-bottom: 0px;
	}
	.info{
		margin-bottom: 15px;
	}
	.note{
		color: #ccc;	
		font-size:14px;
	}
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

<?php if (isset($detail_data)) { ?>

<div class="container" style="margin-top: 30px">
	<div class="row" style="color: #337ab7;font-size: 25px;font-weight: bold; text-transform: uppercase; ">
		<?php echo Yii::t('translate','infor_dentist'); ?>
	</div>
	<div class="row" id="infor_doctor" style="margin-top: 30px">
		<div class="col-md-3" style="margin-top: 20px">
			<div class="img_bs">
	          	<div class="padding_img_bs">
	            	<?php if($detail_data['image']){ ?>
                            	<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/users/lg/<?php echo $detail_data['image'] ?>" class="img-responsive"/>
                    <?php }else{ ?>
                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/users/no_avatar.jpg" class="img"/>
                    <?php } ?>
	          	</div>
	          	<div class="description_bs">
                    <p class="name">

                    <?php if($lang=='vi'){echo $detail_data['name'];}else{echo $this->stripVN($detail_data['name']);} ?>
                    	
                    </p>
                  </div>
        	</div>
        </div>
		<div class="col-md-9">
		
			<div class="col-md-12 info" style="margin-top: 15px; margin-bottom: 125px;">
				<div class="title" style="font-size:16px;"><?php echo Yii::t('translate','introduce'); ?>:</div>
				<?php 	if($lang=='vi'){
							if($detail_data['description']==''){
								echo "Đang cập nhật !";
							}else{
								echo $detail_data['description'];
							}
						}else{
							if($detail_data['description_en']==''){
								echo "Updating !";
							}else{
								echo $detail_data['description_en'];
							}
						}
				?>
				<div class="title" style="font-size:16px;"><?php echo Yii::t('translate','language'); ?> :</div>
				<?php if($lang=='vi'){echo $detail_data['language'];}else{echo $detail_data['language_en'];}?>
			</div>
		
		</div>
		
	</div>
</div>
<?php	} ?>