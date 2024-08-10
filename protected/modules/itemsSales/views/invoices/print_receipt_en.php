
<style>
    p, a, td {
    	word-wrap: break-word;
        font-size: 15pt;
    }

    .ivDt {
    	width: 100%;
        font-size: 11pt;
    }

    .ivDt thead th{
    	padding: 2px auto;
    	text-align: center;
        vertical-align: middle;
    	border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        font-size: 9pt;
    }

    .ivDt tbody td{
        font-size: 9pt;
        padding: 2px auto;
        text-align: center;
        vertical-align: middle;
    }
    .ivS td {
        border-top: 1px solid #ccc;
    }
    .num {
    	text-align: right;
    }
    .ivF td {
    	text-align: center;
        font-size: 9pt;
    }
</style>

<page style="font: arial;font-family:freeserif ;">

<div style="padding-left: 1pt; padding-right: 1pt;">
    <!-- header -->
	<div style="width: 100%">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="padding-right: 20pt;">
                   		<?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width'=>100)); ?>
                    </td>
                    <td style="padding-top: 7pt;">
                        <strong style="font-size: 14pt;">RECEIPT</strong><br>
                        <span style="font-size: 8pt;">#: 
                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                <?php echo $rpt["code"]; ?> 
                            <?php else: ?>
                                <?php echo $invoice["code"]; ?>
                            <?php endif ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end table-->
	
	<!-- info customer -->
    <div style="margin-top: 10pt; width: 100%;">
        <div style="padding-top:3pt;"><b>Date:</b> 
            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                <?php echo date_format(date_create($rpt['pay_date']),'H:m d/m/Y'); ?> 
            <?php else: ?>
                <?php echo date_format(date_create($rpt['create_date']),'H:m d/m/Y'); ?>
            <?php endif ?>
        </div>
        <div style="padding-top:3pt;"><b>Author:</b> 
            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                <?php echo $rpt["author_name"]; ?> 
            <?php else: ?>
                <?php echo $invoice['author_name']; ?>
            <?php endif ?>
        </div>
        <div style="padding-top:3pt;"><b>Patient's #:</b> <?php echo $cus['code_number']; ?></div>
        <div style="padding-top:3pt;"><b>Fullname:</b> <?php echo $invoice['customer_name']; ?></div>
        <div style="padding-top:3pt;"><b>Dob:</b>
            <?php if (strtotime($cus['birthdate'])): ?>
                <?php echo $cus['birthdate']; ?>
            <?php endif ?>
        </div>
        <!-- <div style="padding-top:3pt;"><b>Address:</b> <?php //echo $cus['address']; ?></div> -->
    </div> 

    <!-- table services -->
    <div style="margin-top: 10pt; width: 100%; text-align: right; font-size: 8pt;">Unit: 1.000 VNĐ</div>
    <div style="margin-top: 2pt; width: 100%;">
        <table class="ivDt">
            <thead>
                <tr>
                    <th style="width: 10%;"><strong>#</strong></th>
                    <th style="width: 50%;"><strong>Service(s)</strong></th>
                    <th style="width: 10%;"><strong>Qty</strong></th>
                    <th style="width: 15%;"><strong>U.Price</strong></th>
                    <th style="width: 15%;"><strong>Total</strong></th>
            	</tr>
            </thead>

            <tbody>
                <?php if ($ivDetail): ?>
            		<?php foreach ($ivDetail as $key => $value): ?>
            		<tr>
                        <td style="width: 10%;"><?php echo $key + 1; ?></td>
                        <td style="width: 50%;">
                            <?php echo $value['services_name_en'] ? $value['services_name_en'] : $value['description']; ?>
                        	<?php if ($value['id_service']): ?>
                        		<?php echo $value['services_name_en'] ? $value['services_name_en'] : $value['description']; ?>
                        	<?php else: ?>
                        		<?php echo $value['description']; ?>
                        	<?php endif ?>
                        </td>
                        <td style="width: 10%;"><?php echo $value['qty']; ?></td>
                        <td class="num" style="width: 15%;"><?php echo number_format($value['unit_price']/1000,0,'','.'); ?></td>
                        <td class="num" style="width: 15%;"><?php echo number_format($value['amount']/1000,0,'','.'); ?></td>
                	</tr>
            		<?php endforeach ?>
                <?php endif ?>

                	<tr class="ivS">
                        <td class="num" colspan="3">Grand Total</td>
                        <td></td>
                        <td class="num"><?php echo number_format($invoice['sum_amount']/1000,0,'','.'); ?></td>
                	</tr>
                	<!-- <tr>
                        <td class="ivS num" colspan="3">ƯU ĐÃI %</td>
                        <td></td>
                        <td class="num">
                            <?php //if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                <?php //echo number_format($rpt['pay_promotion']/1000,0,'','.'); ?>
                            <?php //endif ?>
                        </td>
                	</tr>
                    <tr>
                        <td class="ivS num" colspan="3">BẢO HIỂM</td>
                        <td></td>
                        <td class="num">
                            <?php //if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                <?php //if ($rpt['pay_type'] == 3 && $rpt['trans_name'] != '0') {
                                    //echo number_format($rpt['pay_sum']/1000,0,'','.');
                                //} else {echo 0;} ?>
                            <?php //endif ?>
                        </td>
                    </tr> -->
                    <tr>
                        <td class="num" colspan="3">Pay</td>
                        <td></td>
                        <td class="num">
                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                <?php if ($rpt['pay_type'] == 3 && $rpt['trans_name'] != '0') {
                                    echo 0;
                                } else {
                                    echo number_format($rpt['pay_sum']/1000,0,'','.');
                                } ?>
                            <?php else: ?>
                                <?php if ($invoice['balance'] > 0): ?>
                                    <?php echo number_format(($invoice['sum_amount'] - $invoice['balance'])/1000,0,'','.'); ?>
                                <?php else: ?>
                                    <?php echo number_format($invoice['sum_amount']/1000,0,'','.'); ?>
                                <?php endif ?>
                            <?php endif ?>
                         </td>
                    </tr>
                	<tr>
                        <td class="num" colspan="3">Paid</td>
                        <td></td>
                        <td class="num">
                            <?php if ($invoice['balance'] > 0): ?>
                                <?php echo number_format(($invoice['sum_amount'] - $invoice['balance'])/1000,0,'','.'); ?>
                            <?php else: ?>
                                <?php echo number_format($invoice['sum_amount']/1000,0,'','.'); ?>
                            <?php endif ?>
                         </td>
                	</tr>
                	<tr>
                        <td class="num" colspan="3">Remaining</td>
                        <td></td>
                        <td class="num">
                            <?php echo number_format($invoice['balance']/1000,0,'','.'); ?>
                        </td>
                	</tr>
            </tbody>

            <tfoot class="ivF">
                <tr>
                    <td colspan="5" style="padding-top: 10pt;">Thank you for your business!</td>
                </tr>
                <tr>
                    <td colspan="5"><?php echo $branch['address']; ?></td>
                </tr>
                <tr>
                    <td colspan="5"><?php echo $branch['hotline1'] .' - '.$branch['hotline2']; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>  
</div>
</page>