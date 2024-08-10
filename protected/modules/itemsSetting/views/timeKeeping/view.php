<style>
#searchCustomerPopup input, #searchCustomerPopup select {
    margin-bottom: 10px;
} 
</style>

<div class='row'>
    <div class='col-md-3 col-sm-3' style='background-color:#f1f5f7;'>
		<div class="input-group" style="display:inline-flex;padding-top:24px;width:100%"> 
			<!--
			<input type="text" class="form-control" id="searchService" placeholder="Tìm tên nhân viên">
			<div class="input-group-addon" onclick="searchService();" id="glyphicon-search" style="padding-right:25px;cursor:pointer;">
			<span class="glyphicon glyphicon-search"></span>
			</div>-->
			<div id="searchCustomerPopup" class="popover bottom open" style="display: none">                                               
									 
				<div class="popover-content">

					<h5>SẮP XẾP</h5>
				   
					<input class="SortBy" type="radio" name="sort" value="1" checked> Sắp xếp theo họ và tên<br>
					<input class="SortBy" type="radio" name="sort" value="2"> Sắp xếp theo mã số<br>                                

					<h5>TÌM KIẾM</h5>

					<?php
					$list_branch = array();
					$list_branch[1] = "Cơ sở 1";
					$list_branch[2] = "Cơ sở 2";
					echo CHtml::dropDownList('iptSearchBranch','',$list_branch,array('class'=>'form-control','empty' => 'Chọn cơ sở'));
					?> 

					<?php

					$list_group = array(); 
				   
					foreach(GpGroup::model()->findAll() as $temp){
						$list_group[$temp['id']] = $temp['group_name'];
					}
					
					echo CHtml::dropDownList('iptSearchGroup','',$list_group,array('class'=>'form-control','empty' => 'Chọn nhóm','empty' => 'Chọn nhóm'));
					?>                                     

					<?php
					$list_book = array();
					$list_book[0] = "Có";
					$list_book[1] = "Không";
					echo CHtml::dropDownList('iptSearchBook','',$list_book,array('class'=>'form-control','empty' => 'Chọn đặt lịch online'));
					?> 

					<?php
					$list_block = array();
					$list_block[0] = "Not Block";
					$list_block[1] = "Block";
					$list_block[2] = "Delete";
					echo CHtml::dropDownList('iptSearchBlock','',$list_block,array('class'=>'form-control','empty' => 'Chọn trạng thái'));
					?>                                    

					<button onclick="searchListStaffs();" class="new-gray-btn new-green-btn">TÌM</button>
	  
				</div>
 
			</div>
			<div class="customerSearchHolder" style='width:100%'>
				<div id="customer-search-textbox">
					<input type="text" onkeypress="runScript_search(event);" id="searchNameCustomer" class="customerSearch fl blue_focus " value="" placeholder="Tìm kiếm...">
					<input type="hidden" id="searchSortCustomer" value="1">
					<i class="icon-sort-down fr noDisplay" id="advanced-search-PopUp" style="position:absolute;left:227px;margin-top: 7px;cursor: pointer;"></i>
				</div>
					
				<div id="sortLabel" class="sortLabel fr importAndSort">
					<i class="fa fa-list"></i>
				
				</div>
					
				<div class="clearfix"></div>    
				<div id="advancePopup-holder">
					<div class="advanced-search-popup popover bottom">
						<div class="arrow" style="margin-left:82px;"></div>
						<h3 style="background-color: #f8f8f8" class="popover-title">Advanced Search</h3>
						<div class="advanced-search-textarea-holder" style="padding: 10px 40px 0px 12px;">
							<div class="searchByName-input">
								<span><input type="text" placeholder="Search By Name" id="searchByName"></span>
							</div>
							<div class="searchByTag-input">
								<!-- <input type="text" placeholder="Search By Tag" id="searchByTag"> -->
								<div id="advanced-search-tag-view" class="tag-Search-view">
									<ul class="customertags_list" id="customerTagForSearch" style="padding:0px;"></ul>
									<span>
										<input type="text" id="searchByTag" class="tag-input-text" placeholder="Search By Tag">
									</span>
								</div>
							</div>
							<div id="tag-customer-search" class="fl" style="margin-top:9px;margin-left:1px;"></div>
							<div id="btn-advanced-search" style="margin-bottom: 15px;">
								<button id="search-btn-advanced" class="new-gray-btn new-green-btn" style="min-width:115px">Search</button>
								<button id="cancel-btn-advanced" class="new-gray-btn">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<div id="customerListHolder" class="customerListHolder" style='padding-top:10px'>
			
		</div>
	</div>
    <div class='col-md-9 col-sm-9'>
		<div class="t-settings-head">
			<div class="t-settings-head affix-top" data-spy="affix" data-offset-top="105" style="margin-bottom:10px;margin-top:10px;">
				<h2>
				    <div class="input-group" style="display:inline-flex;width:300px;margin-right:30px;">
						<input type="text" class="form-control" id="searchService2" placeholder="Tìm Nhóm Comison">
						<div class="input-group-addon" onclick="searchService2();" id="glyphicon-search" style="padding-right:25px;cursor:pointer;">
						<span class="glyphicon glyphicon-search"></span></div>
					</div>
				    <label class="count" id="countservice"></label>
				    <a id='myBtn' onclick='showAdd();' class="btn_plus" href="javascript:void(0);"></a>
				</h2>
			</div>
		</div>
		<div id='height_service' style='overflow:auto'>
			<?php $this->renderPartial('list_member',array('id_user'=>$id_user,'list_data'=>$list_data,'CsServiceTypeTk'=>$CsServiceTypeTk));?>
		</div>
	</div>
   
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style='background-color:#ffffff;color:#000000'>
			<button type="button" class="close" style='color:#000000' data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Thêm Nhóm Dịch Vụ</h4>
        </div>
        <div class="modal-body content_add"></div>
    </div>
    </div>
