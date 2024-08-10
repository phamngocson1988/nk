<style type="text/css">
p, a, td {
	word-wrap: break-word;
    font-size: 10pt;
}
.ivDt {
	width: 100%;
	border-collapse: collapse;
}
.ivDt thead tr{
	background: #8FAAB1;
	font-size: 10pt;
}
.ivDt thead th, .ivDt tbody td{
	padding: 8px auto;
	text-align: center;
	color: #fff;
	border: 1px solid #ccc;
}
.ivDt tbody td{
	color: #000;	
}
</style>
<page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif ; margin-top:50px;">
	
	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">

		  	<thead class="headertable">
		  		<tr>
		        <th>Mã hóa đơn</th>
       
		        <th>Mã khách hàng</th>

		        <th>Tên khách hàng</th>

		        <th>Tiền mặt</th>

		        <th>Thẻ tín dụng</th>

		        <th>Chuyển khoản</th>

		        <th>Tổng tiền</th>       
		  		</tr>
		  	</thead>
		  	<tbody>
  		
		        <?php   

		        if (isset($listReceipt) && !empty($listReceipt)):

		          $i = 0;

		          $len = count($listReceipt);

		          $total_sum_cash = 0; 

		          $total_sum_credit = 0;   

		          $total_sum_transfer = 0; 

		          $total_sum_pay_amount = 0;             

		          foreach ($listReceipt as $key => $value) :  
		            
		            $invoice = Invoice::model()->findByPk($value['id_invoice']); 

		            $customer = Customer::model()->findByPk($invoice->id_customer);

		            $payReceipt = Receipt::model()->getPayReceipt($value['id_invoice']); 

		            $total_sum_cash += $payReceipt["sum_cash"];  

		            $total_sum_credit += $payReceipt["sum_credit"];  

		            $total_sum_transfer += $payReceipt["sum_transfer"];

		            $total_sum_pay_amount += $value["sum_pay_amount"];

		      ?>             
		        

		        <tr>

		          <td><?php echo $invoice->code;?></td> 

		          <td><?php echo $customer->code_number;?></td>

		          <td><?php echo $customer->fullname;?></td>
		          
		          <td><?php echo number_format($payReceipt["sum_cash"],0,",",".");?></td>

		          <td><?php echo number_format($payReceipt["sum_credit"],0,",",".");?></td>

		          <td><?php echo number_format($payReceipt["sum_transfer"],0,",",".");?></td>

		          <td><?php echo number_format($value['sum_pay_amount'],0,",",".");?></td>

		        </tr>

		      <?php               
		    	
		    	if ($i == $len - 1) {

		      ?>

		        <tr>

		          <td colspan="3" style="text-align:center;"><h4>Total</h4></td>           
		          
		          <td style="vertical-align:middle;"><?php echo number_format($total_sum_cash,0,",",".");?></td>

		          <td style="vertical-align:middle;"><?php echo number_format($total_sum_credit,0,",",".");?></td>

		          <td style="vertical-align:middle;"><?php echo number_format($total_sum_transfer,0,",",".");?></td>

		          <td style="vertical-align:middle;"><?php echo number_format($total_sum_pay_amount,0,",",".");?></td>

		        </tr>
		      
		      <?php    
		           
		        }
		        
		        $i++;     
		          
		        endforeach;

		          
		        else:


		        ?>
		          
		        <tr>
		          
		          <td colspan="7" style="text-align: center;"><?php echo "Không có dữ liệu!";?></td>

		        </tr>

		        <?php      

		        endif;

		        ?>   




		  	</tbody>
			
		</table>
	</div>
</page>