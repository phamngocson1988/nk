<style>
#customer-grid{
    margin-top: 30px;
}
#tab1,#tab2,#tab3,#tab4{
    padding: 50px !important;
}
.margin_10px_0{
	margin: 10px 0;
}
.profile-left{
	border-radius: 5%;	
	padding:20px;
	background-color:#E8E7E7;
	position:relative;
	width: 90%;
	margin: 0px auto;
}
#profile-image{
	width: 70%;
    background-color: #979798;
    position: absolute;
    top: -10%;
    right: 14%;
    border-radius: 50%;
    overflow: hidden;
}
#profile-image img{
	height: auto;
	width: 100%;
}
#profile-name {
    width: 100%;
    text-align: center;
    font-size: 20px; 
    font-weight: 700;
    padding-top: 70%;
}
#profile-code {
    width: 100%;
    text-align: center;
    font-size: 18px; 
 
    font-weight: 700;
    color: #E49737;
}
#code {       
  	margin: 0px auto;
    width: 150px;
    height: 40px;
    background-color: #5D5D5E;
 
}
#code div{ 
	text-align: center;
    padding: 7px;
    color: #fff;
    font-size: 18px;
}
.row h4{
	color: #92C350;
	margin: 25px 0px;
}
.yiiTab ul.tabs a.active{
	color: #00A9DD !important;
	border-top: 3px solid #088eb3 !important;
}
.yiiTab ul.tabs a{
	color: #000000 !important;
}

.yiiTab ul.tabs li a {
    padding: 7px 21px !important;
}

@media only screen and (min-device-width : 320px) and (max-device-width : 768px) {
	#tab1{
		padding:15px 15px !important;
	}
	#tab2{
		padding:15px 15px !important;
	}
	#tab3{
		padding:15px 15px !important;
	}
	#tab4{
		padding:15px 15px !important;
	}
    #tabcontent{
        padding: 10px 10px 5px 10px;
    }

}
#tabcontent{
    padding: 30px 30px 10px 30px;
}

.text-align-right{
	text-align: right;
}
.margin-top-10{
	margin-top: 10px;
}
.margin-top-15{
	margin-top: 15px;
}
.margin-top-20{
	margin-top: 20px;
}
.margin-top-25{
	margin-top: 25px;
}
.margin-top-50{
	margin-top: 50px;
}
/*HO SO BENH AN*/
#pf_medi{font-size: 14px;}
.btn-apply{background: #00AADC;color: #ffffff;border-radius: 4px !important;padding: 5px 12px;}
.btn-apply:hover{background: rgba(0, 170, 220, 0.5);color: #ffffff;}
.btn-completed{background: #00AADC;color: #ffffff;border-radius: 4px !important;padding: 2px 10px;}
.btn-completed:hover{background: rgba(0, 170, 220, 0.5);color: #ffffff;}
.td-apply1{min-width: 520px;}
.td-apply{text-align: right !important;}
.text-align-right{text-align: right;}
.margin-bottom-15{margin-bottom:15px;}
.margin-top-15{margin-top:15px;}
.margin-top-50{margin-top:50px;}
.margin-bottom-50{margin-bottom:50px;}
.margin-bottom-30{margin-bottom:30px;}
.margin-top-20{margin-top:20px;}
.margin-top-30{margin-top:30px;}
.padding-left-15{padding-left:15px;}
.padding-right-15{padding-right:15px;}
.table-treatment>thead{
    color: #fff;  
}
.table-treatment {
    border-bottom:0px !important;
}
.table-treatment>thead>tr th, .table>tbody tr td {
    border: 0px !important;
    text-align: center;
}
.at{
    background-color: #c4e2c7 !important;
}
#pf_medi h4{font-size: 20px;}
#table-diagnosis td{padding: 7px 10px;}
	/*ĐỢT ĐIỀU TRỊ 4*/
#treatment_4 tr:nth-child(even){background-color: #f2f2f2}
.trash,.pencil{cursor: pointer;}
.trash:hover,.pencil:hover{color: #92C350;}
.treatment {
	position: absolute;
  display: none;
  z-index: 10;
  width: 100%;
}
.formholder {
  background: #FFFFFF;
  width: 100%;
  box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2);
}
.formholder input[type="submit"] {
  background: #9CC34D;
  padding: 0px;
  font-size: 13px; 
  border: none;
  color: #fff;
      margin-top: 10px;
    margin-bottom: 10px
}
	/*END ĐỢT ĐIỀU TRỊ 4*/
.file-dinh-kem{	
	margin-bottom: 15px;
    cursor: pointer;
    text-indent: 30px;
    line-height: 20px;
	width: 100%;
    background: url(../../images/medical_record/more_icon/file-dinh-kem-def.png);
    background-size: 15%;
    background-repeat: no-repeat;
    	
}
.file-dinh-kem:hover{
	background: url(../../images/medical_record/more_icon/file-dinh-kem-act.png);
    background-size: 15%;
    background-repeat: no-repeat;
	color: #92C350;		
}
 
.file-chup{	
	margin-bottom: 15px;
    cursor: pointer;
    text-indent: 30px;
    line-height: 20px;
	width: 100%;
    background: url(../../images/medical_record/more_icon/film-chup-def.png);
    background-size: 15%;
    background-repeat: no-repeat;
    	
}
.file-chup:hover{
	background: url(../../images/medical_record/more_icon/film-chup-act.png);
    background-size: 15%;
    background-repeat: no-repeat;
	color: #92C350;		
}
.them{	
	margin-bottom: 15px;
    cursor: pointer;
    text-indent: 30px;
    line-height: 20px;
	width: 100%;
    background: url(../../images/medical_record/more_icon/them-def.png);
    background-size: 15%;
    background-repeat: no-repeat;
    	
}
.them:hover{
	background: url(../../images/medical_record/more_icon/them-act.png);
    background-size: 15%;
    background-repeat: no-repeat;
	color: #92C350;		
}
.xoa{	
	margin-bottom: 15px;
    cursor: pointer;
    text-indent: 30px;
    line-height: 20px;
	width: 100%;
    background: url(../../images/medical_record/more_icon/xoa-def.png);
    background-size: 15%;
    background-repeat: no-repeat;
    	
}
.xoa:hover{
	background: url(../../images/medical_record/more_icon/xoa-act.png);
    background-size: 15%;
    background-repeat: no-repeat;
	color: #92C350;		
}
.nhac-nho{	
	margin-bottom: 15px;
    cursor: pointer;
    text-indent: 30px;
    line-height: 20px;
	width: 100%;
    background: url(../../images/medical_record/more_icon/nhac-nho-def.png);
    background-size: 15%;
    background-repeat: no-repeat;
    	
}
.nhac-nho:hover{
	background: url(../../images/medical_record/more_icon/nhac-nho-act.png);
    background-size: 15%;
    background-repeat: no-repeat;
	color: #92C350;		
}
.ghi-chu{	
	margin-bottom: 15px;
    cursor: pointer;
    text-indent: 30px;
    line-height: 20px;
	width: 100%;
    background: url(../../images/medical_record/more_icon/ghi-chu-def.png);
    background-size: 15%;
    background-repeat: no-repeat;
    	
}
.ghi-chu:hover{
	background: url(../../images/medical_record/more_icon/ghi-chu-act.png);
    background-size: 15%;
    background-repeat: no-repeat;
	color: #92C350;		
}
.d_kem{	
    background: url(../../images/medical_record/more_icon/file-dinh-kem-def.png);
    background-size: 35% 100%;
    background-repeat: no-repeat;
    width: 100%;
    height: 25px;
    background-position: 25px 0px;   
} 
.d_kem:hover{
    background: url(../../images/medical_record/more_icon/file-dinh-kem-act.png);
    background-size: 35% 100%;
    background-repeat: no-repeat; 
    width: 100%;
    height: 25px;
    background-position: 25px 0px;   
} 
#draw{	
    background: url(../../images/medical_record/more_icon/draw-def.png);
    background-size: 100%;
    background-repeat: no-repeat;
    padding: 15px;
} 
#draw:hover{
    background: url(../../images/medical_record/more_icon/draw-act.png);
    background-size: 100%;
    background-repeat: no-repeat; 
    padding: 15px;  
} 
#save{  
    background: url(../../images/medical_record/images/icon-save-def.png);
    background-size: 100%;
    background-repeat: no-repeat;
    padding: 20px;
} 
#save:hover{
    background: url(../../images/medical_record/images/icon-save-act.png);
    background-size: 100%;
    background-repeat: no-repeat; 
    padding: 20px;  
} 
#toggle-dental{
	box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2);
	display:none;
	position:absolute;
	z-index: 10;
	width:170px;
	background-color: #fff;
	height: 170px;
}
#toggle-dental>div{
	padding-left: 15px;
    line-height: 30px;
    font-size: 12px;	
    cursor: pointer;
}
#toggle-dental>div:hover{
	background-color: #00A9DC;
	color: #fff;	
}
.toggle-dental-content{	
	padding: 15px 5px;
	top: 30%;
    left: 101%;
	 display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 333px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}
