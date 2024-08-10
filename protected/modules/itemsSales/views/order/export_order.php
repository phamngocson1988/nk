<style>
p, a, td {
	word-wrap: break-word;
    font-size: 14pt;
}

table.tLeft td{padding-right: 15pt;}

.ivDt {
	width: 100%;
	border-collapse: collapse;
}
.ivDt thead tr{
	background: #8FAAB1;
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
.num {
	padding-right: 10pt;
	text-align: right;
}
.ivS {
	background: #f8f0e4;
}
.ivF td {
	text-align: center;
}

.qP1 {width: 20%;}
.qP2 {width: 40%;}
.qP3 {width: 15%;}
.qP4 {width: 20%;}
.qP5 {width: 20%;}

</style>
<page style="font: arial;font-family:freeserif ;">
<div style="padding-left: 10pt;padding-right: 10pt;">
	 <!-- header -->
	<div style="width: 100%">
        <table style="width: 100%;margin-top: 15pt;">
            <tbody>
                <tr>
                    <td style="color: #222; padding-right: 120pt">
                   		<?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width'=>200)); ?>
                    </td>

                    <td style="color: #222; padding-top: 25pt;">
						<strong style="font-size: 25pt;">ĐƠN HÀNG</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end table-->
	
	<!-- info customer -->
   <div style=" margin-top: 15pt;">
    	<div style="width: 100%;">
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td style="width: 120mm;">
					        <table class="tLeft" style="width: 100%;">
					            <tbody>
					                <tr>
					                    <td>Khách hàng:</td>
					                    <td><?php echo $order['name_recipient']; ?></td>
					                </tr>
					                <tr>
					                    <td>SDT:</td>
					                    <td>
					                    	<?php echo $order['phone_recipient']; ?>
					                    </td>
					                </tr>
					                <tr>
					                    <td>Địa chỉ:</td>
					                    <td><?php echo $order['address_recipient']; ?></td>
					                </tr>
					              </tbody>
					        </table>
	    				</td>
	    				<td style="width: 70mm;">
					        <table class="tLeft">
					            <tbody>
					                <tr>
					                    <td>Ngày:</td>
					                    <td><?php echo $order['create_date']; ?></td>
					                </tr>
					                <tr>
					                    <td>Mã đơn hàng:</td>
					                    <td><?php echo $order['code']; ?></td>
					                </tr>
					              </tbody>
					        </table>
	    				</td>
	    			</tr>
	    		</tbody>
	    	</table>
    		
    	</div>
    </div> 
     <div style="margin-top: 10pt;" >
        <table class="ivDt">
            <thead>
                <tr>
                    <th class="qP2"><strong>Sản phẩm </strong></th>
                    <th class="qP3"><strong>Số lượng</strong></th>
                    <th class="qP4"><strong>Đơn giá</strong></th>
                    <th class="qP5"><strong>Tổng tiền</strong></th>
            	</tr>
            </thead>
            <tbody>
            <?php if ($orderDetail): ?>
        		<?php foreach ($orderDetail as $key => $value): ?>
        		<tr>
                    <td class="qP2"><?php echo $value['product_name']; ?></td>
                    <td class="qP3"><?php echo $value['qty']; ?></td>
                    <td class="num qP4"><?php echo number_format($value['unit_price'],0,'','.'); ?></td>
                    <td class="num qP6"><?php echo number_format($value['amount'],0,'','.'); ?></td>
            	</tr>
        		<?php endforeach ?>
            <?php endif ?>
            	<tr>
                    <td class="ivS" colspan="2">Tổng cộng</td>
                    <td class="num" colspan="2">
                       <?php echo number_format($order['sum_amount'],0,'','.'); ?>
                    </td>
            	</tr>
            </tbody>
            <tfoot class="ivF">
            	<tr>
            		<td colspan="1" style="text-align: left; padding-top: 10pt;">Ghi chú:</td>
            		<?php if ($order['note'] == '') 
            				$pad = '30pt';
            			else
            				$pad = '20pt';
            		 ?>
            		<td colspan="3"  style="text-align: left; padding-top: 10pt;"><?php echo $order['note']; ?></td>
            	</tr>
                <tr>
                    <td colspan="4" style="text-align: left; padding-top: 10pt; padding-bottom: 50pt;">Khách hàng ký tên:</td>
                </tr>
            	<tr>
            		<td colspan="4">Cảm ơn Quý khách đã sử dụng dịch vụ!</td>
            	</tr>
            	<tr>
            		<td colspan="4"><?php echo $branch['address']; ?></td>
            	</tr>
            	<tr>
            		<td colspan="4"><?php echo $branch['hotline1'] .' - '.$branch['hotline2']; ?></td>
            	</tr>
            </tfoot>
        </table>
    </div>  
      
</div>
</page>
