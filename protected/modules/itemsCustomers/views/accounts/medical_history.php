<tr style="display:none;">
	<td id="check_change_status_process">
		<?php echo $model->checkChangeStatusProcess($model->id);?>
	</td>
	<td id="check_add_new_treatment">
		<?php echo $model->checkAddNewTreatment($model->id);?>
	</td>	
</tr>

<?php
$listTreatmentProcess = $model->getListTreatmentProcessOfCustomer($id_mhg);        
if(count($listTreatmentProcess)){	
	$sum = count($listTreatmentProcess);
	foreach($listTreatmentProcess as $k => $v){
	$turn = $sum-$k;		
	?>
	<tr data-toggle="collapse" data-target="#TreatmentProcess<?php echo $k+1;?>" class="accordion-toggle" style="cursor:pointer;background-color: <?php if(($k+1) % 2 == 1){ echo "#fff";} else{ echo "#F2F2F2";}?>;">
	    <td><?php echo $turn;?></td>
	    <td>BS. <?php echo $v['gp_users_name'];?></td>	
	    <td>   
	    	<?php 
		    	foreach ($v['listTreatmentWork'] as $key => $value) {
		    		echo $value['tooth_numbers']."</br>";
		    	}
	    	?>    	
	    </td> 
	    <td>  
	    	
	    </td>    
	    <td><?php if($v['id_prescription']) echo '<i class="fa fa-file-text-o" onclick="viewPrescriptionAndLab('.$v['id'].',1);"></i>'; else echo '<i class="fa fa-file-o"></i>';?></td>
	    <td><?php if($v['id_labo']) echo '<i class="fa fa-file-text-o" onclick="viewPrescriptionAndLab('.$v['id'].',2);"></i>'; else echo '<i class="fa fa-file-o"></i>';?></td>
	    <td><?php echo date('d/m/Y',strtotime($v['createdate']));?></td>	
	    <td>
            <span class="action glyphicon glyphicon-pencil pencil pencilTreatment" onclick="view_frm_treatment(<?php echo $v['id'];?>);">
        </td>  
        <td>
            <span class="action glyphicon glyphicon-trash trash" onclick="deleteMedicalHistory(<?php echo $v['id'];?>);">
        </td>  
	</tr>	
	<tr>
	    <td colspan="9" class="hiddenRow" style="text-align: left;line-height:2;">
	        <div class="accordian-body collapse oView col-md-12" id="TreatmentProcess<?php echo $k+1;?>">	       
		        <div class="oViewDetail col-md-12">
					<div class="row">
				      	<?php include("detail_medical_history.php");?>
				    </div>
		        </div>
	        </div>
	    </td>
    </tr>
<?php 
	}
} ?>

<?php 

if (isset($id_shedule) && $id_shedule) {

	echo 	"<script>

				// $('li#c".$model->id." code').replaceWith('<code class=\"delete_btn status_4\">Hoàn tất</code>');		

				$('li#c".$model->id." code').remove();			

				$('#appointmentList li select').each(function(){
				    if ($(this).val() == 3 || $(this).val() == 6) {
				        $(this).val(4);
				    }
				});		

				setTimeout( function(){ getNoti(".$id_shedule.", 'update', ".Yii::app()->user->getState('user_id').") }, 500);

		  	</script>";

}

?>
<script>
	$(document).ready(function(){
		$('.collapse').collapse();
	})
// $('.accordion-toggle').click(function(){
//     $( ".accordion-toggle" ).each(function( index ) {  
//         $(this).removeClass("at");  
//     });
//     var st =  $(this).attr("aria-expanded");   

//     if(st == 'false' || st == undefined){        
//         $(this).addClass("at");
//     }else if(st == 'true'){

//         $(this).removeClass("at");
//     } 
// });

// $('.collapse').on('show.bs.collapse', function () {    
//     $('.collapse.in').collapse('hide');
// });
</script>







