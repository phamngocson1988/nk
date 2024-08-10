<style>
a{cursor: pointer;}
.opacity-0{opacity: 0}
.text-left{text-align: left !important;}
.size-18{font-size: 18px}
.fl {float: left;}
.fr {float: right;}
.margin-top-5 {margin-top: 5px !important;}
.margin-top-7 {margin-top: 7px !important;}
.margin-top-10{margin-top: 10px !important;}
.margin-top-15{margin-top: 15px !important;}
.margin-top-30{margin-top:30px !important;}
.margin-bottom-10{margin-bottom: 10px !important;}
.bg-w{background:#fff;}
.cursor{cursor: pointer;}
.btn-green{background-color: #92C350 !important;color: #fff !important;margin-bottom: 10px;margin-right: 1%}

#tab-customer{padding: 10px 0 0}
#tab-customer a{text-decoration: none; color: #303030}
#tab-customer a:hover{text-decoration: none; color: #10b1dd}
#tab-customer #left_tab  .name_cus{font-size: 18px;}
#tab-customer #right_tab .nav-tabs{border-bottom: 1px solid #fff}
#tab-customer #right_tab {padding-left: 30px; padding-right: 30px;}
#tab-customer #right_tab ul li{margin-right:10px;border-bottom: 3px solid transparent;}
#tab-customer #right_tab ul li.active {border-bottom: 3px solid #10b1dd;}
#tab-customer #right_tab ul li.active a{color: #455862 !important;}
#tab-customer #right_tab ul li a:hover{background-color: #FFF !important;color: #455862 !important;}
#tab-customer #right_tab ul li a{border: none;margin:0px;color: #C1C8CD;font-size: 14px;text-transform: uppercase;padding: 8px 12px 12px;}
.line{height: 10px; background:#f1f5f7}
#left_medical_records{border-right: 5px solid #f1f5f7; padding: 15px; width: 400px; float: left;}
#left_medical_records .btn-group{margin: 0px;width: 100%}
#left_medical_records .btn-group #typeTooth{width: 83%; margin-right: 1%;}
#left_medical_records .btn-group .dropdown-toggle{width: 15%}

#right_medical_records{width: calc(100% - 400px); float: left; padding: 30px 15px;}
#left_medical_records #dental_status_img{position:relative;width:350px;height:430px; margin:0 auto; margin-bottom: 10px}
#left_medical_records .option-tooth{background:#92C350;color: #fff; float: left;}
#left_medical_records .option-tooth option {background: #fff;color: #303030; }
#left_medical_records .note-tooth{width: 35px; float: right; cursor: pointer;position: relative;}
.bg-treatment{background: #F2B339;color:#fff;padding:7px 10px;width:100%;font-size: 13px;text-transform: uppercase;cursor: pointer; border-radius: 4px}
.treatment {position: absolute;display: none;z-index: 10;left: 0;right:0;width: auto;background: #fff;box-shadow: 0px 2px 1px #00000040; width: 380px; margin-top: 10px;}
.treatment tr td{vertical-align:middle !important;}
.btn-film{background:#53647E; color: #fff; border-radius: 4px !important; text-transform: uppercase;font-size: 13px;padding: 6px 8px;}
.btn-film:hover{background:rgba(83, 100, 126, 0.7); color: #fff}
.btn-save{background:#333; color: #fff; border-radius: 4px !important; text-transform: uppercase; font-size: 13px; padding: 6px 8px;}
.btn-save:hover{background: rgba(16, 177, 221, 0.7); color: #fff}
#noteToothPopup{display: none; max-width: 400px; left: 35px; top:-20px;}
#noteToothPopup .header{background-color: #e6e6e5;}
#noteToothPopup .popover-title{font-size: 16px;float: left;background:transparent;border:0;}
#noteToothPopup .popover-content{width:420px;margin: 10px;}
#noteToothPopup .popover-content div{margin-bottom: 5px}
#noteToothPopup #ic_close {width: 15px; float: right; margin:10px 0;}
#right_medical_records .title{font-size: 20px; color:#303030; font-weight: 700; text-transform: uppercase; }
.table thead tr th{text-align: center;border: 1px solid #fff !important;font-size: 14px;font-weight: 100; padding:5px;color: #fff !important;}
.table thead tr{background-color: #53647E;}
.table tbody tr td{border-bottom: 1px solid #ddd;text-align: center; border-right: 1px solid #ddd; border-left: 1px solid #ddd; border-top: 0}

.table-list .th1{width: 15%;vertical-align: middle;}
.table-list .th2{width: 35%;vertical-align: middle;}
.table-list .th3{width: 45%;vertical-align: middle; cursor: pointer;}
.table-list .th4{width: 5%;vertical-align: middle; cursor: pointer;}

#toggle-dental{display: none;max-width: 420px;width: 420px;border-radius: 0;padding: 20px;}
#toggle-dental .closebtn {width: 20px; float: right;cursor: pointer;}
#toggle-dental #tooth_number{font-size: 20px;text-transform: uppercase;font-weight: 600;float: left;}

#toggle-dental .menu-option ul li{border-bottom: 1px solid transparent; margin-right: 5px;margin-top:5px;}
#toggle-dental .menu-option ul li.active a{color: #fff !important;background:#53647E;}
#toggle-dental .menu-option ul li a:hover{background-color: #53647E !important;color: #fff !important; }
#toggle-dental .menu-option ul li a{border: none;margin:0px;color: #fff;font-size: 14px;padding: 5px 12px;font-size: 13px; background:rgba(83, 100, 126, 0.7); border-radius: 0; text-align: center;}
.sidenav {max-height: 500px; overflow: auto; width: 90%; float: left;}
.sidenav::-webkit-scrollbar {width: 5px !important;}
.sidenav::-webkit-scrollbar-track {background:#f3f3f3; border-radius: 10px; }
.sidenav::-webkit-scrollbar-thumb {border-radius: 10px; background: #53647E; }
.sidenav a {padding: 8px 5px 8px;;text-decoration: none;font-size: 14px;color: #5a5a5a;display: block;transition: 0.3s;border-bottom: 1px solid #ddd; cursor: pointer;}
.sidenav a img{width: 25px;}
.sidenav .list-group {margin-top:10px; margin-bottom: 10px;}
.bg-detail-tooth {background: url(<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/bg-rang.png) no-repeat; background-size: cover;}
#detail_tooth .content{position:relative;width:60%;margin: 0px auto; background: transparent;}
#detail_tooth .content img{max-width: 60px;}
#detail_tooth .content .img-absolute{position: absolute;top: 0;left: 0;width:100%;height: auto;}
#table_conclude textarea{ overflow:hidden;padding:10px;width:100%;font-size:14px;display:block;border:1px solid #ddd;}

#frm-quote table th{color: black !important;font-weight: bold;border-bottom: 2px solid #ddd !important;}
#frm-quote  tbody tr td{border: 0 !important}
#frm-update-quote table th{color: black !important;font-weight: bold;border-bottom: 2px solid #ddd !important;}
#frm-update-quote  tbody tr td{border: 0 !important}
.oUpdates {border-radius: 3px;font-weight: normal;font-size: 14px;padding: 5px 10px;border: solid 1px #D7D7D7;background: #10b1dd;text-decoration: none !important;color: #FFF;text-indent: 0px;text-align: center;display: inline-block;}
.spn-dots {border: none;background: #fff;padding: 15px 0px 0px 0px;}
.ipt-dots {border-top: none;border-left: none;border-right: none;border-bottom: 1px dotted #0e0e0e;border-radius: 0;box-shadow: none;padding: 15px 12px 0px 0px;background-color: #fff; padding-left: 10px;}
.form-control:focus {border-color: #000;outline: 0;-webkit-box-shadow: inset 0 0px 0px rgba(0, 0, 0, .075), 0 0 0px rgba(102, 175, 233, .6);box-shadow: inset 0 0px 0px rgba(0, 0, 0, .075), 0 0 0px rgba(102, 175, 233, .6);}

.accordion-toggle{background: #f3f3f3 !important;}
.accordian-body{padding-top: 20px; padding-bottom: 20px;}
table.oViewB thead th{background: #fff; color: #333 !important;border: 1px solid #ddd!important;}
.hiddenRow{padding: 0 !important}

.modal-body{background: #fff}

.table-list tr {width: 100%;display: inline-table;table-layout: fixed;}
.table-list.table{height:330px; display: -moz-groupbox;}
.table-list tbody{overflow-y: scroll;max-height: 300px;left: 17px;position: absolute;right: 12px;}
.table-list tbody::-webkit-scrollbar { width: 5px;}
.table-list tbody::-webkit-scrollbar-track {background:#f3f3f3; border-radius: 10px; }
.table-list tbody::-webkit-scrollbar-thumb {border-radius: 10px; background: #53647E; }

.table-list2 tr {width: 100%;display: inline-table;table-layout: fixed;}
.table-list2.table-fix{height:630px; display: -moz-groupbox;}
.table-list2 tbody{overflow-y: scroll;max-height: 600px;left: 0;position: absolute;right: -5px;}
.table-list2 tbody::-webkit-scrollbar { width: 5px;}
.table-list2 tbody::-webkit-scrollbar-track {background:#f3f3f3; border-radius: 10px; }
.table-list2 tbody::-webkit-scrollbar-thumb {border-radius: 10px; background: #53647E; }
.oViewB tbody{overflow:hidden !important;height: auto !important;left: 0;position: relative !important;right: 0;}
.noteTooth div{margin-bottom: 3px;}
</style>