.toggle-dental-content div {
    color: black;
    padding: 7px 15px;
    text-decoration: none;    
}
.sick:hover .toggle-dental-content {
    display: block;
}
.text-align-left{
    text-align: left !important;
}
a.hide { display:none;}  
#addnewMedicalHistoryPopup{
    padding:15px;position: fixed;top: 5%;right: 0;left: 0;width: 750px;height: auto;margin: 0 auto;background: #ffffff;border-radius: 3px;z-index: 999;
}
.blur{
    display: none;position: fixed;top: 0;right: 0;width: 100%;height: 100%;z-index: 999;background: rgba(0,0,0,0.8);
}
/*.sHeader{
    background: #0eb1dc;
    color: white;
    padding: 7px 30px;
    font-size: 18px;
    margin-left: -15px;
    margin-top: -15px;
    margin-right: -15px;
}*/
#newPlan {
    border-radius: 3px;
    font-weight: bold;
    font-size: 20px;
    line-height: 28px;
    height: 30px;
    width: 30px;
    padding: 0px;
    float: right;
    border: solid 1px #D7D7D7;
    background: #10b1dd;
    text-decoration: none;
    color: #FFF;
    text-indent: 0px;
    text-align: center;
} 
/*END HO SO BENH AN*/
/*N*/
	#bk_step {position: relative;}
	#pf_img {background: #e9e8e7; border-radius: 10px;text-align: center;position: relative;margin-top: 50px;padding-bottom: 20px;}
	#pf_img img {width: 80%; height: auto; border-radius: 100%; background: #989898;margin-top: -20px;}
	#pf_img p:nth-child(2) {margin-top: 20px; color: #3d3e3e; font-weight: bold;}
	#pf_img p:nth-child(3) {color: #e29a26; font-weight: bold;}
	#pf_img p:last-child {background: #5e5e5e; color: white; width: 80%; margin: auto; border-radius: 5px;}
	#pf_tab .tab-content h4 {color: #94c640; font-weight: bold; padding: 30px 0 10px 0;}
	.h4_insurance_information {color: #94c640; font-weight: bold; padding: 30px 0 10px 0;}
	#pf_rs {font-weight: bold;}
	#pf_qh_tt {text-align: right;}
	#pf_tab .tab-content th, #pf_tab .tab-content td {text-align: center; color: black;}
	.table_insurance_information th,.table_insurance_information td {text-align: center; color: black !important;}
	#pf_treat hr{border: 1px dashed #ddd;}
	#pf_cir {width: 13px;
	    height: 13px;
	    border-radius: 100%;
	    background: #76b042;
	    position: absolute;
	    top: -5px;
	    right: 0;}
	#pf_bill {margin: 20px auto; background: #f4f3f3;}
