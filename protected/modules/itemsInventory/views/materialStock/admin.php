<?php include('style.php'); ?>
<!-- Search -->
<div class="col-xs-12">
	<div class="row">
		<form class="form-inline">
			<div class="col-xs-12 mt-30">
				<div class="form-group">
	                <label>Kho</label>
	                <select class="form-control" id="searchRepository">
						<?php
	                    	foreach ($listRepository as $key => $value):
	                    		echo '<option value ="'.$value['id'].'">'.$value['name'].'</option>'; 
	                    	endforeach;
	                    ?>
	                </select>
            	</div>
				<div class="form-group">
	                <label>Ngày hết hạn</label>
	                <select class="form-control" id="searchExpirationDate">
	                    <option value="0">Tất cả</option>
	                    <option value="1">Hôm nay</option>
	                    <option value="2">Trong tuần</option>
	                    <option value="3">Tháng này</option>
	                    <option value="4">Tháng trước</option>
	                    <option value="5">Chọn thời gian</option>
	                </select>
            	</div>
            	<div class="form-group">
            		<label>Nguyên vật liệu</label>
            		<select class="form-control" id="searchMaterial"></select>
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
		 </form>
	</div>
</div>
<!-- Danh sách-->
<div class="col-xs-12">
	<div class="tableList">
		
	</div>
</div>
<?php include('js.php'); ?>