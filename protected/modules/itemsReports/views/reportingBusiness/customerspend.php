<?php $baseUrl = Yii::app()->baseUrl;?>
<p class="type-report">Chi tiêu của Khách hàng</p>
<p class="time-report"><?php echo $fromdate; ?><?php echo ($todate)?" đến ".$todate:""; ?>, <?php echo (isset($dataBrach) && $dataBrach)?"Văn phòng : ".$dataBrach:"tất cả vị trí"; ?>, <?php echo (isset($dataLstUser) && $dataLstUser)?"Bác sĩ : ".$dataLstUser:"tất cả nhân viên"; ?></p>
<div class="clearfix"></div>
<div class="table table-responsive">
  <table class="table table-bordered table-hover customerspend" cellspacing="0" cellpadding="0" cols="5" border="0" id="list_export">
  <thead class="headertable">
    <tr>
      <td>Khách hàng</td>
      <td style="width: 8%">Số lịch hẹn</td>
      <td style="width: 8%">Số dịch vụ</td>
      <td>Báo giá</td>
      <td>Hóa đơn</td>
      <td>Khuyến mãi</td>
      <td>Thanh toán</td>
      <td>Công nợ</td>
    </tr>
  </thead>
  	<tbody>
    <?php if (isset($lstCustomer) && $lstCustomer) {
      foreach ($lstCustomer as $value) { 
      ?>
      <tr>
        <td><?php echo $value['fullname']; ?></td>
        <td><?php echo $value['totalSchedule']; ?></td>
        <td><?php echo $value['totalService']; ?></td>
        <td><?php echo ($value['sum_amount'])?number_format($value['sum_amount'],0, ',', '.').' vnđ':'0'; ?></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      </tr>
    <?php  }
    } ?>
    <?php if (isset($totalCustomerSpend) && $totalCustomerSpend) { 
    ?>
  		<tr>
  			<td>Tổng</td>
  			<td><?php echo $totalCustomerSpend['total_Schedule']; ?></td>
  			<td><?php echo $totalCustomerSpend['total_Service']; ?></td>
  			<td><?php echo ($totalCustomerSpend['total_Quotation'])?number_format($totalCustomerSpend['total_Quotation'],0, ',', '.').' vnđ':'0'; ?></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
  		</tr>
      <?php } ?>
  	</tbody>
  </table>
</div>