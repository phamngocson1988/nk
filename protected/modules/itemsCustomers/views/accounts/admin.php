<?php
$baseUrl = Yii::app()->getBaseUrl();
?>
<!-- Le Minh Vuong -->
<link rel="stylesheet" href="<?php echo $baseUrl; ?>/js/daterangepicker/daterangepicker.css" type="text/css">

<script type="text/javascript" src='<?php echo $baseUrl; ?>/js/daterangepicker/daterangepicker.js'></script>

<!-- bootstrap-fileinput-master -->
<link href="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/sortable.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/fileinput.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/theme.js"></script>
<!-- end bootstrap-fileinput-master -->

<script src="<?php echo Yii::app()->baseUrl.'/ckeditor/ckeditor.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/webcam/webcam.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/html2canvas.js"></script>

<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-typeahead.js"></script>

<style type="text/css">

#leftsidebar{
    background-color: #f1f5f7;
}
#profileSideNav ul li a i{
    font-size:2em;  
}
</style>

<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>

    <!-- Contact Customers -->
    <div id="customers" class="tab-pane full-height active">
        <div class="row-fluid full-height">
            <div id="customerContent" class="content">
                <div class="row">
                    <div class="customerListContainer col-sm-3 col-md-3 hidden" >
                        <div style="margin:0px 2em;">
                            <div class="customersActionHolder">
                                <h3>Danh sách</h3>
                                <!-- <a class="btn_plus" id="newCustomer" data-placement="right" data-original-title="Thêm khách hàng"></a> -->
                                <div class="clearfix"></div>
                            </div>

                            <!--moved add new customer-->

                            <!--moved advance search-->

                            <div class="customerSearchHolder">
                                <div id="customer-search-textbox">
                                    <input type="text" onkeypress="runScript_search(event);" id="searchNameCustomer" class="customerSearch fl blue_focus " value="<?php if($code_number) echo $code_number;?>" placeholder="Tìm kiếm...">
                                    <input type="hidden" id="searchSortCustomer" value="0">
                                    <i class="icon-sort-down fr noDisplay" id="advanced-search-PopUp" style="position:absolute;left:227px;margin-top: 7px;cursor: pointer;"></i>
                                </div>
                                    
                                <!--moved button advance search-->  
                                    
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

                            <div id="customerListHolder" class="customerListHolder">
                                <ul id="customerList"></ul>

                                <div id="loadding" class="hidden" style="text-align: center;font-weight:bold;">
                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    <span>Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Detail Customer -->
                    <div id="detailCustomer" class="col-md-12">
                        <a class="btn_plus" id="newCustomer" data-placement="right" data-original-title="Thêm khách hàng"></a> 

                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#searchCustomerModal">Search</a>

                        <div id="addnewCustomerPopup" class="popover bottom" style="display: none;">
                            <form id="frm-add-customer" onsubmit="return false;" class="form-horizontal">
                                <div class="arrow"></div>
                                <h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px; padding: 8px 14px;">Thêm khách hàng</h3>

                                <div class="popover-content" style="width:225px;">
                                    <input class="form-control" id="customerNewCodeNumber" name="customerNewCodeNumber" placeholder="Mã khách hàng" style="margin-bottom:10px;" type="text" required 
                                        data-toggle="tooltip" data-placement="right" 
                                        title="<?php echo $hintCodeNumber;?>" 
                                        value="<?php echo yii::app()->user->getState('user_branch') . $createCodeNumber;?>" 
                                        oninvalid="this.setCustomValidity('Vui lòng nhập mã khách hàng.')" 
                                        oninput="setCustomValidity('')" 
                                    >

                                    <input type="text" required oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên.')" oninput="setCustomValidity('')" class="form-control" id="customerNewName" name="customerNewName" placeholder="Họ và tên" style="margin-bottom:10px;">

                                    <input type="text" pattern="\d{6,12}" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại.')" oninput="setCustomValidity('')" title="Số điện thoại phải từ 6 đến 12 số." class="form-control" id="customerNewPhone" name="customerNewPhone" placeholder="Số điện thoại" style="margin-bottom:10px;">   

                                    <span class="help-block" id="parsley" style="color: #c72f29;font-weight:bold;"></span>    
                                    <button id="addnewCustomer" class="new-gray-btn new-green-btn">Tạo mới</button>
                                    <button id="cancelNewCustomer" type="reset" class="cancelNewStaff new-gray-btn" style="min-width: 94px;margin-right: 0px;">Hủy</button>
                                </div>
                            </form>
                        </div>

                        <div id="sortLabel" class="sortLabel importAndSort" style="margin-left: 15px; display: inline-block;">
                            <i class="fa fa-list"></i>                                            
                        </div> 

                        <div id="searchCustomerPopup" class="popover bottom open">
                            <div class="popover-content">

                                <h5>SẮP XẾP</h5>

                                <input class="SortBy" type="radio" name="sort" value="0" checked onkeypress="runScript_search(event);"> Sắp xếp theo lịch hẹn<br>
                                <input class="SortBy" type="radio" name="sort" value="1" onkeypress="runScript_search(event);"> Sắp xếp theo họ và tên<br>
                                <input class="SortBy" type="radio" name="sort" value="2" onkeypress="runScript_search(event);"> Sắp xếp theo mã số<br>                                

                                <h5>TÌM KIẾM</h5>

                                <input id="iptSearchEmail" class="form-control" type="text" placeholder="Email" onkeypress="runScript_search(event);">
                                
                                <?php
                                    $list_country = array(); 
                                    foreach($model->getListCountry() as $value){
                                        $list_country[$value['code']] = $value['country'];
                                    }
                                    echo CHtml::dropDownList('iptSearchCountry','',$list_country,array('class'=>'form-control','empty' => 'Chọn quốc tịch','onkeypress' => 'runScript_search(event);'));
                                ?> 
                                <input id="iptSearchIdentityCardNumber" class="form-control" type="text" placeholder="CMND/Passport" onkeypress="runScript_search(event);">
                                <?php
                                $list_source = array();                          
                                foreach($model->getListSource() as $value){
                                    $list_source[$value['id']] = $value['name'];
                                }                               
                                echo CHtml::dropDownList('iptSearchSource','',$list_source,array('class'=>'form-control','empty' => 'Chọn nguồn','onkeypress' => 'runScript_search(event);'));
                                ?>  
                                <?php                   
                                $list_segment = array();                                       
                                foreach($model->getListSegment() as $value){
                                    $list_segment[$value['id']] = $value['name'];
                                }                                     
                                echo CHtml::dropDownList('iptSearchSegment','',$list_segment,array('class'=>'form-control','empty' => 'Chọn nhóm','onkeypress' => 'runScript_search(event);'));
                                ?>  

                                <button onclick="advanceSearch();" class="new-gray-btn new-green-btn">TÌM</button>
                            </div>
                        </div>
                        
                        <?php include('customer_default.php'); ?>
                    </div>

                    <div class="clearfix"></div>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div id="searchCustomerModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-body">
                <input type="text" id="txtSearchCustomer" placeholder="nhập tên khách hàng">
                <p id="searchProcess">Kết quả...</p>
                <div id="searchCustomerResult"></div>
            </div>
        </div>
    </div>

