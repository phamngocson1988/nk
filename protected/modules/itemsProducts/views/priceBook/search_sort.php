<?php 
$baseUrl = Yii::app()->baseUrl;
?> 

<?php  
if(!empty($list_data['data']))
{       
	foreach($list_data['data'] as $k=> $value)
	{
		?>
		<li id="c<?php echo $value['id'];?>"  class="n">
			<div onclick="detailPriceBook(<?php echo $value['id'];?>);" style="width:calc(100% - 50px);    float: left;">
				<span class="jqTransformCheckboxWrapper" style="display:none;">
					<a href="#" class="jqTransformCheckbox"></a>
					<input type="checkbox" value="<?php echo $value['id'];?>" class="fl" style="display : none;">
				</span>


				<label class="fl"> <?php echo $model->titleCase($value['name']);?> </label>
				<div class="clearfix"></div>
			</div>
			
			<i class="fa fa-pencil hide" aria-hidden="true" onclick="showEditNewPriceBookModal(<?php echo $value['id'];?>);" style="float:right;margin: 9px 6px 0px 0px;    font-size: 20px;"></i>
			<img class="hide" onclick="showEditPriceBookModal(<?php echo $value['id'];?>);" src="<?php echo Yii::app()->getBaseUrl(); ?>/images/icon_sb_left/edit_cam.png" style="float:right;margin: 9px 6px 0px 0px;width: 20px;height: 20px;">
			<div class="clearfix"></div>

		</li>       
		<?php
		// include("popup_edit_price_book.php");
		// include("popup_edit_new_price_book.php");
	}
}
else
{   
	?>
	<li>Không Tìm Thấy Bảng Giá!!!</li>
	<?php
} 
?>

<div class="modal fade" id="editNewPriceBookModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="height:auto">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Chỉnh Sửa Bảng Giá</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editPriceBookModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="height:auto">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Chỉnh Sửa Bảng Giá</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<script>
$(function() {
    $("#customerList li")
        .mouseover(function() { 
            $(this).find("img").removeClass("hide"); 
            $(this).find("i").removeClass("hide");         
        })
        .mouseout(function() {                  
            $(this).find("img").addClass("hide");
            $(this).find("i").addClass("hide");       
        })    
});
$('#editPriceBookModal').on('hidden.bs.modal', function () {
    $("#editPriceBookModal .modal-content").html("");
});
</script>