<?php $baseUrl = Yii::app()->baseUrl;?>
<?php 
    $dt =  date("d-m-Y");  
    $from = date("d-m-Y", strtotime('first day of this month'));
    $to= date("d-m-Y", strtotime('last day of this month'));
?>
<p class="type-report">Tóm tắt hoạt động kinh doanh</p>
<p class="time-report"><?php echo isset($fromdate)?$fromdate:$from; ?><?php 
if(isset($todate)){ 
    if ($todate) {
      echo " đến ".$todate;
  }
  else {
    echo "";
  } 
} 
else{ echo " đến ".$to ;} 
?>, <?php echo (isset($dataBrach) && $dataBrach)?"Văn phòng : ".$dataBrach:"tất cả vị trí"; ?>, <?php echo (isset($dataLstUser) && $dataLstUser)?"Bác sĩ : ".$dataLstUser:"tất cả nhân viên"; ?></p>
<div class="clearfix"></div>
<div class="table table-responsive executive">
  <table class="table table-bordered table-hover" id="list_export">
  	<thead class="headertable">
  		<tr>
  			<td>Nhân viên</td>
  			<td colspan="2">Khách hàng</td>
  			<td colspan="5">Lịch hẹn</td>
  			<td colspan="4" style="display: none;">Bán hàng</td>
  		</tr>
  	</thead>
  	<tbody>
  		<tr class="sort-field">
  			<td style="width: 25%;">Tên</td>
  			<td>Tổng</td>
        <td>Mới</td>
  			<td>Tổng</td>
  			<td>Trực tuyến</td> 
  			<td>Hoàn tất</td>	 
  			<td>Bỏ hẹn</td>
        <td>Không đến</td>
  			<td style="display: none;">Doanh số</td>	 
  			<td style="display: none;">Khuyến mãi</td>	 
  			<td style="display: none;">Hóa đơn</td>	 
  			<td style="display: none;">Công nợ</td>
    	</tr>
        <?php
        if (isset($listStaff) && $listStaff) 
        {
          foreach ($listStaff as $value) 
          {
        ?>
            <tr>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $value['total']; ?></td>
            <td><?php echo $value['totalNew']; ?></td>
            <td><?php echo $value['total']; ?></td>
            <td><?php echo $value['online']; ?></td>
            <td><?php echo $value['completed']; ?></td>
            <td><?php echo $value['leaving']; ?></td>
            <td><?php echo $value['noshow']; ?></td>
            <td style="display: none;">0</td>
            <td style="display: none;">N/A</td>
            <td style="display: none;">0</td>
            <td style="display: none;">0</td>
            </tr>
        <?php  
          } 
        }
        ?>
  	</tbody>
  </table>
</div>