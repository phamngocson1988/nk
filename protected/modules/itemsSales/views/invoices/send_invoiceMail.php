
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

</style>

<page style="font: arial;font-family:freeserif ;">

<div style="padding-left: 10pt;padding-right: 10pt;">
    <!-- header -->
	<div style="width: 100%">
        <table style="width: 100%;margin-top: 15pt;">
            <tbody>
                <tr>
                    <td style="width: 45%">
                   		<img src="<?php echo Yii::app()->params['url_base_http'] ?>/images/Logo%20NK%202000_color-01.png" style="width: 140px;">
                    </td>

                    <td style="color: #222">
						<strong style="font-size: 25px;">PHIẾU THU</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end table-->
	
	<!-- info customer -->
    <div style=" margin-top: 25px;">
    	<div >
	    	<table style="width: 100%;">
	    		<tbody>
	    			<tr>
	    				<td style="width: 70%;">
					        <table class="tLeft" style="width: 100%;">
					            <tbody>
					                <tr>
					                    <td>Khách hàng:</td>
					                    <td><?php echo $invoice['customer_name']; ?></td>
					                </tr>
					                <tr>
					                    <td>Ngày tháng năm sinh:</td>
					                    <td>
					                    <?php if (strtotime($cus['birthdate'])): ?>
					                    	<?php echo $cus['birthdate']; ?>
					                    <?php endif ?>
					                    </td>
					                </tr>
					              </tbody>
					        </table>
	    				</td>
	    				<td style="width: 30%;">
					        <table class="tLeft">
					            <tbody>
					                <tr>
					                    <td>Ngày:</td>
					                    <td>
                                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                                <?php echo $rpt['pay_date']; ?> 
                                            <?php else: ?>      
                                                <?php echo $invoice['create_date']; ?>
                                            <?php endif ?>    
                                        </td>
					                </tr>
					                <tr>
					                    <td>Số hồ sơ:</td>
					                    <td><?php echo $cus['code_number']; ?></td>
					                </tr>
					              </tbody>
					        </table>
	    				</td>
	    			</tr>
                    <tr>
                        <td colspan="2">Địa chỉ: <span style="margin-left: 30mm;"><?php echo $cus['address']; ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Hình thức thanh toán:
                        <span style="margin-left: 10mm;">
                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                <?php echo $this->invoice_type[$rpt['pay_type']]; ?>
                                <?php if ($rpt['trans_name']!='0'){
                                    echo " - " . $rpt['trans_name'];
                                } ?> 
                            <?php endif ?></span>
                        </td>
                    </tr>
	    		</tbody>
	    	</table>
    		
    	</div>
    </div> 

    <div style="margin-top: 25px;" >
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 10%; padding: 10px; border: 1px solid #ccc; background: #8FAAB1; color: white;"><strong>#</strong></th>
                    <th style="width: 46%; padding: 10px; border: 1px solid #ccc; background: #8FAAB1; color: white;"><strong>Dịch vụ</strong></th>
                    <th style="width: 15%; padding: 10px; border: 1px solid #ccc; background: #8FAAB1; color: white;"><strong>Đơn giá</strong></th>
                    <th style="width: 10%; padding: 10px; border: 1px solid #ccc; background: #8FAAB1; color: white;"><strong>Số lượng</strong></th>
                    <th style="width: 15%; padding: 10px; border: 1px solid #ccc; background: #8FAAB1; color: white;"><strong>Tổng tiền</strong></th>
            	</tr>
            </thead>
            <tbody>
            <?php if ($ivDetail): ?>
        		<?php foreach ($ivDetail as $key => $value): ?>
        		<tr>
                    <td style="width: 10%; padding: 10px; border: 1px solid #ccc; text-align: center; "><?php echo $key + 1; ?></td>
                    <td style="width: 46%; padding: 10px; border: 1px solid #ccc; text-align: center; "><?php echo $value['description']; ?></td>
                    <td style="width: 15%; padding: 10px; border: 1px solid #ccc; text-align: right; "><?php echo number_format($value['unit_price'],0,'','.'); ?></td>
                    <td style="width: 10%; padding: 10px; border: 1px solid #ccc; text-align: center; "><?php echo $value['qty']; ?></td>
                    <td style="width: 15%; padding: 10px; border: 1px solid #ccc; text-align: right; "><?php echo number_format($value['amount'],0,'','.'); ?></td>
            	</tr>
        		<?php endforeach ?>
            <?php endif ?>
            	<tr>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right; background: #f8f0e4;" colspan="3">TỔNG CHI PHÍ ĐIỀU TRỊ</td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"></td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"><?php echo number_format($invoice['sum_amount'],0,'','.'); ?> VND</td>
            	</tr>
            	<tr>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right; background: #f8f0e4;" colspan="3">ƯU ĐÃI %</td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"></td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;">
                        <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                            <?php echo number_format($rpt['pay_promotion'],0,'','.'); ?>
                        <?php endif ?> VND
                    </td>
            	</tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right; background: #f8f0e4;" colspan="3">BẢO HIỂM</td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"></td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right; ">
                        <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                            <?php if ($rpt['pay_type'] == 3 && $rpt['trans_name'] != '0') {
                                echo number_format($rpt['pay_sum'],0,'','.');
                            } else {echo 0;} ?>
                        <?php endif ?> VND
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right; background: #f8f0e4;" colspan="3">THANH TOÁN</td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"></td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;">
                        <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                            <?php if ($rpt['pay_type'] == 3 && $rpt['trans_name'] != '0') {
                                echo 0;
                            } else {
                                echo number_format($rpt['pay_sum'],0,'','.');
                            } ?>
                        <?php else: ?>
                            <?php if ($invoice['balance'] > 0): ?>
                                <?php echo number_format($invoice['sum_amount'] - $invoice['balance'],0,'','.'); ?>
                            <?php else: ?>
                                <?php echo number_format($invoice['sum_amount'],0,'','.'); ?>
                            <?php endif ?>
                        <?php endif ?>
                     </td>
                </tr>
            	<tr>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right; background: #f8f0e4;" colspan="3">ĐÃ THANH TOÁN</td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"></td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;">
                        <?php if ($invoice['balance'] > 0): ?>
                            <?php echo number_format($invoice['sum_amount'] - $invoice['balance'],0,'','.'); ?>
                        <?php else: ?>
                            <?php echo number_format($invoice['sum_amount'],0,'','.'); ?>
                        <?php endif ?> VND
                     </td>
            	</tr>
            	<tr>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right; background: #f8f0e4;" colspan="3">CÒN LẠI</td>
                   <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"></td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;">
                        <?php echo number_format($invoice['balance'],0,'','.'); ?> VND
                    </td>
            	</tr>
            </tbody>
            <tfoot class="ivF">
            
                <?php if (count($rpt) != 0 && !isset($rpt['id_invoice']) ): ?>
                    <tr>
                        <td style="text-align: left;" colspan="5" style="padding-top: 25px;">Lịch sử thanh toán</td>    
                    </tr>
                    <?php foreach ($rpt as $k => $pay): 
                        $trans = ($pay['pay_type'] == 3 && $pay['trans_name'] != '0') ? $pay['trans_name'] : '';
                    ?>
                        <tr>
                            <td style="text-align: left; padding-top: 5px; " colspan="5">
                            <?php echo date_format(date_create($pay['pay_date'])); ?> | <?php echo number_format($pay['pay_amount'],0,'','.'); ?> VND + <?php echo number_format($pay['pay_promotion'],0,'','.'); ?> VNĐ | <?php echo $this->invoice_type[$pay['pay_type']]." ".$trans; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            	<tr>
            		<td colspan="5" style="padding-top: 20px; text-align: center;">Cảm ơn Quý khách đã sử dụng dịch vụ!</td>
            	</tr>
            	<tr>
            		<td colspan="5" style="text-align: center;"><?php echo $branch['address']; ?></td>
            	</tr>
            	<tr>
            		<td colspan="5" style="text-align: center;"><?php echo $branch['hotline1'] .' - '.$branch['hotline2']; ?></td>
            	</tr>
            </tfoot>
        </table>
    </div>  
</div>
</page>
