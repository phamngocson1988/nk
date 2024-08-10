<style type="text/css">
      .img-cs1-1{
            width: 80%;
            margin: auto;
            margin-bottom: 20px;
      }
      .img-cs1-1 img{
        margin:0px auto;
      }
</style>
<div class="container">
  <div class="row" style="margin-top: 30px;">
      <?php if($lang=='vi'){?>
            <p style="font-size: 20px; font-weight: bold;"><?php echo $data[0]['title']; ?></p>
            <?php echo $data[0]['content']; ?>
      <?php }else{?>
            <p style="font-size: 20px; font-weight: bold;"><?php echo $data[0]['title_en']; ?></p>
            <?php echo $data[0]['content_en']; ?>
      <?php }?>
</div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.poptrox.js"></script>
<script>
      $(function() {
            
            var foo = $('#gallery');
            foo.poptrox({
                  usePopupCaption: true
            });
            var foo1 = $('#gallery1');
            foo1.poptrox({
                  usePopupCaption: true
            });
      
      });
</script>