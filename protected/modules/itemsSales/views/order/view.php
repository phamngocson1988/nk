<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.min.css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.full.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/autonumeric.js"></script>

<style type="text/css">

body {overflow-y: hidden;}

.no_pay {background: #c8c8c8 !important; color: black !important; cursor: not-allowed}

.btn{color: white;}
input {border-radius: 0;}
 
#rightsidebar {padding: 0;}
#oSrchBar{padding: 20px; }
 
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

table th, table td {
  
}

.tableList{padding: 2px; background: #fff;}

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
.btn_plus {
    height: 30px;
    width: 30px;
    float: right;
    cursor: pointer;
    background: url(/images/icon_add/add-def.png);
    background-size: 100%;
    background-repeat: no-repeat;
}
</style>
<?php $baseUrl = Yii::app()->baseUrl;?>
<div id="oSrchBar" class="col-md-12">
    <form class="form-inline">
        <div id="oSrchRight" class="pull-left" style="width: 69%">
        <div class="form-group">
            <label >Thời gian</label>
            <select name="" class="form-control" id="order_time">
                <option value="1">Tất cả</option>
                <option value="2">Hôm nay</option>
                <option value="3">7 ngày trước</option>
                <option value="4">Tháng trước</option>
            </select>
        </div>
        <div class="form-group">
            <label>Văn phòng</label>
            <?php echo CHtml::dropDownList('branch','',$branch,array('class'=>'form-control' ,'id'=>'order_branch'));  ?>
        </div>
        <div class="form-group">
            <label>Khách hàng</label>
            <select name="" class="form-control" id="order_customer"></select>
        </div>
        </div>
        <div id="oSrchLeft" class="pull-right">
            <div class="input-group">
              <input type="text" class="form-control" id="order_code" placeholder="Tìm kiếm theo mã đơn hàng">
              <div class="input-group-addon" id="order_srch"><span class="glyphicon glyphicon-search"></span></div>
           </div>
             <a type="" style="margin-left: 15px;" class="btn oBtnAdd btn_plus" id="oAdds" data-toggle="modal" data-target="#order_modal" title="" "=""></a>
        </div>
    </form>
</div>

<div class="col-md-12">
  <div id="OrderList">
    
  </div>
</div>

<!-- create-->
<div id="order_modal" class="modal fade">

</div>

<!-- update-->
<div id="update_order_modal" class="modal fade">

</div>

<?php $this->renderPartial('q_js'); ?>