<?php include 'add_deals.php'; ?>
<style type="text/css">
.deals_tbl .tbhead{
	color: #fff;
    background-color: rgba(115, 149, 158, 0.80);
}	
</style>
	
	

		<table id="tbl_deal" class="table table-striped deals_tbl ">
			<thead class="tbhead">
				
				<th style="width:10%; text-align: left;">Hình ảnh</th>
				<th style="width:22%; text-align: left;">Tên chương trình</th>
				<th style="width:15%; text-align: left;">Trạng thái</th>
				
				<th style="width:15%; text-align: left;">Ngày bắt đầu</th>
				<th style="width:15%; text-align: left;">Ngày kết thúc</th>
				<th style="width:23%; text-align: left;">Loại khuyến mãi</th>
				
				
			</thead>
			<tbody id="t_bd" class="tbody">

				<?php 
				$model = new PromotionProduct();
				foreach ($model->getget() as $k=>$v){ ?>
				<tr class="sss" onclick="collapse(<?php echo $v['id']; ?>)" >
					
					<td style="width:10%;"> 
						<img  src="<?php echo Yii::app()->request->baseUrl;?>/upload/deals/lg/<?php if($v['images']!=""){echo $v['images'];}else{echo 'placeholder_70x70.gif';} ?> " id="file_preview_1" style="width:40px; height:40px; border-radius:100%;" >
					</td>
					<td style="width:22%;padding-top: 20px;"><?php echo $v['name'] ?></td>
					<td style="width:15%;padding-top: 20px;">
						<?php if($v['status']==1){echo 'Đang duyệt';}
    						  elseif($v['status']==2){ echo 'Khởi động'; } 
    						   elseif($v['status']==3){ echo 'Tạm dừng'; }
    						    elseif($v['status']==4){ echo 'Kết thúc'; }
    						    else{ echo "Xóa"; } 
    						  ?>
	                       
	                  
					</td>
					
					<td style="width:14%;padding-top: 20px;"><?php echo $v['start_date']; ?></td>
					<td style="width:14%;padding-top: 20px;"><?php echo $v['end_date']; ?></td>
					<td style="width:22%;padding-top: 20px;"> 
						<?php 
								 if($v['type_price']==1){echo 'Phần trăm (%)';}
								 elseif($v['type_price']==2){echo 'Giảm theo số tiền';}
								 elseif($v['type_price']==3){echo 'Giảm giá cố định';}
								 else{echo 'Giảm theo giá trị';}
						?>
                       
				</td>
					 	
					
				</tr>
				<tr id="collapse<?php echo $v['id']; ?>" class="   collapse trdetail">
					
						<?php /*include'detail_promotion.php';*/ ?>

		      </tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	
		


<script type="text/javascript">

		function collapse(id){

			$.ajax({
	        type:'POST',
	        url: baseUrl+'/itemsSales/Deals/Detailpromotion',   
	        data: {"id":id,'stt':1},  

	        success:function(data){
	        	
	           $('#collapse'+id).html(data);
				$('#collapse'+id).collapse('toggle');

	        },
	        error: function(data){
	        console.log("error");
	        console.log(data);
	        }
	    });
			 var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var head = $('.head').height();
    var tbhead  = $('.tbhead').height();
    $('#t_bd').height(windowHeight-header-head-tbhead-30);
    $('#profileSideNav').height(windowHeight-header);
    $('.customerListContainer').height(windowHeight-header);
    $('#detailCustomer').height(windowHeight-header);
	}
	$( document ).ready(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var head = $('.head').height();
    var tbhead  = $('.tbhead').height();
    $('#t_bd').height(windowHeight-header-head-tbhead-30);
    $('#profileSideNav').height(windowHeight-header);
    $('.customerListContainer').height(windowHeight-header);
    $('#detailCustomer').height(windowHeight-header);
    $('.cal-loading').fadeOut('slow');

});
	$(window).resize(function() {
     var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var head = $('.head').height();
    var tbhead  = $('.tbhead').height();
    $('#t_bd').height(windowHeight-header-head-tbhead-30);
    $('#profileSideNav').height(windowHeight-header);
    $('.customerListContainer').height(windowHeight-header);
    $('#detailCustomer').height(windowHeight-header);

});
	$('.collapse').on('show.bs.collapse', function () {    
    $('.collapse.in').collapse('hide');   
});
	
</script>