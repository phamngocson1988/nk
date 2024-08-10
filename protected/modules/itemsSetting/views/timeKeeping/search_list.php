<style>
	#customerList{
		list-style-type:none;
		padding:0 
	}
	.hover_dc_back{
		background:rgba(68, 68, 68, 0.1)
	}
	.hover_dc_label{
		color:#000
	}
</style>
 <?php $baseUrl = Yii::app()->baseUrl;?>
 
 <ul id="customerList">
                                       
        <?php  
        if(!empty($list_data['data']))
        {?>
	        <!--
	        <li id="c0" onclick="detailCustomer(0);"  class="n" >                
				<span class="jqTransformCheckboxWrapper" style="display:none;">
					<a href="#" class="jqTransformCheckbox"></a>
				</span>
				<label class="fl" style='font-size: 17px;font-weight: 600;'>Tất cả ( <?php echo count($list_data['data']);?> ) </label>
				<div class="clearfix"></div>
			</li>-->
        <?php	
		$click_member = 'click_member';
        foreach($list_data['data'] as $k=> $value)
        {
        ?>
        <li id="c<?php echo $value['id'];?>" onclick="detailCustomer(<?php echo $value['id'];?>);"  class="n <?php echo $click_member;?>" >
                                        
			<span class="jqTransformCheckboxWrapper" style="display:none;">
				<a href="#" class="jqTransformCheckbox"></a>
				<input type="checkbox" value="<?php echo $value['id'];?>" class="fl" style="display : none;">
			</span>
			
			<img src="<?php echo $baseUrl; ?><?php if($value['image']!="") echo '/upload/users/sm/'.$value['image']; else echo "/upload/users/no_avatar.png";?>" class="fl" style="border-radius:100%;">
			<label class="fl"><?php echo $value['name'];?> </label>

			<div class="clearfix"></div>
        </li>

        <?php
		$click_member = '';
        }}else{   
        ?>
        <li>Không Tìm Thấy Khách Hàng!!!</li>
        <?php }?>
</ul>
<script type="text/javascript">
$(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#navbar-collapse").height();
    var title = $('.input-group').height();

    $('#customerList').height(windowHeight-header-title-32);
    
});
$( document ).ready(function() { 
 
	$('.click_member').click();
    var windowHeight =  $( window ).height();
    var header       = $("#navbar-collapse").height();
    var title = $('.input-group').height();

    $('#customerList').height(windowHeight-header-title-32);
    
});

function detailCustomer(id){
	$('.n').removeClass("active");
	//$('.n').find('.fl').removeClass("hover_dc_label");
	$('#c'+id).addClass("active");

	$.ajax({
		type:'POST',
		url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/searchListComison', 	
		data: {
			"id":id,
		},   
		success:function(data){
			if(  data != '-1'){
				jQuery("#height_service").fadeOut( 100 , function() {
					jQuery(this).html( data);
				}).fadeIn( 600 );
			}else{
				alert('Không có dữ liệu !!!');
			}
			$('#searchService2').val('');
		},
		error: function(data){
		console.log("error");
		console.log(data);
		}
	});
}
</script>


