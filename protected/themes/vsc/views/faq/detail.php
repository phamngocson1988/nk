<?php   
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

<?php
	$stt = 1;
	if(!$faq){
?>
  <div class="col-md-offset-5 col-xs-offset-4">
  	<p style="font-style: italic;font-weight: bold;">Không có dữ liệu</p>
  </div>
<?php 
  }else{ 
	  foreach($faq as $item){ 
?>
  <div class="panel">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title" style="font-weight: bold;font-size: 16px">
        <a class="faq_hover" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $stt; ?>" aria-expanded="false" aria-controls="<?php echo $stt; ?>">
          <?php 
            if($lang=='vi'){
              echo $item['question']; 
            }elseif($lang=='en'){
               echo $item['question_en'];
            }
          ?>
        </a>
      </h4>
    </div>
    <div id="<?php echo $stt; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
       <?php 
            if($lang=='vi'){
              echo $item['answer']; 
            }elseif($lang=='en'){
               echo $item['answer_en'];
            }
          ?>
    </div>
  </div>
<?php 
  	$stt++;	
    }
	} 
?>
</br>
<div style="clear:both"></div>
<div align="center">
    <?php echo $lst;?>          
</div>