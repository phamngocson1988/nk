<p class="tt" style="float:left;">Khách hàng sau điều trị</p>
<p style="float: right;"> <?php echo $title;?></p>

<?php

$appointment_list =  AfterTreatmentNote::model()->appointmentList;

?>

<style type="text/css">
    button {
        color: #000 !important;
    }
    table {
        table-layout: fixed;
        width: auto !important;
        max-width: unset !important;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        white-space: nowrap;
    }
</style>

<div class="table table-responsive" id="treatmentListContainer">
  	<table class="table table-hover" id="list_export">
	  	<thead class="headertable">
            <tr>
            	<th class="text-align-center">STT</th>   
                <th class="text-align-center">KH</th> 
                <th class="text-align-center">MKH</th>
                <th class="text-align-center">Họ tên</th>
                <th class="text-align-center">Chẩn đoán</th>
                <th class="text-align-center">Bác sĩ</th>
                <th class="text-align-center">Điều trị</th>  
                <th class="text-align-center">Bác sĩ</th>
                <th class="text-align-center">Không điều trị</th>
                <th class="text-align-center">Bác sĩ</th>
                <th class="text-align-center">Đối tác</th>
                <th class="text-align-center">Thời gian CS</th>
                <th class="text-align-center">Phản hồi</th>
                <th class="text-align-center">Chất lượng</th>
                <th class="text-align-center">Hẹn</th>
                <th class="text-align-center">Hẹn tiếp</th>
                <th class="text-align-center">Thời gian</th>
                <th class="text-align-center">Tên KH giới thiệu</th>
                <th class="text-align-center">Mã KH</th>
                <th class="text-align-center">Ghi chú</th>               
            </tr>
        </thead>
	  	<tbody>
        <?php if (count($cs) > 0): ?>
	  	<?php
        $stt = 0; 
	  	foreach ($cs as $id_customer => $treatment){
	  		$stt++;
	  	?>
	  		<tr class="sort-field">
	  			<td><?php echo $stt ?></td>
                <td><?php echo $treatment['service_code'] ?></td>
                <td><a class="id-report text-danger" href="/itemsCustomers/Accounts/admin?code_number=<?php echo $treatment['code_number'] ?>" target="_blank"><?php echo $treatment['code_number'] ?></a></td>
                <td><a class="btn-edit text-danger" style="cursor: pointer;" data-toggle="modal" data-target="#updateTreatmentModal" onclick="viewUpdateTreatmentForm('<?php echo $treatment['id'] ?>')"><?php echo $treatment['customer_fullname'] ?></a></td>
                <td>
                    <?php echo $treatment['diagnose'] ?> 
                </td>
                <td>
                    <?php echo $treatment['diagnose_doctor'] ?> 
                </td>
                <td>
                    <?php echo $treatment['treatment'] ?> 
                </td>  
                <td>
                    <?php echo $treatment['treatment_doctor'] ?> 
                </td>
                <td>
                    <?php echo $treatment['no_treatment'] ?> 
                </td>
                <td>
                    <?php echo $treatment['no_treatment_doctor'] ?> 
                </td>
                <td>
                    <?php 
                    if ($treatment['partner']) {
                        $partner = Partner::model()->findByPk($treatment['partner']);
                        if ($partner) {
                            echo $partner['name'];
                        }
                    }
                    ?> 
                </td>
                <td><?php echo $treatment['cs_time'] ?></td>
                <td><?php echo $treatment['feedback'] ?></td>
                <td><?php echo $treatment['quality'] ?></td>
                <td><?php echo in_array($treatment['appointment'], array(1,2,3))?$appointment_list[$treatment['appointment']]:''; ?></td>
                <td><?php echo ($treatment['next_schedule'] != '0000-00-00 00:00:00')?$treatment['next_schedule']:'-'; ?></td>
                <td><?php echo ($treatment['next_schedule_time'])?$treatment['next_schedule_time'].' Phút':'-'; ?></td>
                <td><?php echo $treatment['ref_customer'] ?></td>
                <td><?php echo $treatment['ref_customer_code'] ?></td>
                <td><?php echo $treatment['note'] ?></td>				
	  		</tr>
	  	<?php } ?>
        <?php else: ?>
            <tr>
                <td colspan="20">Không có dữ liệu</td>
            </tr>
        <?php endif ?>
	  	</tbody>
	</table>
</div>

<div class="modal" id="updateTreatmentModal" role="dialog">    
</div>

<script type="text/javascript">
    function viewUpdateTreatmentForm(id) {
        jQuery.ajax({   type:"POST",
            url:"<?php echo CController::createUrl('reportingTreatmentAfter/loadUpdateNote')?>",
            data:{
                id: id
            },
            beforeSend: function() {
                jQuery("#idwaiting_search").html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/vtbusy.gif" alt="waiting....." />'); 
            },
            success:function(data){
                if(data == '-1'){
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Có lỗi',
                        'closeOnClick': true
                    });
                }else if(data != ''){
                    jQuery("#return_content").fadeIn("slow");
                    $('#updateTreatmentModal').html(data);
                }else{
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Có lỗi',
                        'closeOnClick': true
                    });
                }
                jQuery("#idwaiting_search").html('');
            }
        });   
        return false; 
    }
</script>