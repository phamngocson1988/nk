

<div class="table table-responsive executive">
  <table class="table table-bordered table-hover">
  	<thead class="headertable">
  		<tr>
        <th>Mã hóa đơn</th>
        <th>Ngày phát sinh</th>
  			<th>Nhóm bảng giá</th>
        <th>Mã khách hàng</th>
        <th>Tên khách hàng</th>
        <th>Văn phòng</th>        
  		</tr>
  	</thead>
  	<tbody>
  		
        <?php   

        if (isset($listInvoice) && !empty($listInvoice)):          

          foreach ($listInvoice as $key => $value) :    
        

            //$segment     = $value['id_segment'] ? Segment::model()->findByPk($value['id_segment'])->name : "";  
            
            $code_number = Customer::model()->findByPk($value['id_customer'])->code_number; 

            $branch      = Branch::model()->findByPk($value['id_branch'])->name;

      ?>             
        

        <tr>

          <td><a href="<?php echo Yii::app()->baseUrl.'/itemsCustomers/Accounts/admin?code_number='.$code_number.'&id_invoice='.$value['id'];?>" target="_blank"><?php echo $value['code'];?></a></td> 

          <td><?php echo date('d/m/Y',strtotime($value['create_date']));?></td> 

          <td><?php echo $value['name_price_book'];?></td>

          <td><?php echo $code_number;?></td>

          <td><?php echo $value['customer_name'];?></td>

          <td><?php echo $branch;?></td>            

        </tr>

      <?php               
        
          
        endforeach;

          
        else:


        ?>
          
        <tr>
          
          <td colspan="6" style="text-align: center;"><?php echo "Không có dữ liệu!";?></td>

        </tr>

        <?php      

        endif;

        ?>   




  	</tbody>
  </table>
</div>