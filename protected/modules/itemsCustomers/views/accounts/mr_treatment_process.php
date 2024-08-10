<?php 

$id_schedule=$model->getIdScheduleByIdCustomer($model->id);


?>
	<input type="hidden" id="id_quotation" value="<?php echo $existQuotation['id']; ?>">
	<input type="hidden" id="id_schedule" value="<?php echo $id_schedule;?>">
	<div class="row padding-left-15">   
		<h4 style="display:inline-block;">QUÁ TRÌNH ĐIỀU TRỊ</h4>  	
		<?php 
		if ($existQuotation) 
		{
		?>
			<a class="global_btn oUpdates" data-toggle="modal" data-target="#update_quote_modal">Xem báo giá</a> 
		<?php	
		}
		else
		{
		?>  
			<!-- <a class="global_btn <?php //if(!$id_schedule) echo "disabled";?>" id="oAdds" data-toggle="modal" data-target="#quote_modal">Thêm báo giá</a>   --> 
			<a class="global_btn" id="oAdds" data-toggle="modal" data-target="#quote_modal">Thêm báo giá</a>   
		<?php 
		}	
		?>               		
	</div> 


	<!-- modal báo giá-->
	<div id="quote_modal" class="modal fade">

	</div>
	<!-- model update quotation -->
	<div id="update_quote_modal" class="modal fade">

	</div>
	

	<div class="row" style="padding-bottom:10em;">
		<div class="col-md-12">	
			<div class="table-responsive">
				<div class="blur" id="add-treatment-process-blur">
					<div id="addnewMedicalHistoryPopup">	
							<div class="modal-header sHeader">
						        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						        <h3 id="treatment_process_title" class="modal-title">THÊM QUÁ TRÌNH ĐIỀU TRỊ</h3>
						    </div>		

				            <form id="frm-save-medical-history" onsubmit="return false;" class="form-horizontal">
				               
				                <div class="popover-content row">
					
					                	<input type="hidden" id="id_medical_history" name="id_medical_history" value="">

					                	<div id="containerTreatment">

					                		<div data-treatment="0">

							                	<div class="col-md-6">	
							                	
							                		<label class="control-label">Số răng:</label>

							                		<select name="tooth_numbers[0][]" class="form-control tooth_numbers" multiple style="width: 100%;padding:2px 12px;">
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="31">31</option>
														<option value="32">32</option>
														<option value="33">33</option>
														<option value="34">34</option>
														<option value="35">35</option>
														<option value="36">36</option>
														<option value="37">37</option>
														<option value="38">38</option>
														<option value="41">41</option>
														<option value="42">42</option>
														<option value="43">43</option>
														<option value="44">44</option>
														<option value="45">45</option>
														<option value="46">46</option>
														<option value="47">47</option>
														<option value="48">48</option>
														<option value="51">51</option>
														<option value="52">52</option>
														<option value="53">53</option>
														<option value="54">54</option>
														<option value="55">55</option>
														<option value="61">61</option>
														<option value="62">62</option>
														<option value="63">63</option>
														<option value="64">64</option>
														<option value="65">65</option>
														<option value="71">71</option>
														<option value="72">72</option>
														<option value="73">73</option>
														<option value="74">74</option>
														<option value="75">75</option>
														<option value="81">81</option>
														<option value="82">82</option>
														<option value="83">83</option>
														<option value="84">84</option>
														<option value="85">85</option>
													</select>											
										

							                	</div>	

							                	<div class="col-md-6 margin-bottom-15">
								                
													<label class="control-label">Công tác điều trị:</label>
													<textarea required class="form-control" name="treatment_work[]" rows="3" placeholder="Công tác điều trị"></textarea>
													
												</div>	

											</div>

										</div>

										<div class="col-md-12 margin-bottom-15">
						                
											<button id="addTreatment" class="btn sbtnAdd "><span class="glyphicon glyphicon-plus"></span> Thêm công tác điều trị</button>	
											
										</div>
							
					               		<div class="col-md-6">	

						               		<div class="form-group">
												<label class="col-md-5 control-label">Bác sĩ điều trị:</label>
												<div class="col-md-7">
													<?php 									
											                       	                
								                    	$selected=yii::app()->user->getState('group_id')==Yii::app()->params['id_group_dentist']?yii::app()->user->getState('user_id'):"";

														$listdata = array();
														
														foreach($model->getListDentists() as $temp){
															$listdata[$temp['id']] = $temp['name'];
														}		

														echo CHtml::dropDownList('id_dentist','',$listdata,array('class'=>'form-control','required'=>'required','options'=>array($selected=>array('selected'=>true))));
													?>
												</div>
											</div>	

											<div class="form-group">
												<label class="col-md-5 control-label">Toa thuốc:</label>												
												<a id="action-prescription" data-toggle="modal" data-target="#prescriptionModal">Thêm toa thuốc</a>
											</div>	

											<div class="form-group">
												<label class="col-md-5 control-label">Lab:</label>												
												<a id="action-lab" data-toggle="modal" data-target="#labModal">Thêm lab</a>
											</div>	
										
											<div class="form-group">
								                <div class="checkbox col-md-12">
								                    <label>
								                        <input id="status_success" name="status_success" type="checkbox" value="true"> Cập nhật trạng thái hoàn tất
								                    </label>								                    
								                </div>	
								            </div>									     							
						                    
					                	</div>

					                	<div class="col-md-6">
					                		<div class="col-md-12">
						                		<span class="fl" style="margin-right: 10px;">
													<a class="btn_plus create_appt" id="create_appt_cus"></a>
												</span>
												<span class="fl">
													<button class="global_btn oUpdates" id="get_newest_schedule" style="margin: 0;">Cập nhật lịch hẹn</button>
												</span>
											</div>
											<div class="col-md-10">
												<textarea name="newest_schedule" id="newest_schedule" class="form-control" readonly="true" rows="5"></textarea>
					                		</div>

											<div class="clearfix"></div>

											<div class="col-md-12 hidden">	
				                				<label class="col-md-4 control-label">Ngày tạo:</label>
				                				<div class="col-md-8">
				                					<input  class=" form-control createdate" id="createdate" name="createdate" placeholder="Ngày tạo">
				                				</div>
				                			</div>
											
											<div class="col-md-12 hidden" style="margin-top: 10px; margin-bottom: 10px;">
												<label class="col-md-4 control-label">Ngày giờ tái khám:</label>
												<div class="col-md-8"><input class="form-control" id="reviewdate" name="reviewdate" type="text" placeholder="Ngày giờ tái khám"></div>
											</div>	
											
											<div class="col-md-12 hidden" style="margin-top: 10px; margin-bottom: 10px;">
												<label class="col-md-4 control-label">Ghi chú:</label>
												<div class="col-md-8"><textarea id="description" name="description" class="form-control" rows="3" placeholder="Ghi chú"></textarea></div>
											</div>

										</div>


										<div class="clearfix"></div>

										<div class="col-md-12">								      
							                <div style="float:right;">
								                <button id="addnewMedicalHistory" class="new-gray-btn new-green-btn">Xác nhận</button>
						                    	<button type="reset" class="cancelNewStaff new-gray-btn cancel">Hủy</button>               
							                </div>								    
								        </div>
				                </div>
				            </form>
					</div>
				</div>


				<div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-hidden="true">
				    <div class="modal-dialog" role="document">
				      <div class="modal-content">

						 <div class="modal-header sHeader">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					        <h3 id="modalTitle" class="modal-title">TOA THUỐC</h3>
					    </div>			       

				        <div class="modal-body" style="padding-top:0px;">
				          <form id="frm-prescription" class="form-horizontal" onsubmit="return false;">
				          	<input type="hidden" id="id_cs_medical_history" name="id_cs_medical_history" value="">
				          	<div class="row">
				          		<div class="col-md-7">																		
									<span class="input-group-addon text-align-left spn-dots">Họ và tên bệnh nhân: <?php echo $model->fullname;?></span>
								</div>	
								<div class="col-md-5">																		
									<span class="input-group-addon text-align-left spn-dots">tuổi: <?php if($model->birthdate != '0000-00-00' && $model->birthdate != '') echo date("Y") - date('Y',strtotime($model->birthdate));?></span>
								</div>	
				          	</div>

				          	<div class="row">
				          		<div class="col-md-12">																		
									<span class="input-group-addon text-align-left spn-dots">Địa chỉ: <?php echo $model->address;?></span>
								</div>								
				          	</div>

				 																	
							<div class="input-group">
							  <span class="input-group-addon spn-dots">Chẩn đoán:</span>
							  <input required type="text" class="form-control ipt-dots" id="diagnose" name="diagnose">												 
							</div>
				

				          	<h4 align="center" style="color:#000;margin-bottom:0px;">THUỐC VÀ CÁCH SỬ DỤNG</h4>

				          	<div id="dntd">

				          		<div data-drug="1">
					          		<div class="input-group">
									  <span class="input-group-addon spn-dots">1.</span>
									  <input required type="text" class="form-control ipt-dots" name="drug_name[]">
									</div>				
									<div class="input-group">
									  <span class="input-group-addon dots spn-dots">Ngày</span>
									  <input required type="number" class="form-control ipt-dots text-align-right" name="times[]">	
									  <span class="input-group-addon dots spn-dots">lần, mỗi lần:</span>
									  <input required type="text" class="form-control ipt-dots" name="dosage[]">							  
									</div>
								</div>								
								
							</div>

							<div class="margin-top-15">
								<button id="upAdd" class="btn sbtnAdd "><span class="glyphicon glyphicon-plus"></span> Thuốc</button>	
							</div>

							<div class="row margin-top-30">
								<div class="col-md-12">						                
									<label class="control-label">Lời dặn:</label>
									<textarea class="form-control" id="advise" name="advise"></textarea>
									<script>	
									CKEDITOR.replace( 'advise', {
									    height: 70,
									    toolbarGroups: [                                                     
									        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
									        { name: 'paragraph',   groups: [ 'list', 'indent' ] },
									        { name: 'links' }                                              
									    ]
									});
									</script>
								</div>								
							</div>	
				
							<div class="row">
								<div class="col-md-6">														
									<div class="input-group">
									  <span class="input-group-addon spn-dots">Tái khám sau</span>
									  <input type="number" class="form-control ipt-dots text-align-right" id="examination_after" name="examination_after">
									  <span class="input-group-addon spn-dots">ngày</span>							 
									</div>
								</div>									
							</div>							

							<div class="modal-footer" style="padding: 15px 0px 0px 0px;border-top:none;">
							  	<button type="button" class="btn print">In toa thuốc</button>
							  	<button type="button" class="btn btn-secondary" data-dismiss="modal">
						          	Hủy
						      	</button>
						      	<?php
							      	$group_id =  Yii::app()->user->getState('group_id'); 
							      	if($group_id==1 || $group_id ==8){ 
						      	?>
							      	<span id="cancelPrescription">
								    </span>
							    <?php } ?>
					          	<button type="submit" class="btn btn-primary">Lưu</button>
					        </div>	
					        
				          </form>
				        </div>
				        
				      </div>
				    </div>
				</div>

				<div class="modal fade" id="labModal" tabindex="-1" role="dialog" aria-hidden="true">
				    <div class="modal-dialog" role="document">
				      <div class="modal-content">

						<div class="modal-header sHeader">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					        <h3 id="modalTitle" class="modal-title">THÔNG TIN GIAO NHẬN LABO</h3>
					    </div>		       

				        <div class="modal-body" style="padding-top:0px;">
				          <form id="frm-lab" class="form-horizontal" onsubmit="return false;">
				          	<input type="hidden" id="id_cs_m3dical_history" name="id_cs_m3dical_history" value="">

				          	<div class="row margin-top-20">

				          		<div class="col-md-6">

				          			<div class="form-group">
					   					<span class="col-md-4 control-label">Nha khoa:</span>
				   						<div class="col-md-8">
				   						<?php 
										  	$selected_branch = yii::app()->user->getState('user_branch');		
											$list_branch = array();														
											foreach($model->getListBranch() as $temp){
												$list_branch[$temp['id']] = $temp['name'];
											}	
											echo CHtml::dropDownList('id_br4nch','',$list_branch,array('class'=>'form-control','required'=>'required','options'=>array($selected_branch=>array('selected'=>true))));
										?>			
				   						</div>
					   				</div>

					   				<div class="form-group">
					   					<span class="col-md-4 control-label">Bệnh nhân:</span>
				   						<div class="col-md-8">
				   						<input disabled type="text" class="form-control" value="<?php echo $model->fullname;?>">			
				   						</div>
					   				</div>

					   				<div class="form-group">
					   					<span class="col-md-4 control-label">Ngày gửi:</span>
				   						<div class="col-md-8">
				   						<input required type="text" class="form-control" id="sent_date" name="sent_date" value="<?php echo date("Y-m-d");?>">			
				   						</div>
					   				</div>

				          		</div>

				          		<div class="col-md-6">

				          			<div class="form-group">
					   					<span class="col-md-4 control-label">Nha sĩ:</span>
				   						<div class="col-md-8">
				   						<?php 
											echo CHtml::dropDownList('id_d3ntist','',$listdata,array('class'=>'form-control','required'=>'required','options'=>array($selected=>array('selected'=>true))));
										?>			
				   						</div>
					   				</div>					   				
					   				
			   						<div class="form-group">

			   							<span class="col-md-4 control-label">Giới tính:</span>
				   						<div class="col-md-3" style="padding-right:0px;">
				   						<input disabled type="text" class="form-control" value="<?php if($model->gender == 0) echo "Nam"; else echo "Nữ";?>">		   						
				   						</div>

					   					<span class="col-md-2 control-label">Tuổi:</span>
				   						<div class="col-md-3">
				   						<input disabled type="text" class="form-control" value="<?php echo date("Y") - date('Y',strtotime($model->birthdate));?>">			
				   						</div>				   						

					   				</div>					   						
					   				
					   				<div class="form-group">
					   					<span class="col-md-4 control-label">Ngày nhận:</span>
				   						<div class="col-md-8">
				   						<input required type="text" class="form-control" id="received_date" name="received_date" value="<?php echo date("Y-m-d");?>">			
				   						</div>
					   				</div>

				          		</div>

				          	</div>
				          	

							<div class="row">
								<div class="col-md-12">						                
									<label class="control-label">Chỉ định của bác sĩ</label>
									<textarea required class="form-control" id="assign" name="assign" rows="4"></textarea>									
								</div>								
							</div>	

							<div class="row margin-top-15">
								<div class="col-md-12">						                
									<label class="control-label">Ghi chú</label>
									<textarea class="form-control" id="n0te" name="n0te"></textarea>
									<script>	
									CKEDITOR.replace( 'n0te', {										
									    height: 70,																    				    
									    toolbarGroups: [                                                     
									        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
									        { name: 'paragraph',   groups: [ 'list', 'indent' ] },
									        { name: 'links' }                                              
									    ]
									});								
									</script>									
								</div>								
							</div>			

							<div class="modal-footer" style="padding: 15px 0px 0px 0px;border-top:none;">
							  	<button type="button" class="btn print_lab">In lab</button>
					          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
					          	<?php
							      	$group_id =  Yii::app()->user->getState('group_id'); 
							      	if($group_id==1 || $group_id ==8){ 
						      	?>
							      	<span id="cancelLaob">
								    </span>
							    <?php } ?>
					          	<button type="submit" class="btn btn-primary">Lưu</button>
					        </div>	
					        
				          </form>
				        </div>
				        
				      </div>
				    </div>
				</div>

				<table class="table table-treatment" style="border-collapse:collapse;">

		    			<thead>
					      <tr bgcolor="#8ca7ae" style="position:relative;">	
							<th>Lần</th>
					        <th>BS điều trị</th>						     
					        <th>Số răng </th>
					        <th>Công tác điều trị</th>		
					        <th>Toa thuốc</th>	
					        <th>Lab</th>
					        <th>Ngày tạo</th>	
					        <th colspan="2">
					        	<span style="color: #fff;" class="action glyphicon glyphicon-plus plusTreatment" onclick="set_null_ipt_id_mh();">
					        </th>
					      </tr>

					    </thead>
					    <tbody id="medical_history">
					      	<?php include("medical_history.php");?>
					    </tbody>
		    	</table>

		    </div>

			<div style="position:relative">
				<hr style="border: 1px dashed #ddd;">
				<div id="pf_cir"></div>
			</div>


			<div id="pf_bill">
			
			</div>
		</div>
	</div>

