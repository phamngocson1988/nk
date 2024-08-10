<?php include('style.php'); ?>
<!-- Search -->
<div class="col-xs-12">
	<div class="row">
		<form class="form-inline">
			<div class="col-xs-8 mt-30">
				<div class="form-group">
	                <label>Kho</label>
	                <select class="form-control" id="searchRepository">
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
	                <label>Ngày lập phiếu</label>
	                <select class="form-control" id="searchTime">
	                    <option value="0">Tất cả</option>
	                    <option value="1">Hôm nay</option>
	                    <option value="2">Trong tuần</option>
	                    <option value="3">Tháng này</option>
	                    <option value="4">Tháng trước</option>
	                    <option value="5">Chọn thời gian</option>
	                </select>
            	</div>
               	<div class="form-group hidden hiddenTime">
                    <label>Từ ngày: </label>
                    <input  type="text" id="fromtime" class="form-control">
                </div>
                <div class="form-group hidden hiddenTime">
                    <label>Đến ngày: </label>
                    <input  type="text" id="totime" class="form-control">
                </div>
			</div>
			<div class="col-xs-4 mt-30">
				<a class="btn oBtnAdd btn_plus" id="oAdds" data-toggle="modal" data-target="#createModal"></a>
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
<!-- Danh sách-->
<div class="col-xs-12">
	<div class="tableList">
		
	</div>
</div>
<!-- modal tạo-->
<div id="createModal" class="modal fade"></div>

<?php include('js.php'); ?>