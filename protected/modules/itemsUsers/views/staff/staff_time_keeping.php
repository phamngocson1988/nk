<?php 
	$CsServiceTypeTk = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
    $list_data  = GpUsers::model()->searchStaffs('','',' AND id= '.$id_dentist.' ',1,1);
?>
<div id='' style='width:100%;padding-top:2%; height: 700px; overflow: scroll;'>  
    <table class="table table-bordered">
		<thead>
			<tr>
				<th style='text-align:left;'>Tên Nhân Sự</th>
			    <th style='text-align:left;'>Tên Nhóm </th>
				<th>Comison(%)</th>
				<!--
			<?php foreach($CsServiceTypeTk as $gt){?>
				<th style='font-weight:bold'><?php echo $gt['name'].' (%)';?></th>
			<?php }?>-->
			</tr> 
		</thead>
		<tbody>
			<?php
			if(!empty($list_data['data'])){               
				foreach($list_data['data'] as $k=> $value){
					?>
			<?php for($i=0;$i<count($CsServiceTypeTk);$i++){
					$cus = CsPercentTk::model()->findAll('st = 1 and id_gp_users=:st and id_service_type_tk=:dd',array(':st'=>$value['id'],':dd'=>$CsServiceTypeTk[$i]['id']));
					$val_per = $cus?$cus[0]['percent']:'00';
					?>
			<tr>
				<td style='text-align:left;'><?php echo $value['name'];?></td>
				<td style='text-align:left;'>
					<button disabled id='' type="button" style='text-align:center' class="btn btn-default" value=''>
						<?php echo $CsServiceTypeTk[$i]['name'];?>
					</button> 
				</td>
				<td style='text-align:center;'> 
					<button disabled id='id_cusser_<?php echo $value['id'];?>_<?php echo $CsServiceTypeTk[$i]['id'];?>' type="button" style='text-align:center' class="btn btn-default myBtnChange" value='<?php echo $CsServiceTypeTk[$i]['id'].'|'.$value['id'];?>'><?php echo $val_per;?></button>
				</td>
			</tr>
				<?php }}}else{?>
			<tr>
			<?php for($i=0;$i<count($CsServiceTypeTk)+1;$i++){?>
				<td><h3>Không có dữ liệu !!!</h3></td>
			<?php }?>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>

