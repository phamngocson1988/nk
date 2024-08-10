<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<?php $this->beginContent('//layouts/layouts_menu'); ?>

<?php

$controller = Yii::app()->getController()->getAction()->controller->id;
$action     = Yii::app()->getController()->getAction()->controller->action->id;
?>


<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jqtransform.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/setting.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/customers_new.css" />

<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl ?>" />

<style type="text/css">
    #profileSideNav ul li a i {
        font-size: 2em;
    }

    .itemsPromotions li {
        line-height: 24px;
    }

    body {
        overflow-y: hidden;
    }

    .changeW {
        margin-left: -250px;
        border-top: 1px solid rgb(102, 175, 233) !important;
        width: 800px !important;
    }


    .no_pay {
        background: #c8c8c8 !important;
        color: black !important;
        cursor: not-allowed
    }

    .btn {
        color: white;
    }

    input {
        border-radius: 0;
    }

    a {
        color: black
    }

    #rightsidebar {
        padding: 0;
    }

    #profileSideNav ul li a i {
        font-size: 2em;
    }

    #oSrchBar {
        background: #f1f5f7;
        padding: 15px;
    }


    .hiddenRow {
        padding: 0 !important;
    }

    .hiddenRow:hover {
        background: white;
    }

    tr.accordion-toggle {
        cursor: pointer;
    }

    td.hiddenRow {
        border: 0 !important;
    }

    .oView {
        padding: 10px 0;
    }

    .oViewB {
        background: #f4f7f7;
        padding: 0 0 15px;
        margin: 0 0 15px;
    }

    .oViewB .sum td {
        border: 0;
    }

    .oViewB table.table,
    table.oViewB {
        background: #f4f7f7 !important;
    }

    .oViewB table.table thead {
        background: #e1e7eb;
        color: black;
    }

    .oViewB table tr td,
    .oViewB table tr th {
        border: 1px solid white;
    }

    .oViewDetail p {
        margin-bottom: 5px;
    }

    .oBtnG {
        background: #c8c8c8
    }

    .oBtnDel {
        background: #5e5e5f;
        color: white;
    }

    .oBtnOr {
        background: #f49333;
    }

    .oBtnDetail {
        background: #94c63f;
    }

    .oBtnDetail:hover {
        background: #c8c8c8
    }

    .sVal {
        padding-top: 7px;
    }

    .owe {
        color: red;
    }

    .Submit {
        background: #94c63f
    }

    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
        padding: 8px;
        vertical-align: top;
        border-top: 0
    }

    table th,
    table td {
        text-align: center;
    }

    .tableList {
        padding: 30px;
    }

    .tableList>.table>thead,
    .tableList>.table>tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .tableList thead {
        color: #fff;
        background-color: rgba(115, 149, 158, 0.80);
    }

    .tableList>.table>tbody {
        display: block;
        overflow: auto;
        max-height: 625px;
    }

    .w1 {
        width: 10%
    }

    .w2 {
        width: 15%
    }

    .w3 {
        width: 10%
    }

    .w4 {
        width: 10%
    }

    .w5 {
        width: 10%
    }

    .w6 {
        width: 10%
    }

    .w7 {
        width: 10%
    }

    .qc3 {
        width: 8.5%
    }

    .qc5 {
        width: 8%
    }

    .tr_col {
        background: #F2F2F2;
    }

    .accordion-toggle[aria-expanded='true'] {
        background: #c4e2c7 !important
    }

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

    .line {
        border-top: 2px solid #ddd;
    }

    #order_pay_modal .alert {
        margin-bottom: 0px;
    }

    .alert h3 {
        margin-top: 0px;
    }

    .input-group-addon {
        cursor: pointer;
    }

    #oInfo table tr {
        display: inherit;
    }

    #pBtn {
        padding: 10px;
    }

    #oInfo {
        padding-bottom: 5px;
    }

    #btnReport {
        color: black;
    }
</style>

<div class="row wrapper tab-content full-height">
    <div id="profileSideNav" class="span1 primary-navbar col-sm-2 col-md-1">
        <ul class="nav nav-tab nav-stacked" id="myTab">

            <li id="profile_configure_nav" class="<?php if ($controller == 'deals') {
                                                        echo 'active';
                                                    } ?>">
                <a href="<?php echo $baseUrl; ?>/itemsSales/Deals/view">
                    <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/5_Kinh_doanh/khuyen_mai_def.png" /> <br>
                    Khuyến mãi
                </a>
            </li>
            <li id="profile_configure_nav" <?php if ($controller == 'quotations') echo "class='active'"; ?>>
                <a href="<?php echo $baseUrl; ?>/itemsSales/quotations/view">
                    <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/5_Kinh_doanh/bao_gia_def.png" /> <br>
                    Báo giá
                </a>
            </li>
            <!-- <li id="profile_configure_nav" <?php //if($controller == 'order') echo "class='active'";
                                                ?>>
               <a href="<?php //echo $baseUrl;
                        ?>/itemsSales/order/view">
                   <i class="fa fa-shopping-basket"></i><br>
                   Đơn hàng
               </a>
           </li> -->

            <!-- <li id="profile_embed_nav" <?php //if($controller == 'order') echo "class='active'";
                                            ?>>
               <a href="<?php //echo $baseUrl;
                        ?>/itemsSales/order/View" >
                   <i class="fa fa-shopping-cart" aria-hidden="true"></i> <br>
                    Đơn hàng
               </a>
           </li> -->
            <li id="profile_embed_nav" <?php if ($controller == 'invoices') echo "class='active'"; ?>>
                <a href="<?php echo $baseUrl; ?>/itemsSales/invoices/View">
                    <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/5_Kinh_doanh/hoa_don_def.png" /> <br>
                    Hóa đơn
                </a>
            </li>

            <li id="profile_embed_nav" <?php if ($controller == 'order') echo "class='active'"; ?>>
                <a href="<?php echo $baseUrl; ?>/itemsSales/order/View">
                    <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/5_Kinh_doanh/hoa_don_def.png" /> <br>
                    Hóa đơn sản phẩm
                </a>
            </li>

            <li id="profile_embed_nav" <?php if ($controller == 'insuranceDebt') echo "class='active'"; ?>>
                <a href="<?php echo $baseUrl; ?>/itemsSales/insuranceDebt">
                    <i class="glyphicon glyphicon-grain" aria-hidden="true"></i> <br>
                    Bảo hiểm bảo lãnh
                </a>
            </li>
        </ul>
    </div>

    <div id="rightsidebar" class="col-sm-10 col-md-11">
        <?php echo $content; ?>
    </div>

    <!-- modal báo giá-->
    <div id="quote_modal" class="modal fade">

    </div>
    <script src="<?php echo Yii::app()->getBaseUrl(); ?>/js/select2/i18n/vi.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var windowHeight = $(window).height();
            var header = $("#headerMenu").height();

            $('#profileSideNav').height(windowHeight - header);
            $('.customerListContainer').height(windowHeight - header);
            $('#detailCustomer').height(windowHeight - header);
        });
    </script>
    <?php $this->endContent(); ?>