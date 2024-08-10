<p style="text-align: center;font-size: 30px; font-weight: bold;margin-top: 25px;text-transform: uppercase; "><?php echo Yii::t('translate','equipment'); ?></p>
<div style="text-align: center;margin-top: 25px;" class="col-sm-10 col-sm-offset-1">
     <!--  Nha khoa 2000 được xây dựng trên khuôn viên rộng, các phòng khám được bố trí khoa học, rộng rãi đem lại cảm giác thoải mái cho khách hàng khi đặt chân vào trung tâm. Trong thời gian chờ đợi trong khi bác sĩ chưa tiếp bạn được, bạn có thể ngồi chờ tại phòng khách tiện nghi với truyền hình, sách báo, free wifi,… Cùng với hệ thống trang thiết bị và công nghệ hiện đại đến từ Nhật Bản, Mỹ, Đức… trong một môi trường thư giãn hoàn toàn, chúng tôi cung cấp cho bạn những dịch vụ nha khoa chất lượng cao nhất cùng chi phí hợp lý. -->
     <?php if($lang=='vi'){ echo $introduce[6]['content'];}else{ echo $introduce[6]['content_en'];}?>
</div>
<div class="col-sm-12" style="margin-top: 30px;">
      <?php if($lang=='vi'){?>
            <p style="font-size: 20px; font-weight: bold;">HÌNH ẢNH CƠ SỞ VẬT CHẤT</p>
      <?php }else{?>
            <p style="font-size: 20px; font-weight: bold;">IMAGES EQUIPMENT</p>
      <?php }?>
      <div id="gallery">
            <div class="row product_list about_us">
                  <div class="col-sm-6 col-md-4 product_item">
                        <div class="img_parent" style="position: relative;border: 1px solid #ccc;cursor: pointer;">
                              <a href="<?php echo Yii::app()->request->baseUrl; ?>/gioi-thieu/co-so-vat-chat-1/lang/<?php echo $lang;?>">
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/img_csvc/DSC_15.jpg">
                              </a>
                              <?php if($lang=='vi'){?>
                                    <div style="padding: 6px 0px;">Hình ảnh cơ sở vật chất cơ sở 1</div>
                              <?php }else{?>
                                    <div style="padding: 6px 0px;">Images equipment branch 1</div>
                              <?php }?>
                              
                        </div>
                  </div>
                  <div class="col-sm-6 col-md-4 product_item">
                        <div class="img_parent" style="position: relative;border: 1px solid #ccc;cursor: pointer;">
                              <a href="<?php echo Yii::app()->request->baseUrl; ?>/gioi-thieu/co-so-vat-chat-2/lang/<?php echo $lang;?>">
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/img_csvc/DSC_5.jpg">
                              </a>
                              <?php if($lang=='vi'){?>
                                    <div style="padding: 6px 0px;">Hình ảnh cơ sở vật chất cơ sở 2</div>
                              <?php }else{?>
                                    <div style="padding: 6px 0px;">Images equipment branch 2</div>
                              <?php }?>
                        </div>
                  </div>
                  <div class="col-sm-6 col-md-4 product_item">
                        <div class="img_parent" style="position: relative;border: 1px solid #ccc;cursor: pointer;">
                              <a href="<?php echo Yii::app()->request->baseUrl; ?>/gioi-thieu/nha-khoa-nhi/lang/<?php echo $lang;?>">
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/img_csvc/DSC_4.jpg">
                              </a>
                              <?php if($lang=='vi'){?>
                                    <div style="padding: 6px 0px;">Hình ảnh Nha Khoa Nhi</div>
                              <?php }else{?>
                                    <div style="padding: 6px 0px;">Images Kids Dentist</div>
                              <?php }?>
                        </div>
                  </div>
            </div>
      </div>
</div>