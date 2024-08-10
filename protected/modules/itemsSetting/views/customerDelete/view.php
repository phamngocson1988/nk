
<style>
#detail_customer{overflow:auto;}
.fix_bottom {position: fixed;bottom: 2%;right: 40%;}
</style>
<div class="col-xs-12" style="margin-top: 20px;">
	<div class="col-xs-6">
		<p style="font-size: 20px;">DANH SÁCH KHÁCH HÀNG ĐÃ XÓA</p>
	</div>
	<div class="col-xs-6">
		<div class="input-group" style="display:inline-flex;width:300px;margin-right:30px;float: right;">
          <input type="text" class="form-control"  id="searchCode" placeholder="Tìm kiếm theo mã và tên khách hàng">
          <div class="input-group-addon" onclick="searchCustomer();" id="glyphicon-search" style="padding-right:25px;cursor:pointer;"><span class="glyphicon glyphicon-search"></span></div>
        </div>
	</div>
</div>

<div class="col-xs-12"  id="detail_customer" style="margin-top: 20px;">

</div>
<script>
	var baseUrl = '<?php echo Yii::app()->request->baseUrl; ?>';

	function searchCustomer(page){
		$('.cal-loading').fadeIn('fast');
		var searchCode = $('#searchCode').val();
	 	$.ajax({ 
	       	type     :"POST",
	        url: baseUrl+'/itemsSetting/CustomerDelete/searchCustomer',
	       	data: {
					searchCode 	: searchCode,
					page    	: page,			
	       	},
	       	success: function (data) {
	       		$('.cal-loading').fadeOut('slow');  
	       		$('#detail_customer').html(data);
	       	},
	    });

	}


$(document).ready(function(){
	searchCustomer(1);
});

    $(window).resize(function() {
        var windowHeight =  $( window ).height();
        var header       = $("#headerMenu").height();
    
         $('#detail_customer').height( windowHeight-header-100);
        
        
    });

    $( document ).ready(function() {
        var windowHeight =  $( window ).height();
        var header       = $("#headerMenu").height();
        $('#detail_customer').height(windowHeight-header-100);
        
    });
</script>