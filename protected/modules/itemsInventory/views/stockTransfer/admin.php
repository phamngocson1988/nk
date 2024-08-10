<?php include('style.php'); ?>
<!-- Search phiếu nhập kho-->
<div class="col-xs-12">
	<div class="row">
		<form class="form-inline">
			<div class="col-xs-8 mt-30">
				<div class="form-group">
	                <label>Thời gian</label>
	                <select class="form-control" id="searchTime">
	                    <option value="0">Tất cả</option>
	                    <option value="1">Hôm nay</option>
	                    <option value="2">Trong tuần</option>
	                    <option value="3">Tháng này</option>
	                    <option value="4">Tháng trước</option>
	                    <option value="5">Chọn thời gian</option>
	                </select> 
            	</div> 
            	<div class="form-group">
	                <label>Kho chuyển</label>
					<select class="form-control" id="searchRepositoryTransfer">
						<?php
							$group_id =  Yii::app()->user->getState('group_id'); 
							if($group_id == 1 || $group_id == 20): 
								echo '<option value="">Tất cả</option>';
							endif;
	                    	foreach ($listRepository as $key => $value):
	                    		echo '<option value ="'.$value['id'].'">'.$value['name'].'</option>'; 
	                    	endforeach;
	                    ?>
	                </select>
            	</div>
            	<div class="form-group">
	                <label>Kho nhận</label>
	                <select class="form-control" id="searchRepositoryReceipt">
	                    <option value="">Tất cả</option>
	                    <?php 
	                    	foreach ($listRepository as $key => $value):
	                    	echo '<option value ="'.$value['id'].'">'.$value['name'].'</option>'; 
	                    	endforeach;
	                    ?>
	                </select> 
            	</div>
            	<div class="form-group">
	                <label>Trạng thái</label>
	                <select class="form-control" id="searchStatus">
	                	<option value="0">Tất cả</option>
	                    <option value="1">Phiếu chuyển kho</option>
	                    <option value="2">Nhận chuyển kho</option>
	                </select>
            	</div>
            	<div class="clearfix"></div>
               	<div class="form-group hidden hiddenTime">
                    <label>Từ ngày: </label>
                    <input  type="text" id="fromtime" class="form-control">
                </div>
                <div class="form-group hidden hiddenTime">
                    <label>Đến ngày: </label>
                    <input type="text" id="totime" class="form-control">
                </div>
			</div>
			<div class="col-xs-4 mt-30">
				<?php if($group_id == 1 || $group_id==20 || $group_id ==21): ?>
				<a class="btn oBtnAdd btn_plus" id="oAdds" data-toggle="modal" data-target="#createModal"></a>
				<?php endif;?>
				<div class="input-group pull-right">
	                <input type="text" class="form-control" id="searchCode" placeholder="Tìm kiếm theo mã">
	                <div class="input-group-addon" id="btnSearchCode">
	                	<span class="glyphicon glyphicon-search"></span>
	                </div>
	            </div>
			</div>
		 </form>
	</div>
</div>
<!-- Danh sách phiếu chuyển kho-->
<div class="col-xs-12">
	<div class="tableList">
		
	</div>
</div>
<!-- modal tạo-->
<div id="createModal" class="modal fade"></div>
<!-- modal cập nhật-->
<div id="updateModal" class="modal fade"></div>
<?php include('js.php'); ?>
