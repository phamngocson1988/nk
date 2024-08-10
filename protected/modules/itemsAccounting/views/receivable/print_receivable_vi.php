
<style>
    p, a, td {word-wrap: break-word; font-size: 10pt;}

    .ivDt {font-size: 11pt;}

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
        font-size: 8pt;
    }

</style>

<page style="font: arial; font-family:freeserif;">
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 30%;">
                    <?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width'=>100)); ?>
                </td>
                <td style="width: 69%; vertical-align: middle; text-align: center;">
                    <strong style="font-size: 12pt;"><?php echo Yii::t('accountingLang', 'receipt.title'); ?></strong>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 5pt;">
        <tbody>
            <tr>
                <td style="width: 60%;">
                    <table>
                        <tbody>
                            <tr>
                                <td><?php echo Yii::t('accountingLang', 'customer'); ?>:</td>
                                <td><?php echo $receivable['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%"><?php echo Yii::t('accountingLang', 'address'); ?>:</td>
                                <td style="width: 69%;"><?php echo $receivable['address']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td style="width: 30%;">
                    <table>
                        <tbody>
                            <tr>
                                <td><?php echo Yii::t('accountingLang', 'date'); ?>:</td>
                                <td><?php echo date_format(date_create($receivable['received_date']),'d/m/Y'); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%"><?php echo Yii::t('accountingLang', 'invoiceCode'); ?>:</td>
                                <td style="width: 69%;"><?php echo $receivable['order_number']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%"><?php echo Yii::t('accountingLang', 'user'); ?>:</td>
                                <td style="width: 69%;"><?php echo $receivable['user_name']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <?php $sv = explode(". ", $receivable['description']); ?>

    <table style="width: 100%; margin-top: 7p" class="ivDt">
        <thead>
            <tr>
                <th style="width: 5%;"><strong>#</strong></th>
                <th style="width: 40%;"><strong><?php echo Yii::t('accountingLang', 'services'); ?></strong></th>
                <th style="width: 25%;"><strong><?php echo Yii::t('accountingLang', 'dentist'); ?></strong></th>
                <th style="width: 15%;"><strong><?php echo Yii::t('accountingLang', 'amount'); ?></strong></th>
                <th style="width: 15%;"><strong><?php echo Yii::t('accountingLang', 'refund'); ?></strong></th>
            </tr>
        </thead>

        <tbody>
            <?php if (count($sv)>1): ?>
                <?php foreach ($sv as $key => $value): ?>
                    <?php $svItem = explode(" - ", $value); ?>
                    <?php if (count($svItem) > 1): ?>
                        <tr>
                            <td style="width: 5%;"><?php echo $key; ?></td>
                            <td style="width: 40%;">
                                <?php echo $svItem[1]; ?>
                            </td>
                            <td style="width: 25%;"><?php echo $svItem[2]; ?></td>
                            <td class="num" style="width: 15%;">
                                <?php $amount = (isset($svItem[3])) ? $svItem[3] : 0; ?>
                                <?php echo number_format($amount, 0, '', '.'); ?>
                            </td>
                            <td class="num" style="width: 15%;">
                                <?php $amount = (isset($svItem[4])) ? $svItem[4] : 0; ?>
                                <?php echo number_format($amount, 0, '', '.'); ?>
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>

            <tr class="ivS">
                <td class="num" colspan="3"><b><?php echo Yii::t('accountingLang', 'sumRefund'); ?></b></td>
                <td class="num" colspan="2"><?php echo number_format($receivable['amount'], 0, '', '.'); ?></td>
            </tr>
        </tbody>
    </table>

    <div style="width: 100%; margin-top: 7pt; text-align: center;"><?php echo Yii::t('accountingLang', 'thanks'); ?></div>
</page>