/*END N*/
/*HOI VIEN*/
#bonus_score {
	border-radius: 3px;
	font-weight: bold;
	font-size: 20px;
	line-height: 28px;
	height: 30px;
	width: 30px;
	padding: 3px 8px;
	border: solid 1px #D7D7D7;
	background: #10b1dd;
	text-decoration: none;
	color: #FFF;
	text-indent: 0px;
	text-align: center;
}

#voucher{
	border-radius: 3px;
	font-weight: bold;
	font-size: 20px;
	line-height: 28px;
	height: 30px;
	width: 30px;
	padding: 3px 8px;
	border: solid 1px #D7D7D7;
	background: #10b1dd;
	text-decoration: none;
	color: #FFF;
	text-indent: 0px;
	text-align: center;
}

.h3_member{
    float: left;
    width: 170px;
    line-height: 27px;
    font-size: 22px;
    color: #455862;
    font-weight: 400;
    margin: 0px;
}
/*END HOI VIEN*/

/*Sidenav*/
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #10b1dd;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
    position: absolute;
}

.sidenav a {
    padding: 8px 8px 5px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #fff;
    display: block;
    transition: 0.3s
}

.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.list-group-item{
    background-color: #fff !important;
    color: #818181 !important;
}
/*End Sidenav*/
.table{
    display: table;     
}
.cell{    
    display:table-cell;
    vertical-align: middle;
 }
