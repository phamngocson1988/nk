<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/owl-carousel/owl.carousel.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/owl-carousel/owl.carousel.js"></script>
<style type="text/css">
	.thumbail{
		width: 100% !important;
	}
	.img-main{
		width: 100% !important;
	}
	#thumbail div{ 	
		padding-right: 0px;
	}
	.defaulf-padding-left{
		padding-left: 0px;
	}
	.name_product{
		font-weight: bold;
   		font-size: 30px;
	}
	.title
	{
		font-size: 17px;
    	font-weight: bold;
	}
	.content_title
	{
		color: #919190;
	}
	.product_item img{
		height: 300px;
		margin-left: 25px;
	}
	.btn{
		font-size: 13px;
	}
	@media only screen and (min-width:300px) and (max-width: 500px){
		.btn{
			font-size: 11px;
		}
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
        $("#img-main").elevateZoom({
        	gallery:'thumbail',
            zoomWindowWidth:300,
            zoomWindowHeight:300,
            zoomWindowFadeIn: 600,
            zoomWindowFadeOut: 600,
            lensFadeIn: 600,
            lensFadeOut: 600
        });
    });
    $("#img-main").bind("click", function(e) {  
	  var ez =   $('#img-main').data('elevateZoom');	
	  $.fancybox(ez.getGalleryList());
	  return false;
	});
</script>

<div class="container">
	<div style="margin-top: 40px" class="row">
	    <div class="col-sm-6" style="color: #19a8e0; font-size: 20px;font-weight: bold;">
	    SẢN PHẨM</div>
	    <div class="search col-sm-6" style="text-align: right; font-size: 12px;color: #ccc">
	        <ul>
	            <li>
	                <div style="border-right: 1px solid; padding-right: 10px;">
	                    <img src="<?php echo Yii::app()->params['image_url']; ?>/images/muasam/icon_search.png" style="width: 25px" />
	                </div>
	            </li>
	            <li>
	                <div>
	                Giỏ hàng : 0 sản phẩm
	                </div>
	            </li>
	        </ul>
	    </div>
	    <div class="clearfix"></div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-5">
			<?php
                $img= ProductImage::model()->findByAttributes(array('id_product' => $list['id']));
                if ($img){
             ?>
			<img id="img-main" style="border: 1px solid #ccc; width:60%;" src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $img['url_action'] ?>/lg/<?php echo $img['name_upload'] ?>" data-zoom-image="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $img['url_action'] ?>/lg/<?php echo $img['name_upload'] ?>" class="img-responsive "/>
			<?php } ?>

			<?php
                $img_thumbail= ProductImage::model()->findAllByAttributes(array('id_product' => $list['id']));
             ?>
			<div style="margin-top: 10px" class="row" id="thumbail">
				<?php foreach ($img_thumbail as $key => $value) { ?>
					<div class="col-xs-3 col-sm-3">
						<a href="#" data-image="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $value['url_action'] ?>/lg/<?php echo $value['name_upload'] ?>" data-zoom-image="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $value['url_action'] ?>/lg/<?php echo $value['name_upload'] ?>">
							<img  style=" height:102px;" class="img-responsive thumbail<?php echo $key;?>" style="border: 1px solid #ccc" src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $value['url_action'] ?>/lg/<?php echo $value['name_upload'] ?>" >
						</a>
					</div>
					
				<?php }  ?>
				
			</div>
			
			<input type="hidden" name="" id="qty" value="1">
			<input type="hidden" name="" id="price" value="<?php echo $list['price'];?>">
			<div class="col-xs-12 col-sm-12 defaulf-padding-left " style="">
				<div class="col-xs-5 col-sm-6 defaulf-padding-left">
					<button style="width: 100%;margin:15px 0px;" type="button" class="btn btn_green" onclick="addShopingCart(<?php echo $list['id'].",  '".$list['name']."', '".$list['price']."' , '".$list['stock']."'" ?>);">MUA NGAY</button>
				</div>
				<div class="col-xs-7 col-sm-6 defaulf-padding-left">
					<button style="margin:15px 0px; width: 100%;" type="button" class="btn btn_green" onclick="addExpressShopingCart(<?php echo $list['id'].",  '".$list['name']."', '".$list['price']."' , '".$list['stock']."'" ?>);" >THÊM VÀO GIỎ HÀNG</button>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-7 row">
			<p class="name_product"><?php echo $list['name'] ?></p>
			<div class="row" style="margin-top: 30px">
				<div class="col-xs-6 col-sm-6">
					<p class="title">Giá tiền</p>
					<p class="content_title" style="color: red; font-size: 20px; "><?php echo number_format($list['price'],0, ',', '.');?> VNĐ</p>
				</div>
				
				<div class="col-xs-6 col-sm-6">
					 <div class="weight">
						<p class="title">Trọng lượng</p>
						<p class="content_title"><?php echo $list['unit'] ?></p>
					</div>
				</div>
				<div class="col-xs-12 ">
					<p class="title">Công dụng</p>
					<div class="content_title " >
						<?php echo $list['description'] ?>
					</div>
				</div>
				<div class="col-xs-12 " >
					<p class="title">Thông tin chi tiết</p>
					<div class="content_title "><?php echo $list['instruction'] ?></div>
				</div>

			</div>
		</div>
	</div>
	<div class="row" style="padding-left: 15px;margin-top: 60px;margin-bottom: 30px">
		<p style="font-size: 25px;font-weight: bold;">Sản phẩm cùng loại</p>
		<?php
			$product_line =  $list['id_product_line'];
	   		$idSP =  $list['id'];
		 	$sort = Product::model()->productSort($product_line, $idSP);
		?>

		<div class="row  owl-carousel" id="product_list">
		<?php  foreach ($sort as $key => $v) { ?>
			<div class="item ">
				<div class="product_item">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/detailproduct/index?id=<?php echo $v['id'] ?>"><img  class="img-responsive"  src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $v['url_action'] ?>/lg/<?php echo $v['name_upload'] ?>" > </a>
					<div align="center" class="product_title">
		                <p class="name"><?php echo $v['name']; ?></p>
		                <p style="color: #9ec63b">VND <?php echo number_format($v['price'],0, ',', '.');?></p>
	            	</div>
				</div>
			</div>
		<?php } ?>
		</div> <!-- product_list-->
	</div> <!-- row-->
