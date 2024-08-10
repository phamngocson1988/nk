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
		        <th>Ngày phát sinh</th>
		  		<th>Nhóm khách hàng</th>
		        <th>Mã khách hàng</th>
		        <th>Tên khách hàng</th>
		        <th>Văn phòng</th>        
		  		</tr>
		  	</thead>
		  	<tbody>
  		
		        <?php   

		        if (isset($listInvoice) && !empty($listInvoice)):          

		          foreach ($listInvoice as $key => $value) :    
		        

		            $segment     = $value['id_segment'] ? Segment::model()->findByPk($value['id_segment'])->name : "";  
		            
		            $code_number = Customer::model()->findByPk($value['id_customer'])->code_number; 

		            $branch      = Branch::model()->findByPk($value['id_branch'])->name;

		      ?>             
		        

		        <tr>

		          <td><?php echo $value['code'];?></td> 

		          <td><?php echo date('d/m/Y',strtotime($value['create_date']));?></td> 

		          <td><?php echo $segment;?></td>

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
</page>