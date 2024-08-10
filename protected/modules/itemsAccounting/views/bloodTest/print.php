
<style>
    p, a, td, div {word-wrap: break-word; font-size: 11pt;}

    .content div {margin-top: 9pt;}
</style>

<?php $typeInfo = in_array($bloodTest['type'], BloodTest::$_receipt) ? 'BloodTestReceipt' : (in_array($bloodTest['type'], BloodTest::$_refund) ? 'BloodTestRefund' : '');?>

<?php if (!$typeInfo): ?>
    Thông tin không hợp lệ!
    <?php exit; ?>
<?php endif; ?>

<page style="font: arial; font-family:freeserif;">
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 30%;">
                    <?php echo CHtml::image('images/Logo NK 2000_color-01.png', 'NhaKhoa2000', array('width'=>100)); ?>
                </td>

                <td style="width: 69%; vertical-align: middle; text-align: center;">
                    <strong style="font-size: 12pt; text-transform: uppercase;"><?php echo Yii::t('accountingLang', "$typeInfo.title"); ?></strong> <br>
                    <strong style="font-size: 12pt; text-transform: uppercase; margin-top: 6pt;"><?php echo Yii::t('accountingLang', "bloodTest"); ?></strong>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="width: 90%; margin: auto; margin-top: 13pt;" class="content">
        <div><b><?php echo Yii::t('accountingLang', 'date'); ?></b>: <?php echo date_format(date_create($bloodTest['create_date']),'d/m/Y'); ?></div>
        <div><b><?php echo Yii::t('accountingLang', 'customer'); ?></b>: <?php echo $customer['fullname']; ?></div>
        <div><b><?php echo Yii::t('accountingLang', 'bloodTest.amount'); ?></b>: <?php echo number_format($bloodTest['amount'], 0, '', '.'); ?></div>
    </div>

    <table style="width: 100%; margin: auto; margin-top: 5pt;">
        <tbody>
            <tr>
                <td style="width: 65%"></td>
                <td style="width: 35%; text-align: center;"><?php echo Yii::t('accountingLang', $typeInfo.'.user'); ?></td>
            </tr>

            <tr>
                <td></td>
                <td style="text-align: center; padding-top: 50pt;"><b>
                    <?php if ($typeInfo == 'bloodTestIncrease'): ?>
                        <?php echo $author['name']; ?>
                    <?php else : ?>
                        <?php echo $customer['fullname']; ?>
                    <?php endif; ?>
                </b></td>
            </tr>
        </tbody>
    </table>

    <div style="width: 90%; margin: auto; margin-top: 10pt;" class="content">
        <div style="text-align: center;"><?php echo Yii::t('accountingLang', 'thanks'); ?><</div>
    </div>
</page>