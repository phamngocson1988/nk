<div class="container" style="margin-bottom: 20px;">
  <div class="row" style="margin-top: 30px;">
  	<?php if($lang=='vi'){?>
      <p style="font-size: 20px; font-weight: bold; text-transform: uppercase; ">Clip chuyên đề NHA KHOA 2000</p>
    <?php }else{?>
       <p style="font-size: 20px; font-weight: bold;">DOCUMENTARY FILMS</p>
   	<?php }?>

      <div id="gallery1">
        <div class="row product_list about_us">
        <?php foreach($clips as $key => $item){ ?>
          <div class="col-sm-6 col-md-4 product_item">
                <div class="img_parent" style="position: relative;border: 1px solid #ccc;cursor: pointer; width: 100%; height: 100%" onclick="popup(<?php echo $key;?>)">
                    <div style="position:absolute;z-index: 10;width: 100%;height: 100%;"> </div>
                    <iframe  width="100%" height="300px" src="https://drive.google.com/file/d/<?php echo $item['url_action']; ?>/preview?autoplay=0" frameborder="0" allowfullscreen="1"></iframe>
                    <?php if($lang=='vi'){?>
                   		<div style="padding: 6px 0px;"><?php echo $item['name']; ?></div>
                    <?php }else{?>
                    	<div style="padding: 6px 0px;"><?php echo $item['name_en']; ?></div>
                    <?php }?>
                </div>
          </div>

          <?php } ?>
        </div>
      </div>
    </div>

</div>
<?php foreach($clips as $key => $item){ ?>
        <div id="notify_sch<?php echo $key;?>" class="modal fade">
            <div class="modal-dialog" style=" width:800px; height: 600px; margin-top:5%">
                <div class="modal-content">
                  <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <div id="video">
                      <iframe id="iframe-demo" width="100%" height="500px" src="https://drive.google.com/file/d/<?php echo $item['url_action']; ?>/preview?autoplay=0" frameborder="0" allowfullscreen="1"></iframe>
                    </div>
                  </div>
                </div>
              </div>
        </div>

 <?php } ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.poptrox.js"></script>
<script type="text/javascript">

function popup(id){
  $('#notify_sch'+id).modal('show');
}

$(document).bind('keydown', function(e) { 
        if (e.which == 27) {  
          location.href = '<?php echo Yii::app()->params['url_base_http'] ?>/introduce/clipchuyende';
        }
}); 
</script>