<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/fancyBox_1/lightbox.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/fancyBox_1/lightbox.js"></script>
<style type="text/css">
   #hdnk{
      height: 250px;
      margin-bottom:30px;
   }
   .ns_img {
    overflow: hidden;
    position: relative;
   }
   .about_us .xem {
    position: absolute;
    width: 20px;
    text-align: center;
    left: 45%;
}
.about_us .title {
    color: #ffffff;
    font-size: 14px;
    text-align: center;
}
.about_us .blur {
    -webkit-transition: -webkit-transform 1s;
    background-color: rgba(0,0,0,0.7);
    cursor: pointer;
    height: 50px;
    min-width: 100%;
    position: absolute;
    z-index: 10;
    opacity: 0;
    bottom: 0px;
    left: 0px;
}
</style>

<div class="container" style="margin-bottom: 20px;">
      <div class="row" style="margin-top: 30px;">
      <?php if($lang=='vi'){?>
         <p style="font-size: 20px; font-weight: bold; text-transform: uppercase;">Hình ảnh hoạt động NHA KHOA 2000</p>
      <?php }else{?>
          <p style="font-size: 20px; font-weight: bold;">DENTAL CLINIC 2000‘S IMAGES</p>
      <?php }?>
      <div id="gallery1">
            <div class="row product_list about_us">
            <?php foreach($img as $item){ ?>
              <?php if($item['name_upload']){ ?>
                  <div class=" col-xs-12 col-sm-4 col-md-4" >
                        <div class="ns_img" id="hdnk">
                           <a class="example-image-link" href="<?php echo Yii::app()->request->baseUrl; ?>/upload/images/lg/<?php echo $item['name_upload'];?>"  data-lightbox="example-set">
                              <span class="blur">
                                  <?php if($lang=='vi'){?>
                                    <div class="title"><?php echo $item['name'];?></div>
                                  <?php }else{?>
                                    <div class="title"><?php echo $item['name_en'];?></div>
                                  <?php }?>
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem" title="Hoạt động ngoại khóa">
                              </span>
                              <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/images/lg/<?php echo $item['name_upload'] ?>"; ></a>
                        </div>
                  </div>
            <?php } } ?>  
            </div>
      </div>
    </div>
</div>
<!-- <script src="<?php //echo Yii::app()->request->baseUrl; ?>/js/jquery.poptrox.js"></script>
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
</script> -->
