<div id="cusListFilter" class="modal" style="padding-right: 0;">
	<form enctype="multipart/form-data" class="form-horizontal" id="send_sms" action="" method="post">

	   	<div class="modal-dialog" style="width: 380px; padding-top: 100px;">
	      	<div class="modal-content">
	         	<div class="modal-header sHeader">
			        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			        <h3 id="modalTitle" class="modal-title">GỬI TIN NHẮN </h3>
			    </div>
	   
	         	<div class="modal-body">
    				<div class="form-group" style="position: relative;">
	               		<label class="col-xs-4 control-label">Số điện thoại</label>
	               		<div class="col-xs-7">
	               			<input type="text" name="Sms[phone]" id="Sms_phone" value="" placeholder="Số điện thoại" class="form-control">
	               			<input type="hidden" id="Sms_cus" value="">
							<input type="hidden" id="Sms_id_cus" value="">								               			
		                </div>
		                <div data-toggle="tooltip" title="Chọn nhóm" id="filterGroup" style="position: absolute; right: 14px; top: 7px;">
		                	<i class="fa fa-plus" aria-hidden="true" style="cursor: pointer;"></i>
		                </div>
	               	</div>
	               	<div class="form-group">
	               		<label class="col-xs-4 control-label">Nội dung</label>
	               		<div class="col-xs-7">
		                  	 <textarea class="form-control" placeholder="Nội dung" name="Sms[content]" id="Sms_content" rows=5></textarea>
		               		<div class="clearfix"></div>
			                <div class="charLeft">Tin <span id="smsNum"> 1 </span> - Còn <span id="charNum">160</span> ký tự</div>
		                </div>
	               	</div>
	               	<div class="form-group">
	               		<div class="col-xs-9 text-center" style="line-height: 33px;">
	               			Tin nhắn không hỗ trợ tiếng Việt có dấu!
	               		</div>
	               		<div class="col-xs-3 text-right" style="padding: 0; padding-right: 40px;">
	               			<button type="submit" class="btn" style="background: #93c541; color: white;">Gửi</button>
	               		</div>
	               	</div>
	          	</div>
	        </div>
	    </div>

	    <!-- Pop up gửi tin nhắn theo nhóm -->
		<div id="popUpFilterGroup" class="popover right" style="display: none; width: 300px; border-radius: 0; padding: 0">
		    <h3 class="popover-title popHead" style="background: #0eb1dc;border-radius: 0;"><span style="color: white; font-weight: normal;">Nhóm khách hàng</span></h3>
		    <div class="popover-content">
	            <div class="col-xs-12">
	            	<div class="form-group">
               			<select name="" id="filterChoose" class="form-control">
               				<option value="1">Sinh nhật khách hàng</option>
               				<option value="2">Ngày khám cuối</option>		               				
               			</select>
	               	</div>
	               	<div class="form-group">
	               		<label class="control-label">Ngày bắt đầu</label>
	               		<input type="text" name="" id="dateStart" class="form-control frmDateTime">
	               	</div>
	               	<div class="form-group">
	               		<label class="control-label">Ngày kết thúc</label>
	               		<input type="text" name="" id="dateEnd" class="form-control frmDateTime">
	               	</div>
	               	<div class="col-xs-12" id="filterText">
	               		
	               	</div>
	                <div class="form-group" style="padding-top: 5px; text-align: right;">
	                    <button id="" type="button" class=" btn btn_cancel cacelPop" style="min-width: 94px;margin-right: 0px;">Đóng</button>
	                    <button type="button" id="filterSubmit" class="btn" style="background: #93c541; color: white;">Lọc</button>
	                </div>
	            </div>
		    </div>
		</div>
	</form>
</div>