<?php
$baseUrl = Yii::app()->baseUrl;
if ($treatment) {
	$id_mhg = $treatment->id;
	$name = $treatment->name;
	$date_treatment = $treatment->createdata;
} else {
	$id_mhg = $treatment;
	$name = '';
	$date_treatment = '';
}

$medical_history_group = $model->getListMedicalHistoryGroupByCustomer($model->id);
$count 				= count($medical_history_group);
$tooth_data 		= new ToothData;
$listToothData 		= $tooth_data->getListToothData($model->id,$id_mhg);
$listFaceTooth 		= $tooth_data->getListFaceTooth($model->id,$id_mhg);
$listToothStatus    = $tooth_data->getListToothStatusNew($model->id,$id_mhg);
$listOnlyToothNote  = $tooth_data->getListOnlyToothNote($model->id,$id_mhg);
$id_schedule 		= $model->getIdScheduleByIdCustomer($model->id);
$existQuotation     = $model->existQuotation($model->id,$id_mhg);
$labo = LaboHistory::model()->getLaboByCustomer($model->id);
?>

<input type="hidden" id="id_mhg" value="<?php echo $id_mhg; ?>">
<input type="hidden" id="id_customer" value="<?php echo $model->id; ?>">
<input type="hidden" id="check_change_status_process" value="<?php echo $model->checkChangeStatusProcess($model->id, $id_mhg); ?>">
<input type="hidden" id="check_add_new_treatment" value="<?php echo $model->checkAddNewTreatment($model->id, $id_mhg); ?>">
<input type="hidden" id="dental_status_change" value="0">
<input type="hidden" class="id_quotation" id="id_quotation" value="<?php echo $existQuotation['id']; ?>">
<input type="hidden" class="id_invoice" id="id_invoice" value="">
<input type="hidden" id="id_schedule" value="<?php echo $id_schedule; ?>">

<style type="text/css">
	.table-list2 tbody {
		position: relative;
	}
</style>

