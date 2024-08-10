<style>
 .control-label{text-transform: uppercase;  }
</style>
<script type="text/javascript">
function setActive() {
  aObj = document.getElementById('nav').getElementsByTagName('a');
  for(i=0;i<aObj.length;i++) { 
    if(document.location.href.indexOf(aObj[i].href)>=0) {
      aObj[i].className='material-feature active';
    }
  }
}

window.onload = setActive;
</script>
<?php   $baseUrl = Yii::app()->getBaseUrl(); 
        $controller = Yii::app()->getController()->getAction()->controller->id;
        $action     = Yii::app()->getController()->getAction()->controller->action->id;
        $lang = Yii::app()->request->getParam('lang','');
            if($lang == ''){
                $lang =  'vi';
            }
        Yii::app()->setLanguage($lang);
        $product_line = ProductLine::model()->findAll(); 
?>
<div id="scroll"></div>
<div class="container">
    <div class="row" style="padding-top: 35px; padding-bottom: 35px;">
        <div class="col-md-12 material ">
            <div class="col-md-10 default-padding nav nav-pills" style="padding:0px;margin: 0px auto;float: none;">
                <ul id="nav" class="row" style="padding: 0px;">
                    <li class="col-xs-12 col-sm-6 col-md-3">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/san-pham/lamsach/lang/<?php echo $lang;?>" class="material-feature <?php if($action=='lamsach'){echo "active";}?>">
                            <div class="icon-honey">
                            </div>
                            <span>
                                <?php if($lang=='vi'){?>
                                    <label class="control-label text-center"><?php echo $product_line[0]['name'];?></label>
                                <?php }else{?>
                                    <label class="control-label text-center"><?php echo $product_line[0]['name_en'];?></label>
                                <?php }?>
                            </span>
                        </a>
                    </li>
                    <li class=" col-xs-12 col-sm-6 col-md-3">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/san-pham/chamsocrang/lang/<?php echo $lang;?>"  class="material-feature <?php if($action=='chamsocrang'){echo "active";}?>">
                            <div class="icon-aloe">
                            </div>
                            <span>
                                <?php if($lang=='vi'){?>
                                    <label class="control-label text-center"><?php echo $product_line[1]['name'];?></label>
                                <?php }else{?>
                                    <label class="control-label text-center"><?php echo $product_line[1]['name_en'];?></label>
                                <?php }?>
                            </span>
                        </a>
                    </li>
                    <li class="col-xs-12 col-sm-6 col-md-3">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/san-pham/chinhakhoa/lang/<?php echo $lang;?>"  class="material-feature <?php if($action=='chinhakhoa'){echo "active";}?>">
                            <div class="icon-rose">
                            </div>
                            <span>
                                <?php if($lang=='vi'){?>
                                    <label class="control-label text-center"><?php echo $product_line[2]['name'];?></label>
                                <?php }else{?>
                                    <label class="control-label text-center"><?php echo $product_line[2]['name_en'];?></label>
                                <?php }?>
                            </span>
                        </a>
                    </li>
                    <li class="col-xs-12 col-sm-6 col-md-3">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/san-pham/sanphamkhac/lang/<?php echo $lang;?>">
                            <div class="icon-fruit"  class="material-feature <?php if($action=='sanphamkhac'){echo "active";}?>">
                            </div>
                            <span>
                                <?php if($lang=='vi'){?>
                                    <label class="control-label text-center"><?php echo $product_line[3]['name'];?></label>
                                <?php }else{?>
                                    <label class="control-label text-center"><?php echo $product_line[3]['name_en'];?></label>
                                <?php }?>
                            </span>
                        </a>
                    </li>
                </ul>
                
            </div>
            <div class="col-sm-12">
            <hr style="border-top:1px solid #9ec63b">
                <div class="row">
                    <div class="col-sm-6" style="color: #19a8e0; font-size: 20px;font-weight: bold;">
                    <?php echo Yii::t('translate','all_product'); ?></div>
                    <div class="search col-sm-6" style="text-align: right; font-size: 12px;color: #ccc">
                        <ul>
                            <li>
                                <div style="border-right: 1px solid; padding-right: 10px;">
                                  
                                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/muasam/icon_search.png" class="img_responsive " style="width: 25px; " />
                                </div>
                            </li>
                            <li>
                                <!-- <label></label> -->
                                <div style="border-right: 1px solid ;padding-right: 10px;"><?php echo Yii::t('translate','arrange'); ?>
                                    <select style="border: none;" id="arrange">
                                        <option value="1">
                                        <?php echo Yii::t('translate','defaul'); ?></option>
                                        <option value="2">
                                        <?php echo Yii::t('translate','price_hight_low'); ?></option>
                                        <option value="3">
                                        <?php echo Yii::t('translate','price_low_hight'); ?></option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div>
                                <?php echo Yii::t('translate','cart'); ?> :<?php echo count(Yii::app()->session['cart']);?> <?php echo Yii::t('translate','product'); ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="content_product">
                     
                </div>         
            </div>
        </div>
    </div>
</div>
<script>
$(window).load(function () {
    $('body').delay(1000) //wait 5 seconds
        .animate({
            'scrollTop': $('#scroll').offset().top
        }, 300);
});

$(document).ready(function(){
    search_lamsach(1);
    $('#arrange').change(function(e){
        type    = $("#arrange").val();
        search_lamsach(type);
    });
});

function search_lamsach(type){
    var lang = '<?php echo $lang; ?>';
    var curpage=1; 
    var id_product_line = 5;
    jQuery.ajax({   
            type:"POST",
            url:"<?php echo CController::createUrl('shopping/searchTypeProduct')?>",
            data:{
                type          :  type,
                curpage    : curpage,
                id_product_line: id_product_line,
                lang:lang
            
            },
            success:function(data){
                console.log(data);
                $('#content_product').html(data)
    
            },
    });    
}

function pagination(curpage){ 
    var lang = '<?php echo $lang; ?>'; 
    $('.cal-loading').fadeIn('fast');  
     var type = $('#arrange').val();
     var id_product_line = 5;
    $.ajax({
        type:'POST',
        url: "<?php echo CController::createUrl('shopping/searchTypeProduct')?>",
        data:{"curpage": curpage,"type": type, 'id_product_line':id_product_line,'lang':lang},
        success:function(data){
            $('#content_product').html(data);
        },
        error: function(data){
            console.log("error");
            console.log(data);
        }
    });      
}
</script>