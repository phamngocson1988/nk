<?php $baseUrl  = Yii::app()->baseUrl; ?>
<?php $group_id = Yii::app()->user->getState('group_id'); ?>

<div class="customerProfileContainer">
	<div id="customerProfileDetail" class="customerProfileHolder" style="display: block;margin:30px auto;">
		<div id="alert-success" style="position: fixed;top: 50px;right: 0px;"></div>
		<div class="row">

			<form class="col-md-2" id="imageUploader" enctype="multipart/form-data" style="margin:0px;">
				<?php include("customer_image.php"); ?>
			</form>

			<div class="col-md-8">
				<div class="table" style="height:120px;">
					<div class="cell">
						<input onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" class="customer_name yellow_hover blue_focus" value="<?php echo $model->fullname; ?>" id="fullname" name="fullname" placeholder="Họ tên" />

						<div class="row margin-top-20" style="text-indent: 7px;color:orange;font-size:15px;">
							<div class="col-md-3">
								<?php echo $model->countMissAppointment($model->id); ?>
							</div>

							<div class="col-md-5">
								<?php echo $model->getSumBalance($model->id); ?>
							</div>

							<div class="row" style="clear: both">
								<a style="float:left;" class="printProfile"><i class="fa fa-print"></i>&nbsp;In</a>
								<a style="float:left;" class="actionMedicalHistory" href="<?php echo Yii::app()->getBaseUrl() . '/itemsSales/quotations/View?code_number=' . $model->code_number; ?>">Báo giá</a>
								<a style="float:left;" class="actionMedicalHistory" href="<?php echo Yii::app()->getBaseUrl() . '/itemsSales/invoices/View?code_number=' . $model->code_number; ?>" target="_blank">Hóa đơn</a>
								<a style="float:left;" class="actionMedicalHistory" href="javascript:void(0)" data-toggle="modal" data-target="#dentiMaxModal">Hồ sơ cũ</a>
								<button style="float:left;" class="actionMedicalHistory" data-toggle="modal" data-target="#addOldBalance" id="getFormOldBalance" data-id="<?php echo $model->id; ?>">Nợ cũ</button>
								<a style="float:left;" class="actionMedicalHistory" target="_blank" href="<?php echo Yii::app()->params['upload_url'] . '/upload/customer/scan/1/' . $model->code_number_old . '.pdf'; ?>">Scan</a>
								<a style="float: left;cursor: pointer;" class="actionMedicalHistory" data-toggle="modal" data-target="#photosForIdentityCardModal"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal bootstrap-fileinput-master -->
				<div class="modal fade" id="photosForIdentityCardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header sHeader">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h3 class="modal-title">Thư Viện Ảnh Chứng Minh Nhân Dân</h3>
							</div>
							<div class="modal-body">
								<form enctype="multipart/form-data">
									<div class="form-group">
										<input id="input-777" name="kartik-input-777[]" type="file" multiple class="file-loading">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="dentiMaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header sHeader">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h3 class="modal-title">Hồ sơ cũ</h3>
							</div>

							<div class="modal-body">
								<table class="table">
									<thead>
										<tr>
											<th>Chart Number</th>
											<th>Code Number</th>
											<th>Billing Number</th>
											<th>Date</th>
											<th>Tooth</th>
											<th>Account Code</th>
											<th>Description</th>
											<th>Fee</th>
											<th>Provider Code</th>
											<th>Payment Number</th>
										</tr>
									</thead>
									<tbody>

										<?php

										$dentiMax = $model->getListDentiMax($model->code_number);

										if (!empty($dentiMax)) {

											foreach ($dentiMax as $key => $value) {

												?>
												<tr <?php if ($value['account_code'] == "PATCASH") echo "style='color: rgb(100,190,100);'"; ?>>
													<td><?php echo $value['code_number_old']; ?></td>
													<td><?php echo $value['code_number']; ?></td>
													<td><?php if ($value['billing_number']) echo $value['billing_number']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($value['date'])); ?></td>
													<td><?php echo $value['tooth']; ?></td>
													<td><?php echo $value['account_code']; ?></td>
													<td><?php echo $value['description']; ?></td>
													<td><?php if ($value['fee']) echo $value['fee']; ?></td>
													<td><?php echo $value['provider_code']; ?></td>
													<td><?php if ($value['payment_number']) echo $value['payment_number']; ?></td>
												</tr>
											<?php
											}
										} else {
											?>

											<tr>
												<td colspan="10">Không có dữ liệu</td>
											</tr>

										<?php
										}
										?>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="addOldBalance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				</div>

			</div>

			<ul id="customerDetailFormList">
				<div class="col-md-6" style="display:inline-block;">
					<li>
						<label class="fl">Mã số</label>
						<input onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" value="<?php echo $model->code_number; ?>" placeholder="Mã số" name="code_number" id="code_number" class="custProfileInput yellow_hover blue_focus fl">
						<div class="clearfix"></div>
					</li>
					<li>
						<?php
						$member = CustomerMember::model()->findByAttributes(array('id_customer' => $model->id));
						$code_member = $member['code_member'];
						$status_member	= $member['status'];
						?>
						<label class="fl">Thẻ hội viên</label>
						<input onchange="updateCodeMember(<?php echo $model->id; ?>);" type="text" value="<?php if ($code_member) echo $code_member; ?>" placeholder="Thẻ hội viên" name="membership_card" id="membership_card" class="custProfileInput yellow_hover blue_focus fl">
						<div class="clearfix"></div>
					</li>
					<li class="hide">
						<label class="fl">Nickname</label>
						<input onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" value="<?php echo $model->nickname; ?>" placeholder="Nickname" name="nickname" id="nickname" class="custProfileInput yellow_hover blue_focus fl">
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Email</label>
						<input style="width: 180px;" onchange="sendEmail(<?php echo $model->id; ?>),updateCustomer(<?php echo $model->id; ?>);" type="email" value="<?php echo $model->email; ?>" placeholder="Email" name="email" id="email" class="custProfileInput yellow_hover blue_focus fl">
						<!-- <span class="cus_sms cus_icon">
							<span style="cursor: pointer;" class="" id="sendEmail" title="gửi mail"><img style="width: 25px;" src="<?php echo $baseUrl; ?>/images/medical_record/more_icon/phone_sms.jpg" class="img-responsive"></span>
						</span>	 -->
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Di động</label>
						<input style="width: 160px;" onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" placeholder="Số điện thoại" name="phone" id="phone" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($model->phone) echo $model->phone; ?>">
						<span class="cus_cal cus_icon" style="float: left;margin-left: 5px;">
							<img onclick="clickToCall(<?php echo $model->phone; ?>);" style="width: 25px;cursor: pointer;height: 25px;" src="<?php echo $baseUrl; ?>/images/medical_record/more_icon/phone.jpg" class="img-responsive">
						</span>
						<span class="cus_sms cus_icon" style="float: left;margin-left: 5px;">
							<span style="cursor: pointer;" class="" id="sendSMS" data-toggle="modal" data-target="#sendSmsPop" title=""><img style="width: 25px;height: 25px;" src="<?php echo $baseUrl; ?>/images/medical_record/more_icon/phone_sms.jpg" class="img-responsive"></span>
						</span>
						<!-- send sms -->
						<div id="sendSmsPop" class="modal fade">
							<?php include 'send_sms.php'; ?>
						</div>
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Di động 2</label>
						<input style="width: 180px;" onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" placeholder="Số điện thoại 2" name="phone2" id="phone2" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($model->phone) echo $model->phone2; ?>">
						<div class="clearfix"></div>
					</li>
					<li class="hidden">
						<label class="fl">Số sms</label>
						<input style="width: 180px;" onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" placeholder="Số sms" name="phone_sms" id="phone_sms" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($model->phone_sms) echo $model->phone_sms; ?>">
						<div class="clearfix"></div>
					</li>

					<li>
						<label class="fl">Giới tính</label>
						<?php
						$listdata = array();
						$listdata[0] = "Nam";
						$listdata[1] = "Nữ";
						echo CHtml::dropDownList('gender', '', $listdata, array('onchange' => 'updateCustomer(' . $model->id . ');', 'class' => 'custProfileInput yellow_hover blue_focus fl', 'options' => array($model->gender => array('selected' => true))));
						?>
						<div class="clearfix"></div>
					</li>

					<li>
						<label class="fl">Ngày sinh</label>
						<input onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" placeholder="Ngày sinh" name="birthdate" id="birthdate" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($model->birthdate != "0000-00-00" && $model->birthdate != "") echo date('d/m/Y', strtotime($model->birthdate)); ?>">
						<div class="clearfix"></div>
					</li>

					<li>
						<label class="fl">Ngày điều trị</label>
						<input autocomplete="off" onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" placeholder="Ngày điều trị cuối cùng" name="last_day" id="last_day" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($model->last_day != "0000-00-00" && $model->last_day != "") echo date('d/m/Y', strtotime($model->last_day)); ?>">
						<div class="clearfix"></div>
					</li>

					<li>
						<label class="fl">Nhắc hẹn</label>
						<div id="slideRemind" onclick="change_remindSchedule(<?php echo $model->id; ?>)" class="slider_holder staffhours sliderdone" style="margin-left: 18px;">
							<input id="remind-isRemindSchedule" name="isRemindSchedule" type="hidden" value="<?php echo $remind->status; ?>">
							<span class="slider_off sliders <?php if ($remind->status == 0) echo "Off"; ?>"> TẮT </span>
							<span class="slider_on sliders <?php if ($remind->status == 0) echo "On"; ?>"> BẬT </span>
							<span class="slider_switch <?php if ($remind->status == 0) echo "Switch"; ?>"></span>
						</div>
						<div class="clearfix"></div>
					</li>

					<?php $displayRemain = ($remind->status == 1) ? "block" : "none"; ?>

					<li class="remindSchedule" style="display: <?php echo $displayRemain ?>;">
						<label class="fl">Sau</label>
						<div class="input-group">
							<input id="remind-durations" onchange="updateScheduleRemind(<?php echo $model->id; ?>)" type="number" min="1" step="1" class="custProfileInput yellow_hover blue_focus" name="durations" value="<?php echo $remind->durations; ?>" style="width: 100px; float: left">
							<div style="float: left" >
								<select id="remind-durations_type" onchange="updateScheduleRemind(<?php echo $model->id; ?>)" name="durations_type" class="custProfileInput yellow_hover blue_focus" style="width: 100px; height: 32px; margin-left: 0;">
									<?php foreach (CustomerScheduleRemind::$_DURATION_TYPE as $value): ?>
										<?php $durations_type = (!$remind->durations_type) ? 1 : $remind->durations_type; ?>
										<?php $remindSelected = ($durations_type == $value) ? 'selected' : ''; ?>
										<option value="<?php echo $value; ?>" <?php echo $remindSelected; ?>><?php echo CustomerScheduleRemind::$_DURATION_TYPE_NAME[$value]; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
					</li>

					<li class="remindSchedule" style="display: <?php echo $displayRemain ?>;">
						<label class="fl" style="font-size: 0.9em;">Ngày nhắc hẹn</label>
						<input id="remind-date_remind" onchange="updateScheduleRemind(<?php echo $model->id; ?>)" autocomplete="off" type="text" placeholder="Ngày nhắc hẹn tiếp theo" class="custProfileInput yellow_hover blue_focus fl datepicker" name="date_remain" value="<?php if ($remind->date_remind != "0000-00-00" && $remind->date_remind != "") echo date('d/m/Y', strtotime($remind->date_remind	)); ?>">
						<div class="clearfix"></div>
					</li>

					<li>
						<label class="fl">Ghi chú</label>
						<input onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" placeholder="Ghi chú" name="note" id="note_customer" class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->note; ?>">
						<div class="clearfix"></div>
					</li>

				</div>
				<div class="col-md-6" style="display:inline-block;">
					<li>
						<label class="fl">Quốc tịch</label>
						<?php
						$listdata = array();
						if ($model->id) {
							foreach ($model->getListCountry() as $temp) {
								$listdata[$temp['code']] = $temp['country'];
							}
						}
						echo CHtml::dropDownList('id_country', '', $listdata, array('onchange' => 'updateCustomer(' . $model->id . ');showCountry()', 'class' => 'custProfileInput yellow_hover blue_focus fl', 'empty' => 'Chọn quốc tịch', 'options' => array($model->id_country => array('selected' => true))));
						?>
						<div class="clearfix"></div>
					</li>
					<li id="liCountryOther" <?php echo ($model->id_country == "OTHER")?'':'style="display: none;"'; ?>>
						<label class="fl">&nbsp</label>
						<input onchange="updateCountryOther(<?php echo $model->id; ?>)" type="text" placeholder="Quốc tịch" name="countryOther" id="countryOther" class="custProfileInput yellow_hover blue_focus fl" value="<?php if (!empty($model->country_other)) echo $model->country_other; ?>">
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">CMND/Passport</label>
						<input onchange="updateCustomer(<?php echo $model->id; ?>);" type="text" placeholder="CMND/Passport" name="identity_card_number" id="identity_card_number" class="custProfileInput yellow_hover blue_focus fl" value="<?php if (!empty($model->identity_card_number)) echo $model->identity_card_number; ?>">
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Nguồn</label>
						<?php
						$list_source = array();
						if ($model->id) {
							foreach ($model->getListSource() as $temp) {
								$list_source[$temp['id']] = $temp['name'];
							}
						}
						echo CHtml::dropDownList('id_source', '', $list_source, array('onchange' => 'updateCustomer(' . $model->id . ');', 'class' => 'custProfileInput yellow_hover blue_focus fl', 'empty' => 'Chọn nguồn', 'options' => array($model->id_source => array('selected' => true))));
						?>
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Nhóm</label>
						<?php
						$list_segment = array();
						$selected     = $model->getSelectedSegment($model->id);
						if ($model->id) {
							foreach ($model->getListSegment() as $temp) {
								$list_segment[$temp['id']] = $temp['name'];
							}
						}
						echo CHtml::dropDownList('id_segment', '', $list_segment, array('onchange' => 'updateCustomerSegment(' . $model->id . ');', 'class' => 'custProfileInput yellow_hover blue_focus fl', 'empty' => 'Chọn nhóm', 'options' => array($selected => array('selected' => true))));
						?>
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Nghề nghiệp</label>
						<?php
						$listdata = array();
						if ($model->id) {
							foreach ($model->getJob() as $temp) {
								$listdata[$temp['id']] = $temp['name'];
							}
						}
						echo CHtml::dropDownList('id_job', '', $listdata, array('onchange' => 'updateCustomer(' . $model->id . ');', 'class' => 'custProfileInput yellow_hover blue_focus fl', 'empty' => 'Chọn nghề nghiệp', 'options' => array($model->id_job => array('selected' => true))));
						?>
						<div class="clearfix"></div>
					</li>
					<li class="hide">
						<label class="fl">Chức vụ</label>
						<?php
						$listdata = array();
						$listdata[1] = "Nhân viên";
						$listdata[2] = "Quản lý";
						echo CHtml::dropDownList('position', '', $listdata, array('onchange' => 'updateCustomer(' . $model->id . ');', 'class' => 'custProfileInput yellow_hover blue_focus fl', 'empty' => 'Chọn chức vụ', 'options' => array($model->position => array('selected' => true))));
						?>
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Tỉnh thành</label>
						<select class="custProfileInput yellow_hover blue_focus fl" onchange="showCounty(<?php echo $model->id; ?>)" id="city">
							<option value="0">Chọn tỉnh thành</option>
							<?php foreach ($Localtionprovince as $key => $value) : ?>
								<?php
								$selected = "";
								if ($model->city == $value["provinceID"]) {
									$selected = "selected";
								}
								?>
								<option value="<?php echo $value["provinceID"]; ?>" <?php echo $selected; ?>>
									<?php echo $value["provinceDescriptionVn"]; ?>
								</option>
							<?php endforeach ?>
						</select>
						<div class="clearfix"></div>
					</li>
					<li id="Localtiondistrict">
						<label class="fl">Quận huyện</label>
						<select class="custProfileInput yellow_hover blue_focus fl" id="county">
							<option value="0">Chọn quận huyện</option>
						</select>
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Địa chỉ liên hệ</label>
						<textarea onchange="updateCustomer(<?php echo $model->id; ?>);" id="address" name="address" placeholder="Địa chỉ liên hệ" rows="4" class="custProfileInput yellow_hover blue_focus fl"><?php echo $model->address; ?></textarea>
						<div class="clearfix"></div>
					</li>
					<li id="BranchList">
						<label class="fl">Cơ sở</label>
						<select class="custProfileInput yellow_hover blue_focus fl" id="branch" onchange="updateCustomer(<?php echo $model->id; ?>)">
							<option value="0">Chọn cơ sở</option>
							<?php 
								$branch_list = Branch::model()->findAll();
								foreach ($branch_list as $key => $value){
									$selected = "";
									if ($value['id'] == $model->id_branch) {
										$selected = "selected";
									}
									?>
									<option value="<?php echo $value["id"]; ?>" <?php echo $selected; ?>>
										<?php echo $value["name"]; ?>
									</option>
								<?php } ?>
							?>
						</select>
						<div class="clearfix"></div>
					</li>
				</div>

				<div class="clearfix"></div>
				<hr style="width:80%;" style="display:inline-block;">

				<div class="col-md-6" style="display:inline-block;">
					<li>
						<label class="fl">Tài khoản</label>
						<input readonly type="text" value="<?php echo $model->username; ?>" placeholder="Tài khoản" name="username" id="username" class="custProfileInput yellow_hover blue_focus fl">
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Mật khẩu</label>
						<input readonly type="password" value="<?php echo $model->password; ?>" placeholder="Mật khẩu" name="password" id="password" class="custProfileInput yellow_hover blue_focus fl">
						<div class="clearfix"></div>
					</li>
				</div>
				<div class="col-md-6" style="display:inline-block;">
					<li>
						<label class="fl">Hồ sơ online</label>
						<div onclick="change_flag(<?php echo $model->id; ?>);" class="slider_holder staffhours sliderdone" style="margin-left: 18px;">
							<input id="hidden_flag" name="effect" type="hidden" value="<?php echo $model->flag; ?>">
							<span id="off_flag" class="slider_off sliders <?php if ($model->flag == 0) echo "Off"; ?>"> TẮT </span>
							<span id="on_flag" class="slider_on sliders <?php if ($model->flag == 0) echo "On"; ?>"> BẬT </span>
							<span id="switch_flag" class="slider_switch <?php if ($model->flag == 0) echo "Switch"; ?>"></span>
						</div>
					</li>
				</div>

				<div class="clearfix"></div>
				<hr style="width:80%;" style="display:inline-block;">
				<?php
				$id_insurrance = CsCustomerInsurrance::model()->findByAttributes(array("id_customer" => $model->id));
				?>
				<div class="col-md-6" style="display:inline-block;">

					<li>
						<label class="fl">Mã bảo hiểm</label>
						<input onchange="insertUpdateCustomerInsurrance(<?php echo $model->id; ?>);" type="text" placeholder="Mã bảo hiểm" name="code_insurrance" id="code_insurrance" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($id_insurrance) echo $id_insurrance['code_insurrance']; ?>">
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Tên bảo hiểm</label>
						<?php
						$list_data = array();
						if ($model->id) {
							foreach ($model->getInsurranceType() as $temp) {
								$list_data[$temp['id']] = $temp['name'];
							}
						}
						echo CHtml::dropDownList('type_insurrance', '', $list_data, array('onchange' => 'insertUpdateCustomerInsurrance(' . $model->id . ');', 'class' => 'custProfileInput yellow_hover blue_focus fl', 'empty' => 'Chọn tên bảo hiểm', 'options' => array($id_insurrance['type_insurrance'] => array('selected' => true))));
						?>
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Black List</label>
						<div id="note_insurrance" onclick="changeBlackList(<?php echo $model->id; ?>)" class="slider_holder staffhours sliderdone" style="margin-left: 18px;">
							<input id="insurrance_status" name="insurrance_status" type="hidden" value="<?php echo $id_insurrance['status']; ?>">
							<span id="off_flag" class="slider_off sliders <?php if ($id_insurrance['status'] == 0) echo "Off"; ?>"> TẮT </span>
							<span id="on_flag" class="slider_on sliders <?php if ($id_insurrance['status'] == 0) echo "On"; ?>"> BẬT </span>
							<span id="switch_flag" class="slider_switch <?php if ($id_insurrance['status'] == 0) echo "Switch"; ?>"></span>
						</div>
					</li>
				</div>
				<div class="col-md-6" style="display:inline-block;">
					<li>
						<label class="fl">Ngày bắt đầu</label>
						<input onchange="insertUpdateCustomerInsurrance(<?php echo $model->id; ?>);" type="text" placeholder="Thời gian bắt đầu" name="startdate" id="startdate" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($id_insurrance) echo $id_insurrance['startdate']; ?>">
						<div class="clearfix"></div>
					</li>
					<li>
						<label class="fl">Ngày kết thúc</label>
						<input onchange="insertUpdateCustomerInsurrance(<?php echo $model->id; ?>);" type="text" placeholder="Thời gian kết thúc" name="enddate" id="enddate" class="custProfileInput yellow_hover blue_focus fl" value="<?php if ($id_insurrance) echo $id_insurrance['enddate']; ?>">
						<div class="clearfix"></div>
					</li>
				</div>

				<div class="clearfix"></div>

				<hr style="width:80%;" style="display:inline-block;">

				<div class="col-md-6" style="display:inline-block;">

					<div class="customersActionHolder" style="border:0px;">
						<label class="fl" style="line-height:33px;padding-right:10px;">Người trong gia đình</label>
						<a id="showFamilyPopover" class="btn_plus" style="float:left;"></a>
						<div class="clearfix"></div>

						<?php
						$relation =  CustomerRelationship::model()->listCustomerRelationFamily($model->id);
						?>
						<style>
							.trash_hover:hover i {
								display: block !important;
								;
							}

							.trash_hover .trash {
								display: none !important;
								cursor: pointer;
								margin-left: 10px;
							}
						</style>
						<?php if ($relation['relation_2']) { ?>
							<div class="col-md-12 row">
								<div style="width:89px;text-align: right;font-size: 13px;float: left; ">Vợ/chồng:</div>
								<div style="width:221px; float: left; ">
									<ul style="padding: 0px 15px;">
										<?php
										foreach ($relation['relation_2'] as $key) {
											$infor_2 = CustomerRelationship::model()->inforRelationFamily($key);
											?>
											<li class="trash_hover">
												<span><?php echo $infor_2['name_2']; ?></span>
												<span style="float: right;"><i class="fa fa-trash trash" aria-hidden="true" onclick="deleteRelationFamily(<?php echo  $infor_2['id']; ?> )"></i></span>
											</li>

										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
						<?php if ($relation['relation_1']) { ?>
							<div class="col-md-12 row" style="margin-top:7px;">
								<div style="width:89px;text-align: right;font-size: 13px;float: left; ">Con:</div>
								<div style="width:221px; float: left; ">
									<ul style="padding: 0px 15px;">
										<?php
										foreach ($relation['relation_1'] as $key) {
											$infor_1 = CustomerRelationship::model()->inforRelationFamily($key);
											?>
											<li class="trash_hover"><?php echo $infor_1['name_2']; ?><i class="fa fa-trash trash" aria-hidden="true" onclick="deleteRelationFamily(<?php echo  $infor_1['id']; ?> )"></i></li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
						<?php if ($relation['relation_3']) { ?>
							<div class="col-md-12 row" style="margin-top:7px;">
								<div style="width:89px;text-align: right;font-size: 13px;float: left; ">Cha/mẹ:</div>
								<div style="width:221px; float: left; ">
									<ul style="padding: 0px 15px;">
										<?php
										foreach ($relation['relation_3'] as $key) {
											$infor_3 = CustomerRelationship::model()->inforRelationFamily($key);
											?>
											<li class="trash_hover"><?php echo $infor_3['name_2']; ?><i class="fa fa-trash trash" aria-hidden="true" onclick="deleteRelationFamily(<?php echo  $infor_3['id']; ?> )"></i></li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
						<?php if ($relation['relation_4']) { ?>
							<div class="col-md-12 row" style="margin-top:7px;">
								<div style="width:89px;text-align: right;font-size: 13px;float: left; ">Anh(chị)/em:</div>
								<div style="width:221px; float: left; ">
									<ul style="padding: 0px 15px;">
										<?php
										foreach ($relation['relation_4'] as $key) {
											$infor_4 = CustomerRelationship::model()->inforRelationFamily($key);
											?>
											<li class="trash_hover"><?php echo $infor_4['name_2']; ?><i class="fa fa-trash trash" aria-hidden="true" onclick="deleteRelationFamily(<?php echo  $infor_4['id']; ?> )"></i></li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
						<?php if ($relation['relation_5']) { ?>
							<div class="col-md-12 row" style="margin-top:7px;">
								<div style="width:89px;text-align: right;font-size: 13px;float: left; ">Khác:</div>
								<div style="width:221px; float: left; ">
									<ul style="padding: 0px 15px;">
										<?php
										foreach ($relation['relation_5'] as $key) {
											$infor_5 = CustomerRelationship::model()->inforRelationFamily($key);
											?>
											<li class="trash_hover"><?php echo $infor_5['name_2']; ?><i class="fa fa-trash trash" aria-hidden="true" onclick="deleteRelationFamily(<?php echo  $infor_5['id']; ?> )"></i></li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
					</div>

					<div id="familyPopover" class="popover bottom " style="display: none; ">
						<form id="frm-add-relation-family" onsubmit="return false;" class="form-horizontal">
							<div class="arrow"></div>
							<h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Thêm người trong gia đình</h3>
							<div class="popover-content" style="width:225px;">
								<select name="customer_relation" class="form-control" id="customer_relation"></select>
								<?php
								$listFamily = array();
								$listFamily[1]  = "Con cái";
								$listFamily[2]  = "Vợ/chồng";
								$listFamily[3]  = "Cha/mẹ";
								$listFamily[4]  = "Anh(chị)/em";
								$listFamily[5]  = "Khác";
								echo CHtml::dropDownList('relation_family', '', $listFamily, array('class' => 'form-control', 'style' => 'background-color: #fff;border:1px solid #ccc;box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075);', 'empty' => 'Chọn quan hệ'));
								?>
								<!-- <input  type="hidden" id="id_customer" name="id_customer" value="<?php //echo $model->id
																										?>"> -->
								<span class="help-block"></span>
								<button class="new-gray-btn new-green-btn">Tạo mới</button>
								<button id="hideFamilyPopover" type="reset" class="cancelNewStaff new-gray-btn" style="min-width: 94px;margin-right: 0px;">Hủy</button>
							</div>
						</form>
					</div>

				</div>
				<div class="col-md-6" style="display:inline-block;">

					<div class="customersActionHolder" style="border:0px;">
						<label class="fl" style="line-height:33px;padding-right:10px;">Quan hệ xã hội</label>
						<a id="showSocietyPopover" class="btn_plus" style="float:left;"></a>
						<div class="clearfix"></div>
						<?php
						$relation_social_1 = VRelationSocial::model()->findAllByAttributes(array('customer_1' => ($model->id), 'id_relation' => '1', 'status' => '1'));
						$relation_social_2 = VRelationSocial::model()->findAllByAttributes(array('customer_1' => ($model->id), 'id_relation' => '2', 'status' => '1'));
						?>
						<?php if ($relation_social_1) { ?>
							<div class="col-md-12 row">
								<div style="width:89px;text-align: right;font-size: 13px;float: left; ">Cơ quan:</div>
								<div style="width:221px; float: left; ">
									<ul style="padding: 0px 15px;">
										<?php foreach ($relation_social_1 as $key => $val1) { ?>
											<li class="trash_hover"><?php echo $val1['name_2']; ?>
												<i class="fa fa-trash trash" aria-hidden="true" onclick="deleteRelationSocial(<?php echo  $val1['id']; ?> )"></i></li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
						<?php if ($relation_social_2) { ?>
							<div class="col-md-12 row" style="margin-top:7px;">
								<div style="width:89px;text-align: right;font-size: 13px;float: left; ">Bạn bè:</div>
								<div style="width:221px; float: left; ">
									<ul style="padding: 0px 15px;">
										<?php foreach ($relation_social_2 as $key => $val2) { ?>
											<li class="trash_hover"><?php echo $val2['name_2']; ?><i class="fa fa-trash trash" aria-hidden="true" onclick="deleteRelationSocial(<?php echo  $val2['id']; ?> )"></i></li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
					</div>

					<div id="societyPopover" class="popover bottom" style="display: none;">
						<form id="frm-add-relation-social" onsubmit="return false;" class="form-horizontal">
							<div class="arrow"></div>
							<h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Thêm quan hệ xã hội</h3>
							<div class="popover-content" style="width:225px;">
								<select name="customer_relation_social" class="form-control" id="customer_relation_social"></select>
								<?php
								echo CHtml::dropDownList('relation_social', '', CHtml::listData(RelationSocial::model()->findAll(), 'id', 'name'), array('class' => 'form-control', 'style' => 'background-color: #fff;border:1px solid #ccc;box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075);', 'empty' => 'Chọn quan hệ'));
								?>
								<!-- <input  type="hidden" id="id_customer" name="id_customer" value="<?php //echo $model->id
																										?>"> -->
								<span class="help-block"></span>
								<button class="new-gray-btn new-green-btn">Tạo mới</button>
								<button id="hideSocietyPopover" type="reset" class="cancelNewStaff new-gray-btn" style="min-width: 94px;margin-right: 0px;">Hủy</button>
							</div>
						</form>
					</div>
				</div>

				<div class="clearfix"></div>
			</ul>
		</div>
	</div>
</div>

<script>
	$('#getFormOldBalance').click(function(e) {
		e.preventDefault();

		id = $(this).data('id');
		if (!$('#addOldBalance div').length) {
			console.log(id);
			formOldBalance(id);
		}
	});

	/* bootstrap-fileinput-master */

	$(function() {

		var iP = [];

		var iPC = [];

		<?php
		$dir = Yii::app()->basePath . "/../upload/customer/photos_for_identity_card/" . $model->code_number;
		if (is_dir($dir)) {
			?>
			var code_number = "<?php echo $model->code_number; ?>";
			var id_customer = $('#id_customer').val();

			var dir = baseUrl + "/upload/customer/photos_for_identity_card/" + code_number + "/";


			$.ajax({

				type: "POST",
				url: baseUrl + '/itemsCustomers/Accounts/getPhotosForIdentityCard',
				data: {
					"id_customer": id_customer
				},
				success: function(data) {

					var getData = $.parseJSON(data);

					if (getData) {


						$.each(getData, function(i, item) {

							var response = {};

							iP.push(baseUrl + "/upload/customer/photos_for_identity_card/" + code_number + "/" + getData[i].name);

							response['caption'] = getData[i].name;

							response['key'] = getData[i].id;

							response['extra'] = {
								id: getData[i].id,
								name: getData[i].name,
								code_number: "<?php echo $model->code_number; ?>",
								id_customer: $('#id_customer').val()
							};

							iPC.push(response);

						});

					}

				},
				async: false
			});

		<?php
		}
		?>

		$("#input-777").fileinput({
			uploadUrl: baseUrl + '/itemsCustomers/Accounts/uploadPhotosForIdentityCard',
			deleteUrl: baseUrl + '/itemsCustomers/Accounts/deletePhotosForIdentityCard',
			uploadAsync: false,
			overwriteInitial: false,
			initialPreview: iP,
			initialPreviewAsData: true, // defaults markup
			initialPreviewFileType: 'image', // image is the default and can be overridden in config below
			initialPreviewConfig: iPC,
			uploadExtraData: {
				code_number: "<?php echo $model->code_number; ?>",
				id_customer: $('#id_customer').val()
			}
		}).on('filesorted', function(e, params) {
			console.log('File sorted params', params);
		}).on('fileuploaded', function(e, params) {
			console.log('File uploaded params', params);
		});

		$('#input-777').on('filebatchuploadsuccess', function(event, data, previewId, index) {

			$("#webcamModal").removeClass("in");
			$(".modal-backdrop").remove();
			$('#bootstrapFileinputMasterModal').modal('hide');
			var form = data.form,
				files = data.files,
				extra = data.extra,
				response = data.response,
				reader = data.reader;
			detailCustomer(response.id_customer);

		});

		$("#input-777").on("filepredelete", function(jqXHR) {
			var abort = true;
			if (confirm("Are you sure you want to delete this image?")) {
				abort = false;
			}
			return abort; // you can also send any data/object that you can receive on `filecustomerror` event
		});

		$( ".datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			yearRange: '1900:+0'
		});

	});

	/* end bootstrap-fileinput-master */
	$(document).ready(function() {
		<?php if ($model->city != 0 && $model->city != "") : ?>
			showCounty("<?php echo $model->id; ?>", "<?php echo $model->county; ?>");
		<?php endif ?>
	})
		function showCountry(){
		var id_country = $("#id_country").val();
		console.log($("#countryOther"));
		
		if(id_country== "OTHER"){
			$("#liCountryOther").show();
			return;
		}
		$("#liCountryOther").hide();
	}
	function updateCountryOther(id){
		var CountryOther = $("#countryOther").val();
		$.ajax({
			type:'POST',
			url: '<?php echo CController::createUrl('Accounts/updateCountryOther'); ?>',
			data:{id:id,CountryOther:CountryOther},
			success:function(data){
				if (data=="0") {
					$('#alert-success').append('<div class = "alert alert-success" id="success-alert"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thành Công!</strong> Đã cập nhật...</div>');
					var element = $('.alert-success');
					// var count = element.length;
					for (var i = element.length; i >= 0; i--) {
						$(element[i]).fadeTo(2000, 500).slideUp(500, function() {
							$(this).remove();
						});
					}
					return;
				}
				$.jAlert({
					'title': 'Thông báo',
					'content': 'Bạn sửa thất bại',
					'closeOnClick': true
				});
				return;
			},
			error: function(xhr, ajaxOptions, thrownError){
				console.log(xhr.status);
				console.log(thrownError);
			}
		}); 
	}
</script>
<?php include('relation_js.php'); ?>