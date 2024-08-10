
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
.qP2 {width: 30%;}
.qP3 {width: 8%;}
.qP4 {width: 15%;}
.qP5 {width: 8%;}
.qP6 {width: 15%;}

</style>

<page style="font: arial;font-family:freeserif ;">

<div style="padding-left: 10px;padding-right: 10px;">
    <!-- header -->
	<div style="width: 100%">
        <table style="width: 100%; margin-top: 20px;">
            <tbody> 
                <tr>
                    <td style="width:400px;">
                   		<img src="<?php echo Yii::app()->params['url_base_http'] ?>/images/Logo%20NK%202000_color-01.png" style="width: 140px;">
                    </td>

                    <td style="color: #222;">
						<strong style="font-size: 26px;">BÁO GIÁ</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end table-->
	
	<!-- info customer -->
    <div style=" margin-top: 30px;">
    	<div>
	    	<table style="width: 100%;">
	    		<tbody>
	    			<tr>
	    				<td style="width: 60%;">
					        <table class="tLeft" style="width: 100%;">
					            <tbody>
					                <tr>
					                    <td>Khách hàng:</td>
					                    <td><?php echo $quotation['customer_name']; ?></td>
					                </tr>
					                <tr>
					                    <td>Ngày tháng năm sinh:</td>
					                    <td>
					                    <?php if (strtotime($cus['birthdate'])): ?>
					                    	<?php echo $cus['birthdate']; ?>
					                    <?php endif ?>
					                    </td>
					                </tr>
					                <tr>
					                    <td>Địa chỉ:</td>
					                    <td><?php echo $cus['address']; ?></td>
					                </tr>
					              </tbody>
					        </table>
	    				</td>
	    				<td style="width: 40%;">
					        <table class="tLeft">
					            <tbody>
					                <tr>
					                    <td>Ngày:</td>
					                    <td><?php echo $quotation['create_date']; ?></td>
					                </tr>
					                <tr>
					                    <td>Mã báo giá:</td>
					                    <td><?php echo $quotation['code']; ?></td>
					                </tr>
					              </tbody>
					        </table>
	    				</td>
	    			</tr>
	    		</tbody>
	    	</table>
    		
    	</div>
    </div> 

    <div style="margin-top: 10px;" >
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #8FAAB1; color: white;"><strong>Người thực hiện</strong></th>
                    <th style="padding: 10px; background: #8FAAB1; color: white;"><strong>Sản phẩm và Dịch vụ</strong></th>
                    <th style="padding: 10px; background: #8FAAB1; color: white;"><strong>Số răng</strong></th>
                    <th style="padding: 10px; background: #8FAAB1; color: white;"><strong>Đơn giá</strong></th>
                    <th style="padding: 10px; background: #8FAAB1; color: white;"><strong>Thuế</strong></th>
                    <th style="padding: 10px; background: #8FAAB1; color: white;"><strong>Tổng tiền</strong></th>
            	</tr>
            </thead>
            <tbody>
            <?php if ($quoteDetail): ?>
        		<?php foreach ($quoteDetail as $key => $value): ?>
        		<tr style="margin-top: 5px;">
                    <td style="padding: 15px 0; text-align: center; border: 1px solid #ccc"><?php echo $value['user_name']; ?></td>
                    <td style="padding: 15px 0; text-align: center; border: 1px solid #ccc"><?php echo $value['description']; ?></td>
                    <td style="padding: 15px 0; text-align: center; border: 1px solid #ccc"><?php echo $value['teeth']; ?></td>
                    <td style="padding: 15px 10px; text-align: right; border: 1px solid #ccc"><?php echo number_format($value['unit_price'],0,'','.'); ?></td>
                    <td style="padding: 15px 10px; text-align: right; border: 1px solid #ccc"><?php echo number_format($value['tax'],0,'','.'); ?></td>
                    <td style="padding: 15px 10px; text-align: right; border: 1px solid #ccc"><?php echo number_format($value['amount'],0,'','.'); ?></td>
            	</tr>
        		<?php endforeach ?>
            <?php endif ?>
            	<tr>
                    <td style="padding: 15px 10px; text-align: right; border: 1px solid #ccc; background: #f8f0e4;" colspan="4">Bao gồm thuế</td> 
                    <td style="padding: 15px 10px; text-align: right; border: 1px solid #ccc;" colspan="2"><?php echo number_format($quotation['sum_tax'],0,'','.'); ?> VND</td>
            	</tr>
            	<tr>
                    <td style="padding: 15px 10px; text-align: right; border: 1px solid #ccc; background: #f8f0e4;" colspan="4">Tổng cộng</td>
                    <td style="padding: 15px 10px; text-align: right; border: 1px solid #ccc;" colspan="2">
                       <?php echo number_format($quotation['sum_amount'],0,'','.'); ?> VND
                    </td>
            	</tr>
            </tbody>
            <tfoot class="ivF">
            	<tr>
            		<td colspan="1" style="text-align: left; padding-top: 10pt;">Ghi chú:</td>
            		<?php if ($quotation['note'] == '') 
            				$pad = '30pt';
            			else
            				$pad = '20pt';
            		 ?>
            		<td colspan="5"  style="text-align: left; padding-top: 10pt;"><?php echo $quotation['note']; ?></td>
            	</tr>
                
            	<tr style="text-align: center;">
            		<td colspan="6">Cảm ơn Quý khách đã sử dụng dịch vụ!</td>
            	</tr>
            	<tr style="text-align: center;">
            		<td colspan="6"><?php echo $branch['address']; ?></td>
            	</tr>
            	<tr style="text-align: center;">
            		<td colspan="6"><?php echo $branch['hotline1'] .' - '.$branch['hotline2']; ?></td>
            	</tr>
            </tfoot>
        </table>
    </div>  
</div>
</page>
