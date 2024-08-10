
<table id="excel_service_table">

  <thead>
    <tr>
      <th>Mã dịch vụ</th>
      <th>Tên dịch vụ</th>
      <th>Tên dịch vụ EN</th>
      <th>Giá bán</th>
      <th>Loại Tiền</th>
      <th>Do UT</th>
      <th>Mo Ta</th>
      <th>Tên nhóm</th>
    </tr>
  </thead>
  
  <tbody>

    <?php
    foreach ($data as $key => $value) {
      ?>
      <tr>
       <td><?php echo $value['code'];?></td>
       <td><?php echo $value['name'];?></td>
       <td><?php echo $value['name_en'];?></td>
       <td><?php echo number_format($value['price'],0,".",",");?></td> 
       <td><?php echo ($value['flag_price']==1) ? "VND" : "USD"?></td>
       <td><?php echo $value['priority_pay'];?></td>
       <td><?php echo $value['description'];?></td>
       <td><?php echo $ArrayServiceType[$value['id_service_type']];?></td>
     </tr>
     <?php 
   }
   ?>  

 </tbody>

</table>