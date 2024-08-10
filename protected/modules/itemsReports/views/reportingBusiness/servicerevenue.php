<?php $baseUrl = Yii::app()->baseUrl;?>
<p class="type-report">Doanh thu Dịch vụ</p>
<p class="time-report"><?php echo $fromdate; ?><?php echo ($todate)?" đến ".$todate:""; ?>, <?php echo (isset($dataBrach) && $dataBrach)?"Văn phòng : ".$dataBrach:"tất cả vị trí"; ?>, <?php echo (isset($dataLstUser) && $dataLstUser)?"Bác sĩ : ".$dataLstUser:"tất cả nhân viên"; ?></p>
<div class="clearfix"></div>
<div class="table table-responsive">
  <table class="table table-bordered table-hover servicevenue" cellspacing="0" cellpadding="0" cols="5" border="0" id="list_export">
  <thead class="headertable">
    <tr>
      <td style="width: 25%">Dịch vụ</td>
      <td>Số lịch hẹn</td>
      <td>Thời lượng</td>
      <td>Số khách hàng</td>
      <td>Số lượng</td>
      <td>Đơn giá</td>
      <td>Doanh thu</td>
    </tr>
  </thead>
    <tbody>
    <?php if(!$listService){?>
       <tr>
        <td colspan="6">Chưa có dữ liệu</td>
      </tr>
    <?php
        }else {
          $totalSchedule_1        = 0;
          $lenghtSchedule_1       =0;
          $totalCustomerService_1 = 0;
          $totalServices_1        = 0;
          $totalQuotationService_1  = 0;

        foreach ($listService as $value) { ?>
          <tr>
          <?php if($value['totalServices'] >0){

            $totalSchedule_1        += $value['totalSchedule'];
            $lenghtSchedule_1       += $value['lenghtSchedule'];
            $totalCustomerService_1 += $value['totalCustomerService'];
            $totalServices_1        += $value['totalServices'];
            $totalQuotationService_1  += $value['totalQuotationService'];
          ?>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $value['totalSchedule']; ?></td>
            <td><?php if($value['lenghtSchedule']){echo $value['lenghtSchedule'].' phút';}else { echo "0 phút";} ?></td>
            <td><?php if($value['totalCustomerService']){echo $value['totalCustomerService'];}else { echo "0 ";} ?> </td>
            <td><?php if($value['totalServices']){echo $value['totalServices'];}else { echo "0 ";} ?></td>
            <td><?php echo ($value['price'])?number_format($value['price'],0, ',', '.').' VND':'0 '; ?></td>
            <td><?php echo ($value['totalQuotationService'])?number_format($value['totalQuotationService'],0, ',', '.').' VND':'0 VND'; ?></td>
          <?php }?>
          </tr>
       <?php }
       } ?>
          <tr>
            <td>Tổng</td>
            <td><?php echo $totalSchedule_1; ?></td>
            <td><?php if($lenghtSchedule_1){echo $lenghtSchedule_1;}else{ echo "0" ;} ?> phút</td>
            <td><?php if($totalCustomerService_1){echo $totalCustomerService_1;}else{ echo "0" ;}  ?></td>
            <td><?php if($totalServices_1){echo $totalServices_1;}else{ echo "0" ;}  ?></td>
            <td>N/A</td>
            <td><?php echo ($totalQuotationService_1)?number_format($totalQuotationService_1,0, ',', '.').' VND':'0 VND'; ?></td>
          </tr>
    </tbody>
  </table>
</div>