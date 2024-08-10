<div class="col-xs-12">
  <?php if($list_data): ?>
  <?php foreach ($list_data as $key => $value): ?>
  <div class="row border-bottom margin-bottom-20">
    <div class="content_question">
      <div class="col-xs-12">
        <div class="row border-bottom">
          <div class="avatar_cus">
            <?php if($value['img']): ?>
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/faq/<?php echo $value['img'];?>" >
            <?php else: ?>
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/customer/no_avatar.png" >
            <?php endif; ?>
          </div>
          <div class="name_cus">
            <?php echo $value['name']; ?>
          </div>
        </div>
        <div class="row">
          <strong>Câu hỏi: </strong>
          <?php echo $value['content']; ?>
        </div>
      </div>
    </div>
    <div class="content_answer" id="t<?php echo $value['id'];?>">
      <div class="content">
        <div class="text-answer">
          <strong>Nha Khoa 2000: </strong>
          <?php echo $value['answer']; ?>
        </div>
      </div>
      <span class="icon_down hidden" >
         <img src="<?php echo Yii::app()->baseUrl?>/images/icon_faq/icon_down.png" class="img_ud">
         <input type="hidden" id="stt_hidden" value="1">
      </span>
    </div>
  </div>

  <?php endforeach; ?>
  <?php else: ?>
  <?php echo "<p style='text-align:center'>Không có dữ liệu</p>";?>
  <?php endif;?>
</div>
<div align="center">
    <?php echo $lst;?>          
</div>
<script>
  $(document).ready(function() {
    $('.content_answer .icon_down').click(function() { 
      var str = $(this).find('#stt_hidden').val();
      if(str == 1){
        $(this).parent().find('.content').css({"height": "auto"});
        $(this).find('.img_ud').attr('src', '<?php echo Yii::app()->request->baseUrl ?>/images/icon_faq/icon_up.png');
        $(this).find('#stt_hidden').val(2);
      }else if(str == 2){
        $(this).parent().find('.content').css({"height": "60px"});
        $(this).find('.img_ud').attr('src', '<?php echo Yii::app()->request->baseUrl ?>/images/icon_faq/icon_down.png');
        $(this).find('#stt_hidden').val(1);
      }  
    });

    <?php foreach ($list_data as $key => $v) { ?>
      var length<?php echo $v['id'];?> = $("#t<?php echo $v['id'];?>").find('.text-answer').height();
      if(length<?php echo $v['id'];?> > 60){
        $("#t<?php echo $v['id'];?>").find('.icon_down').removeClass('hidden');
      }
    <?php } ?>
  });
</script>