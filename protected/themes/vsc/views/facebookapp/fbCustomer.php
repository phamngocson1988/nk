<?php include 'fb_app_css.php'; ?>
<style type="text/css">
.line_dot {border: 1px dashed #bfbdbd;}

#fb_book_review table th, #fb_book_review table td {border: 0;}
#fb_book_review table th {text-align: right;}

#fb_book_resgiter_info form {position: relative;}
#bk_res_log_info {
    padding: 25px 15px;
    border-left: 2px solid #ddd;
    margin: 5px 0;
    position: absolute;
    bottom: 65px;
    right: 0;
}

</style>

<?php $baseUrl = Yii::app()->getBaseUrl();
	$book 		= Yii::app()->session['book'];
?>

<div class="col-xs-12 fb_book">
	<div class="col-xs-12" id="bk_st_tt">
		<h4>THÔNG TIN LỊCH HẸN</h4>
	</div>

	<div class="col-xs-12" id="fb_book_review">
		<table class="table">
			<tr>
				<th>Thời gian khám: </th>
				<td><?php echo $book[0]['day'] . ' ' . $book[0]['time']; ?></td>
			</tr>
			<tr>
				<th>Phòng khám: </th>
				<td><?php echo $book[0]['branch']; ?></td>
			</tr>
			<tr>
				<th>Dịch vụ:</th>
				<td><?php echo $book[0]['service']; ?></td>
			</tr>
			<tr>
				<th>Nha sỹ chỉ định điều trị:</th>
				<td><?php echo GpUsers::model()->findByPk($book[0]['id_dentist'])->name; ?></td>
			</tr>
		</table>
	</div>

	<div class="col-xs-12" id="bk_st_tt">
		<h4>THÔNG TIN CỦA BẠN</h4>
	</div>

	<div class="col-xs-12" id="fb_book_customer">
		<?php 
			if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false){
				$this->renderPartial('fbEditCus',array('model'=>$model,'phone'=>$phone));
			}
			else{
				$this->renderPartial('fbRegisterCus',array('model'=>$model));
			}
		?>
	</div>
</div>


<script>
$(function(e){
	$('a#fb_login').click(function(e){
		e.preventDefault();

		$.ajax({
			url: "<?php echo CController::createUrl('facebookapp/fbLogin'); ?>",
			type: 'POST',
			dataType: 'html',
			success: function (data) {
				$('#fb_book_customer').empty();
				$('#fb_book_customer').html(data);
			}, 
		})
	})
})
</script>