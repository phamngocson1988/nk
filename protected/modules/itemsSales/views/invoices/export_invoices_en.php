
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
                    <td style="color: #222; padding-right: 120pt">
                        <?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width'=>200)); ?>
                    </td>

                    <td style="color: #222; padding-top: 25pt;">
                        <strong style="font-size: 25pt;">RECEIPT</strong>
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
                                        <td>Fullname:</td>
                                        <td><?php echo $invoice['customer_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dob:</td>
                                        <td>
                                        <?php if (strtotime($cus['birthdate'])): ?>
                                            <?php echo $cus['birthdate']; ?>
                                        <?php endif ?>
                                        </td>
                                    </tr>
                                  </tbody>
                            </table>
                        </td>
                        <td style="width: 70mm;">
                            <table class="tLeft">
                                <tbody>
                                    <tr>
                                        <td>Date:</td>
                                        <td>
                                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                                <?php echo $rpt['pay_date']; ?> 
                                            <?php else: ?>      
                                                <?php echo $invoice['create_date']; ?>
                                            <?php endif ?>    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Patient's #:</td>
                                        <td><?php echo $cus['code_number']; ?></td>
                                    </tr>
                                  </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Address: <span style="margin-left: 30mm;"><?php echo $cus['address']; ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Payment method:
                        <span style="margin-left: 10mm;">
                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                                <?php echo $this->invoice_type_en[$rpt['pay_type']]; ?>
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

    <div style="margin-top: 10pt;" >
        <table class="ivDt">
            <thead>
                <tr>
                    <th style="width: 10%;"><strong>#</strong></th>
                    <th style="width: 46%;"><strong>Service(s)</strong></th>
                    <th style="width: 15%;"><strong>Unit Price</strong></th>
                    <th style="width: 10%;"><strong>Quanity</strong></th>
                    <th style="width: 15%;"><strong>Total</strong></th>
                </tr>
            </thead>
            <tbody>
            <?php if ($ivDetail): ?>
                <?php foreach ($ivDetail as $key => $value): ?>
                <tr>
                    <td style="width: 10%;"><?php echo $key + 1; ?></td>
                    <td style="width: 46%;">
                    	<?php if ($value['id_service']): ?>
                    		<?php echo $value['services_name_en'] ? $value['services_name_en'] : $value['description']; ?>
                    	<?php else: ?>
                    		<?php echo $value['description']; ?>
                    	<?php endif ?>
                    </td>
                    <td class="num" style="width: 15%;"><?php echo number_format($value['unit_price'],0,'','.'); ?></td>
                    <td style="width: 10%;"><?php echo $value['qty']; ?></td>
                    <td class="num" style="width: 15%;;"><?php echo number_format($value['amount'],0,'','.'); ?></td>
                </tr>
                <?php endforeach ?>
            <?php endif ?>
                <tr>
                    <td class="ivS" colspan="3">GRAND TOTAL</td>
                    <td></td>
                    <td class="num"><?php echo number_format($invoice['sum_amount'],0,'','.'); ?></td>
                </tr>
                <tr>
                    <td class="ivS" colspan="3">DISCOUNT %</td>
                    <td></td>
                    <td class="num">
                        <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                            <?php echo number_format($rpt['pay_promotion'],0,'','.'); ?>
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <td class="ivS" colspan="3">INSURRANCE</td>
                    <td></td>
                    <td class="num">
                        <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])): ?>
                            <?php if ($rpt['pay_type'] == 3 && $rpt['trans_name'] != '0') {
                                echo number_format($rpt['pay_sum'],0,'','.');
                            } else {echo 0;} ?>
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <td class="ivS" colspan="3">PAY</td>
                    <td></td>
                    <td class="num">
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
                    <td class="ivS" colspan="3">PAID</td>
                    <td></td>
                    <td class="num">
                        <?php if ($invoice['balance'] > 0): ?>
                            <?php echo number_format($invoice['sum_amount'] - $invoice['balance'],0,'','.'); ?>
                        <?php else: ?>
                            <?php echo number_format($invoice['sum_amount'],0,'','.'); ?>
                        <?php endif ?>
                     </td>
                </tr>
                <tr>
                    <td class="ivS" colspan="3">REMAINING</td>
                    <td></td>
                    <td class="num">
                        <?php echo number_format($invoice['balance'],0,'','.'); ?>
                    </td>
                </tr>
            </tbody>
            <tfoot class="ivF">
            
                <?php if (count($rpt) != 0 && !isset($rpt['id_invoice']) ): ?>
                    <tr>
                        <td style="text-align: left;" colspan="5" style="padding-top: 20pt;">Payment History</td>    
                    </tr>
                    <?php foreach ($rpt as $k => $pay): 
                        $trans = ($pay['pay_type'] == 3 && $pay['trans_name'] != '0') ? $pay['trans_name'] : '';
                    ?>
                        <tr>
                            <td style="text-align: left;" colspan="5">
                            <?php echo date_format(date_create($pay['pay_date']),'H:m d/m/y'); ?> | <?php echo number_format($pay['pay_amount'],0,'','.'); ?> VNĐ + <?php echo number_format($pay['pay_promotion'],0,'','.'); ?> VNĐ | <?php echo $this->invoice_type_en[$pay['pay_type']]." ".$trans; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
                <tr>
                    <td colspan="5" style="padding-top: 20pt;">Thank you for your business!</td>
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
