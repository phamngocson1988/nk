<?php
/*print_r($model);
exit(); */
$id = $model->id;
foreach(CsLeadActivity::model()->findAllByAttributes(array("id_customer"=>$id)) as $k=> $value){
          ?>
<tr class="sss" >
					
					<td style="width:25%;"> 
						<?php echo $value['date'] ?>
					</td>
					
					<td style="width:55%;">
						
	                     <?php echo $value['note'] ?>, Ngày hẹn.<?php echo $value['activity_date'] ?>
	                  
					</td>
					
					
					<td style="width:20%;"> 
						<?php $name = CsLeadActivity::model()->getname($value['id_user']); echo $name['name'] ;?>
					</td>
					 	
					
</tr>
<?php }


 ?>
 