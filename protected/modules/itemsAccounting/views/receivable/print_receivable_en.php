
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
        font-size: 8pt;
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
                        <strong style="font-size: 14pt;">Receivable</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end table-->
    
    <!-- info customer -->
    <div style="margin-top: 10pt; width: 100%;">
        <div style="padding-top:3pt;"><b>Date:</b> 
            <?php echo date_format(date_create($receivable['received_date']),'d/m/Y'); ?>
        </div>
        <div style="padding-top:3pt;"><b>Invoice number:</b> <?php echo $receivable['order_number']; ?></div>
        <div style="padding-top:3pt;"><b>User:</b> <?php echo $receivable['user_name']; ?></div>
        <div style="padding-top:3pt;"><b>Fullname:</b> <?php echo $receivable['name']; ?></div>
        <div style="padding-top:3pt;"><b>Address:</b> <?php echo $receivable['address']; ?></div>
    </div> 

    <?php $sv = explode(". ", $receivable['description']); ?>
    <!-- table services -->
    <div style="margin-top: 10pt; width: 100%; text-align: right; font-size: 8pt;">Unit: 1.000 VNĐ</div>
    <div style="margin-top: 2pt; width: 100%;">
        <table class="ivDt">
            <thead>
                <tr>
                    <th style="width: 10%;"><strong>#</strong></th>
                    <th style="width: 50%;"><strong>Service(s)</strong></th>
                    <th style="width: 25%;"><strong>Dentist</strong></th>
                    <th style="width: 15%;"><strong>Amount</strong></th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($sv)>1): ?>
                    <?php foreach ($sv as $key => $value): ?>
                        <?php $svItem = explode(" - ", $value); ?>
                        <?php if (count($svItem) > 1): ?>
                            <tr>
                                <td style="width: 10%;"><?php echo $key; ?></td>
                                <td style="width: 50%;"><?php echo $svItem[1]; ?></td>
                                <td style="width: 25%;"><?php echo $svItem[2]; ?></td>
                                <td class="num" style="width: 15%;">
                                    <?php $amount = (isset($svItem[4])) ? $svItem[4] : 0; ?>
                                    <?php //if (isset($svItem[3])): ?>
                                        <?php echo number_format($amount/1000,0,'','.'); ?>
                                    <?php //endif ?>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
                    <tr class="ivS">
                        <td class="num" colspan="3"><b>Sum Refund</b></td>
                        <td class="num"><?php echo number_format($receivable['amount']/1000,0,'','.'); ?></td>
                    </tr>
            </tbody>

            <tfoot class="ivF">
                <tr>
                    <td colspan="4" style="padding-top: 10pt;">Thank you for your business!</td>
                </tr>
                <!-- <tr>
                    <td colspan="5"><?php //echo //$branch['address']; ?></td>
                </tr>
                <tr>
                    <td colspan="5"><?php //echo //$branch['hotline1'] .' - '.$branch['hotline2']; ?></td>
                </tr> -->
            </tfoot>
        </table>
    </div>  
</div>
</page>