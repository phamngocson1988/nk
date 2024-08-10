<div class="col-md-12 tableList" style="padding: 0;">
    <div class="text-right">Tổng cộng: <b class="customer-sum_deposit"><?php echo number_format($sum_deposit, 0, '', '.'); ?> VND</b></div>

    <table class="table table-condensed table-hover" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Ngày thực hiện</th>
                <th>Nguời thực hiện</th>
                <th>Mã hóa đơn</th>
                <th>Hình thức</th>
                <th>Deposit</th>
                <th>Ghi chú</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($deposit['count'] <= 0) : ?>
                <tr>
                    <td colspan="6">Không có dữ liệu!</td>
                </tr>
            <?php else : ?>
                <?php foreach ($deposit['data'] as $key => $value) : ?>
                    <tr>
                        <td><?php echo date_format(date_create($value['create_date']), 'H:i d/m/Y'); ?></td>
                        <td><?php echo (isset($value->user)) ? $value->user->name : ''; ?></td>
                        <td><?php echo $value['code_invoice']; ?></td>
                        <td><?php echo DepositTransaction::$_type[$value['type']]['name']; ?></td>
                        <td><?php echo number_format($value['amount'], 0, '', '.'); ?></td>
                        <td><?php echo $value['note']; ?></td>
                        <td>
                            <a href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsAccounting/deposit/printDeposit?id=<?php echo $value['id']; ?>&amp;idc=<?php echo $value['id_customer']; ?>&amp;lang=vi" target="_blank" title="" class="label label-success">In-vi</a>
                            <a href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsAccounting/deposit/printDeposit?id=<?php echo $value['id']; ?>&amp;idc=<?php echo $value['id_customer']; ?>&amp;lang=en" target="_blank" title="" class="label label-success">In-en</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="clear:both"></div>

<div class="row fix_bottom">
    <?php if ($page_list) echo $page_list; ?>
</div>

<script>
    var height = $(window).height();
    var menu = $('#headerMenu').outerHeight();
    var oSrchBar = $('#oSrchBar').outerHeight();

    $('.tableList>.table>tbody').css('max-height', height - menu - oSrchBar - 300 + 'px');
</script>