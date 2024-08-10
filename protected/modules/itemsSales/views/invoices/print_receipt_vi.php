<style>
    p,
    a,
    td {
        word-wrap: break-word;
        font-size: 11pt;
    }

    .ivDt {
        width: 100%;
        font-size: 11pt;
    }

    .ivDt thead th {
        padding: 2px auto;
        text-align: center;
        vertical-align: middle;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        font-size: 11pt;
    }

    .ivDt tbody td {
        font-size: 11pt;
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
        font-size: 11pt;
    }
</style>

<page style="font: arial;font-family: freeserif ;">
    <?php $receiptLength = count($allReceipt); ?>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="padding-right: 110pt;">
                    <?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width' => 100)); ?>
                </td>

                <td style="padding-top: 3pt;">
                    <strong style="font-size: 16pt;"><?php echo Yii::t('sale_translate', 'receipt.title'); ?></strong><br>
                    <span style="font-size: 8pt;">#: <?php echo $invoice["code"]; ?></span>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 10pt;">
        <tr>
            <td style="width: 60%;">
                <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.code_number'); ?>:</b> <?php echo $cus['code_number']; ?></div>
                <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.customer'); ?>:</b> <?php echo $cus['fullname']; ?></div>
            </td>

            <td style="width: 38%;">
                <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.date'); ?>:</b>
                    <?php echo date_format(date_create('now'), 'd/m/Y'); ?>
                </div>
            </td>
        </tr>
    </table>

    <div style="width: 100%; text-align: right;"><?php echo Yii::t('sale_translate', 'receipt.unit'); ?>: VND</div>
    <table class="ivDt" style="margin-top: 2pt;">
        <thead>
            <tr>
                <th style="width: 5%;"><strong>#</strong></th>
                <th style="width: 40%;"><strong><?php echo Yii::t('sale_translate', 'receipt.service'); ?></strong></th>
                <th style="width: 8%;"><strong><?php echo Yii::t('sale_translate', 'receipt.qty'); ?></strong></th>
                <th style="width: 16%;"><strong><?php echo Yii::t('sale_translate', 'receipt.unit_price'); ?></strong></th>
                <th style="width: 15%;"><strong><?php echo Yii::t('sale_translate', 'receipt.promotion'); ?> (%)</strong></th>
                <th style="width: 16%;"><strong><?php echo Yii::t('sale_translate', 'receipt.total'); ?></strong></th>
            </tr>
        </thead>

        <tbody>
            <?php if ($ivDetail) : ?>
                <?php foreach ($ivDetail as $key => $value) : ?>
                    <tr>
                        <td style="width: 5%;"><?php echo $key + 1; ?></td>
                        <td style="width: 40%;">
                            <?php if ($value['id_service']) : ?>
                                <?php 
                                    if($lang == 'en'){
                                        echo $value['services_name_en']; 
                                    }else{
                                        echo $value['services_name']; 
                                    }
                                ?>
                            <?php else : ?>
                                <?php echo $value['description']; ?>
                            <?php endif ?>
                        </td>
                        <td style="width: 8%;"><?php echo $value['qty']; ?></td>
                        <td class="num" style="width: 16%;"><?php echo number_format($value['unit_price'], 0, '', '.'); ?></td>
                        <td><?php echo number_format($value['percent_decrease'], 0, '', '.'); ?></td>
                        <td class="num" style="width: 16%;"><?php echo number_format($value['amount'], 0, '', '.'); ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>

            <tr class="ivS">
                <td class="num" colspan="4"><?php echo Yii::t('sale_translate', 'receipt.sum_pay_treatment'); ?></td>
                <td></td>
                <td class="num"><?php echo number_format($invoice['sum_amount'], 0, '', '.'); ?></td>
            </tr>

            <tr>
                <td class="num" colspan="4"><?php echo Yii::t('sale_translate', 'receipt.sum_insurance'); ?></td>
                <td></td>
                <td class="num"><?php echo number_format($invoice['sum_insurance'], 0, '', '.'); ?></td>
            </tr>

            <tr>
                <td class="num" colspan="4"> 
                    <?php echo Yii::t('sale_translate', 'receipt.sum_pay'); ?>
                </td>
                <td></td>

                <td class="num">
                    <?php if ($idRpt) : ?>
                        <?php if ($rpt['pay_insurance']) : ?>
                            <?php echo number_format($rpt['pay_insurance'], 0, '', '.'); ?>
                        <?php else : ?>
                            <?php echo number_format($rpt['pay_amount'], 0, '', '.'); ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if ($invoice['balance'] < $invoice['sum_amount']) : ?>
                            <?php if ($receiptLength > 0) : ?>
                                <?php echo number_format($allReceipt[$receiptLength - 1]['pay_amount'], 0, '', '.'); ?>
                            <?php endif; ?>
                        <?php else : ?>
                            0
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>


            <tr>
                <td class="num" colspan="4"><?php echo Yii::t('sale_translate', 'receipt.balance'); ?></td>
                <td></td>
                <td class="num">
                    <?php echo number_format($invoice['balance'], 0, '', '.'); ?>
                </td>
            </tr>
        </tbody>

        <!-- Lich hen tai kham -->
        <tbody>
            <tr>
                <td colspan="6" style="text-align: left;"><u><?php echo Yii::t('sale_translate', 'receipt.schedule'); ?>:</u></td>
            </tr>

            <tr>
                <td colspan="6" style="text-align: left;">
                    <?php foreach ($schedule as $key => $value) : ?>
                        <div> <?php echo $value; ?></div>
                    <?php endforeach ?>
                </td>
            </tr>
        </tbody>

        <!-- Tien coc -->
        <tbody>
            <tr>
                <td colspan="6" style="text-align: left;">
                    <b><?php echo Yii::t('sale_translate', 'receipt.deposit'); ?>:</b> <?php echo number_format($cus['deposit'], 0, '', '.'); ?> VND
                </td>
            </tr>
        </tbody>

        <!-- Lich su thanh toan -->
        <tbody>
            <tr>
                <td colspan="6" style="text-align: left;"><u><?php echo Yii::t('sale_translate', 'receipt.payment_history'); ?>:</u></td>
            </tr>

            <tr>
                <td colspan="6" style="text-align: left;">
                    <?php foreach ($allReceipt as $key => $value) : ?>
                        <?php $type = 'invoice_type_' . $lang; ?>
                        <div>
                            <?php echo date_format(date_create($value['pay_date']), 'H:i d/m/y'); ?> |
                            <?php echo number_format($value['pay_amount'], 0, '', '.'); ?> VND |

                            <?php if ($lang == 'vi') : ?>
                                <?php echo Invoice::$invoice_type_vi[$value['pay_type']]; ?>
                            <?php else : ?>
                                <?php echo Invoice::$invoice_type_en[$value['pay_type']]; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach ?>
                </td>
            </tr>
        </tbody>

        <tbody class="ivF">
            <tr>
                <td colspan="6" style="padding-top: 10pt;"><?php echo Yii::t('sale_translate', 'receipt.thanks'); ?></td>
            </tr>
            <tr>
                <td colspan="6"><?php echo $branch['address']; ?></td>
            </tr>
            <tr>
                <td colspan="6"><?php echo $branch['hotline1'] . ' - ' . $branch['hotline2']; ?></td>
            </tr>
        </tbody>
    </table>
</page>