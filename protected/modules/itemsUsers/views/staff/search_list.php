 <?php $baseUrl = Yii::app()->baseUrl;?>
 <ul id="customerList">
                                       
        <?php  
        if(!empty($list_data['data']))
        {               
        foreach($list_data['data'] as $k=> $value)
        {
        ?>
        <li id="c<?php echo $value['id'];?>" onclick="detailCustomer(<?php echo $value['id'];?>);"  class="n" >
                                        
			<span class="jqTransformCheckboxWrapper" style="display:none;">
				<a href="#" class="jqTransformCheckbox"></a>
				<input type="checkbox" value="<?php echo $value['id'];?>" class="fl" style="display : none;">
			</span>
			
			<img src="<?php echo $baseUrl; ?><?php if($value['image']!="") echo '/upload/users/sm/'.$value['image']; else echo "/upload/users/no_avatar.png";?>" class="fl" style="border-radius:100%;">
			<label class="fl"><?php echo $value['name'];?> </label>

			<img id="ltn<?php echo $value['id'];?>" class="hide" onclick="showUpdateStaff(<?php echo $value['id'];?>);" src="<?php echo Yii::app()->getBaseUrl(); ?>/images/icon_sb_left/edit_cam.png" style="float:right;margin: 9px 6px 0 0;width: 20px;height: 20px;">

			<div class="clearfix"></div>
        </li>

        <div id="updateStaffPopup<?php echo $value['id'];?>" class="popover bottom staff" style="display: none;padding:0px;top:150px;left:500px;">
            <form id="frm-update-staff-<?php echo $value['id'];?>" onsubmit="return false;" class="form-horizontal">                                                                                                 
                <h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Chỉnh sửa nhân viên</h3>
                <div class="popover-content" style="width:225px;">
                    <input type="text" required oninvalid="this.setCustomValidity('Vui lòng nhập tên nhân viên.')" oninput="setCustomValidity('')" class="form-control" id="staffName<?php echo $value['id'];?>" name="staffName" value="<?php echo $value['name'];?>" placeholder="Tên nhân viên" style="margin-top:0px;padding: 6px 12px;margin-bottom:10px;width:98%;">
                    <button onclick="deleteStaff(<?php echo $value['id'];?>);" class="cancelNewStaff new-gray-btn btn-danger" style="min-width: 94px;margin-right: 0px;">Xóa</button>
                    <button onclick="updateStaffName(<?php echo $value['id'];?>);" class="new-gray-btn btn-success">Cập nhật</button>
                </div>
            </form>
        </div>

        <?php
        }
        }
        else
        {   
        ?>
        <li>Không Tìm Thấy Khách Hàng!!!</li>
        <?php
        } 
        ?>
</ul>
<script type="text/javascript">
    $(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#navbar-collapse").height();
    var title = $('.customerListContainer .customersActionHolder').height();
    var search = $('.customerSearchHolder').height();

    $('#customerList').height(windowHeight-header-title-search-69);
    
    
});
$( document ).ready(function() {

    var windowHeight =  $( window ).height();
    var header       = $("#navbar-collapse").height();
    var title = $('.customersActionHolder').height();
    var search = $('.customerSearchHolder').height();


    $('#customerList').height(windowHeight-header-title-search-69);
    

});
</script>


