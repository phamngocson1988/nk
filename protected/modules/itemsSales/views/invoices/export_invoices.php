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

    <div>
        <!-- header -->
        <div style="width: 100%">
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="padding-right: 110pt;">
                            <?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width' => 100)); ?>
                        </td>
                        <td style="padding-top: 3pt;">
                            <strong style="font-size: 16pt;"><?php echo Yii::t('sale_translate', 'receipt.title'); ?></strong><br>
                            <span style="font-size: 8pt;">#:
                                <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])) : ?>
                                    <?php echo $rpt["code"]; ?>
                                <?php else : ?>
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
            <table style="width: 100%">
                <tr>
                    <td style="width: 60%;">
                        <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.code_number'); ?>:</b> <?php echo $cus['code_number']; ?></div>
                        <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.customer'); ?>:</b> <?php echo $invoice['customer_name']; ?></div>
                        <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.dob') ?>:</b>
                            <?php if (strtotime($cus['birthdate'])) : ?>
                                <?php echo date_format(date_create($cus['birthdate']), 'd/m/Y'); ?>
                            <?php endif ?>
                        </div>
                        <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.address') ?>:</b> <?php echo $cus['address']; ?></div>
                    </td>
                    <td style="width: 38%;">
                        <div style="padding-top:5pt;"><b><?php echo Yii::t('sale_translate', 'receipt.date'); ?>:</b>
                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])) : ?>
                                <?php echo date_format(date_create($rpt['pay_date']), 'H:m d/m/Y'); ?>
                            <?php else : ?>
                                <?php echo date_format(date_create($invoice['create_date']), 'H:m d/m/Y'); ?>
                            <?php endif ?>
                        </div>
                        <div style="padding-top:3pt;"><b><?php echo Yii::t('sale_translate', 'receipt.user') ?>:</b>
                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])) : ?>
                                <?php echo $rpt["author_name"]; ?>
                            <?php else : ?>
                                <?php echo $invoice['author_name']; ?>
                            <?php endif ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- table services -->

        <div style="margin-top: 2pt; width: 100%;">
            <table class="ivDt">
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
                                        <?php if ($lang == 'en') : ?>
                                            <?php echo $value['services_name_en']; ?>
                                        <?php else : ?>
                                            <?php echo $value['services_name']; ?>
                                        <?php endif ?>
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
                        <td class="num" colspan="4"><?php echo Yii::t('sale_translate', 'receipt.sum_pay'); ?></td>
                        <td></td>
                        <td class="num">
                            <?php if (count($rpt) == 1 && isset($rpt['id_invoice'])) : ?>
                                <?php if ($rpt['pay_type'] == 3 && $rpt['trans_name'] != '0') {
                                    echo 0;
                                } else {
                                    echo number_format($rpt['pay_sum'], 0, '', '.');
                                } ?>
                            <?php else : ?>
                                <?php if ($invoice['balance'] > 0) : ?>
                                    <?php echo number_format(($invoice['sum_amount'] - $invoice['balance']), 0, '', '.'); ?>
                                <?php else : ?>
                                    <?php echo number_format($invoice['sum_amount'], 0, '', '.'); ?>
                                <?php endif ?>
                            <?php endif ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="num" colspan="4"><?php echo Yii::t('sale_translate', 'receipt.sum_payed'); ?></td>
                        <td></td>
                        <td class="num">
                            <?php if ($invoice['balance'] > 0) : ?>
                                <?php echo number_format(($invoice['sum_amount'] - $invoice['balance']), 0, '', '.'); ?>
                            <?php else : ?>
                                <?php echo number_format($invoice['sum_amount'], 0, '', '.'); ?>
                            <?php endif ?>
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

                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: left;"><?php echo Yii::t('sale_translate', 'receipt.schedule'); ?>:</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: left;">
                            <?php foreach ($schedule as $key => $value) : ?>
                                <div> <?php echo $value; ?></div>
                            <?php endforeach ?>
                        </td>
                    </tr>
                </tbody>

                <tfoot class="ivF">
                    <tr>
                        <td colspan="6" style="padding-top: 10pt;"><?php echo Yii::t('sale_translate', 'receipt.thanks'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"><?php echo $branch['address']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"><?php echo $branch['hotline1'] . ' - ' . $branch['hotline2']; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</page>