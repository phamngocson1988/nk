<table class="table table-list2 margin-top-10">
	<thead>
		<tr>
			<th style="width: 10%">Ngày</th>
			<th style="width: 10%">Răng</th>
			<th style="width: 20%">Mã DV</th>
			<th style="width: 30%">Công tác điều trị</th>
			<th style="width: 15%">Chi phí</th>
			<th style="width: 15%">Bác sĩ</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if($data):
				foreach ($data as $key => $v) :
					$status_invoice = isset($v['status_invoice']) ? $v['status_invoice'] : 1;
					$confirm = isset($v['confirm']) ? $v['confirm'] : 1;

					if ($status_invoice == -3) {
						continue;
					}
					if ($status_invoice == -1 && $confirm == 0) {
						continue;
					}
		?>
				<tr class="invoiceTreatment<?php echo $key+1; ?>" data-toggle="collapse" data-target="#TreatmentProcess<?php echo $key+1;?>" class="accordion-toggle">
					<td style="width: 10%">
						<?php
							if(isset($v['create_date'])){
								if($v['create_date'] != "0000-00-00" && $v['create_date'] != ""){
									echo date_format(date_create($v['create_date']), 'd-m-Y');
								}
							}
						?>
					</td>
					<td style="width: 10%">
						<?php
							if(isset($v['teeth'])){echo $v['teeth'];}
							elseif(isset($v['listTreatmentWork'])){
								foreach ($v['listTreatmentWork'] as $k => $value) {
						    		echo $value['tooth_numbers']."</br>";
						    	}
							}
						?>
					</td>

					<?php $code = (isset($v['code_service'])) ? $v['code_service'] : ''; ?>
					<td style="width: 20%" class="serviceCodeAction cursorHover"
						data-idx="<?php echo $key+1; ?>"
						data-id="<?php echo $v['id']; ?>"
						data-code="<?php echo $code; ?>"
						data-i-id="<?php echo (isset($v['id_invoice'])) ? $v['id_invoice'] : ''; ?>"
						data-sv-name="<?php echo (isset($v['services_name'])) ? $v['services_name'] : ''; ?>"
						data-sv-price="<?php echo (isset($v['amount'])) ? $v['amount'] : ''; ?>"
						data-dt-name="<?php echo (isset($v['user_name'])) ? $v['user_name'] : ''; ?>"
						data-status="<?php echo (isset($status_invoice)) ? $status_invoice : ''; ?>"
					>
						<?php if ($confirm == 0): ?>
							<div style="height: 20px; width: 2px; background: #53647e; padding: 0; float: left;"></div>
						<?php endif; ?>
						
						<?php echo $code;?>
						<?php if ($status_invoice == -1): ?>
							<span class="label label-danger">Hủy</span>
						<?php endif; ?>
						<?php if ($status_invoice == -2): ?>
							<span class="label label-warning">CH</span>
						<?php endif; ?>
					</td>
					<td style="width: 30%">
						<?php
							if(isset($v['services_name'])){
								echo $v['services_name'];
							}
						?>
					</td>

					<td style="width: 15%">
						<?php
							$amount = isset($v['amount']) ? $v['amount'] : 0;
							echo number_format($amount, 0, '', '.');
						?>
					</td>
					<td style="width: 15%">
						<?php
							if(isset($v['user_name'])){echo $v['user_name'];}
						?>
					</td>

				</tr>
				<?php if(isset($v['listTreatmentWork'])): ?>
					<tr>
					    <td colspan="6" class="hiddenRow" >
					        <div class="accordian-body collapse oView col-md-12" id="TreatmentProcess<?php echo $key+1;?>">
						        <div class="col-md-12 margin-bottom-10">
						            <div class="row">
							            <div class="col-xs-6">
								            <div class="row">
								                <div class="col-xs-6">
								                    <span>
								                        Ngày tái khám:
								                    </span>
								                    <span>
								                        <?php if($v['reviewdate']!=0) echo date('d/m/Y H:m:s',strtotime($v['reviewdate'])); else echo "Không";?>
								                    </span>
								                </div>

								                <div class="col-xs-6">
								                    <span>Ghi chú:</span>
								                    <span><?php if($v['description']!="") echo $v['description']; else echo "Không";?></span>
								                </div>
								            </div>
							            </div>
										<div class="col-xs-6">
											<?php
												$labo = Customer::model()->infoLabo($v['id']);
												if($labo){
													$id_labo =  $labo['id'];
												}else{
													$id_labo = " ";
												}
												$prescription = Customer::model()->infoPrescription($v['id']);
												if($prescription){
													$id_prescription =  $prescription['id'];
												}else{
													$id_prescription = " ";
												}
											?>
											<div class="row">
												<div class="col-xs-3">
													<a  data-toggle="modal" data-target="#prescriptionModal" onclick="viewPrescription('<?php echo $id_prescription;?>', '<?php echo $v['id']; ?>')">Toa thuốc</a>
												</div>
												<div class="col-xs-3">
													<a  data-toggle="modal" data-target="#labModal" onclick="viewLabo('<?php echo $id_labo;?>', '<?php echo $v['id']; ?>')">Labo</a>
												</div>
												<div class="col-xs-3">
													<a data-toggle="modal" data-target="#add-treatment-process-modal" onclick="viewTreatment('3', '<?php echo $v['id'];?>')">Chỉnh sửa</a>
												</div>
												<div class="col-xs-3">
													<a href="" onclick="deleteMedicalHistory(<?php echo $v['id'];?>)">Xóa</a>
												</div>
											</div>
										</div>
						            </div>
						        </div>
						        <div class="col-xs-12 ">
						            <table class="table oViewB">
						                <thead>
					                        <th style="width: 20%;">Số răng</th>
					                        <th style="width: 80%;">Công tác điều trị</th>
						                </thead>
						                <tbody>
						                    <?php
						                        foreach ($v['listTreatmentWork'] as $key => $value) {
						                    ?>
						                     <tr>
						                        <td style="width: 20%;">
						                        	<?php echo $value['tooth_numbers']; ?>
						                        </td>
						                        <td style="width: 80%;">
						                        	<?php echo $value['treatment_work']; ?>
						                        </td>
						                    </tr>
						                    <?php }?>
						                </tbody>
						            </table>

						        </div>

					        </div>
					    </td>
				    </tr>
				<?php endif; ?>
		<?php
				endforeach;
			else:
				echo  '<tr><td colspan="6">Không có dữ liệu!</td></tr>' ;
			endif;
		?>
	</tbody>
</table>
<script>
	$(document).ready(function(){
		$('.collapse').collapse();
	})
</script>