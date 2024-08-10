<p style="text-align: center;font-size: 30px; font-weight: bold;margin-top: 25px;"><?php echo Yii::t('translate','about_us'); ?></p>
<div style="text-align: center;margin-top: 25px;" class="col-sm-10 col-sm-offset-1">
     <?php if($lang=='vi'){ echo $introduce[4]['content'];}else{ echo $introduce[4]['content_en'];}?>
</div>
<div class="col-sm-12" style="    margin-top: 30px;">
      <p style="font-size: 20px; font-weight: bold; text-transform: uppercase;"><?php echo Yii::t('translate','image_1'); ?></p>
      <div id="gallery" style="margin-bottom: 20px;">
            <div class="row product_list about_us">
                  <div class="col-sm-6 col-md-4 product_item">
                        <div class="img_parent" style="position: relative;border: 1px solid #ccc;cursor: pointer;">
                              <a href="<?php echo Yii::app()->request->baseUrl; ?>/gioi-thieu/hoat-dong-nha-khoa/lang/<?php echo $lang;?>">
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/introduce/VCT-1.jpg">
                              </a>
                              <div style="padding: 6px 0px;"><?php echo Yii::t('translate','image_2'); ?></div>
                        </div>
                  </div>
                  <div class="col-sm-6 col-md-4 product_item">
                       <div class="img_parent" style="position: relative;border: 1px solid #ccc;cursor: pointer;">
                              <a href="<?php echo Yii::app()->request->baseUrl; ?>/gioi-thieu/hoat-dong-ngoai-khoa/lang/<?php echo $lang;?>">
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/ngoaikhoa/_DSC0032.jpg">
                              </a>
                              <div style="padding: 6px 0px;"><?php echo Yii::t('translate','image_3'); ?></div>
                        </div>
                  </div>
                  <div class="col-sm-6 col-md-4 product_item">
                       <div class="img_parent" style="position: relative;border: 1px solid #ccc;cursor: pointer;">
                              <a href="<?php echo Yii::app()->request->baseUrl; ?>/gioi-thieu/clipchuyende/lang/<?php echo $lang;?>">
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/introduce/background_clip.jpg" style="height: 232px">
                              </a>
                              <div style="padding: 6px 0px;"><?php echo Yii::t('translate','image_4'); ?></div>
                        </div>
                  </div>
                  <!-- -->
            </div>
      </div>

</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.poptrox.js"></script>
<script>
      // $(function() {
            
      //       var foo = $('#gallery');
      //       foo.poptrox({
      //             usePopupCaption: true
      //       });
      //       var foo1 = $('#gallery1');
      //       foo1.poptrox({
      //             usePopupCaption: true
      //       });
      
      // });
</script>