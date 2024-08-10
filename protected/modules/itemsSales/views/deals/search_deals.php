
<style type="text/css">
.deals_tbl .tbhead{
	color: #fff;
    background-color: rgba(115, 149, 158, 0.80);
}	
</style>
	
	

		<table id="tbl_deal" class="table table-striped deals_tbl ">
			<thead class="tbhead">
				
				<th style="width:10%; text-align: left;">Hình ảnh</th>
				<th style="width:25%; text-align: left;">Tên chương trình</th>
				<th style="width:15%; text-align: left;">Trạng thái</th>
				
				<th style="width:15%; text-align: left;">Ngày bắt đầu</th>
				<th style="width:15%; text-align: left;">Ngày kết thúc</th>
				<th style="width:20%; text-align: left;">Loại khuyến mãi</th>
				
				
			</thead>
			<tbody id="t_bd" class="tbody">

				<?php  
					$model = new PromotionProduct();
			        if(!empty($list_data['data']))
			        {   

			        foreach($list_data['data'] as $k=> $v)
			        {
			        ?>
			      
				<tr class="sss" data-toggle="collapse" data-target="#collapse<?php echo $v['id']; ?>">
					
					<td style="width:10%;"> 
						<img  src="<?php echo Yii::app()->request->baseUrl;?>/upload/deals/lg/<?php if($v['images']!=""){echo $v['images'];}else{echo 'placeholder_70x70.gif';} ?> " id="file_preview_1" style="width:40px; height:40px; border-radius:100%;" >
					</td>
					<td style="width:25%;padding-top: 20px;"><?php echo $v['name'] ?></td>
					<td style="width:15%;padding-top: 20px;">
						<select class="" name="status_deal" disabled=""  style="float: left;
    background-color: #f9f9f9;
    border: 0px;">
	                        <option value="1" <?php if($v['status']==1){echo 'selected';} ?>>Đang duyệt</option>
	                        <option value="2" <?php if($v['status']==2){echo 'selected';} ?>>Khởi động</option>
	                        <option value="3" <?php if($v['status']==3){echo 'selected';} ?>>Tạm dừng</option>
	                        <option value="4" <?php if($v['status']==4){echo 'selected';} ?>>Kết thúc</option>
	                        <option value="-1" <?php if($v['status']==-1){echo 'selected';} ?>>Xóa</option>
	                  </select>
					</td>
					
					<td style="width:14%;padding-top: 20px;"><?php echo $v['start_date']; ?></td>
					<td style="width:14%;padding-top: 20px;"><?php echo $v['end_date']; ?></td>
					<td style="width:20%;padding-top: 20px;"> 
						<select class="" name="type_price" id="type_promotion" onchange="promotion_type()" disabled="" style="float: left;
    background-color: #f9f9f9;
    border: 0px;">
                        <option value="0">Select promotional v</option>
                        <option value="1" <?php if($v['type_price']==1){echo 'selected';} ?>>phần trăm (%)</option>
                        <option value="2" <?php if($v['type_price']==2){echo 'selected';} ?>>giảm theo số tiền</option>
                        <option value="3" <?php if($v['type_price']==3){echo 'selected';} ?>>Bán giá cố định</option>
                        <option value="4" <?php if($v['type_price']==4){echo 'selected';} ?>>Giảm theo giá trị</option>
                  </select>
				</td>
					 	
					
				</tr>
				<tr id="collapse<?php echo $v['id']; ?>" class="   collapse trdetail">
					<td class="" colspan="7">
						<?php include'detail_promotion.php'; ?>
			      	</td>
		      </tr>
			<?php } 
			} ?>
			</tbody>
		</table>
	
	
		


<script type="text/javascript">
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