<div class="row">
	<div id="left_medical_records">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-7" id="list-treatment">
					<div class="row">
						<div class="bg-treatment" id="table_treatment">
							Đợt điều trị
							<?php echo $name;?>
							<?php if($date_treatment != "0000-00-00" && $date_treatment != "") echo date('d-m-Y',strtotime($date_treatment));?>
							<span class="caret fr margin-top-7"></span>
						</div>
					</div>

					<div class="treatment">
						<table class="table">
							<tbody>
								<?php if($medical_history_group && $count > 0):
									foreach ($medical_history_group as $key => $m_h_g): ?>
										<tr class="cursor" onclick="detailTreatment(<?php echo $m_h_g['id'];?>);">
											<td>
												Đợt điều trị
												<?php echo $m_h_g['name'];?>
												<?php if($m_h_g['createdata'] != "0000-00-00" && $m_h_g['createdata'] != "") echo date('d-m-Y',strtotime($m_h_g['createdata']));?>
											</td>
											<td class="text-right">
												<select class="form-control uT" <?php if($m_h_g['status_process'] !=0) echo "disabled" ;?>
												onchange="updateTreatment(
												<?php echo $m_h_g['id'];?>);">
												<option <?php if($m_h_g['status_process']==0) echo "selected" ;?>>Chưa Hoàn tất</option>
												<option <?php if($m_h_g['status_process']!=0) echo "selected" ;?>>Hoàn tất</option>
											</select>
										</td>
										<td onclick="printTreatmentRecords(<?php echo $m_h_g['id'];?>);">
											<span class="fa fa-print size-18"></span>
										</td>
									</tr>
								<?php endforeach;
							endif; ?>
						</tbody>
					</table>

					<div class="row">
						<div class="col-md-8 col-md-offset-2 margin-top-10 margin-bottom-10 ">
							<input id="add_new_treatment" class="form-control btn-green" type="submit" value="Thêm đợt điều trị mới" disabled />
						</div>
					</div>
				</div>
			</div>
			<?php
				$group_id =  Yii::app()->user->getState('group_id');
				if($group_id != 16):
			?>
				<div class="col-xs-5" style="padding-right: 0">
					<button class="btn btn-film" data-toggle="modal" data-target="#bootstrapFileinputMasterModal">Film</button>
					<button class="btn btn-save" id="save" disabled>Lưu lại</button>
				</div>
			<?php endif;?>
		</div>
	</div>
	<div class="col-xs-12 margin-top-10">
		<div class="row">
			<div class="col-xs-6">
				<div class="row">
					<div class="btn-group">
						<button id="typeTooth" type="button" class="btn btn-green" value="RĂNG NGƯỜI LỚN">RĂNG NGƯỜI LỚN</button>
						<button type="button" class="btn dropdown-toggle btn-green" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="#">RĂNG NGƯỜI LỚN</a>
							</li>
							<li>
								<a href="#">RĂNG TRẺ EM</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<button class="btn btn-film" data-toggle="modal" data-target="#otherModal2">Bệnh/tt khác</button>
				<button class="btn btn-film" id="tooth_2h">2H</button>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- bộ răng -->
	<div id="dental_status_img">

		<img id="rang-nguoi-lon-11" class="tooth" title="RĂNG 11" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/11.png"
		style="position:absolute;width:11%;left: 42%;" <?php if (array_key_exists(11, $listToothData)) { echo "data-tooth=" . $listToothData[11]; } ?>>

		<img id="rang-nguoi-lon-12" class="tooth" title="RĂNG 12" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/12.png"
		style="position:absolute;width:11%;top: 2%;left: 34.5%;" <?php if (array_key_exists(12, $listToothData)) { echo "data-tooth=" . $listToothData[12]; } ?>>

		<img id="rang-nguoi-lon-13" class="tooth" title="RĂNG 13" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/13.png"
		style="position:absolute;width:11%;top: 6%;left: 30%;" <?php if (array_key_exists(13, $listToothData)) { echo "data-tooth=" . $listToothData[13]; } ?>>

		<img id="rang-nguoi-lon-14" class="tooth" title="RĂNG 14" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/14.png"
		style="position:absolute;width:11%;top: 10.5%;left: 26%;" <?php if (array_key_exists(14, $listToothData)) { echo "data-tooth=" . $listToothData[14]; } ?>>

		<img id="rang-nguoi-lon-15" class="tooth" title="RĂNG 15" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/15.png"
		style="position:absolute;width:11%;top: 16.5%;left: 23.5%;" <?php if (array_key_exists(15, $listToothData)) { echo "data-tooth=" . $listToothData[15]; } ?>>

		<img id="rang-nguoi-lon-16" class="tooth" title="RĂNG 16" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/16.png"
		style="position:absolute;width:11%;top: 23.5%;left: 20.5%;" <?php if (array_key_exists(16, $listToothData)) { echo "data-tooth=" . $listToothData[16]; } ?>>

		<img id="rang-nguoi-lon-17" class="tooth" title="RĂNG 17" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/17.png"
		style="position:absolute;width:11%;top: 31%;left: 18.5%;" <?php if (array_key_exists(17, $listToothData)) { echo "data-tooth=" . $listToothData[17]; } ?>>

		<img id="rang-nguoi-lon-18" class="tooth" title="RĂNG 18" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/18.png"
		style="position:absolute;width:11%;top: 39%;left: 18%;" <?php if (array_key_exists(18, $listToothData)) { echo "data-tooth=" . $listToothData[18]; } ?>>

		<img id="rang-nguoi-lon-21" class="tooth" title="RĂNG 21" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/21.png"
		style="position:absolute;width:11%;left: 50.7%;" <?php if (array_key_exists(21, $listToothData)) { echo "data-tooth=" . $listToothData[21]; } ?>>

		<img id="rang-nguoi-lon-22" class="tooth" title="RĂNG 22" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/22.png"
		style="position:absolute;width:11%;top: 1.5%;left: 58%;" <?php if (array_key_exists(22, $listToothData)) { echo "data-tooth=" . $listToothData[22]; } ?>>

		<img id="rang-nguoi-lon-23" class="tooth" title="RĂNG 23" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/23.png"
		style="position:absolute;width:11%;top: 6%;left: 62%;" <?php if (array_key_exists(23, $listToothData)) { echo "data-tooth=" . $listToothData[23]; } ?>>

		<img id="rang-nguoi-lon-24" class="tooth" title="RĂNG 24" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/24.png"
		style="position:absolute;width:11%;top: 10.5%;left: 66%;" <?php if (array_key_exists(24, $listToothData)) { echo "data-tooth=" . $listToothData[24]; } ?>>

		<img id="rang-nguoi-lon-25" class="tooth" title="RĂNG 25" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/25.png"
		style="position:absolute;width:11%;top: 16.5%;left: 69.3%;" <?php if (array_key_exists(25, $listToothData)) { echo "data-tooth=" . $listToothData[25]; } ?>>

		<img id="rang-nguoi-lon-26" class="tooth" title="RĂNG 26" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/26.png"
		style="position:absolute;width:11%;top: 23.3%;left: 71.7%;" <?php if (array_key_exists(26, $listToothData)) { echo "data-tooth=" . $listToothData[26]; } ?>>

		<img id="rang-nguoi-lon-27" class="tooth" title="RĂNG 27" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/27.png"
		style="position:absolute;width:11%;top: 30.7%;left: 74%;" <?php if (array_key_exists(27, $listToothData)) { echo "data-tooth=" . $listToothData[27]; } ?>>

		<img id="rang-nguoi-lon-28" class="tooth" title="RĂNG 28" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/28.png"
		style="position:absolute;width:11%;top: 39%;left: 74%;" <?php if (array_key_exists(28, $listToothData)) { echo "data-tooth=" . $listToothData[28]; } ?>>

		<img id="rang-nguoi-lon-31" class="tooth" title="RĂNG 31" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/31.png"
		style="position:absolute;width:11%;top: 91.2%;left: 50.7%;" <?php if (array_key_exists(31, $listToothData)) { echo "data-tooth=" . $listToothData[31]; } ?>>

		<img id="rang-nguoi-lon-32" class="tooth" title="RĂNG 32" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/32.png"
		style="position:absolute;width:11%;top: 89.3%;left: 58%" <?php if (array_key_exists(32, $listToothData)) { echo "data-tooth=" . $listToothData[32]; } ?>>

		<img id="rang-nguoi-lon-33" class="tooth" title="RĂNG 33" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/33.png"
		style="position:absolute;width:11%;top: 85%;left: 62%;" <?php if (array_key_exists(33, $listToothData)) { echo "data-tooth=" . $listToothData[33]; } ?>>

		<img id="rang-nguoi-lon-34" class="tooth" title="RĂNG 34" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/34.png"
		style="position:absolute;width:11%;top: 80.5%;left: 66%;" <?php if (array_key_exists(34, $listToothData)) { echo "data-tooth=" . $listToothData[34]; } ?>>

		<img id="rang-nguoi-lon-35" class="tooth" title="RĂNG 35" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/35.png"
		style="position:absolute;width:11%;top: 74.5%;left: 69.3%;" <?php if (array_key_exists(35, $listToothData)) { echo "data-tooth=" . $listToothData[35]; } ?>>

		<img id="rang-nguoi-lon-36" class="tooth" title="RĂNG 36" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/36.png"
		style="position:absolute;width:11%;top: 67.5%;left: 71.7%;" <?php if (array_key_exists(36, $listToothData)) { echo "data-tooth=" . $listToothData[36]; } ?>>

		<img id="rang-nguoi-lon-37" class="tooth" title="RĂNG 37" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/37.png"
		style="position:absolute;width:11%;top: 60%;left: 73.5%;" <?php if (array_key_exists(37, $listToothData)) { echo "data-tooth=" . $listToothData[37]; } ?>>

		<img id="rang-nguoi-lon-38" class="tooth" title="RĂNG 38" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/38.png"
		style="position:absolute;width:11%;top: 52%;left: 74%;" <?php if (array_key_exists(38, $listToothData)) { echo "data-tooth=" . $listToothData[38]; } ?>>

		<img id="rang-nguoi-lon-41" class="tooth" title="RĂNG 41" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/41.png"
		style="position:absolute;width:11%;top: 91.3%;left: 41.7%;" <?php if (array_key_exists(41, $listToothData)) { echo "data-tooth=" . $listToothData[41]; } ?>>

		<img id="rang-nguoi-lon-42" class="tooth" title="RĂNG 42" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/42.png"
		style="position:absolute;width:11%;top: 89.3%;left: 34.4%;" <?php if (array_key_exists(42, $listToothData)) { echo "data-tooth=" . $listToothData[42]; } ?>>

		<img id="rang-nguoi-lon-43" class="tooth" title="RĂNG 43" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/43.png"
		style="position:absolute;width:11%;top: 85.1%;left: 30.3%;" <?php if (array_key_exists(43, $listToothData)) { echo "data-tooth=" . $listToothData[43]; } ?>>

		<img id="rang-nguoi-lon-44" class="tooth" title="RĂNG 44" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/44.png"
		style="position:absolute;width:11%;top: 80.5%;left: 26.5%;" <?php if (array_key_exists(44, $listToothData)) { echo "data-tooth=" . $listToothData[44]; } ?>>

		<img id="rang-nguoi-lon-45" class="tooth" title="RĂNG 45" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/45.png"
		style="position:absolute;width:11%;top: 74.5%;left: 23%;" <?php if (array_key_exists(45, $listToothData)) { echo "data-tooth=" . $listToothData[45]; } ?>>

		<img id="rang-nguoi-lon-46" class="tooth" title="RĂNG 46" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/46.png"
		style="position:absolute;width:11%;top: 67.5%;left: 20.5%;" <?php if (array_key_exists(46, $listToothData)) { echo "data-tooth=" . $listToothData[46]; } ?>>

		<img id="rang-nguoi-lon-47" class="tooth" title="RĂNG 47" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/47.png"
		style="position:absolute;width:11%;top: 60.1%;left: 18.5%;" <?php if (array_key_exists(47, $listToothData)) { echo "data-tooth=" . $listToothData[47]; } ?>>

		<img id="rang-nguoi-lon-48" class="tooth" title="RĂNG 48" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/48.png"
		style="position:absolute;width:11%;top: 51.9%;left: 18.3%;" <?php if (array_key_exists(48, $listToothData)) { echo "data-tooth=" . $listToothData[48]; } ?>>

		<div id="universal_kid" class="hide">
			<img id="rang-nguoi-lon-51" class="tooth" title="RĂNG 51" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/51.png"
			style="position:absolute;width:8%;top: 23%;left: 44%;" <?php if (array_key_exists(51, $listToothData)) { echo "data-tooth=" . $listToothData[51]; } ?>>

			<img id="rang-nguoi-lon-52" class="tooth" title="RĂNG 52" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/52.png"
			style="position:absolute;width:8%;top: 26%;left: 38%;" <?php if (array_key_exists(52, $listToothData)) { echo "data-tooth=" . $listToothData[52]; } ?>>

			<img id="rang-nguoi-lon-53" class="tooth" title="RĂNG 53" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/53.png"
			style="position:absolute;width:8%;top: 30%;left: 34%;" <?php if (array_key_exists(53, $listToothData)) { echo "data-tooth=" . $listToothData[53]; } ?>>

			<img id="rang-nguoi-lon-54" class="tooth" title="RĂNG 54" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/54.png"
			style="position:absolute;width:8%;top: 34%;left: 31%;" <?php if (array_key_exists(54, $listToothData)) { echo "data-tooth=" . $listToothData[54]; } ?>>

			<img id="rang-nguoi-lon-55" class="tooth" title="RĂNG 55" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/55.png"
			style="position:absolute;width:8%;top: 40%;left: 29%;" <?php if (array_key_exists(55, $listToothData)) { echo "data-tooth=" . $listToothData[55]; } ?>>

			<img id="rang-nguoi-lon-61" class="tooth" title="RĂNG 61" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/61.png"
			style="position:absolute;width:8%;top: 23%;left: 52%;" <?php if (array_key_exists(61, $listToothData)) { echo "data-tooth=" . $listToothData[61]; } ?>>

			<img id="rang-nguoi-lon-62" class="tooth" title="RĂNG 62" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/62.png"
			style="position:absolute;width:8%;top: 26%;left: 58%;" <?php if (array_key_exists(62, $listToothData)) { echo "data-tooth=" . $listToothData[62]; } ?>>

			<img id="rang-nguoi-lon-63" class="tooth" title="RĂNG 63" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/63.png"
			style="position:absolute;width:8%;top: 30%;left: 62%;" <?php if (array_key_exists(63, $listToothData)) { echo "data-tooth=" . $listToothData[63]; } ?>>

			<img id="rang-nguoi-lon-64" class="tooth" title="RĂNG 64" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/64.png"
			style="position:absolute;width:8%;top: 34%;left: 65%;" <?php if (array_key_exists(64, $listToothData)) { echo "data-tooth=" . $listToothData[64]; } ?>>

			<img id="rang-nguoi-lon-65" class="tooth" title="RĂNG 65" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/65.png"
			style="position:absolute;width:8%;top: 40%;left: 66%;" <?php if (array_key_exists(65, $listToothData)) { echo "data-tooth=" . $listToothData[65]; } ?>>

			<img id="rang-nguoi-lon-71" class="tooth" title="RĂNG 71" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/71.png"
			style="position:absolute;width:8%;top: 70%;left: 52%;" <?php if (array_key_exists(71, $listToothData)) { echo "data-tooth=" . $listToothData[71]; } ?>>

			<img id="rang-nguoi-lon-72" class="tooth" title="RĂNG 72" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/72.png"
			style="position:absolute;width:8%;top: 67%;left: 58%;" <?php if (array_key_exists(72, $listToothData)) { echo "data-tooth=" . $listToothData[72]; } ?>>

			<img id="rang-nguoi-lon-73" class="tooth" title="RĂNG 73" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/73.png"
			style="position:absolute;width:8%;top: 63%;left: 62%;" <?php if (array_key_exists(73, $listToothData)) { echo "data-tooth=" . $listToothData[73]; } ?>>

			<img id="rang-nguoi-lon-74" class="tooth" title="RĂNG 74" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/74.png"
			style="position:absolute;width:8%;top: 59%;left: 65%;" <?php if (array_key_exists(74, $listToothData)) { echo "data-tooth=" . $listToothData[74]; } ?>>

			<img id="rang-nguoi-lon-75" class="tooth" title="RĂNG 75" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/75.png"
			style="position:absolute;width:8%;top: 53%;left: 66%;" <?php if (array_key_exists(75, $listToothData)) { echo "data-tooth=" . $listToothData[75]; } ?>>

			<img id="rang-nguoi-lon-81" class="tooth" title="RĂNG 81" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/81.png"
			style="position:absolute;width:8%;top: 70%;left: 44%;" <?php if (array_key_exists(81, $listToothData)) { echo "data-tooth=" . $listToothData[81]; } ?>>

			<img id="rang-nguoi-lon-82" class="tooth" title="RĂNG 82" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/82.png"
			style="position:absolute;width:8%;top: 67%;left: 38%;" <?php if (array_key_exists(82, $listToothData)) { echo "data-tooth=" . $listToothData[82]; } ?>>

			<img id="rang-nguoi-lon-83" class="tooth" title="RĂNG 83" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/83.png"
			style="position:absolute;width:8%;top: 63%;left: 34%;" <?php if (array_key_exists(83, $listToothData)) { echo "data-tooth=" . $listToothData[83]; } ?>>

			<img id="rang-nguoi-lon-84" class="tooth" title="RĂNG 84" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/84.png"
			style="position:absolute;width:8%;top: 59%;left: 31%;" <?php if (array_key_exists(84, $listToothData)) { echo "data-tooth=" . $listToothData[84]; } ?>>

			<img id="rang-nguoi-lon-85" class="tooth" title="RĂNG 85" src="<?php echo $baseUrl; ?>/images/medical_record/medical/rang/85.png"
			style="position:absolute;width:8%;top: 53%;left: 29%;" <?php if (array_key_exists(85, $listToothData)) { echo "data-tooth=" . $listToothData[85]; } ?>>
		</div>
	</div>
	<!-- Ghi chú trên răng -->
	<div class="col-xs-12 noteTooth">
		<div class="row">
			<div>1. Nhóm tình trạng sức khỏe răng:</div>
			<div class="row">
				<div class="col-md-7">
					<div>
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-khoe.jpg">&nbsp;&nbsp;Răng khỏe mạnh
					</div>
					<div>
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-benh.jpg">&nbsp;&nbsp;Răng bệnh
					</div>
				</div>
				<div class="col-md-5">
					<div>
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-yeu.jpg">&nbsp;&nbsp;Răng yếu
					</div>
					<div>
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-mat.jpg">&nbsp;&nbsp;Răng mất
					</div>
				</div>
			</div>

			<div>2. Nhóm tình trạng sau điều trị:</div>
			<div class="row">
				<div class="col-md-7">
					<div style="border-left: 2px solid;padding-left: 5px;margin-left: 8px;">
						<div>Răng phục hồi cố định</div>
						<div>
							<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-gia-co-dinh.jpg">&nbsp;&nbsp;Răng giả cố định
						</div>
						<div>
							<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/vi-tri-cau-rang-gia.jpg">&nbsp;&nbsp;Vị trí cầu răng giả
						</div>
					</div>
					<div style="margin-left:15px;">
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-phuc-hoi-thao-lap.jpg">&nbsp;&nbsp;Răng phục hình tháo lắp
					</div>
					<div style="margin-left:15px;">
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/phuc-hoi-implant.jpg">&nbsp;&nbsp;Răng phục hình Implant
					</div>
				</div>
				<div class="col-md-5">
					<div>
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-tram-A.jpg">&nbsp;&nbsp;Răng trám A
					</div>
					<div>
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-tram-CO.jpg">&nbsp;&nbsp;Răng trám CO
					</div>
					<div>
						<img width="10%" src="<?php echo $baseUrl; ?>/images/medical_record/color_icon/rang-tram-GIC.jpg">&nbsp;&nbsp;Răng trám GIC
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- xem chi tiết từng răng -->
	<div class="col-md-12 margin-top-50 bg-detail-tooth">
		<div class="row opacity-0" id="detail_tooth">
			<h3 align="center" id="tooth_title">- RĂNG 17 -</h3>

			<div class="col-md-6 col-md-offset-3 margin-bottom-10">
				<div id="nhai" class="content">
					<img id="mat-nhai" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/matnhai-17.png" class="img-responsive">
					<h5>MẶT NHAI</h5>

					<?php if (!empty($listFaceTooth)) {
						foreach ($listFaceTooth as $vl) {

							$listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matnhai");
							?>

							<div id="mat_nhai_<?php echo $vl['tooth_number'];?>" class="mat">

								<?php
								if (!empty($listToothImage)) {
									foreach ($listToothImage as $v) {
										?>
										<img id="<?php echo $v['id_image'];?>" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
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
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6 margin-bottom-10">
						<div id="ngoai" class="content">
							<img id="mat-ngoai" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/matngoai-17.png" class="img-responsive">
							<h5 class="text-center">MẶT NGOÀI</h5>
							<?php
							if (!empty($listFaceTooth)) {
								foreach ($listFaceTooth as $vl) {
									$listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matngoai");
									?>
									<div id="mat_ngoai_<?php echo $vl['tooth_number'];?>" class="mat">
										<?php
										if (!empty($listToothImage)) {
											foreach ($listToothImage as $v) {
												?>
												<img id="<?php echo $v['id_image'];?>" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>"  style="position: absolute;top: 0;left: 0;width:100%;height: auto;" />
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
					<div class="col-md-6 margin-bottom-10">
						<div id="trong" class="content">
							<img id="mat-trong" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/mattrong-17.png" class="img-responsive">
							<h5 class="text-center">MẶT TRONG</h5>
							<?php
							if (!empty($listFaceTooth)) {
								foreach ($listFaceTooth as $vl) {
									$listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"mattrong");
									?>
									<div id="mat_trong_<?php echo $vl['tooth_number'];?>" class="mat">
										<?php
										if (!empty($listToothImage)) {
											foreach ($listToothImage as $v) {
												?>
												<img id="<?php echo $v['id_image'];?>" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>"  style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
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
					<div class="col-md-6 margin-bottom-10">
						<div id="gan" class="content">
							<img id="mat-gan" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/matgan-17.png" class="img-responsive">
							<h5 class="text-center">MẶT GẦN</h5>
							<?php
							if (!empty($listFaceTooth)) {
								foreach ($listFaceTooth as $vl) {
									$listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matgan");
									?>
									<div id="mat_gan_<?php echo $vl['tooth_number'];?>" class="mat">
										<?php
										if (!empty($listToothImage)) {
											foreach ($listToothImage as $v) {
												?>
												<img id="<?php echo $v['id_image'];?>" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>"  style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
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
					<div class="col-md-6 margin-bottom-10">
						<div id="xa" class="content">
							<img id="mat-xa" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/matxa-17.png" class="img-responsive">
							<h5 class="text-center">MẶT XA</h5>
							<?php
							if (!empty($listFaceTooth)) {
								foreach ($listFaceTooth as $vl) {
									$listToothImage = $tooth_data->getListToothImage($model->id,$id_mhg,$vl['tooth_number'],"matxa");
									?>
									<div id="mat_xa_<?php echo $vl['tooth_number'];?>" class="mat">
										<?php
										if (!empty($listToothImage)) {
											foreach ($listToothImage as $v) {
												?>
												<img id="<?php echo $v['id_image'];?>" src="<?php echo $baseUrl; ?>/images/medical_record/images/rang-nguoi-lon/<?php echo $v['src_image'];?>"  style="position: absolute;top: 0;left: 0;width:100%;height: auto;">
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
					<input type="hidden" id="hidden_number">
					<input type="hidden" id="hidden_string_number">
					<input type="hidden" id="id_user" value="<?php echo yii::app()->user->getState('user_id');?>">
				</div>
			</div>
		</div>
	</div>

	<!-- popup thêm bệnh, tình trạng, điều trị, ghi chú, nhập lại -->
	<div id="toggle-dental" class="popover bottom">
		<div class="col-xs-12 header">
			<div class="row">
				<div id="tooth_number">Nhập răng 27</div>
				<a class="closebtn" onclick="closeNav()">
					<img src="<?php echo $baseUrl; ?>/images/cancel.png" class="img-responsive">
				</a>
			</div>
		</div>
		<div class="col-xs-12 popover-content menu-option">
			<div class="row">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#benhan">Bệnh</a>
					</li>
					<li>
						<a data-toggle="tab" href="#tinhtrang">Tình trạng</a>
					</li>

					<li>
						<a href="javascript:void(0)"  onclick="retype();">Nhập lại</a>
					</li>
					<div class="clearfix"></div>
					<?php if($group_id != 16): ?>
						<li>
							<a data-toggle="tab" href="#baogia" class="quote_open" data-teeth="1">Báo giá</a>
						</li>
						<li>
							<a data-toggle="modal" data-target="#add-treatment-process-modal" onclick="viewTreatment(1,'');">Công tác điều trị</a>
						</li>
						<li>
							<a data-toggle="tab" href="#hoadon" class="invoice_open" data-teeth="1">Điều trị</a>
						</li>
					<?php endif ;?>
				</ul>
				<div class="tab-content margin-top-15">
					<div id="benhan" class="tab-pane fade in active">
						<div class="sidenav">
							<div class="submenu">
								<a class="submenu-heading" data-parent="#nav-menu" data-toggle="collapse" data-target="#submenu2" >
									<img src="<?php echo $baseUrl; ?>/images/medical_record/images/decay.png" >  Sâu răng
								</a>
								<div class="submenu-body collapse" id="submenu2">
									<div class="list-group">

										<a href="javascript:void(0)" onclick="incisalSal(2);" class="list-group-item decay"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/incisal...sal.png" style="width:10%;">   Mặt nhai</a>

										<a  onclick="proximalD(2);" class="list-group-item decay">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/proximal-d.png" >   Mặt bên (X)
										</a>
										<a  onclick="proximalM(2);" class="list-group-item decay">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/proximal-m.png" >   Mặt bên (G)
										</a>
										<a  onclick="abfractionV(2);" class="list-group-item decay">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/abfraction.png" >   Cổ răng
										</a>
										<a  onclick="facialBuccal(2);" class="list-group-item decay">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/facial-buccal.png" >   Mặt ngoài
										</a>
										<a  onclick="palateLingual(2);" class="list-group-item decay">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/palate-lingual.png" >   Mặt trong
										</a>
									</div>
								</div>
							</div>
							<div class="submenu">
								<a class="submenu-heading" data-parent="#nav-menu" data-toggle="collapse" data-target="#submenu3" ><img src="<?php echo $baseUrl; ?>/images/medical_record/images/toothache.png" >   Đau răng</a>
								<div class="submenu-body collapse" id="submenu3">
									<div class="list-group">
										<a  onclick="sensitive();" class="list-group-item toothache"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/sensitive.png" >   Nhạy cảm</a>
										<a  onclick="pulpitis();" class="list-group-item toothache"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/pulpitis.png" >   Viêm tuỷ</a>
										<a  onclick="acutePeriapical();" class="list-group-item toothache"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/acute-periapical.png" >Viêm quanh chóp cấp</a>
										<a  onclick="chronicPeriapical();" class="list-group-item toothache"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/chroni...riapical.png" >   Viêm quanh chóp mãn</a>
									</div>
								</div>
							</div>
							<div class="submenu">
								<a class="submenu-heading" data-parent="#nav-menu" data-toggle="collapse" data-target="#submenu4" ><img src="<?php echo $baseUrl; ?>/images/medical_record/images/fractured.png" >   Nứt răng</a>
								<div class="submenu-body collapse" id="submenu4">
									<div class="list-group">
										<a  onclick="crown();" class="list-group-item fractured"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/crown-sub.png" >   Nứt thân răng</a>
										<a  onclick="root();" class="list-group-item fractured"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/root.png" >   Nứt chân răng</a>
										<a  onclick="crownRoot();" class="list-group-item fractured"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/crown-root.png" >   Nứt thân- chân răng</a>
									</div>
								</div>
							</div>
							<div class="submenu">
								<a class="submenu-heading" data-parent="#nav-menu" data-toggle="collapse" data-target="#submenu5" ><img src="<?php echo $baseUrl; ?>/images/medical_record/images/calculus.png" >   Vôi răng</a>
								<div class="submenu-body collapse" id="submenu5">
									<div class="list-group">
										<a  onclick="gradeI(1);" class="list-group-item calculus"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/calculus-grade1.png" >   Độ 1</a>
										<a  onclick="gradeII(1);" class="list-group-item calculus"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/calculus-grade2.png" >   Độ 2</a>
										<a  onclick="gradeIII(1);" class="list-group-item calculus"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/calculus-grade3.png" >   Độ 3</a>
										<a  onclick="gradeIV();" class="list-group-item calculus"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/calculus-grade3.png" >   Độ 4</a>
									</div>
								</div>
							</div>
							<div class="submenu">
								<a class="submenu-heading" data-parent="#nav-menu" data-toggle="collapse" data-target="#submenu6" ><img src="<?php echo $baseUrl; ?>/images/medical_record/images/mobility.png" >   Lung lay</a>
								<div class="submenu-body collapse" id="submenu6">
									<div class="list-group">
										<a  onclick="gradeI(2);" class="list-group-item mobility"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/mobility-grade1.png" >   Độ 1</a>
										<a  onclick="gradeII(2);" class="list-group-item mobility"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/mobility-grade2.png" >   Độ 2</a>
										<a  onclick="gradeIII(2);" class="list-group-item mobility"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/mobility-grade3.png" >   Độ 3</a>
									</div>
								</div>
							</div>
							<a id="residual_crown"  onclick="residualCrown()"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/residual-crown.png" >   Răng bể</a>

							<div class="submenu">
								<a class="submenu-heading" data-parent="#nav-menu" data-toggle="collapse" data-target="#submenu7" ><img src="<?php echo $baseUrl; ?>/images/medical_record/images/calculus.png" >   Túi nha chu</a>
								<div class="submenu-body collapse" id="submenu7">
									<div class="list-group">
										<a  onclick="mesial(3);" class="list-group-item periodontal"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/mesial.png" >   Mặt gần</a>
										<a  onclick="distal(3);" class="list-group-item periodontal"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/distal.png" >   Mặt xa</a>
										<a  onclick="facialBuccal(3);" class="list-group-item periodontal"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/facial-buccal.png" >   Mặt ngoài</a>
										<a  onclick="palateLingual(3);" class="list-group-item periodontal"><img src="<?php echo $baseUrl; ?>/images/medical_record/images/palate-lingual.png" >   Mặt trong</a>
									</div>
								</div>
							</div>

							<a  onclick="toothOther()">Khác</a>
						</div>
					</div>
					<div id="tinhtrang" class="tab-pane fade">
						<div class="sidenav" >
							<a id="missing"  onclick="missingStatus();">
								<img src="<?php echo $baseUrl; ?>/images/medical_record/images/missing.png">   Răng mất
							</a>
							<div class="submenu">
								<a class="submenu-heading" data-parent="#nav-menu" data-toggle="collapse" data-target="#submenu1" >
									<img src="<?php echo $baseUrl; ?>/images/medical_record/images/restoration.png">   Phục hồi (miếng trám)
								</a>
								<div class="submenu-body collapse" id="submenu1">
									<div class="list-group">
										<a  onclick="incisalUsal(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/incisal...usal.png">   Mặt nhai (X)
										</a>
										<a  onclick="incisalSal(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/incisal...sal.png">   Mặt nhai (G)
										</a>
										<a  onclick="distal(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/distal.png">   Mặt xa
										</a>
										<a  onclick="mesial(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/mesial.png">   Mặt gần
										</a>
										<a  onclick="proximalD(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/proximal-d.png">   Mặt bên xa
										</a>
										<a  onclick="proximalM(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/proximal-m.png">   Mặt bên gần
										</a>
										<a  onclick="abfractionV(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/abfraction.png">   Cổ răng
										</a>
										<a  onclick="facialBuccal(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/facial-buccal.png">   Mặt ngoài
										</a>
										<a  onclick="palateLingual(1);" class="list-group-item restoration">
											<img src="<?php echo $baseUrl; ?>/images/medical_record/images/palate-lingual.png">   Mặt trong
										</a>
									</div>
								</div>
							</div>

							<a id="crown"  onclick="crownStatus();">
								<img src="<?php echo $baseUrl; ?>/images/medical_record/images/crown.png">   Mão
							</a>
							<a id="pontic"  onclick="ponticStatus();">
								<img src="<?php echo $baseUrl; ?>/images/medical_record/images/pontic.png">   Nhịp cầu
							</a>

							<a id="residual_root"  onclick="residualRootStatus();">
								<img src="<?php echo $baseUrl; ?>/images/medical_record/images/residual-root.png">   Còn chân răng
							</a>

							<a id="implant"  onclick="implantStatus();">
								<img src="<?php echo $baseUrl; ?>/images/medical_record/images/implant.png">   Implant
							</a>

							<a class="rang_moc_lech"  onclick="rangMocLech();">
								<img src="<?php echo $baseUrl; ?>/images/medical_record/images/residual-root.png">   Răng mọc lệch
							</a>

							<a class="rang_moc_ngam"  onclick="rangMocNgam();">
								<img src="<?php echo $baseUrl; ?>/images/medical_record/images/residual-root.png">   Răng mọc ngầm
							</a>
							<a  onclick="toothOther()">Khác</a>
						</div>
					</div>
					<div id="dieutri" class="tab-pane fade">
						<h3>Menu 2</h3>
						<p>Some content in menu 2.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="right_medical_records">
	<div class="col-xs-12 exam_result">
		<div class="title">1. Kết Quả khám</div>
		<div >
			<table class="table table-list margin-top-10 " id="table_conclude">
				<thead>
					<tr>
						<th class="th1">Răng</th>
						<th class="th2 text-left">Chẩn đoán</th>
						<th class="th3 text-left">Chỉ định</th>
						<th class="th4 text-left"></th>
					</tr>
				</thead>
				<tbody style="top: 70px">
					<?php
					$i = 0;
					if (!empty($listToothStatus)) :
						foreach ($listToothStatus as $tooth_status) :
							$i++;
							?>
							<tr>
								<td class="th1 sorang" id="so_rang_<?php echo $tooth_status['tooth_number'];?>">
									<span>
										<?php echo str_replace( "_", " ", $tooth_status['tooth_number']);?>
									</span>
								</td>
								<td class="th2 ketluan text-left" id="ket_luan_<?php echo $tooth_status['tooth_number'];?>">
									<?php
									if (!empty($tooth_status['listToothConclude'])){
										foreach ($tooth_status['listToothConclude'] as $k =>$tooth_conclude){
											?>
											<span id="<?php echo $tooth_conclude['id_i']?>"  data-user="<?php echo $tooth_conclude['id_user'];?>" data-toggle="tooltip" title="<?php echo $model->getNameByIdDentist($tooth_conclude['id_user']);?>">
												<?php
												$conclude = $tooth_conclude['conclude'];
												if($k == 0){
													echo str_replace(", "," ",$conclude);
												}else{
													echo $conclude;
												}
												?>
											</span>
											<?php
										}
									}
									?>
								</td>
								<td class="th3 text-left chidinh" id="chi_dinh_<?php echo $tooth_status['tooth_number'];?>">
									<textarea rows='1' placeholder="Nhập chỉ định" class="textarea"><?php echo $tooth_status['assign']; ?></textarea>
								</td>
								<td>
									<?php if($group_id != 16): ?>
										<i class="fa fa-trash-o" data-tooth="<?php echo $tooth_status['tooth_number']; ?>" id="deletetooth" aria-hidden="true" style="font-size: 30px" ></i>
									<?php endif?>
								</td>
							</tr>
							<?php
						endforeach;
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-xs-12 margin-top-30 treatmen_result">
		<div class="row treatmen_result_1">
			<div class="title col-xs-4">2. Điều trị</div>
			<div class="col-xs-8">
				<span style="padding-right: 10px;">Đợt điều trị</span>
				<input type="hidden" id="id_mhg_dt" value="<?php echo $id_mhg; ?>">
				<?php
				if($medical_history_group && $count > 0):
					foreach ($medical_history_group as $key => $m_h_g): ?>
						<button class="btn btn_ddt <?php if($id_mhg ==$m_h_g['id'] ){echo 'btn-green';} ?>" style="margin-bottom: 10px;margin-right: 1%;" data-key="<?php echo $m_h_g['id']; ?>"><?php echo $m_h_g['name']; ?></button>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
		<div class="col-xs-5 margin-top-10 margin-bottom-10 treatmen_result_2">
			<div class="row">
				<div class="col-xs-6" style="padding-left: 0">
					<input id="search_tooth" class="form-control" placeholder="Tìm theo số răng" >
				</div>
				<div class="col-xs-6" style="padding-left: 0">
					<input id="search_code_service" class="form-control" placeholder="Tìm theo mã dịch vụ" >
				</div>
			</div>
		</div>
		<div class="col-xs-7 margin-top-10 ">
			<div class="row">
				<button class="btn btn-green fr hidden" id="see_all">Xem tất cả</button>
				<button class="btn btn-green fr hidden" id="see_hidden">Ẩn bớt</button>
				<?php if($group_id != 16): ?>
					<button class="btn btn-green fr quote_open" data-teeth="0">Báo giá</button>
					<button class="btn btn-green fr invoice_open">Điều trị</button>
					<button class="btn btn-green fr" data-toggle="modal" data-target="#add-treatment-process-modal" onclick="viewTreatment(2,'');">
						Công tác điều trị
					</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="row" id="ds_dieutri">
				<table class="table table-list2 margin-top-10 table-fix">
					<thead>
						<tr>
							<th style="width: 10%">Ngày</th>
							<th style="width: 20%;">Răng</th>
							<th style="width: 10%">Mã DV</th>
							<th style="width: 30%">Công tác điều trị</th>
							<th style="width: 15%">Chi phí</th>
							<th style="width: 15%">Bác sĩ</th>
						</tr>
					</thead>
					<tbody id="InvoiceAndTreatment" styles="position: relative;">
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 margin-top-30 labo_result">
		<div class="labo_result_1">
			<div class="title">3. Thông tin giao nhận labo</div>
				<table class="table table-list margin-top-10 " id="table_conclude">
					<thead>
						<tr>	
							<th>Tên Labo</th>
							<th>Ngày giờ giao</th>
							<th>Người giao</th>
							<th>Ngày giờ nhận</th>
							<th>Người nhận</th>
							<th width="3%"></th>
						</tr>
					</thead>
					<tbody >
						<?php
						if ($labo):
							foreach ($labo as $key => $value):
								?>
								<tr>
									<td><?php echo $value['labo_name'] ?></td>
									<td><?php echo $value['sent_date'] ?></td>
									<td><?php echo $value['sent_person'] ?></td>
									<td><?php echo $value['receive_date'] ?></td>
									<td><?php echo $value['receive_person'] ?></td>
									<td width="3%">
										<i class="fa fa-pencil" style="font-size:20px; float: right;cursor: pointer;" onclick="openUpdateLabo(<?php echo $value['id'] ?>)"></i>
									</td>
								</tr>
								<?php
							endforeach;
						else:
							echo "<tr><td colspan='14'>Không có dữ liệu</td></tr>";
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Upload film -->
<div class="modal fade" id="bootstrapFileinputMasterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header sHeader">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Thư Viện Ảnh Tình Trạng Răng</h3>
			</div>
			<div class="modal-body">
				<form enctype="multipart/form-data">
					<div class="form-group">
						<input id="upload-film" name="kartik-upload-film[]" type="file" multiple class="file-loading">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- BAO GIA -->
<div id="quote_modal" class="modal fade"></div>
<!-- HOA DON -->
<div id="invoice_modal" class="modal fade"></div>

<!-- Thêm công tác điều trị -->
<div id="add-treatment-process-modal" class="modal fade margin-top-50"></div>

<!-- Thêm toa thuốc -->
<div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<!-- Thêm lab -->
<div class="modal fade" id="labModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<!-- pop up dat lich hen -->
<div id="CalendarModal" class="modal fade"></div>

<!-- pop up thêm bệnh, tình trạng khác -->
<div id="otherModal" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header sHeader">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h3 id="modalTitle" class="modal-title">Nhập bệnh/ tình trạng khác</h3>
			</div>
			<div class="modal-body col-xs-12">
				<div class="col-xs-12">
					<div class="row margin-top-10">
						<span class="col-md-4 control-label">Bệnh/tình trạng:</span>
						<div class="col-md-8">
							<input  type="text" class="form-control" id="sick_other">
						</div>
					</div>
					<div class="row margin-top-10">
						<span class="col-md-4 control-label">Chỉ định:</span>
						<div class="col-md-8">
							<textarea class="form-control" placeholder="Chỉ định" rows="5" id="assign_other"></textarea>
						</div>
					</div>
					<div class="col-xs-12 text-right margin-top-10">
						<button type="submit" class="btn btn-primary" onclick="saveToothOther();">Lưu</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- pop up thêm bệnh, tình trạng khác 2 -->
<div id="otherModal2" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header sHeader">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h3 id="modalTitle" class="modal-title">Nhập bệnh/ tình trạng khác</h3>
			</div>
			<div class="modal-body col-xs-12">
				<form id="frm-other-btt" class="frm-book" method="post" enctype="multipart/form-data">
					<div class="col-xs-12">
						<div class="row margin-top-10">
							<span class="col-md-4 control-label">Răng:</span>
							<div class="col-md-8">
								<input  type="text" class="form-control" name="tooth_number" required="required">
							</div>
						</div>
						<div class="row margin-top-10">
							<span class="col-md-4 control-label">Bệnh/tình trạng:</span>
							<div class="col-md-8">
								<input  type="text" class="form-control" name="sick_other" required="required">
							</div>
						</div>
						<div class="row margin-top-10">
							<span class="col-md-4 control-label">Chỉ định:</span>
							<div class="col-md-8">
								<textarea class="form-control" placeholder="Chỉ định" rows="5" name="assign_other" required="required"></textarea>
							</div>
						</div>
						<div class="col-xs-12 text-right margin-top-10">
							<button type="submit" class="btn btn-primary">Lưu</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- pop up xóa bệnh-->
<div id="smsRs" class="modal pop_bookoke">
	<div class="modal-dialog" style="width: 380px; padding-top: 100px;">
		<div class="modal-content">
			<div class="modal-header popHead">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>
				<span>THÔNG BÁO</span>
			</div>

			<div class="modal-body">
				<p id="rsct">Bạn muốn xóa bệnh</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn_bookoke calcf">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<!-- Pop up hien thi thao tac transaction -->
<div id="actionInvoiceTransaction" class="invoiceTransaction pop_bookoke" style="display: none; position: absolute;">
	<div class="modal-dialog invoiceTransaction" style="width: 140px; color: white;">
		<div class="modal-content invoiceTransaction" style="background-color: #53647E;">
			<div class="invoiceTransaction transactionChange" style="padding: 8px; cursor: pointer;">Chuyển dịch vụ <span class="servicesName"></span></div>
			<hr class="invoiceTransaction" style="margin: 1px;">
			<div class="invoiceTransaction transactionCancel" style="padding: 8px; cursor: pointer;">Hủy dịch vụ <span class="servicesName"></span></div>
		</div>
	</div>
</div>

<div id="actionTransactionCancel" class="modal pop_bookoke">
	<div class="modal-dialog" style="width: 430px;">
		<div class="modal-content">
			<div class="modal-header sHeader">
				<button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h3 id="modalTitle" class="modal-title">HỦY DỊCH VỤ</h3>
			</div>

			<div class="modal-body">
				<form id="invoiceTransactionCancel" class="form-horizontal row">
					<input type="hidden" name="id" class="transaction-id">
					<input type="hidden" name="id_invoice" class="transaction-idi">
					<input type="hidden" name="id_customer" value="<?php echo $model->id; ?>">
					<input type="hidden" name="id_dentist" class="transaction-id_dentist">

					<div class="col-xs-12">
						<div class="form-group">
							<label class="col-xs-3 text-right">Dịch vụ:</label>
							<div class="col-xs-9">
								<input type="text" readOnly class="form-control transaction-service_name">
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Giá:</label>
							<div class="col-xs-9">
								<div class="input-group">
									<input type="text" readOnly class="form-control text-right autoNum transaction-amount">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Bác sỹ:</label>
							<div class="col-xs-9">
								<input type="text" readOnly class="form-control transaction-dentist_name">
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Chi phí hoàn trả: </label>
							<div class="col-xs-9">
								<div class="input-group" style="margin-bottom: 10px;">
									<input type="text" name="refund" required class="form-control text-right autoNum transaction-refund">
									<span class="input-group-addon">VND</span>
								</div>
								<div class="input-group">
									<input type="number" name="percent" min="0" max="100" step="any" required class="form-control text-right transaction-refund_percent" value="100">
									<span class="input-group-addon"> % </span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Lý do: </label>
							<div class="col-xs-9">
								<textarea class="form-control" name="reason"></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-12 text-right">
						<button class="btn" data-dismiss="modal">Hủy</button>
						<button class="btn btn-green" type="submit">Xác nhận</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="actionTransactionChange" class="modal pop_bookoke">
	<div class="modal-dialog" style="width: 430px;">
		<div class="modal-content">
			<div class="modal-header sHeader">
				<button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h3 id="modalTitle" class="modal-title">CHUYỂN DỊCH VỤ</h3>
			</div>

			<div class="modal-body">
				<form id="invoiceTransactionChange" class="form-horizontal row">
					<input type="hidden" name="id" class="transaction-id">
					<input type="hidden" name="id_invoice" class="transaction-idi">
					<input type="hidden" name="id_customer" value="<?php echo $model->id; ?>">

					<div class="col-xs-12">
						<div class="form-group">
							<label class="col-xs-3 text-right">Dịch vụ:</label>
							<div class="col-xs-9">
								<input type="text" readOnly class="form-control transaction-service_name">
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Giá:</label>
							<div class="col-xs-9">
								<div class="input-group">
									<input type="text" readOnly class="form-control text-right autoNum transaction-amount">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Bác sỹ chuyển:</label>
							<div class="col-xs-9">
								<input type="text" readOnly class="form-control transaction-dentist_name">
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Bác sỹ nhận:</label>
							<div class="col-xs-9">
								<select name="id_dentist_receive" required class="form-control change_dentist"></select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Chi phí chuyển: </label>
							<div class="col-xs-9">
								<div class="input-group" style="margin-bottom: 10px;">
									<input type="text" name="refund" required class="form-control text-right autoNum transaction-refund">
									<span class="input-group-addon">VND</span>
								</div>

								<div class="input-group">
									<input type="number" name="percent" min="0" max="100" step="any" required readonly class="form-control text-right transaction-refund_percent" value="100">
									<span class="input-group-addon"> % </span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-3 text-right">Lý do: </label>
							<div class="col-xs-9">
								<textarea class="form-control" name="reason"></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-12 text-right">
						<button class="btn" data-dismiss="modal">Hủy</button>
						<button class="btn btn-green" type="submit">Xác nhận</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include('js.php'); ?>
<?php include('sales_js.php'); ?>

<div class="modal" id="updateLaboModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header sHeader">
                <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 id="info_head" class="modal-title">Cập nhật thông tin giao nhận Labo</h3>
            </div>

            <div class="modal-body">
            	<form id="frm-labo-up" class="form-horizontal" onsubmit="return false;">
            		<input type="hidden" name="labo_up_id_customer" value="" id="labo_up_id_customer">
            		<input type="hidden" name="labo_up_id" value="" id="labo_up_id">
	            	<div class="margin-top-20">
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Tên khách hàng:</span>
	   						<div class="col-md-8">
	   						<input disabled type="text" class="form-control" value="" id="labo_up_customer_name" name="labo_up_customer_name">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Mã khách hàng:</span>
	   						<div class="col-md-8">
	   						<input disabled type="text" class="form-control" value="" id="labo_up_code_number" name="labo_up_code_number">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Bác sĩ:</span>
	   						<div class="col-md-8">
	   						<?php 
	   							$selected=yii::app()->user->getState('group_id')==Yii::app()->params['id_group_dentist']?yii::app()->user->getState('user_id'):"";
	   							$listdata = array();				
								foreach($model->getListDentists() as $temp){
									$listdata[$temp['id']] = $temp['name'];
								}	
								echo CHtml::dropDownList('labo_up_id_d3ntist','',$listdata,array('class'=>'form-control','required'=>'required','options'=>array($selected=>array('selected'=>true))));
							?>
	   						</div>
		   				</div>
			   				 								   				
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Labo: </span>
	   						<div class="col-md-8">
	   						<?php
	   							$listdata = array();				
								foreach(ListLabo::model()->findAll() as $temp){
									$listdata[$temp['id']] = $temp['name'];
								}	
								echo CHtml::dropDownList('labo_up_id_labo','',$listdata,array('class'=>'form-control','required'=>'required'));
	   						?>		
	   						</div>
		   				</div>
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Ngày giao:</span>
	   						<div class="col-md-8">
		   						<input required type="text" class="form-control col-sm-6" id="labo_up_sent_date" name="labo_up_sent_date" value="">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Người giao:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" id="labo_up_sent_person" name="labo_up_sent_person">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Khay giao:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" id="labo_up_sent_tray" name="labo_up_sent_tray">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Ngày nhận:</span>
	   						<div class="col-md-8">
		   						<input required type="text" class="form-control" id="labo_up_receive_date" name="labo_up_receive_date" value="">			
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Người nhận:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" id="labo_up_receive_person" name="labo_up_receive_person">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Khay nhận:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" id="labo_up_receive_tray" name="labo_up_receive_tray">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Bảo vệ:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" id="labo_up_security" name="labo_up_security" value="">			
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Nha tá nhận:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" id="labo_up_receive_assistant" name="labo_up_receive_assistant" value="">			
	   						</div>
		   				</div>

		   				<div class="row">
							<div class="col-md-12">						                
								<label class="control-label">Nội dung</label>
								<textarea required class="form-control" id="labo_up_description" name="labo_up_description" rows="4"></textarea>		
							</div>								
						</div>

	          		</div>

					<div class="modal-footer" style="padding: 15px 0px 0px 0px;border-top:none;">
						<?php
					      	$group_id =  Yii::app()->user->getState('group_id'); 
					      	if($group_id==1){ 
				      	?>
					      	<button type="button" class="btn btn-danger" onclick="removeLabo()">Xóa</button>
					    <?php } ?>
			          	<button type="submit" class="btn btn-primary">Lưu</button>
			        </div>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    
    </div>
</div>

<script type="text/javascript">

	var id_customer = '<?php echo $model->id; ?>';
	$(function () {
	    $( "#labo_up_sent_date" ).datetimepicker({
	    	dateFormat: 'yy-mm-dd',
	    	timeFormat: 'hh:mm:ss',
	        showSecond: false, 
	       	showTimezone: false,
	       	showMillisec: false,
	       	showMicrosec: false,
	    });
	    $( "#labo_up_receive_date" ).datetimepicker({
	        dateFormat: 'yy-mm-dd',
	    	timeFormat: 'hh:mm:ss',
	        showSecond: false, 
	       	showTimezone: false,
	       	showMillisec: false,
	       	showMicrosec: false,
	    });
	});

	function openUpdateLabo(id) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsMedicalRecords/AccountsCus/getLaboHistory",
			data: {
				id: id
			},
			success: function (resp) {
				if (resp != -1) {					
					data = JSON.parse(resp);
					$('#labo_up_id').val(id);
					$('#labo_up_id_customer').val(data.id_customer);
					$('#labo_up_customer_name').val(data.customer_name);
					$('#labo_up_code_number').val(data.code_number);
					$("select#labo_up_id_d3ntist").attr('selectedIndex',data.id_user);
					//$('#labo_up_id_d3ntist').val(data.gp_users_name);
					$('#labo_up_id_labo').val(data.id_labo);
					$('#labo_up_sent_date').val(data.sent_date);
					$('#labo_up_sent_person').val(data.sent_person);
					$('#labo_up_sent_tray').val(data.sent_tray);
					$('#labo_up_receive_date').val(data.receive_date);
					$('#labo_up_receive_person').val(data.receive_person);
					$('#labo_up_receive_tray').val(data.receive_tray);
					$('#labo_up_security').val(data.security);
					$('#labo_up_receive_assistant').val(data.receive_assistant);
					$('#labo_up_description').val(data.description);
					$('#updateLaboModal').modal('show');
				}
			},
		});
	}

	function removeLabo() {
		var id = $('#labo_up_id').val();
		if (confirm("Bạn muốn xóa labo?")) {
			$.ajax({
				type: "POST",
				url: baseUrl + '/itemsMedicalRecords/AccountsCus/RemoveLaboHistory',
				data: {
					id: id
				},
				success: function(data) {
					$.jAlert({
						'title': "Thông báo",
						'content': data,
					});

					setTimeout(function(){
						location.reload();
					}, 1500);
				},
				error: function(xhr, ajaxOptions, thrownError){
					alert(xhr.status);
					alert(thrownError);
				},
			});
		}
	}

	$('#frm-labo-up').submit(function(e) {
	    $('.cal-loading').fadeIn('fast');
	    e.preventDefault();
	    var formData = new FormData($("#frm-labo-up")[0]);
	    if (!formData.checkValidity || formData.checkValidity()) {
	        jQuery.ajax({           
	            type:"POST",
	            url: baseUrl+'/itemsMedicalRecords/AccountsCus/updateLaboHistory',   
	            data:formData,
	            datatype:'json',
	            success:function(data){
	            	if (data == 1) {
	            		e.stopPropagation(); 
		                alert("Success!"); 
		                loadMedicalRecords(id_customer, '');   	
	            	} else {
	            		alert('update error');
	            	}
	            	$('#updateLaboModal').modal('hide');  	  
	            	$('.cal-loading').fadeOut('slow');          
	            },
	            error: function(data) {
	                alert("Error occured. Please try again!");
	            },
	            cache: false,
	            contentType: false,
	            processData: false
	        });
	    }
	    return false;
	});
</script>

<script src="<?php echo Yii::app()->baseUrl.'/js/jquery-ui-timepicker-addon.js'; ?>"></script>
<link href="<?php echo $baseUrl; ?>/css/jquery-ui-timepicker-addon.css" media="all" rel="stylesheet" type="text/css"/>