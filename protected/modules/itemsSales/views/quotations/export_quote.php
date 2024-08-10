<style>
    p,
    a,
    td,
    div {
        word-wrap: break-word;
        font-size: 12pt;
    }

    .ivDt {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10pt;
    }

    .ivDt thead tr {
        background: #8FAAB1;
    }

    .ivDt thead th,
    .ivDt tbody td {
        padding: 5pt auto;
        text-align: center;
        color: #fff;
        border: 1px solid #ccc;
    }

    .ivDt tbody td {
        color: #000;
    }

    .num {
        padding-right: 5pt;
        text-align: right;
    }

    .ivS {
        background: #f8f0e4;
    }

    .ivF td {
        text-align: center;
    }

    .qP1 {
        width: 22%;
    }

    .qP2 {
        width: 31%;
    }

    .qP3 {
        width: 10%;
    }

    .qP4 {
        width: 15%;
    }

    .qP5 {
        width: 5%;
    }

    .qP6 {
        width: 17%;
    }
</style>

<page style="font: arial; font-family:freeserif; width: 100%;">
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 20%;">
                    <?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width' => 150)); ?>
                </td>

                <td style="width: 79%; padding-top: 12pt; text-align: center;">
                    <strong style="font-size: 20pt;"><?php echo Yii::t('sale_translate', 'quote.title'); ?></strong>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 10pt;">
        <tbody>
            <tr>
                <td style="width: 69%;">
                    <table class="tLeft" style="width: 90%;">
                        <tbody>
                            <tr>
                                <td><?php echo Yii::t('sale_translate', 'receipt.customer'); ?>:</td>
                                <td><?php echo $quotation['customer_name']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('sale_translate', 'receipt.dob'); ?>:</td>
                                <td>
                                    <?php if (strtotime($cus['birthdate'])) : ?>
                                        <?php echo date_format(date_create($cus['birthdate']), 'd/m/Y'); ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('sale_translate', 'receipt.address'); ?>:</td>
                                <td style="width: 65%;"><?php echo $cus['address']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 30%;">
                    <table class="tLeft">
                        <tbody>
                            <tr>
                                <td><?php echo Yii::t('sale_translate', 'receipt.date'); ?>:</td>
                                <td><?php echo date_format(date_create($quotation['create_date']), 'd/m/Y'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('sale_translate', 'quote.code'); ?>:</td>
                                <td><?php echo $quotation['code']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="ivDt">
        <thead>
            <tr>
                <th class="qP1"><strong><?php echo Yii::t('sale_translate', 'receipt.user'); ?></strong></th>
                <th class="qP2"><strong><?php echo Yii::t('sale_translate', 'receipt.service'); ?></strong></th>
                <th class="qP3"><strong><?php echo Yii::t('sale_translate', 'teethNumber'); ?></strong></th>
                <th class="qP4"><strong><?php echo Yii::t('sale_translate', 'receipt.unit_price'); ?></strong></th>
                <th class="qP5"><strong><?php echo Yii::t('sale_translate', 'tax'); ?></strong></th>
                <th class="qP6"><strong><?php echo Yii::t('sale_translate', 'receipt.total'); ?></strong></th>
            </tr>
        </thead>

        <tbody>
            <?php if ($quoteDetail) : ?>
                <?php foreach ($quoteDetail as $key => $value) : ?>
                    <tr>
                        <td class="qP1"><?php echo $value['user_name']; ?></td>
                        <td class="qP2"><?php echo ($value['name_'.$lang]) ? $value['name_'.$lang] : $value['name_vi']; ?></td>
                        <td class="qP3"><?php echo str_replace(',', ' ', $value['teeth']); ?></td>
                        <td class="num qP4"><?php echo number_format($value['unit_price'], 0, '', '.'); ?></td>
                        <td class="qP5"><?php echo number_format($value['tax'], 0, '', '.'); ?></td>
                        <td class="num qP6"><?php echo number_format($value['amount'], 0, '', '.'); ?> <?php echo ($value['flag_price'] == 2) ? 'USD' : 'VND'; ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>

            <tr>
                <td class="ivS" colspan="4" style="text-align: right; padding-right: 10pt;"><?php echo Yii::t('sale_translate', 'includeTax'); ?></td>
                <td class="num" colspan="2"><?php echo number_format($quotation['sum_tax'], 0, '', '.'); ?></td>
            </tr>

            <tr>
                <td class="ivS" colspan="4" rowspan="2" style="text-align: right; padding-right: 10pt;"><?php echo Yii::t('sale_translate', 'sumAmount'); ?></td>
                <td class="num" colspan="2">
                    <?php echo number_format($quotation['sum_amount'], 0, '', '.'); ?> VND
                </td>
            </tr>

            <tr>
                <td class="num" colspan="2">
                    <?php echo number_format($quotation['sum_amount_usd'], 0, '', '.'); ?> USD
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 8pt;">
        <tbody>
            <tr>
                <td><?php echo Yii::t('sale_translate', 'note'); ?>:</td>
                <td><?php echo $quotation['note']; ?></td>
            </tr>

            <tr>
                <td colspan="2" style="padding-top: 8pt; padding-bottom: 50pt;"><?php echo Yii::t('sale_translate', 'customerSign'); ?>:</td>
            </tr>
        </tbody>
    </table>

    <div style="width: 100%; text-align: center;"><?php echo Yii::t('sale_translate', 'receipt.thanks'); ?></div>
    <div style="width: 100%; text-align: center;"><?php echo $branch['address']; ?></div>
    <div style="width: 100%; text-align: center;"><?php echo $branch['hotline1'] . ' - ' . $branch['hotline2']; ?></div>
</page>