<!-- ko bit de lam gi  Complete settings -->
    <!-- <div class="tab-pane full-height" id="settings">
        <div class="row-fluid full-height">
            <div id="settingsSideNav" class="span1 primary-navbar"></div>
            <div id="settingsTabContent" class="tab-content full-height">
                <div class="tab-pane full-height" id="staff">
                    <div id="staffSideList" class="span3 secondary-navbar container-fluid"></div>
                    <div class="span9 detail-wrapper">
                        <div id="staffContentNav" class="detail-navbar container-fluid"></div>

                        <div class="container-fluid staff-details-container">
                            <div class="tab-content">
                                <div class="tab-pane" id="staff-details"></div>
                                <div class="tab-pane" id="staff-services"></div>
                                <div class="tab-pane" id="staff-hours"></div>
                                <div class="tab-pane" id="staff-break"></div>
                                <div class="tab-pane" id="staff-timeoff" style="padding-bottom: 100px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane full-height" id="accounts">
                    <div id="accountsSideNav" class="span3 secondary-navbar container-fluid"></div>

                    <div class="tab-content">
                        <div class="tab-pane active" id="preferences"></div>
                        <div class="tab-pane" id="payment_integration"></div>
                        <div class="tab-pane" id="billing_history">
                            <div align="center" class="setmoreHorizontalLoader">
                                <img src="<?php echo Yii::app()->params['image_url']; ?>/images/setmore-loader.gif">
                            </div>
                            <div align="center" class="setmoreHorizontalLoaderContent">Loading please wait...</div>
                        </div>

                        <div class="tab-pane" id="export_schedule">
                            <div align="center" class="setmoreHorizontalLoader">
                                <img src="<?php echo Yii::app()->params['image_url']; ?>/images/setmore-loader.gif">
                            </div>
                            <div align="center" class="setmoreHorizontalLoaderContent">Loading please wait...</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane full-height" id="services">
                    <div id="services-category" class="span3 secondary-navbar container-fluid full-height"></div>
                    <div class="span9 detail-wrapper">
                        <div id="servicesListHeader" class="detail-navbar container-fluid"></div>
                        <div class="row-fluid position-relative full-height">
                          <ul id="servicesList" class="stacked-list service-list full-height"></ul>
                          <div id="serviceDetails" class="full-height service-info-holder row-fluid" style="display:none;"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane full-height" id="classesSetting">
                    <div id="classCategoryList" class="span3 secondary-navbar container-fluid full-height"></div>
                    <div class="span9 detail-wrapper">
                        <div id="classCategoryHeader" class="detail-navbar container-fluid"></div>
                        <div class="row-fluid position-relative classDetailsContainer">
                            <ul id="settingsClassesList" class="stacked-list class-list full-height"></ul>
                            <div id="classDetails" class="full-height row-fluid" style="display:none;">
                                <div class="span6 class-details-container full-height" id="classDetailsHolder"></div>
                                <div class="span6 class-timings-list">
                                    <div class="class-timings-header container-fluid full-height" id="classTimingHeader"></div>
                                    <ul class="class-date-time stacked-list row-fluid" id="classApptList"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane full-height active" id="payments">
                    <div id="paymentsSideNav" class="span3 secondary-navbar container-fluid full-height"></div>
                    <div class="tab-content full-height">
                        <div class="tab-pane active" id="paymentConfigureHolder"></div>
                        <div class="tab-pane " id="paymentHistory">
                            <div class="span8 detial-header-wraper">
                                <div class="detail-navbar container-fluid">
                                    <h3>Payment Transaction History</h3>
                                </div>
                                <div class="container-fluid payment-history-container" id="paymentHistoryHolder"></div>
                            </div>
                        </div>
                        <div class="tab-pane " id="paymentBookingPage">
                            <div class="span8 detial-header-wraper">
                                <div class="detail-navbar container-fluid">
                                    <h3>Get Paid from Your Booking Page</h3>
                                </div>
                                <div class="container-fluid payment-config-contianer" id="paymentBookingPageHolder"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane full-height active" id="notifications"></div>
            </div>
        </div>
    </div> -->

    <!-- Complete dashBoard -->
    <!-- <div class="tab-pane full-height" id="dashboard">
    </div> -->

<?php 

if (isset($_GET['code_number'])) {
	echo '<script>
			$( document ).ready(function() {
				searchCustomers();
			});
		</script>';
}

?>


<script type="text/javascript">
    
$(window).resize(function() {
    var windowHeight =  $(window).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();
    var customer_action = $(".customersActionHolder").height();  
    var customer_search = $(".customerSearchHolder").height();

    $('#profileSideNav').height(windowHeight-header);
    $('.statsTabContent').height(windowHeight-header-tab_menu - 45);     
    $('#customerList').css('max-height', windowHeight-header-customer_action-customer_search-80);
});

$( document ).ready(function() {

    var windowHeight =  $(window).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();
    var customer_action = $(".customersActionHolder").height();    
    var customer_search = $(".customerSearchHolder").height();

    $('#profileSideNav').height(windowHeight - header + 50);

   $('.statsTabContent').height(windowHeight-header-tab_menu-45);   
   

   $('#customerList').css('max-height', windowHeight-header-customer_action-customer_search-80);
   

});

$( document ).ready(function() {
    //searchCustomers();
    $('.cal-loading').fadeOut('fast'); 
});

</script>


<?php include('_style.php'); ?>
<?php include('_js.php'); ?>