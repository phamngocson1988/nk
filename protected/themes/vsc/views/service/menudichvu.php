<div id="ns_srch_tt">
	<h4 style="cursor:pointer" onclick="ve_trang();">- DỊCH VỤ HIỆN CÓ -</h4>
</div>
<div id="wrapper">
	<dl>
	<?php
		$type_service = Service::model()->findAll();
		foreach($type_service as $item){ 
	?>
		<dt><a onclick="chuyen_nd_2(<?php echo $item['id']?>);"><?php echo $item['name'];?></a></dt>
	<?php } ?>
	</dl>
</div>

<script type="text/javascript">

function ve_trang(){
	window.location = '/nhakhoa2000/dich-vu';
}

function chuyen_nd_2(id){
	jQuery.ajax({
        type:"POST",
        url:"<?php echo CController::createUrl('service/detailservice_type')?>",
		data        : { 
                          "id": id,          
                      },
        success:function(data){
			
           $("#nd_datail").html(data);
        } 
    });
}

</script>