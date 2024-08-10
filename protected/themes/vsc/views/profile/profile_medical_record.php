<style>
	.tabBa.container{width: 1170px; margin-bottom: 70px;margin-top: 70px;}
	.mt-70{margin-top: 70px;}
	.mt-10{margin-top: 10px;}
	.mt-30{margin-top: 30px;}
	.tabBa .title{color: #17a8e1;font-weight: bold;text-align: left;font-size: 18px;text-transform: uppercase;}
	.bg-treatment {max-width: 210px;background: #F2B339;color: #fff;padding: 7px 10px;width: 100%;font-size: 13px;text-transform: uppercase;cursor: pointer;border-radius: 4px;float: right}
	.treatment {position: absolute;display: none;z-index: 10;top: 35px;right: 15px;width: auto;background: #fff;box-shadow: 0px 2px 1px #00000040;width: 400px;margin-top: 10px;font-size: 13px;}
	.noteTooth .name{font-weight: bold;color: #333;font-size: 16px;}
	.noteTooth div{margin-bottom: 3px}
	.imgTooth{max-width: 270px;}
	.tableTreatment thead tr {background-color: #8ca7ae;}
	.tableTreatment thead tr th {color: #fff !important;text-align: center;border: 1px solid #fff !important; font-weight: 100}
	.tableTreatment tbody {background-color: #f1f5f6;}
	.tableTreatment tbody tr td,.tableTreatment tbody tr td {border: 1px solid #ccc !important;vertical-align: middle !important;text-align: center; font-size:13px; color:#333;}
	.tableTreatment tbody tr{background: #fff}
	.cursor{cursor: pointer;}
</style>

<?php 
	if ($treatment) {
		$id_mhg 		= $treatment->id;
		$name 			= $treatment->name;
		$date_treatment = $treatment->createdata;
	} else {
		$id_mhg 		= $treatment;
		$name 			= '';
		$date_treatment = '';
	}
	$medical_history_group = $model->getListMedicalHistoryGroupByCustomer($model->id);
	$count = 0;
	if($medical_history_group){
		$count 				= count($medical_history_group);
	}
	$tooth_data 		= new ToothData;
	$listToothStatus    = $tooth_data->getListToothStatusNew($model->id,$id_mhg);
	$data   			= $model->getListInvoiceAndTreatment($id_mhg,$model->id,'','');
?>
<div class="container tabBa">
	<!--Đợt điều trị-->
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<p class="title">TÌNH TRẠNG RĂNG</p>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="bg-treatment" id="table_treatment">
				Đợt điều trị
				<?php echo $name;?>
				<?php if($date_treatment != "0000-00-00" && $date_treatment != "") echo date('d-m-Y',strtotime($date_treatment));?>
				<span class="caret fr margin-top-7"></span>
			</div>
			<div class="treatment">
				<table class="table">
					<tbody>
						<?php 
							if($medical_history_group && $count > 0):
							foreach ($medical_history_group as $key => $m_h_g): 
						?>
								<tr class="cursor" onclick="detailTreatment(<?php echo $m_h_g['id'];?>);">
									<td>
										Đợt điều trị
										<?php echo $m_h_g['name'];?>
										<?php if($m_h_g['createdata'] != "0000-00-00" && $m_h_g['createdata'] != "") echo date('d-m-Y',strtotime($m_h_g['createdata']));?>
									</td>
									<td class="text-right">
										<select class="form-control uT" disabled="disabled">
											<option <?php if($m_h_g['status_process']==0) echo "selected" ;?>>Chưa Hoàn tất</option>
											<option <?php if($m_h_g['status_process']!=0) echo "selected" ;?>>Hoàn tất</option>
										</select>
									</td>
								</tr>
						<?php endforeach;
						endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!--Tình trạng răng-->
	<div class="row">
		<div class="col-xs-12 col-sm-6 mt-30">
			<?php 
				if (!empty($listToothStatus)) :
			        $code_number = $model->code_number;
			        $filename = Yii::app()->request->baseUrl.'/upload/customer/dental_status_image/'.$code_number.'/'.$code_number.'-'.$id_mhg.'.png';
					$file_headers = @get_headers($filename);
					if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
						echo "<img  src='".Yii::app()->baseUrl."/images/color_icon/rang.png' class='img-responsive imgTooth'>";
					}
					else {
					    echo "<img  src=".$filename." class='img-responsive imgTooth'>";
					}
				else :
					echo "<img  src='".Yii::app()->request->baseUrl."/images/no_tooth.png' class='img-responsive imgTooth'>";
				endif;		
			?>
		</div>
		<div class="col-xs-12 col-sm-6 mt-30 noteTooth">
			<div class="name">Ghi chú màu răng</div>
			<div>1. Nhóm tình trạng sức khỏe răng:</div>
			<div class="row">
				<div class="col-md-7">
					<div>
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-khoe.jpg">&nbsp;&nbsp;Răng khỏe mạnh
					</div>
					<div>
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-benh.jpg">&nbsp;&nbsp;Răng bệnh
					</div>
				</div>
				<div class="col-md-5">
					<div>
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-yeu.jpg">&nbsp;&nbsp;Răng yếu
					</div>
					<div>
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-mat.jpg">&nbsp;&nbsp;Răng mất
					</div>
				</div>
			</div>
			<div>2. Nhóm tình trạng sau điều trị:</div>
			<div class="row">
				<div class="col-md-7">
					<div style="border-left: 2px solid;padding-left: 5px;margin-left: 8px;">
						<div>Răng phục hồi cố định</div>
						<div>
							<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-gia-co-dinh.jpg">&nbsp;&nbsp;Răng giả cố định
						</div>
						<div>
							<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/vi-tri-cau-rang-gia.jpg">&nbsp;&nbsp;Vị trí cầu răng giả
						</div>
					</div>
					<div style="margin-left:15px;">
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-phuc-hoi-thao-lap.jpg">&nbsp;&nbsp;Răng phục hình tháo lắp
					</div>
					<div style="margin-left:15px;">
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/phuc-hoi-implant.jpg">&nbsp;&nbsp;Răng phục hình Implant
					</div>
				</div>
				<div class="col-md-5">
					<div>
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-tram-A.jpg">&nbsp;&nbsp;Răng trám A
					</div>
					<div>
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-tram-CO.jpg">&nbsp;&nbsp;Răng trám CO
					</div>
					<div>
						<img width="20px" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/color_icon/rang-tram-GIC.jpg">&nbsp;&nbsp;Răng trám GIC
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 mt-30">
			<p class="title">KẾT QUẢ KHÁM</p>
			<table class="table tableTreatment">
		        <thead>
		            <tr>
		                <th style="width: 20%;">
		                	Răng
		                </th>
		                <th style="width: 40%;">
		                	Chẩn đoán
		                </th>
		                <th style="width: 40%;">
		                	Chỉ định
		                </th>
		            </tr>
		        </thead>
		        <tbody >
					<?php
					$i = 0;
					if (!empty($listToothStatus)) :
						foreach ($listToothStatus as $tooth_status) :
							$i++;
					?>
							<tr>
								<td class="th1 sorang">
									<span>
										<?php echo str_replace( "_", " ", $tooth_status['tooth_number']);?>
									</span>
								</td>
								<td class="th2 ketluan text-left">
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
								<td class="th3 text-left chidinh">
									<?php echo $tooth_status['assign']; ?>
								</td>
								
							</tr>
							<?php
						endforeach;
					else:
						echo  '<tr><td colspan="3">Không có dữ liệu!</td></tr>' ;
					endif;
					?>
				</tbody>
		    </table>
		</div>
	</div>
	<!--Điều trị-->
	<div class="row mt-30">
		<div class="col-xs-12">
			<p class="title">Điều trị</p>
			<table class="table tableTreatment margin-top-10">
				<thead>
					<tr>
						<th style="width: 15%">Ngày</th>
						<th style="width: 20%">Răng</th>
						<th style="width: 15%">Mã DV</th>
						<th style="width: 35%">Công tác điều trị</th>
						<th style="width: 15%">Bác sĩ</th>
					</tr>
				</thead>
				<tbody id="InvoiceAndTreatment">
					<?php
						if($data):
							foreach ($data as $key => $v) :
								$status_invoice = isset($v['status_invoice']) ? $v['status_invoice'] : 1;
								if ($status_invoice == -3) {
									continue;
								}
					?>
							<tr class="invoiceTreatment<?php echo $key+1; ?>">
								<td style="width: 15%">
									<?php
										if(isset($v['create_date'])){
											if($v['create_date'] != "0000-00-00" && $v['create_date'] != ""){
												echo date_format(date_create($v['create_date']),'d-m-Y');
											}
										}
									?>
								</td>
								<td style="width: 20%; word-break: break-word;">
									<?php
										if(isset($v['teeth'])){echo str_replace(","," ",$v['teeth']);}
										elseif(isset($v['tooth_numbers'])){ echo str_replace(","," ",$v['tooth_numbers']);}
									?>
								</td>
								<?php 
									$code = (isset($v['code_service'])) ? $v['code_service'] : ''; 
									$type = 1;
									if($code){
										$type = 2;
									}
								?>
								<td style="width: 15%" class="serviceCodeAction cursorHover"
									data-idx="<?php echo $key+1; ?>"
									data-id="<?php echo $v['id']; ?>"
									data-code="<?php echo $code; ?>"
									data-i-id="<?php echo (isset($v['id_invoice'])) ? $v['id_invoice'] : ''; ?>"
									data-sv-name="<?php echo (isset($v['services_name'])) ? $v['services_name'] : ''; ?>"
									data-sv-price="<?php echo (isset($v['amount'])) ? $v['amount'] : ''; ?>"
									data-dt-name="<?php echo (isset($v['user_name'])) ? $v['user_name'] : ''; ?>"
									data-status="<?php echo (isset($status_invoice)) ? $status_invoice : ''; ?>"
								>
									<?php echo $code;?>
									<?php if ($status_invoice == -1): ?>
										<span class="label label-danger">Hủy</span>
									<?php endif; ?>
									<?php if ($status_invoice == -2): ?>
										<span class="label label-warning">CH</span>
									<?php endif; ?>
								</td>
								<td style="width: 35%">
									<?php
										if(isset($v['services_name'])){
											echo $v['services_name'];
										}
										elseif(isset($v['treatment_work'])){
											echo $v['treatment_work'];
										}
									?>
								</td>
								<td style="width: 15%">
									<?php
										if(isset($v['user_name'])){echo $v['user_name'];}
									?>
								</td>
							</tr>
							<?php  
								if(isset($v['description'])): 
									if($v['description']): 
							?>
								<tr>
									<td colspan="6">Cần lưu ý: <?php echo $v['description']; ?></td>
								</tr>
							<?php 
									endif;
								endif; 
								if(isset($v['note'])): 
									if($v['note']):
							?>
								<tr>
									<td colspan="6">Cần lưu ý: <?php echo $v['note']; ?></td>
								</tr>
							<?php 
									endif;
								endif;
							?>
					<?php
							endforeach;
						else:
							echo  '<tr><td colspan="6">Không có dữ liệu!</td></tr>' ;
						endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	function detailTreatment(id){
    	$('.cal-loading').fadeIn('fast');
	    var id_customer = '<?php echo $model->id; ?>';
	    $.ajax({
	        type:'POST',
	        url:"<?php echo CController::createUrl('profile/detailTreatment')?>",
	        data: {"id":id,"id_customer":id_customer},
	        success:function(data){
	            $('#pf_ba').html(data);
	            $('.cal-loading').fadeOut('slow');
	        },
	        error: function(data){
	        console.log("error");
	        console.log(data);
	        }
	    });
	}
	$('#table_treatment').click(function(){
	    $('#triangle').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top');
		$('.treatment').fadeToggle('fast');
	});
 
</script>