.opacity_0{
    opacity: 0;
}
#oAdds{
    border-radius: 3px;
    font-weight: normal;
    font-size: 14px;
    line-height: 28px;   
    padding: 5px 10px;
    float: right;
    border: solid 1px #D7D7D7;
    background: #10b1dd;
    text-decoration: none;
    color: #FFF;
    text-indent: 0px;
    text-align: center;
    display: inline-block;
    margin: 15px;
}
.oUpdates{
    border-radius: 3px;
    font-weight: normal;
    font-size: 14px;
    line-height: 28px;   
    padding: 5px 10px;
    float: right;
    border: solid 1px #D7D7D7;
    background: #10b1dd;
    text-decoration: none !important;
    color: #FFF;
    text-indent: 0px;
    text-align: center;
    display: inline-block;
    margin: 15px;
}
.oUpdates:hover{    
    color: #FFF;    
}
/*calendarModal*/
#calendarModal .modal-content{width: 60%;}
#calendarModal .modal-header {background: #0eb1dc; color: white; padding: 7px 25px; font-weight: bold; }
#calendarModal .modal-header h3 {font-size: 22px; line-height: 1.5em;}
#calendarModal .modal-body {padding: 0 15px 10px;}
#calendarModal .modal-header .close {font-size: 36px; color: white; opacity: 1; font-weight: lighter;}
#calendarModal table {margin-top: 5px;}
#calendarModal table tr td {border: 0;}
.btn_new {background: #969696;}
.oView {    
    padding: 0 25px 25px 25px;
    margin: 10px 0;    
}
.oViewB {background: #f4f7f7; padding: 0 0 15px; margin: 0 0 15px;}
.oViewB .sum td{border: 0;}
.oViewB table.table {background: #f4f7f7;}
.oViewB table.table thead{background: #e1e7eb; color: black;}
.oViewB table tr td, .oViewB table tr th{border: 1px solid white;}
.hiddenRow {padding: 0 !important;background-color: #f1f5f7;}
.btn-fw {
    width: 125px;
    box-sizing: border-box;
}
.btn-success {
    color: #fff;
    background-color: #94c63f;
    border-color: #94c63f;
}
.txt_treat {
    padding: 25px 0 0;
}
.opacity-0{
    opacity: 0;
}
</style>




<form id="frm-treatment" onsubmit="return false;" class="form-horizontal">	

	<div class="row padding-left-15">
		<h4>BỆNH SỬ Y KHOA</h4>
	</div>

	<?php	
	 	$list_ma = $model->getListMedicalHistoryAlertOfCustomer($model->id);
	 	if(count($list_ma) > 0 ){
		?>
		
		<div class="row">
			<div class="col-md-11 col-md-offset-1 margin-bottom-15">
				<b>Bệnh nhân mắc phải:</b>
			</div>

			<?php foreach ($list_ma as $p_w) {
				?>
				<div class="col-md-3 col-md-offset-2">
					<ul>
					  <li><?php echo $p_w['name_medicine_alert'];?></li>									  
					</ul>
				</div>	
			<?php } ?>	
		</div>

	<?php  } ?>


</form>




<?php 
$tooth_data = new ToothData;
$id_mhg = $treatment->id;
$listToothData = $tooth_data->getListToothData($model->id,$id_mhg);
$listFaceTooth = $tooth_data->getListFaceTooth($model->id,$id_mhg);
$listToothConcludeAndNote = $tooth_data->getListToothConcludeAndNote($model->id,$id_mhg);
$evaluateStateOfTartar = $model->getEvaluateStateOfTartar($id_mhg);
$checkExistImage = $model->getListName($model->id,$id_mhg);
?>

<div class="row padding-left-15 padding-right-15">   
    <h4 style="display: inline-block;">TÌNH TRẠNG RĂNG</h4> 

    
</div>

<input id="dental_status_change" type="hidden" value="0">
<input id="image_dental_status_change" type="hidden" value="<?php if(!empty($checkExistImage)) echo "1";?>">



<div style="margin:0px;position:relative;">    



    <div class="row">
        <div id="teeth_model" class="col-md-5 margin-top-50">

        

        

            <a style="float:right;" href="javascript:void(0)"><div id="note"></div></a>     

            <div id="notePopup" class="popover bottom" style="display: none;max-width:400px;">      

                    <div style="background-color: #e6e6e5;">
                        <h3 class="popover-title" style="background-color: #e6e6e5;display: inline-block;font-size: 16px;padding: 15px;">CHÚ THÍCH MÀU RĂNG</h3>                        
                    
                        <a style="float:right;margin: 10px;" href="javascript:void(0)"><div id="ic_close"></div></a>    
                    </div>
                  

                    <div class="popover-content" style="width:450px;margin: 10px;line-height:2;">

                        <div>1. Nhóm tình trạng sức khỏe răng:</div>
                        <div class="row" style="margin:0px;line-height:2;font-size:12px;">
                            <div class="col-md-6">
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-khoe.jpg">&nbsp;&nbsp;Răng khỏe mạnh</div>
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-benh.jpg">&nbsp;&nbsp;Răng bệnh</div>
                            </div>
                            <div class="col-md-6">
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-yeu.jpg">&nbsp;&nbsp;Răng yếu</div>
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-mat.jpg">&nbsp;&nbsp;Răng mất</div>
                            </div>
                        </div>

                        <div>2. Nhóm tình trạng sau điều trị:</div>
                        <div class="row" style="line-height:2;font-size:12px;">
                            <div class="col-md-6">
                                <div style="border-left: 2px solid;padding-left: 5px;margin-left: 8px;">
                                <div>Răng phục hồi cố định</div>
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-gia-co-dinh.jpg">&nbsp;&nbsp;Răng giả cố định</div>
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/vi-tri-cau-rang-gia.jpg">&nbsp;&nbsp;Vị trí cầu răng giả</div>
                                </div>
                                <div style="margin-left:15px;"><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-phuc-hoi-thao-lap.jpg">&nbsp;&nbsp;Răng phục hồi tháo lắp</div>
                                <div style="margin-left:15px;"><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/phuc-hoi-implant.jpg">&nbsp;&nbsp;Răng phục hồi Implant</div>
                            </div>
                            <div class="col-md-6">
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-tram-A.jpg">&nbsp;&nbsp;Răng trám A</div>
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-tram-CO.jpg">&nbsp;&nbsp;Răng trám CO</div>
                                <div><img width="10%" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-tram-GIC.jpg">&nbsp;&nbsp;Răng trám GIC</div>
                            </div>
                        </div>
                    </div>          
            </div>

        <div style="position:relative;width:360px;height:432px; margin:0px auto;">      

            <img id="rang-nguoi-lon-11" class="tooth" title="RĂNG 11" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/11.png" style="position:absolute;width:11%;left: 42%;" <?php if(array_key_exists(11,$listToothData)){echo "data-tooth=".$listToothData[11];}?>>
            <img id="rang-nguoi-lon-12" class="tooth" title="RĂNG 12" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/12.png" style="position:absolute;width:11%;top: 2%;left: 34.5%;" <?php if(array_key_exists(12,$listToothData)){echo "data-tooth=".$listToothData[12];}?>>
            <img id="rang-nguoi-lon-13" class="tooth" title="RĂNG 13" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/13.png" style="position:absolute;width:11%;top: 6%;left: 30%;" <?php if(array_key_exists(13,$listToothData)){echo "data-tooth=".$listToothData[13];}?>>
            <img id="rang-nguoi-lon-14" class="tooth" title="RĂNG 14" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/14.png" style="position:absolute;width:11%;top: 10.5%;left: 26%;" <?php if(array_key_exists(14,$listToothData)){echo "data-tooth=".$listToothData[14];}?>>
            <img id="rang-nguoi-lon-15" class="tooth" title="RĂNG 15" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/15.png" style="position:absolute;width:11%;top: 16.5%;left: 23.5%;" <?php if(array_key_exists(15,$listToothData)){echo "data-tooth=".$listToothData[15];}?>>
            <img id="rang-nguoi-lon-16" class="tooth" title="RĂNG 16" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/16.png" style="position:absolute;width:11%;top: 23.5%;left: 20.5%;" <?php if(array_key_exists(16,$listToothData)){echo "data-tooth=".$listToothData[16];}?>>
            <img id="rang-nguoi-lon-17" class="tooth" title="RĂNG 17" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/17.png" style="position:absolute;width:11%;top: 31%;left: 18.5%;" <?php if(array_key_exists(17,$listToothData)){echo "data-tooth=".$listToothData[17];}?>>
            <img id="rang-nguoi-lon-18" class="tooth" title="RĂNG 18" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/18.png" style="position:absolute;width:11%;top: 39%;left: 18%;" <?php if(array_key_exists(18,$listToothData)){echo "data-tooth=".$listToothData[18];}?>>                                   
            
            <img id="rang-nguoi-lon-21" class="tooth" title="RĂNG 21" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/21.png" style="position:absolute;width:11%;left: 50.7%;" <?php if(array_key_exists(21,$listToothData)){echo "data-tooth=".$listToothData[21];}?>>
            <img id="rang-nguoi-lon-22" class="tooth" title="RĂNG 22" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/22.png" style="position:absolute;width:11%;top: 1.5%;left: 58%;" <?php if(array_key_exists(22,$listToothData)){echo "data-tooth=".$listToothData[22];}?>>
            <img id="rang-nguoi-lon-23" class="tooth" title="RĂNG 23" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/23.png" style="position:absolute;width:11%;top: 6%;left: 62%;" <?php if(array_key_exists(23,$listToothData)){echo "data-tooth=".$listToothData[23];}?>>
            <img id="rang-nguoi-lon-24" class="tooth" title="RĂNG 24" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/24.png" style="position:absolute;width:11%;top: 10.5%;left: 66%;" <?php if(array_key_exists(24,$listToothData)){echo "data-tooth=".$listToothData[24];}?>>
            <img id="rang-nguoi-lon-25" class="tooth" title="RĂNG 25" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/25.png" style="position:absolute;width:11%;top: 16.5%;left: 69.3%;" <?php if(array_key_exists(25,$listToothData)){echo "data-tooth=".$listToothData[25];}?>>
            <img id="rang-nguoi-lon-26" class="tooth" title="RĂNG 26" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/26.png" style="position:absolute;width:11%;top: 23.3%;left: 71.7%;" <?php if(array_key_exists(26,$listToothData)){echo "data-tooth=".$listToothData[26];}?>>
            <img id="rang-nguoi-lon-27" class="tooth" title="RĂNG 27" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/27.png" style="position:absolute;width:11%;top: 30.7%;left: 74%;" <?php if(array_key_exists(27,$listToothData)){echo "data-tooth=".$listToothData[27];}?>>
            <img id="rang-nguoi-lon-28" class="tooth" title="RĂNG 28" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/28.png" style="position:absolute;width:11%;top: 39%;left: 74%;" <?php if(array_key_exists(28,$listToothData)){echo "data-tooth=".$listToothData[28];}?>>
            
            <img id="rang-nguoi-lon-31" class="tooth" title="RĂNG 31" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/31.png" style="position:absolute;width:11%;top: 91.2%;left: 50.7%;" <?php if(array_key_exists(31,$listToothData)){echo "data-tooth=".$listToothData[31];}?>>
            <img id="rang-nguoi-lon-32" class="tooth" title="RĂNG 32" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/32.png" style="position:absolute;width:11%;top: 89.3%;left: 58%" <?php if(array_key_exists(32,$listToothData)){echo "data-tooth=".$listToothData[32];}?>>
            <img id="rang-nguoi-lon-33" class="tooth" title="RĂNG 33" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/33.png" style="position:absolute;width:11%;top: 85%;left: 62%;" <?php if(array_key_exists(33,$listToothData)){echo "data-tooth=".$listToothData[33];}?>>
            <img id="rang-nguoi-lon-34" class="tooth" title="RĂNG 34" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/34.png" style="position:absolute;width:11%;top: 80.5%;left: 66%;" <?php if(array_key_exists(34,$listToothData)){echo "data-tooth=".$listToothData[34];}?>>
            <img id="rang-nguoi-lon-35" class="tooth" title="RĂNG 35" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/35.png" style="position:absolute;width:11%;top: 74.5%;left: 69.3%;" <?php if(array_key_exists(35,$listToothData)){echo "data-tooth=".$listToothData[35];}?>>
            <img id="rang-nguoi-lon-36" class="tooth" title="RĂNG 36" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/36.png" style="position:absolute;width:11%;top: 67.5%;left: 71.7%;" <?php if(array_key_exists(36,$listToothData)){echo "data-tooth=".$listToothData[36];}?>>
            <img id="rang-nguoi-lon-37" class="tooth" title="RĂNG 37" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/37.png" style="position:absolute;width:11%;top: 60%;left: 73.5%;" <?php if(array_key_exists(37,$listToothData)){echo "data-tooth=".$listToothData[37];}?>>
            <img id="rang-nguoi-lon-38" class="tooth" title="RĂNG 38" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/38.png" style="position:absolute;width:11%;top: 52%;left: 74%;" <?php if(array_key_exists(38,$listToothData)){echo "data-tooth=".$listToothData[38];}?>>

            <img id="rang-nguoi-lon-41" class="tooth" title="RĂNG 41" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/41.png" style="position:absolute;width:11%;top: 91.3%;left: 41.7%;" <?php if(array_key_exists(41,$listToothData)){echo "data-tooth=".$listToothData[41];}?>>
            <img id="rang-nguoi-lon-42" class="tooth" title="RĂNG 42" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/42.png" style="position:absolute;width:11%;top: 89.3%;left: 34.4%;" <?php if(array_key_exists(42,$listToothData)){echo "data-tooth=".$listToothData[42];}?>>
            <img id="rang-nguoi-lon-43" class="tooth" title="RĂNG 43" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/43.png" style="position:absolute;width:11%;top: 85.1%;left: 30.3%;" <?php if(array_key_exists(43,$listToothData)){echo "data-tooth=".$listToothData[43];}?>>
            <img id="rang-nguoi-lon-44" class="tooth" title="RĂNG 44" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/44.png" style="position:absolute;width:11%;top: 80.5%;left: 26.5%;" <?php if(array_key_exists(44,$listToothData)){echo "data-tooth=".$listToothData[44];}?>>
            <img id="rang-nguoi-lon-45" class="tooth" title="RĂNG 45" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/45.png" style="position:absolute;width:11%;top: 74.5%;left: 23%;" <?php if(array_key_exists(45,$listToothData)){echo "data-tooth=".$listToothData[45];}?>>
            <img id="rang-nguoi-lon-46" class="tooth" title="RĂNG 46" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/46.png" style="position:absolute;width:11%;top: 67.5%;left: 20.5%;" <?php if(array_key_exists(46,$listToothData)){echo "data-tooth=".$listToothData[46];}?>>
            <img id="rang-nguoi-lon-47" class="tooth" title="RĂNG 47" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/47.png" style="position:absolute;width:11%;top: 60.1%;left: 18.5%;" <?php if(array_key_exists(47,$listToothData)){echo "data-tooth=".$listToothData[47];}?>>
            <img id="rang-nguoi-lon-48" class="tooth" title="RĂNG 48" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/medical/rang/48.png" style="position:absolute;width:11%;top: 51.9%;left: 18.3%;" <?php if(array_key_exists(48,$listToothData)){echo "data-tooth=".$listToothData[48];}?>>

            <div id="toggle-dental">
                <center><h5 id="tooth_number"></h5></center>
                <div onclick="openNav2();"><span>THÊM BỆNH</span></div>
                <div onclick="openNav()"><span>THÊM TÌNH TRẠNG</span></div>
                <div data-toggle="modal" data-target="#noteToothModal"><span>THÊM GHI CHÚ</span></div>
                <div onclick="retype();"><span>NHẬP LẠI</span></div>
                                                             
            </div>
            
            <span style="position: absolute;color: #000;top: 19%;left: 42%;">HÀM TRÊN</span>
            <span style="position: absolute;font-weight: 900;color: #000;top: 47%;left: 30%;font-family:sans-serif;">◄ RĂNG NGƯỜI LỚN ►</span>
            <span style="position: absolute;color: #000;top: 74%;left: 42%;">HÀM DƯỚI</span>
        </div>
        </div>
        <div class="col-md-7 margin-top-50">                
            <div style="background: url(<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/bg-rang.png) no-repeat; background-size: 100%;">
            <div class="row opacity-0" id="row_opacity">
            <h3 align="center" id="tooth_title">- RĂNG 17 -</h3>
                <div class="col-md-4">
                    <div class="table" style="width:100%; height:432px; text-align:center;">
                      <div class="cell">
                        <div id="nhai" style="position:relative;width:60%;margin: 0px auto;">
                            <img id="mat-nhai" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai-17.png" style="width: 100%;height: auto;">                           
                            <h5 style="color: #000;font-weight: normal;">MẶT NHAI</h5>
                            <?php 
                            if (!empty($listFaceTooth)) 
                            {                           
                            foreach ($listFaceTooth as $vl) 
                            {   
                                $listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matnhai");                     
                            ?>
                                <div id="mat_nhai_<?php echo $vl['tooth_number'];?>" class="mat">
                                <?php 
                                if (!empty($listToothImage)) 
                                {                           
                                foreach ($listToothImage as $v) 
                                {   
                                ?>
                                <img id="<?php echo $v['id_image'];?>" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
                                <?php 
                                }
                                }                           
                                ?>
                                </div>  
                            <?php 
                            }
                            }                           
                            ?>
                        </div> 
                       </div>    
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table" style="width:100%;text-align:center;">
                                <div class="cell">
                                    <div id="ngoai" style="position:relative;width:60%;margin: 0px auto;">                                      
                                        <img id="mat-ngoai" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai-17.png" style="width: 100%;height: auto;">                                     
                                        <h5 style="color: #000;font-weight: normal;">MẶT NGOÀI</h5>
                                        <?php 
                                        if (!empty($listFaceTooth)) 
                                        {
                                        foreach ($listFaceTooth as $vl) 
                                        {       
                                            $listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matngoai");                    
                                        ?>
                                            <div id="mat_ngoai_<?php echo $vl['tooth_number'];?>" class="mat">
                                            <?php 
                                            if (!empty($listToothImage)) 
                                            {                           
                                            foreach ($listToothImage as $v) 
                                            {   
                                            ?>
                                            <img id="<?php echo $v['id_image'];?>" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
                                            <?php 
                                            }
                                            }                           
                                            ?>  
                                            </div>  
                                        <?php 
                                        }
                                        }
                                        ?>  
                                    </div>
                                </div>
                            </div>      
                        </div>
                        <div class="col-md-6">
                            <div class="table" style="width:100%;text-align:center;">
                                <div class="cell">
                                    <div id="trong" style="position:relative;width:60%;">
                                        <img id="mat-trong" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong-17.png" style="width: 100%;height: auto;">                                     
                                        <h5 style="color: #000;font-weight: normal;">MẶT TRONG</h5>
                                        <?php 
                                        if (!empty($listFaceTooth)) 
                                        {   
                                        foreach ($listFaceTooth as $vl) 
                                        {           
                                            $listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"mattrong");                
                                        ?>
                                            <div id="mat_trong_<?php echo $vl['tooth_number'];?>" class="mat">
                                            <?php 
                                            if (!empty($listToothImage)) 
                                            {                           
                                            foreach ($listToothImage as $v) 
                                            {   
                                            ?>
                                            <img id="<?php echo $v['id_image'];?>" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
                                            <?php 
                                            }
                                            }                           
                                            ?>          
                                            </div>  
                                        <?php 
                                        }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>      
                        </div>
                        <div class="col-md-6">
                            <div class="table" style="width:100%;text-align:center;">
                                <div class="cell">
                                    <div id="gan" style="position:relative;width:60%;margin: 0px auto;">                                        
                                        <img id="mat-gan" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matgan-17.png" style="width: 100%;height: auto;">
                                        <h5 style="color: #000;font-weight: normal;">MẶT GẦN</h5>
                                        <?php 
                                        if (!empty($listFaceTooth)) 
                                        {   
                                        foreach ($listFaceTooth as $vl) 
                                        {   
                                            $listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matgan");                      
                                        ?>
                                            <div id="mat_gan_<?php echo $vl['tooth_number'];?>" class="mat">
                                            <?php 
                                            if (!empty($listToothImage)) 
                                            {                           
                                            foreach ($listToothImage as $v) 
                                            {   
                                            ?>
                                            <img id="<?php echo $v['id_image'];?>" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
                                            <?php 
                                            }
                                            }                           
                                            ?>
                                            </div>  
                                        <?php 
                                        }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table" style="width:100%;text-align:center;">
                                <div class="cell">
                                    <div id="xa" style="position:relative;width:60%;">                                      
                                        <img id="mat-xa" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matxa-17.png" style="width: 100%;height: auto;">
                                        <h5 style="color: #000;font-weight: normal;">MẶT XA</h5>
                                        <?php 
                                        if (!empty($listFaceTooth)) 
                                        {
                                        foreach ($listFaceTooth as $vl) 
                                        {   
                                            $listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matxa");                       
                                        ?>
                                            <div id="mat_xa_<?php echo $vl['tooth_number'];?>" class="mat">
                                            <?php 
                                            if (!empty($listToothImage)) 
                                            {                           
                                            foreach ($listToothImage as $v) 
                                            {   
                                            ?>
                                            <img id="<?php echo $v['id_image'];?>" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
                                            <?php 
                                            }
                                            }                           
                                            ?>  
                                            </div>  
                                        <?php 
                                        }
                                        }   
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            </div>
        </div>

        <input type="hidden" id="hidden_number">

    </div>

    <div class="row">
        <div class="col-md-5">
            <textarea disabled id="evaluate_state_of_tartar" class="form-control margin-top-30" rows="5" placeholder="Đánh giá tổng quan..." style="height:115px;width: 85%;background-color: #f1f5f6;border:0;font-weight: bold;"><?php echo $evaluateStateOfTartar->evaluate_state_of_tartar;?></textarea>
            

        </div>
        <div class="col-md-7 margin-top-30">
            <div class="col-md-12 margin-bottom-50" style="background-color:#f1f5f6;border-radius: 4px;padding-right:30px;padding-left:30px;min-height: 115px;">
                <h4 style="color:#5e5e5e;font-weight: bold;">KẾT LUẬN</h4>
                

                <div id="div_conclude">
                <?php 
				if (!empty($listToothConcludeAndNote)) 
				{	
				foreach ($listToothConcludeAndNote as $ltcan) 
				{
					$dental_status = $tooth_data->getDentalStatus($model->id,$ltcan['id_group_history'],$ltcan['tooth_number']);
				?>						
					<p id="ket_luan_<?php echo $ltcan['tooth_number'];?>" class="ket"><?php if ($ltcan['note'] != "" || !empty($ltcan['listToothConclude']) || $dental_status != ""){ ?><i>Răng <?php echo $ltcan['tooth_number'];?>: <?php echo $dental_status;?></i><?php } ?><?php if (!empty($ltcan['listToothConclude'])){foreach ($ltcan['listToothConclude'] as $ltc){ ?><i id="<?php echo $ltc['id_i']?>" data-user="<?php echo $ltc['id_user'];?>" data-toggle="tooltip" title="<?php echo $model->getNameByIdDentist($ltc['id_user']);?>"><?php echo $ltc['conclude']?></i><?php } } ?></p> 
					<p id="ghi_chu_<?php echo $ltcan['tooth_number'];?>" class="ghi"><?php echo $ltcan['note'];?></p>	
				<?php 
				}
				}
				?>
                </div>

            </div>
        </div>
    </div>
</div>


<script>

function onOpacityZero() {   
    $('#mat-nhai').addClass('opacity-0');
    $('#mat-ngoai').addClass('opacity-0');
    $('#mat-trong').addClass('opacity-0');
    $('#mat-gan').addClass('opacity-0');
    $('#mat-xa').addClass('opacity-0');
}
function offOpacityZero() {    
    $('#mat-nhai').removeClass('opacity-0');
    $('#mat-ngoai').removeClass('opacity-0');
    $('#mat-trong').removeClass('opacity-0');
    $('#mat-gan').removeClass('opacity-0');
    $('#mat-xa').removeClass('opacity-0');
}
function onOpacityZeroType1() {    
    $('#mat-ngoai').addClass('opacity-0');
    $('#mat-trong').addClass('opacity-0');
    $('#mat-gan').addClass('opacity-0');
    $('#mat-xa').addClass('opacity-0');
}

function checkSick(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];   
    var types =    [6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];   
    var types =    [101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkDecay(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
    var types = [8, 9, 10, 11, 12, 13, 14, 15, 16];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkFractured(number){

    var faces = ['matnhai', 'matngoai', 'mattrong'];
    var types = [21, 22, 23];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkResidualCrownRoot(type,number){ 

    if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){    

        if ($("#matngoai-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1 && $("#mattrong-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1){           
            
            return 1;
        }

        return 0;
    }

    return 0;
}

function checkResidualCrown(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 6;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;   

}

function checkCrown(number){

    var face = 'matnhai';    
    var type = 21;
                   
    if ($("#"+face+"-"+type+"-"+number).length > 0){  
        return 1;
    }  

    return 0;   

}

function checkCrownStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 103;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkPonticStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 104;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkResidualRootStatus(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 105;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkMissingStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 101;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkImplantStatus(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 106;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkRoot(number){

    var faces = ['matngoai', 'mattrong'];      
    var type = 22;  

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    }

    return 0;   

}

function checkCalculus(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];     
    var types = [24, 25, 26, 27];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkToothache(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];     
    var types = [17, 18, 19, 20];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkCrownRoot(number){

    var faces = ['matngoai', 'mattrong'];      
    var type = 23;  

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    }

    return 0;   

}

function checkRestorationStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
    var types = [107, 108, 109, 110, 111, 112, 113, 114, 115];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0; 

}

$(document).ready(function(){   
  $(".tooth").each(function() {  
        if($(this).attr("data-tooth")) {

            if($(this).attr("data-tooth")=='1') {               
                var src = $(this).attr("src").replace("rang", "rangbenh");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='103') {               
                var src = $(this).attr("src").replace("rang", "ranggiacodinh");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='101') {               
                var src = $(this).attr("src").replace("rang", "rangmat");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='106') {               
                var src = $(this).attr("src").replace("rang", "rangphuchoiIMPLANT");
                $(this).attr("src", src);                
            }
           
        }
    });  
});



$('.tooth').click(function (e) {  
    $('#row_opacity').removeClass('opacity-0');
    var title=$( this ).attr("title"); 
    var ret = title.split(" ");
    var number = ret[1];    
    var src1 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai-"+number+".png";
    var src2 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai-"+number+".png";
    var src3 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong-"+number+".png";
    var src4 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matgan-"+number+".png";
    var src5 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matxa-"+number+".png";            
    $('#tooth_title').html("- "+title+" -");
    $('#hidden_number').val(number);
    $('#mat-nhai').attr("src", src1); 
    $('#mat-ngoai').attr("src", src2);
    $('#mat-trong').attr("src", src3);
    $('#mat-gan').attr("src", src4);
    $('#mat-xa').attr("src", src5);
    $('.mat').addClass("hidden");
    $('#mat_nhai_'+number).removeClass("hidden");
    $('#mat_ngoai_'+number).removeClass("hidden");
    $('#mat_trong_'+number).removeClass("hidden");
    $('#mat_gan_'+number).removeClass("hidden");
    $('#mat_xa_'+number).removeClass("hidden"); 
    offOpacityZero();  

    if (checkMissingStatus(number) == 1) {
        onOpacityZero();
                            
    }else if (checkCrownStatus(number) == 1) {        
                          
    }else if (checkPonticStatus(number) == 1) {
        onOpacityZero();  

    }else if (checkResidualRootStatus(number) == 1) {
        onOpacityZeroType1();

    }else if (checkImplantStatus(number) == 1) {
        onOpacityZeroType1();

    }else if (checkResidualCrown(number) == 1) {
        onOpacityZeroType1();

    }

    if (checkCrown(number) == 1) {        
        $('#mat-nhai').addClass('opacity-0');
    }else if (checkRoot(number) == 1) {
        $('#mat-ngoai').addClass('opacity-0');
        $('#mat-trong').addClass('opacity-0');
    }else if (checkCrownRoot(number) == 1) {
        $('#mat-ngoai').addClass('opacity-0');
        $('#mat-trong').addClass('opacity-0');
    }
                                     
    $("#mat_nhai_"+number+" img").each(function() {         
        if ($(this).attr("id").indexOf("fractured-crown") >= 0){
            $('#mat-nhai').addClass('opacity-0');           
        }                 
    });

    $("#mat_ngoai_"+number+" img").each(function() {         
        if ($(this).attr("id").indexOf("fractured-root") >= 0 || $(this).attr("id").indexOf("fractured-crownRoot") >= 0){
            $('#mat-ngoai').addClass('opacity-0');           
        }                 
    });

    $("#mat_trong_"+number+" img").each(function() {         
        if ($(this).attr("id").indexOf("fractured-root") >= 0 || $(this).attr("id").indexOf("fractured-crownRoot") >= 0){
            $('#mat-trong').addClass('opacity-0');           
        }                 
    });  

});

$(function() {
    $(".tooth")
        .mouseover(function() { 
            if($(this).attr("data-tooth") == '1'){
                var src = $(this).attr("src").replace("rangbenh", "rangACTIVE");         
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth") == '103'){
                var src = $(this).attr("src").replace("ranggiacodinh", "rangACTIVE");         
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth") == '101'){
                var src = $(this).attr("src").replace("rangmat", "rangACTIVE");         
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth") == '106'){
                var src = $(this).attr("src").replace("rangphuchoiIMPLANT", "rangACTIVE");         
                $(this).attr("src", src);                
            }
            else{
                var src = $(this).attr("src").replace("rang", "rangACTIVE");         
                $(this).attr("src", src);
            }
        })
        .mouseout(function() {
            if($(this).attr("data-tooth") == '1'){
                var src = $(this).attr("src").replace("rangACTIVE", "rangbenh");            
                $(this).attr("src", src);
            }  
            else if($(this).attr("data-tooth") == '103'){
                var src = $(this).attr("src").replace("rangACTIVE", "ranggiacodinh");            
                $(this).attr("src", src);
            }   
            else if($(this).attr("data-tooth") == '101'){
                var src = $(this).attr("src").replace("rangACTIVE", "rangmat");            
                $(this).attr("src", src);
            }  
            else if($(this).attr("data-tooth") == '106'){
                var src = $(this).attr("src").replace("rangACTIVE", "rangphuchoiIMPLANT");            
                $(this).attr("src", src);
            }  
            else{
                var src = $(this).attr("src").replace("rangACTIVE", "rang");            
                $(this).attr("src", src);
            }    
        });
});



</script>		