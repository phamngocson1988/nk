<p class="type-report">Doanh thu sản phẩm </p>
<p class="time-report"><?php echo $fromdate; ?><?php echo ($todate)?" đến ".$todate:""; ?>, <?php echo (isset($dataBrach) && $dataBrach)?"Văn phòng : ".$dataBrach:"tất cả vị trí"; ?>, <?php echo (isset($dataLstUser) && $dataLstUser)?"Bác sĩ : ".$dataLstUser:"tất cả nhân viên"; ?></p>
<div class="table table-responsive">
  <table class="table table-bordered table-hover" id="list_export">
  <thead class="headertable">
    <tr>
      <td>Mã hóa đơn</td>
      <td>Khách hàng</td>
      <td>Chi nhánh</td>
      <td>Người tạo</td>
      <td>Tên sản phẩm</td>
      <td>Số lượng</td>
      <td>Đơn giá</td>
      <td>Tổng tiền</td>
      <td>Ngày tạo</td>
    </tr>
  </thead>
    <tbody>
    
    </tbody>
  </table>
</div>