
<style>
    p, a, td, div {word-wrap: break-word; font-size: 11pt;}

    .content div {margin-top: 9pt;}
</style>

<?php $typeInfo = in_array($deposit['type'], DepositTransaction::$_typeIncrease) ? 'depositIncrease' : (in_array($deposit['type'], DepositTransaction::$_typeDescrease) ? 'depositDecrease' : '');?>

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
                    <strong style="font-size: 12pt;"><?php echo Yii::t('accountingLang', "$typeInfo.title"); ?></strong>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="width: 90%; margin: auto; margin-top: 13pt;" class="content">
        <div><b><?php echo Yii::t('accountingLang', 'date'); ?></b>: <?php echo date_format(date_create($deposit['create_date']),'d/m/Y'); ?></div>
        <div><?php echo Yii::t('accountingLang', $typeInfo.'.content'); ?></div>
        <div style="text-align: center;"><b><?php echo $customer['fullname']; ?></b></div>
    </div>

    <table style="width: 80%; margin: auto; margin-top: 10pt;">
        <tbody>
            <tr>
                <td style="width: 70%;"><?php echo Yii::t('accountingLang', 'deposit.amount'); ?></td>
                <td style="width: 30%; text-align: right"><b><?php echo number_format($deposit['amount'], 0, '', '.'); ?></b> VND</td>
            </tr>

            <tr>
                <td></td>
                <td style="text-align: center; padding-top: 15pt;"><?php echo Yii::t('accountingLang', $typeInfo.'.user'); ?></td>
            </tr>

            <tr>
                <td></td>
                <td style="text-align: center; padding-top: 50pt;"><b>
                    <?php if ($typeInfo == 'depositIncrease'): ?>
                        <?php echo $author['name']; ?>
                    <?php else : ?>
                        <?php echo $customer['fullname']; ?>
                    <?php endif; ?>
                </b></td>
            </tr>
        </tbody>
    </table>

    <div style="width: 90%; margin: auto; margin-top: 10pt;" class="content">
        <div style="text-align: center;"><?php echo Yii::t('accountingLang', 'deposit.thanks'); ?><</div>
    </div>
</page>