</div>

<div class="modal fade" id="myModalUpdate" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style='background-color:#ffffff;color:#000000'>
			<button type="button" class="close" style='color:#000000' data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Chỉnh Sửa Nhóm Dịch Vụ</h4>
        </div> 
        <div class="modal-body content_update"></div>
    </div>
    </div>
</div> 
<script>
$('#sortLabel').click(function(){ 
    var position = $( this ).position(); 
    $('#searchCustomerPopup').css({"width": '100%', "top": 50, "left": 140}).fadeToggle('fast');
});
$('.SortBy').click(function(){
	$("#searchSortCustomer").val($(this).val()); 
});
function runScript_search(e){
	if (e.keyCode == 13) {
        e.preventDefault();
       searchListStaffs();
    }
}
function searchListStaffs(id=''){
    
	var value = $('#searchNameCustomer').val();	
    var id_branch = $('#iptSearchBranch').val();
    var id_group = $('#iptSearchGroup').val();  
    var book_onl = $('#iptSearchBook').val(); 
    var block = $('#iptSearchBlock').val();     
	var type  = $("#searchSortCustomer").val();
    var group_id = <?php  echo Yii::app()->user->getState('group_id'); ?>;
    var id_user = <?php echo Yii::app()->user->getState('user_id'); ?>;
    $('.cal-loading').fadeIn('fast');

    $.ajax({
	    type:'POST',
	    url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/searchList', 	
	    data: {"value":value,"id_branch":id_branch,"id_group":id_group,"book_onl":book_onl,"block":block,"type":type,"group_id":group_id,'id_user':id_user},   
	    success:function(data){
	    	if(data != '-1'){
				jQuery("#customerListHolder").fadeOut( 100 , function() {
					jQuery(this).html( data);
				}).fadeIn( 600 );
				$('.cal-loading').fadeOut('slow');
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
function showAdd(){
	var id_user = $('#id_user').val();
	$.ajax({
		type:'POST',
		url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/addNewTimeKeeping', 
			
		data: {
			"id_user":id_user
		}, 
		success:function(data){
			$("#myModal").modal();
			$(".content_add").html(data);			
		},
		error: function(data){
		console.log("error");
		console.log(data);
		}
	});
}
function searchService(){
	var searchService = $.trim($("#searchService").val());
	$.ajax({
		type:'POST',
		url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/searchList', 
				
		data: {
			"searchService":searchService,
		},   
		success:function(data){
			if(  data != '-1'){
				jQuery("#customerListHolder").fadeOut( 100 , function() {
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
function searchService2(){
	var searchService2 = $.trim($("#searchService2").val());
	var id_user = $('#id_user').val();
	$.ajax({
		type:'POST',
		url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/searchList2', 
				
		data: {
			"searchService2":searchService2,
			"id_user":id_user,
		},   
		success:function(data){
			if(  data != '-1'){
				jQuery("#height_service").fadeOut( 100 , function() {
					jQuery(this).html( data);
				}).fadeIn( 600 );
			}else{
				alert('Không có dữ liệu !!!');
			}
		},
		error: function(data){
		console.log("error");
		console.log(data);
		}
	});
}
function change_percen(){
	var id_user = $.trim($("#id_user").val());
    var id_service_type = $.trim($("#id_service_type").val());
	var text_change = $.trim($("#text_change").val());
	//var but_cus = $('#id_cusser_'+id_user);
	$.ajax({
		type:'POST',
		url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/changePercent', 
				
		data: {
			"text_change":text_change,
			"id_user":id_user,
			"id_service_type":id_service_type
		},   
		success:function(data){
			$('#id_cusser_'+id_user+'_'+id_service_type).html(data);
			$("#cusser_close").click();
			//$("#myModal").modal();
			//$(".content_add").html(data);			
		},
		error: function(data){
		console.log("error");
		console.log(data);
		}
	});
}

$(document).ready(function(){
	searchListStaffs();
	var windowHeight =  $( window ).height();
	var headerMenu   =  $('#headerMenu').height();
    var header       = $(".t-settings-head").height();

    $('#height_service').height(windowHeight-header-headerMenu-33); 
    $(".myBtnChange").click(function(){ 
	    var str = $.trim($(this).html());
		var str2 = $(this).val();
	    $("#myModal2").modal();
        $("#text_change").val(str);
        $("#id_user").val(str2.split("|")[1]); 	
        $("#id_service_type").val(str2.split("|")[0]);		
        //alert(str.split("|")[1]);		
    });
});
$(window).resize(function() {
	var windowHeight =  $( window ).height();
	var headerMenu   =  $('#headerMenu').height();
    var header       = $(".t-settings-head").height();

    $('#height_service').height(windowHeight-header-headerMenu-33);
});
</script>