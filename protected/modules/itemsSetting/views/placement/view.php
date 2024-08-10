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
<!-- Contact Customers -->
<div id="customers" class="tab-pane full-height active">
    <div class="row-fluid full-height">

        <div id="customerContent" class="content">
            <div class="row">
                <div class="customerListContainer col-sm-3 col-md-3" >
                    <div style="margin:0px 2em;">
						<div class="customersActionHolder">
							<?php 
								//$totalCustomers = $model->findAll();
							?>
							<h3>Danh sách</h3>
							<a class="btn_plus" id="newCustomer" data-delay="0" data-placement="right" data-original-title="Thêm Nhân Viên"></a>
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
								<h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Thêm Ghế</h3>
								<div class="popover-content" style="width:225px;">
									<input type="text" required oninvalid="this.setCustomValidity('Vui lòng nhập tên ghế.')" oninput="setCustomValidity('')" class="form-control" name="name_chair" placeholder="Tên ghế" style="margin-bottom:10px;">
									<select name='type_branch' class="form-control" style="margin-bottom:10px;">
									<?php
									foreach(Branch::model()->findAll('status=:st',array(':st'=>1)) as $temp){?>
									    <option value='<?php echo $temp['id'];?>'><?php echo $temp['name'];?></option>
									<?php }?>
									</select>
									<select name='type_chair' class="form-control" style="margin-bottom:10px;">
									    <option value='2'>Ghế điều trị</option>
										<option value='1'>Ghế khám</option>
									</select>
									<span class="help-block" id="parsley" style="color: #c72f29;font-weight:bold;"></span>                                     
									<button type='submit' id="addnewCustomer" class="new-gray-btn new-green-btn">Tạo mới</button>
									<button id="cancelNewCustomer" type="reset" class="cancelNewStaff new-gray-btn" style="min-width: 94px;margin-right: 0px;">Hủy</button>
								</div>
							</form>
						</div>

						<div id="searchCustomerPopup" class="popover bottom open" style="display: none;">                                               
									 
							<div class="popover-content">

								<h5>TÌM KIẾM</h5>
                                
								<?php
								
								
								$list_group = array(); 
								foreach(Branch::model()->findAll('status=:st',array(':st'=>1)) as $temp){
									$list_group[$temp['id']] = $temp['name'];
								}
								echo CHtml::dropDownList('iptSearchBranch','',$list_group,array('class'=>'form-control','empty' => 'Chọn chi nhánh'));
								
								$list_branch = array();
								$list_branch[1] = "Ghế khám ";
								$list_branch[2] = "Ghế điều trị";
								echo CHtml::dropDownList('iptSearchGhe','',$list_branch,array('class'=>'form-control','empty' => 'Chọn loại ghế'));
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