</div>
<script type="text/javascript">
$(document).ready(function() {
      var owl = $("#product_list");
      owl.owlCarousel({
      autoPlay: 3000,
      items : 4, 
      itemsDesktop : [1000,4], 
      itemsDesktopSmall : [900,3],
      itemsTablet: [600,1], 
      itemsMobile : [400,1] 
      });
      
});
				
</script>
<script>
	function addShopingCart(idProduct,name, price, stock){
		var qty = $('#qty').val();
		var price =   $('#price').val();
		var amount = parseInt(qty)*parseInt(price);
    	jQuery.ajax({
                type : "POST",
                url : "<?php echo CController::createUrl("detailproduct/addShoppingCart");?>",
                data : {
                    "idProduct" : idProduct,
                    "name"      : name,
                    "price"     : price,
                    "qty"		: qty,
                    "amount"	: amount,
                    "stock"    	: stock,
                    },
                    success : function(data){
                    	if(data == -1){
                    		$("#login-customer-modal").modal({backdrop: true});
                    	}else{
                    		console.log(data);
                           window.location.href = '<?php echo CController::createUrl("detailproduct/cart");?>'; 
                        }
                    },
    	});
	}

	function addExpressShopingCart(idProduct,name,price, stock){
		var qty = $('#qty').val();
		var price =   $('#price').val();
		var amount = parseInt(qty)*parseInt(price);
        jQuery.ajax({
            type : "POST",
            url : "<?php echo CController::createUrl("detailproduct/addShoppingCart");?>",
            data : {
			    "idProduct" : idProduct,
                "name"      : name,
                "price"     : price,
                "qty"		: qty,
                "amount"	: amount,
                "stock"    	: stock,

            },

            success : function(data){
                	if(data == -1){
            			$("#login-customer-modal").modal({backdrop: true});
            		}else{

                         var r = confirm("Đã lưu sản phẩm vào giỏ hàng. \n \nBạn có muốn kiểm tra giỏ hàng ngay bây giờ không?");
                         if (r == true) {
                         	console.log(data);
                            	window.location.href = '<?php echo CController::createUrl("detailproduct/cart");?>';      
                         }
                    }
             },

		});
	}
</script>