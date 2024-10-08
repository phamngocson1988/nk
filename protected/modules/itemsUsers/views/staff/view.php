<?php $baseUrl = Yii::app()->baseUrl;?>
<!--Font Awesome and Bootstrap Main css  -->


<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jqtransform.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/setting.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/customers_new.css" />

<link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/bootstrap-multiselect.css" type="text/css"/>

<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>

<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-multiselect.js"></script>
<style type="text/css">
#profileSideNav ul li a i{
    font-size:2em;  
}
 #tabcontent {
    padding: 30px 30px 10px 30px;
} 

</style>
 <?php $group_id =  Yii::app()->user->getState('group_id');?>
<!-- Contact Customers -->
<div id="customers" class="tab-pane full-height active">
    <div class="row-fluid full-height">

        <div id="customerContent" class="content">
            <div class="row">
                <div class="customerListContainer col-sm-3 col-md-3" >
                    <div style="margin:0px 2em;">
						<div class="customersActionHolder">

							<h3>Danh sách</h3>
							<?php if($group_id != 18 ){ ?>
								<a class="btn_plus" id="newCustomer" data-delay="0" data-placement="right" data-original-title="Thêm Nhân Viên"></a>
							<?php } ?>
							<div id="importExportLabel" class="importLabel fr importAndSort blue_glowb hide">
								Import/Export
								<ul id="importExportOptionList">
									<li id="import"> Import </li>
									<li id="export"> Export All </li>
								</ul>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="addnewCustomerPopup" class="popover bottom" style="display: none;">
							<form id="frm-add-customer" onsubmit="return false;" class="form-horizontal">
								<div class="arrow"></div>
								<h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Thêm Nhân Viên</h3>
								<div class="popover-content" style="width:225px;">
									<input type="text" required oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên.')" oninput="setCustomValidity('')" class="form-control" name="staffNewName" placeholder="Họ và tên" style="margin-bottom:10px;">
									<input type="text" required oninvalid="this.setCustomValidity('Vui lòng nhập tài khoản.')" oninput="setCustomValidity('')" class="form-control" name="staffNewAccount" placeholder="Tài khoản" style="margin-bottom:10px;">
									<input type="password" required oninvalid="this.setCustomValidity('Vui lòng nhập mật khẩu.')" oninput="setCustomValidity('')" class="form-control" name="staffNewPassword" placeholder="Mật khẩu" style="margin-bottom:10px;"> 
									<?php
									$list_group = array();
									
									foreach(GpGroup::model()->findAll() as $value){
										$list_group[$value['id']] = $value['group_name'];
									}
									
									echo CHtml::dropDownList('staffNewGroupId','',$list_group,array('required'=>'required','class'=>'form-control','empty'=>'Chọn nhóm','style'=>'margin-bottom:10px;'));
									?>        
									<span class="help-block" id="parsley" style="color: #c72f29;font-weight:bold;"></span>                                     
									<button id="addnewCustomer" class="new-gray-btn new-green-btn">Tạo mới</button>
									<button id="cancelNewCustomer" type="reset" class="cancelNewStaff new-gray-btn" style="min-width: 94px;margin-right: 0px;">Hủy</button>
								</div>
							</form>
						</div>

						<div id="searchCustomerPopup" class="popover bottom open" style="display: none;">                                               
									 
							<div class="popover-content">

								<h5>SẮP XẾP</h5>
							   
								<input class="SortBy" type="radio" name="sort" value="1" checked> Sắp xếp theo họ và tên<br>
								<input class="SortBy" type="radio" name="sort" value="2"> Sắp xếp theo mã số<br>                                
								<input class="SortBy" type="radio" name="sort" value="4"> Tìm theo code<br>                                

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

						<div class="customerSearchHolder">
							<div id="customer-search-textbox">
								<input type="text" onkeypress="runScript_search(event);" id="searchNameCustomer" class="customerSearch fl blue_focus " value="" placeholder="Tìm kiếm...">
								<input type="hidden" id="searchSortCustomer" value="1">
								<i class="icon-sort-down fr noDisplay" id="advanced-search-PopUp" style="position:absolute;left:227px;margin-top: 7px;cursor: pointer;"></i>
							</div>
								
							<div id="sortLabel" class="sortLabel fr importAndSort">
								<i class="fa fa-list"></i>
							<!--<ul id="sortOptionList">
									<li class="SortBy" class="sort-customers-option"><input type="hidden" value="1">Theo Họ và Tên </li>
									<li class="SortBy" class="sort-customers-option"><input type="hidden" value="3">Theo điện thoại </li>
									<li class="SortBy" class="sort-customers-option"><input type="hidden" value="4">Theo Mã số </li>                                              
								</ul> -->
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

                        <div id="customerListHolder" class="customerListHolder"></div>
                    </div>
                </div>
                <!-- Detail Customer -->
                <div id="detailCustomer" class="col-sm-7 col-md-9"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php include('_style.php'); ?>
<?php include('_js.php'); ?>


<script type="text/javascript">

$(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();

    $('#profileSideNav').height(windowHeight-header);
    $('.customerListContainer').height(windowHeight-header);
    
    $('.statsTabContent').height(windowHeight-header-tab_menu-45);
    
    
});
$( document ).ready(function() {

    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();

    $('#profileSideNav').height(windowHeight-header);
    $('.customerListContainer').height(windowHeight-header);

    $('.statsTabContent').height(windowHeight-header-tab_menu-45);
    $('.cal-loading').fadeOut('slow');

});


</script>
