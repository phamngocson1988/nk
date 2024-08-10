
<style type="text/css">
    .pagination>.active>a{
        color: #fff !important;
        background-color: #808285 !important;
    }
    .rollover div {
        margin-top: 25% !important; /*50*/
    }
    .div_trang {padding: 7px 12px;;text-align: center;border: 1px solid #808285 !important;margin-right: 5px;}
</style>
<div class="row product_list">
<?php 
  foreach($product as $item){ 
    $title = $this->convert_vi_to_en($item['name']);
    $id = $item['id'];
?>
    <div class="col-xs-12 col-sm-6 col-md-3 product_item" style="min-height:412px;">
      <a href="<?php echo Yii::app()->request->baseUrl; ?>/san-pham/chi-tiet/<?php echo $title;?>-<?php echo $id;?>/lang/<?php echo $lang;?>">
            <div style="position: relative;">
              <?php
                  $img= ProductImage::model()->findByAttributes(array('id_product' => $item['id']));
                  if ($img){
               ?>
               <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $img['url_action'] ?>/lg/<?php echo $img['name_upload'] ?>" class="img" style="width: 100%;"/>
               <?php } else {?>
                <img src="<?php echo Yii::app()->params['image_url']; ?>/images/muasam/chinhakhoa/19.jpg" class="img" style="width: 100%;"/>
              <?php }?>
            </div>
      
             <div align="center" class="product_title">
                <div class="name" style="font-size:13pt;width: 255px; height: 50px; ">
                    <?php if($lang=='vi'){echo $item['name'];}else{echo $item['name_en'];}?>
                 </div>
                <p style="color: #9ec63b;font-size:13pt;"><?php echo number_format($item['price'],0, ',', '.');?> VNĐ</p>
            </div>
        </a>
    </div>
    <?php } ?>
</div>
<div class="paging">
<ul class="pagination pull-right">
    <?php
    if (isset($lst)) {
        echo $lst ;
        if($lang=='vi'){
    ?>
      <li style="float: right; "><a href="<?php echo Yii::app()->request->baseUrl; ?>/san-pham">Xem tất cả >></a></li>
      <?php } else{ ?>
      <li style="float: right; "><a href="<?php echo Yii::app()->request->baseUrl; ?>/product">See all product >></a></li>
      <?php  } 
    } else{ ?>
    <li></li>
  <?php } ?>
</ul>
</div>