<style type="text/css">
      .product_item a {color: #333;}
      .product_item{cursor: pointer;}
      .img {cursor: pointer;display: block;min-width: 100%;overflow: hidden;height: auto;}
</style>
<p style="text-align: center;font-size: 30px; font-weight: bold;margin-top: 25px;text-transform: uppercase; "><?php echo Yii::t('translate','team_medical'); ?></p>

<div style="text-align: center;margin-top: 25px;" class="col-sm-10 col-sm-offset-1">
   <?php if($lang=='vi'){ echo $introduce[5]['content'];}else{ echo $introduce[5]['content_en'];}?>
</div>

<div class="row product_list list_doctor">
      <?php if(isset($list_doctor)){

            foreach ($list_doctor as $item) { ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="product_item">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/chi-tiet/bacsi-<?php echo $item['id'];?>/lang/<?php echo $lang;?>">
                        <div>
                        	<?php if($item['image']){ ?>
                            	<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/users/md/<?php echo $item['image'] ?>" class="img"/>
                            <?php }else{ ?>
                            	<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/users/no_avatar.jpg" class="img"/>
                            <?php } ?>
                        </div>
                        <?php if($lang=='vi'){?>
                          <div class="description">
                                <p class="name"><?php if($item['id']==26 || $item['id'] == 27) echo 'Y sĩ'; else echo 'Bác sĩ'; ?> : <?php echo $item['name'] ?></p>
                          </div>
                          <?php }else{?>
                            <div class="description">
                                <p class="name"><?php if($item['id']==26 || $item['id'] == 27) echo 'Nurse'; else echo 'Dentist'; ?> : <?php echo $this->stripVN($item['name']); ?></p>
                            </div>
                          <?php }?>
                        </a>
                  </div>
            </div>
      <?php } } ?>
</div>
<div class="row" style="font-size: 30px;font-weight: bold;margin-top: 40px;text-align: center;"><?php echo Yii::t('translate','doctor_collaboration'); ?></div>

<div class="row product_list list_doctor" style="margin-top: 40px">
      <?php if(isset($list_doctor_ct)){

            foreach ($list_doctor_ct as $item) { ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="product_item">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/introduce/detailbacsi?id=<?php echo $item['id'] ?>">
                        <div>
                          <?php if($item['image']){ ?>
                              <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/users/md/<?php echo $item['image'] ?>" class="img"/>
                            <?php }else{ ?>
                              <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/users/no_avatar.jpg" class="img"/>
                            <?php } ?>
                        </div>
                        <div class="description">
                            <?php if($lang=='vi'){?>
                              <p class="name">Bác sĩ:<?php echo $item['name'] ?></p>
                            <?php }else{?>
                              <p class="name">Dentist:<?php echo $this->stripVN($item['name']); ?></p>
                            <?php }?>
                        </div>
                        </a>
                  </div>
            </div>
      <?php } } ?>
</div>
