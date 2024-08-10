<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<?php $this->beginContent('//layouts/layouts_menu'); ?>

<?php
$controller = Yii::app()->getController()->getAction()->controller->id;
$action     = Yii::app()->getController()->getAction()->controller->action->id;
?>


<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jqtransform.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/setting.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/customers_new.css" />
<link rel="stylesheet" href="<?php echo $baseUrl; ?>/js/daterangepicker/daterangepicker.css" type="text/css">

<script type="text/javascript" src='<?php echo $baseUrl; ?>/js/daterangepicker/moment.min.js'></script>

<script type="text/javascript" src='<?php echo $baseUrl; ?>/js/daterangepicker/moment.js'></script>

<script type="text/javascript" src='<?php echo $baseUrl; ?>/js/daterangepicker/daterangepicker.js'></script>
<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>

<style type="text/css">
#profileSideNav {overflow: auto}
#profileSideNav ul li a i{
    font-size:2em;
}
.itemsPromotions li {
    line-height: 24px;
}
#profileSideNav ul li{ margin-top: 0px; }

body {overflow-y: hidden;}

.no_pay {background: #c8c8c8 !important; color: black !important; cursor: not-allowed}

.btn{color: white;}
input {border-radius: 0;}
a {color: black}

#profileSideNav ul li a i{
    font-size:2em; display: block;
}

#oSrchBar{padding: 20px;}

.form-group {margin-right: 10px;}
.hiddenRow { padding: 0 !important; }
.hiddenRow:hover {background: white;}
tr.accordion-toggle {cursor: pointer;}
td.hiddenRow {border: 0 !important;}

