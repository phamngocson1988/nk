<form id="form-upExcel"  action="" method="post" enctype="multipart/form-data">
	<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:10px;">
		<tr>
			<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">
			Import Excel file into Sevice</td>
		</tr>
		<tr>
			<td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Data Uploading System</td>
		</tr>
		<tr>
			<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>
			<td width="50%" style="border-bottom:1px solid #eee; padding:5px;">
				<input type="file" name="upExcel" id="upExcel" />
			</td>
		</tr>
		<tr>
			<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>
			<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>
		</tr>
	</table>
</form>
<div id="error">
	
</div>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('.cal-loading').fadeOut('slow');
		$('#mn_nav').css("background-color", "#f1f5f7");
	});
	$('#form-upExcel').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($("#form-upExcel")[0]);
		if (!formData.checkValidity || formData.checkValidity()) {
			jQuery.ajax({ 
				type: "POST",
				url:"<?php echo CController::createUrl('ExcelService/GetImport')?>",
				data:formData,
				datatype:'json',
				success:function(data){
					
					var jsonData = $.parseJSON(data);
					if(jsonData.status == 'successful'){
						$("#error").html("<table border='1' width='100%'><tr><td>MaDV</td><td>TenDV</td><td>Loại tiền</td><td>Ten Nhom</td><td>Lỗi</td></tr></table>");
						$.each(jsonData.data, function(i,item){
							var htmlRow ="<tr>";
							htmlRow += "<td>"+item[0]+"</td>";
							htmlRow += "<td>"+item[1]+"</td>";
							htmlRow += "<td>"+item[4]+"</td>";
							htmlRow += "<td>"+item[7]+"</td>";
							htmlRow += "<td>"+item[8]+"</td>";
							htmlRow +="</tr>";
							$(htmlRow).appendTo("#error table");
						});

					}else{
						$.jAlert({
							'title': "Thông báo !",
							'content': "Thất bại !. "+jsonData.message,
						});
					}
				},
				error: function(data) { 
					console.log("error");
					console.log(data);
				},
				cache: false,
				contentType: false,
				processData: false
			});
			return false;
		}
	});
</script>