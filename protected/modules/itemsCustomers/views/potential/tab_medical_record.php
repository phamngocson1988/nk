<?php $baseUrl = Yii::app()->baseUrl;?>
<style type="text/css">
	.customerProfileHolder ul li label {
    width: 113px;
    text-align: right;
    line-height: 31px;
    color: #424242;
}
</style>
<div class="customerProfileContainer">

	<div id="customerProfileDetail" class="customerProfileHolder" style="display: block;margin:30px auto;">

		 <div class="row">

			<form class="col-md-2" id="imageUploader" enctype="multipart/form-data" style="margin:0px;">
				<?php include("customer_image.php");?>
			</form>

			<div class="col-md-9" style="line-height:120px;">
				<div class="configmouseout">
					<i class="delete_camera customer_delete_camera icon-remove-sign icon-2x" style="display:none;"></i>
				</div>
				<input  onchange="updateCustomer(<?php echo $model->id;?>);" type="text" class="customer_name yellow_hover blue_focus" value="<?php echo $model->fullname;?>" id="fullname" name="fullname" placeholder="Họ tên" />
			</div>

		</div> 


		<ul id="customerDetailFormList">
			<div class="col-md-6" style="/*display:inline-block;border-right: 2px solid rgba(49, 157, 70, 0.8);*/">
				<li>
					<label class="fl">Mã số</label>
					 <input readonly type="text" value="<?php echo $model->code_number;?>" placeholder="Mã số" name="code_number" id="code_number" class="custProfileInput yellow_hover blue_focus fl">                     
					<div class="clearfix"></div>
				</li>
				<!-- <li>
					<label class="fl">Họ và Tên</label>
					<input  onchange="updateCustomer(<?php echo $model->id;?>);" type="text"  class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->fullname;?>" id="fullname" name="full_name" placeholder="Họ tên" />
					<div class="clearfix" ></div>
				</li> -->
				                   
				<li>
					<label class="fl">Giới tính</label>
					<?php
					$listdata = array();
					$listdata[0] = "male";
					$listdata[1] = "female";
					echo CHtml::dropDownList('gender','',$listdata,array('onchange'=>'updateCustomer('.$model->id.');','class'=>'custProfileInput yellow_hover blue_focus fl','options'=>array($model->gender=>array('selected'=>true))));
					?>  
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">Ngày sinh</label>
					<input onchange="updateCustomer(<?php echo $model->id;?>);" type="date" placeholder="Ngày sinh" name="birthdate" id="birthdate" class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->birthdate;?>">
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">CMND/Passport</label>
					<input onchange="updateCustomer(<?php echo $model->id;?>);" type="text" placeholder="CMND/Passport" name="identity_card_number" id="identity_card_number" class="custProfileInput yellow_hover blue_focus fl" value="<?php if(!empty($model->identity_card_number)) echo $model->identity_card_number;?>">
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">Số điện thoại</label>                   
					<input style="width: 180px;" onchange="updateCustomer(<?php echo $model->id;?>);" type="text" placeholder="Số điện thoại" name="phone" id="phone" class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->phone;?>">
					<span class="cus_cal cus_icon">
						<img onclick="outgoing_calls();" style="width: 25px;cursor: pointer;" src="<?php echo $baseUrl; ?>/images/medical_record/more_icon/phone.jpg" class="img-responsive">
					</span>                       
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">Số sms</label>                   
					<input style="width: 180px;" onchange="updateCustomer(<?php echo $model->id;?>);" type="text" placeholder="Số sms" name="phone_sms" id="phone_sms" class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->phone_sms;?>">                       
					<span class="cus_sms cus_icon">
						<span style="cursor: pointer;" class="" id="sendSMS" data-toggle="modal" data-target="#sendSmsPop" title=""><img style="width: 25px;" src="<?php echo $baseUrl; ?>/images/medical_record/more_icon/phone_sms.jpg" class="img-responsive"></span>
					</span>
					<?php /*include 'send_sms.php';*/ ?>
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">Home Phone</label>
					<input onchange="updateCustomer(<?php echo $model->id;?>);" type="text" placeholder="Số điện thoại" name="homephone" id="homephone" class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->home_phone;?>">
					<div class="clearfix"></div> 
				</li>                   
				<li>
					<label class="fl">Công ty</label>                   
					<input onchange="updateCustomer(<?php echo $model->id;?>);" type="text" placeholder="Company" name="organization" id="organization" class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->organization;?>">
					<div class="clearfix"></div>
				</li>
				
				<!-- <li>
					<label class="fl">Campaign</label>
					<input  type="text" placeholder="Campaign" name="campaign" id="campaign" class="custProfileInput yellow_hover blue_focus fl" value="">
					<div class="clearfix"></div>
				</li> -->
				<li>
					<label class="fl">Refomed by</label>
					<input  type="text" placeholder="Refomed by" name="refomed" id="refomed" class="custProfileInput yellow_hover blue_focus fl" value="">
					<div class="clearfix"></div>
				</li>
			</div>                
			<div class="col-md-6" style="display:inline-block;">
				
				<li>
					<label class="fl">Account manager</label>
					<input  type="text" placeholder="Account manager" name="account" id="account" class="custProfileInput yellow_hover blue_focus fl" value="">
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">Address</label>
					<input  type="text" onchange="updateCustomer(<?php echo $model->id;?>);" id="address" name="address" placeholder="Address" class="custProfileInput yellow_hover blue_focus fl" value="<?php echo $model->address;?>">
					<div class="clearfix"></div>
				</li>
				<li> 
					<label class="fl">Nguồn</label>
					 <?php
					/*$list_source = array();  
					if($model->id){
						foreach($model->getListSource() as $temp){
							$list_source[$temp['id']] = $temp['name'];
						}
					}
					echo CHtml::dropDownList('id_source','',$list_source,array('onchange'=>'updateCustomer('.$model->id.');','class'=>'custProfileInput yellow_hover blue_focus fl','empty' => 'Chọn nguồn','options'=>array($model->id_source=>array('selected'=>true))));*/
					?>          
					<div class="clearfix"></div>
				</li>	
				<li> 
					<label class="fl">Nhóm</label>
					<!-- <?php					
					$list_segment = array();  
					$selected     = $model->getSelectedSegment($model->id);
					if($model->id){
						foreach($model->getListSegment() as $temp){
							$list_segment[$temp['id']] = $temp['name'];
						}
					} 
					echo CHtml::dropDownList('id_segment','',$list_segment,array('class'=>'custProfileInput yellow_hover blue_focus fl','empty' => 'Chọn nhóm','options'=>array($selected=>array('selected'=>true))));
					?>   -->           
					<div class="clearfix"></div>
				</li>	
				<li>
					<label class="fl">Country</label>
					<?php
					$listdata = array();  
					if($model->id){
						foreach($model->getListCountry() as $temp){
							$listdata[$temp['code']] = $temp['country'];
						}
					} 
					echo CHtml::dropDownList('id_country','',$listdata,array('onchange'=>'updateCustomer('.$model->id.');','class'=>'custProfileInput yellow_hover blue_focus fl','empty' => 'Country','options'=>array($model->id_country=>array('selected'=>true))));
					?>                       
					<div class="clearfix"></div>
				</li>   
				<li> 
					<label class="fl">City</label>
					<?php
					$listdata = array();
					if($model->id){
						foreach(CsCity::model()->findAllByAttributes(array()) as $temp){
							$listdata[$temp['id']] = $temp['name_long'];
						}
					}
					echo CHtml::dropDownList('id_city','',$listdata,array('onchange'=>'updateCustomer('.$model->id.');','class'=>'custProfileInput yellow_hover blue_focus fl','empty' => 'City','options'=>array($model->id_city=>array('selected'=>true))));
					?>                        
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">State</label>
					<?php
					$listdata = array();
					if($model->id){
						foreach(CsState::model()->findAllByAttributes(array()) as $temp){
							$listdata[$temp['id']] = $temp['name_long'];
						}
					}
					echo CHtml::dropDownList('id_state','',$listdata,array('onchange'=>'updateCustomer('.$model->id.');','class'=>'custProfileInput yellow_hover blue_focus fl','empty' => 'State','options'=>array($model->id_state=>array('selected'=>true))));
					?>                          
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">Email</label>
					<input onchange="updateCustomer(<?php echo $model->id;?>);" type="email" value="<?php echo $model->email;?>" placeholder="Email" name="email" id="email" class="custProfileInput yellow_hover blue_focus fl">
					<div class="clearfix"></div>
				</li>
				<li>
					<label class="fl">Curent use</label>                        
					<input type="text" onchange="" id="current_use" name="current_use" placeholder="Current Use" rows="3" class="custProfileInput yellow_hover blue_focus fl">
					<div class="clearfix"></div>
				</li>  
			</div>
			<div class="clearfix"></div>
             <div class="clearfix"></div>

			<hr style="width:80%;" style="display:inline-block;">

			<div class="col-md-6" style="display:inline-block;">  
				<li>
					<label class="fl">Mã bảo hiểm</label>                        
					<input onchange="insertUpdateCustomerInsurrance(<?php echo $model->id;?>);" type="text" placeholder="Mã bảo hiểm" name="code_insurrance" id="code_insurrance" class="custProfileInput yellow_hover blue_focus fl" value="">
					<div class="clearfix"></div>
				</li> 
				<li>
					<label class="fl">Loại bảo hiểm</label>
					<?php
					/*$list_data = array();
					if($model->id){
						foreach($model->getInsurranceType() as $temp){
							$list_data[$temp['id']] = $temp['name'];
						}
					}
					echo CHtml::dropDownList('type_insurrance','',$list_data,array('onchange'=>'insertUpdateCustomerInsurrance('.$model->id.');','class'=>'custProfileInput yellow_hover blue_focus fl','empty' => 'Chọn loại bảo hiểm'));*/
					?>     
					<div class="clearfix"></div>
				</li> 
			</div>
			<div class="col-md-6" style="display:inline-block;">  
				<li>
					<label class="fl">Ngày bắt đầu</label>                        
					<input onchange="insertUpdateCustomerInsurrance(<?php echo $model->id;?>);" type="date" placeholder="Thời gian bắt đầu" name="startdate" id="startdate" class="custProfileInput yellow_hover blue_focus fl" value="">
					<div class="clearfix"></div>
				</li> 
				<li> 
					<label class="fl">Ngày kết thúc</label>                        
					<input onchange="insertUpdateCustomerInsurrance(<?php echo $model->id;?>);" type="date" placeholder="Thời gian kết thúc" name="enddate" id="enddate" class="custProfileInput yellow_hover blue_focus fl" value="">
					<div class="clearfix"></div>
				</li>  
			</div>  
		  
			<div class="clearfix"></div> 
			<div>    
				<div class="col-md-6" style="display:inline-block;">  
					<li>
						<label class="fl" style="width:104px;">Khách hàng:</label>

						<input id="btn_save_user" onclick="changeCustomer(<?php echo $model['id'];?>)" value="Khách hàng" type="submit" name="btn_save_user" style="width: 100px;height: 35px;background: #10b1dd;color: #fff;border-radius: 8px;padding: 3px 8px;font-size: 15px;border: solid 1px #D7D7D7;margin-left: 20px;">
					</li>
				</div>
			</div>
			<div class="clearfix"></div>  
			<hr style="width:80%;" style="display:inline-block;">

			<div class="col-md-6" style="display:inline-block;"> 
			
				<div class="customersActionHolder" style="border:0px;">
                    <label class="fl" style="line-height:33px;padding-right:10px;">Người trong gia đình</label>
                    <a id="showFamilyPopover" class="btn_plus" style="float:left;"></a>                      
                    <div class="clearfix"></div>
                </div>

                <div id="familyPopover" class="popover bottom" style="display: none;">
                    <form id="frm-add-customer" onsubmit="return false;" class="form-horizontal">
                        <div class="arrow"></div>
                        <h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Thêm người trong gia đình</h3>
                        <div class="popover-content" style="width:225px;">   
                            <?php 								
							/*echo CHtml::dropDownList('id_family','',$customer,array('class'=>'form-control','style'=>'width:100%;','empty' => 'Chọn người'));			                            

                            $listFamily = array();
							$listFamily[1]  = "Con cái";
							$listFamily[2]  = "Vợ/chồng";
							$listFamily[3]  = "Cha/mẹ";		
							echo CHtml::dropDownList('relation_family','',$listFamily,array('class'=>'form-control','style'=>'background-color: #fff;border:1px solid #ccc;box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075);','empty' => 'Chọn quan hệ'));				*/	
                            ?>                           
                            <span class="help-block"></span>
                            <button id="" class="btn btn_bookoke btn_bookoke_w">Tạo mới</button>
                            <button id="hideFamilyPopover" type="reset" class="btn btn_cancel" style="min-width: 94px;margin-right: 0px;">Hủy</button>
                        </div>
                    </form>
                </div>
				
			</div>
			<div class="col-md-6" style="display:inline-block;">  
			
				<div class="customersActionHolder" style="border:0px;">
                    <label class="fl" style="line-height:33px;padding-right:10px;">Quan hệ xã hội</label>
                    <a id="showSocietyPopover" class="btn_plus" style="float:left;"></a>                      
                    <div class="clearfix"></div>
                </div>

                <div id="societyPopover" class="popover bottom" style="display: none;">
                    <form id="frm-add-customer" onsubmit="return false;" class="form-horizontal">
                        <div class="arrow"></div>
                        <h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Thêm quan hệ xã hội</h3>
                        <div class="popover-content" style="width:225px;">   
                            <?php 		                            
							/*echo CHtml::dropDownList('id_society','',$customer,array('class'=>'form-control','style'=>'width:100%;','empty' => 'Chọn người'));			                            

                            $listFamily = array();
							$listFamily[1]  = "Bạn bè";							
							echo CHtml::dropDownList('relation_society','',$listFamily,array('class'=>'form-control','style'=>'background-color: #fff;border:1px solid #ccc;box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075);','empty' => 'Chọn quan hệ'));			*/		
                            ?>                           
                            <span class="help-block"></span>
                            <button id="" class="btn btn_bookoke btn_bookoke_w">Tạo mới</button>
                            <button id="hideSocietyPopover" type="reset" class="btn btn_cancel" style="min-width: 94px;margin-right: 0px;">Hủy</button>
                        </div>
                    </form>
                </div>
				
			</div>  
		  
			<div class="clearfix"></div>   
		</ul> 
				
	</div>
</div>



 	