.oView {padding: 10px 0;}
.oViewB {background: #f4f7f7; padding: 0 0 15px; margin: 0 0 15px;}
.oViewB .sum td{border: 0;}
.oViewB table.table {background: #f4f7f7;}
.oViewB table.table thead{background: #e1e7eb; color: black;}
.oViewB table tr td, .oViewB table tr th{border: 1px solid white;}

.oViewDetail p {margin-bottom: 5px;}

.oBtnG {background: #c8c8c8}
.oBtnDel {background: #5e5e5f; color: white;}
.oBtnOr {background: #f49333;}
.oBtnDetail {background: #94c63f;}
.oBtnDetail:hover {background: #c8c8c8}
.sVal {padding-top: 7px;}
.owe {color: red;}
.oBtnAdd {background: #0eb1dc;}
.Submit{background: #94c63f}

/*.table>thead>tr>th,
.table>tbody>tr>th,
.table>tfoot>tr>th,
.table>thead>tr>td,
.table>tbody>tr>td,
.table>tfoot>tr>td {
    padding: 8px;
    vertical-align: top;
    border-top: 0
    }*/

    .tableList{padding: 30px;}

    .tableList>.table>thead, .tableList>.table>tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .tableList thead {
        color: #fff;
        background-color: rgba(115, 149, 158, 0.80);
    }
    .tableList .table>tbody {
      display: block;
      overflow: auto;
      max-height: 625px;
  }

  .w1{width: 10%}
  .w2{width: 15%}
  .w3{width: 10%}
  .w4{width: 10%}
  .w5{width: 10%}
  .w6{width: 10%}
  .w7{width: 10%}

  .qc3{width: 8.5%}
  .qc5{width: 8%}
/* .qc1{width: 30%}
.qc2{width: 12%}
.qc4{width: 13.5%}
.qc6{width: 13.5%}
.qc8{width: 10%} */

.tr_col {background: #F2F2F2;}
.accordion-toggle[aria-expanded='true'] {background: #c4e2c7 !important}

.div_trang {
    width: 30px;
    padding: 5px 10px 5px 10px;
    text-align: center;
    margin: 2px;
}

.fix_bottom {
    position: fixed;
    bottom: 2%;
    right: 40%;
}

.txt_treat {
  padding: 25px 0 0;
}

.line {border-top: 2px solid #ddd;}

#order_pay_modal .alert{margin-bottom: 0px;}
.alert h3{margin-top: 0px;}

.input-group-addon {cursor: pointer;}

#oInfo table tr{display: inherit;}

#pBtn {padding: 10px;}
#oInfo {padding-bottom: 5px;}
#btnReport {color: black;}

.report-controls {
    float: left;
    padding-left: 10px;
}
.report-controls .btn-xs {
    padding: 1px 5px;
    font-size: 13px;
    line-height: 1.5;
    border-radius: 2px;
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.btn_bookoke{
    background: #94c63f;
}
</style>

<div class="row wrapper tab-content full-height">

   <div  id="profileSideNav"  class="span1 primary-navbar col-sm-2 col-md-1">
       <ul class="nav nav-tab nav-stacked" id="myTab">
        <?php $group_id =  Yii::app()->user->getState('group_id');?>
        <?php if($group_id !=3 && $group_id !=16 && $group_id !=19){ ?>
            <li id="profile_preview_nav" class="<?php if($controller == 'reportingSalary') echo "active"; ?>">
                <a href="<?php echo $baseUrl; ?>/itemsReports/reportingSalary/View" >
                    <img src="<?php echo $baseUrl;?>/images/icon_sb_left/1_tong_quan/kinh_doanh_<?php if($controller == 'reportingSalary'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
                    Lương Bác Sĩ
                </a>
            </li>
            <li id="profile_preview_nav" class="<?php if($controller == 'reportingRevenue') echo "active"; ?>">
                <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingRevenue/view" >
                    <img src="<?php echo $baseUrl;?>/images/icon_sb_left/7_tai_chinh/dogn_tien_<?php if($controller == 'ReportingRevenue'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
                    Tài chính
                </a>
            </li>

            <li id="profile_preview_nav" class="<?php if($controller == 'reportingAppointment') echo "active"; ?>">
                <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingAppointment/view" >
                    <img src="<?php echo $baseUrl;?>/images/icon_sb_left/9_bao_cao/calendar_<?php if($controller == 'reportingAppointment'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
                    Lịch hẹn
                </a>
            </li>

            <li id="profile_preview_nav" class="<?php if($controller == 'reportCustomers') echo "active"; ?>">
                <a href="<?php echo $baseUrl; ?>/itemsReports/ReportCustomers/View" >
                    <img src="<?php echo $baseUrl;?>/images/icon_sb_left/4_khach_hang/khach_hang_<?php if($controller == 'reportCustomers'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
                    Khách hàng
                </a>
            </li>

            <li id="profile_preview_nav" class="<?php if($controller == 'reportingEmployee') echo "active"; ?>">
                <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingEmployee/View" >
                    <img src="<?php echo $baseUrl;?>/images/icon_sb_left/4_khach_hang/nhom_<?php if($controller == 'reportingEmployee'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
                    Nhân viên
                </a>
            </li>

            <li id="profile_preview_nav" class="<?php if($controller == 'reportingTransaction') echo "active"; ?>">
                <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingTransaction/View" >
                    <i class="fa fa-exchange" aria-hidden="true"></i>
                    Giao dịch
                </a>
            </li>

            <li id="profile_embed_nav" <?php if($controller == 'reportingInvoice') echo "class='active'"; ?>>
               <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingInvoice/View">
                   <img src="<?php echo $baseUrl;?>/images/icon_sb_left/5_Kinh_doanh/hoa_don_def.png" /> <br>
                   Hóa đơn
               </a>
           </li>

           <li id="profile_preview_nav" class="<?php if($controller == 'reportingCashFlow') echo "active"; ?>">
            <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingCashFlow/View" >
                <i class="fa fa-money" aria-hidden="true"></i>
                Dòng tiền
            </a>
        </li>

        <li id="profile_preview_nav" class="<?php if($controller == 'reportingOrderProduct') echo "active"; ?>">
            <a href="<?php echo $baseUrl; ?>/itemsReports/reportingOrderProduct/View" >
               <i class="fa fa-shopping-basket"></i>
               Hóa đơn bán sản phẩm
           </a>
       </li>
       <li id="profile_preview_nav" class="<?php if($controller == 'reportingTreatment') echo "active"; ?>">
        <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingTreatment/View" >
           <img src="<?php echo $baseUrl;?>/images/icon_sb_left/1_tong_quan/kinh_doanh_<?php if($controller == 'ReportingTreatment'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
           Điều trị
       </a>
   </li>
<?php }elseif ($group_id==3) { ?>
    <li id="profile_preview_nav" class="<?php if($controller == 'reportCustomers') echo "active"; ?>">
        <a href="<?php echo $baseUrl; ?>/itemsReports/ReportCustomers/View" >
            <img src="<?php echo $baseUrl;?>/images/icon_sb_left/4_khach_hang/khach_hang_<?php if($controller == 'reportCustomers'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
            Khách hàng
        </a>
    </li>
<?php }elseif ($group_id==16) { ?>
    <li id="profile_preview_nav" class="<?php if($controller == 'reportingAppointment') echo "active"; ?>">
        <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingAppointment/view" >
            <img src="<?php echo $baseUrl;?>/images/icon_sb_left/9_bao_cao/calendar_<?php if($controller == 'reportingAppointment'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
            Lịch hẹn
        </a>
    </li>
<?php } elseif ($group_id==19) { ?>
    <li id="profile_preview_nav" class="<?php if($controller == 'reportCustomers') echo "active"; ?>">
        <a href="<?php echo $baseUrl; ?>/itemsReports/ReportCustomers/View" >
            <img src="<?php echo $baseUrl;?>/images/icon_sb_left/4_khach_hang/khach_hang_<?php if($controller == 'reportCustomers'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
            Khách hàng
        </a>
    </li>
    
<?php } ?>
  <li id="profile_preview_nav" class="<?php if($controller == 'reportingLabo') echo "active"; ?>">
    <a href="<?php echo $baseUrl; ?>/itemsReports/ReportingLabo/View" >
      <img src="<?php echo $baseUrl;?>/images/icon_sb_left/1_tong_quan/kinh_doanh_<?php if($controller == 'reportingLabo'){ echo "act"; }else{ echo 'def'; } ?>.png" /> <br>
         Labo
     </a>
  </li>
</ul>
</div>


<div  id="rightsidebar" class="col-sm-10 col-md-11">
    <?php echo $content; ?>
</div>

</div>

<script type="text/javascript">

    $( document ).ready(function() {

        var windowHeight =  $( window ).height();
        var header       = $("#headerMenu").height();
        var oSrchBar = $('#oSrchBar').height();
        $('#profileSideNav').height(windowHeight-header);
        $('.customerListContainer').height(windowHeight-header);
        $('#detailCustomer').height(windowHeight-header);
        $('#return_content').height(windowHeight-header-oSrchBar-45);
        $('.cal-loading').fadeOut('slow');

    });


    $(window).resize(function() {
        var windowHeight =  $( window ).height();
        var header       = $("#headerMenu").height();
        var oSrchBar = $('#oSrchBar').height();
        $('#profileSideNav').height(windowHeight-header);
        $('.customerListContainer').height(windowHeight-header);
        $('#detailCustomer').height(windowHeight-header);
        $('#return_content').height(windowHeight-header-oSrchBar-45);
    });
</script>

<?php $this->endContent(); ?>