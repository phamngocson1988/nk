<?php

$total = 0;

$amount_reduced = 0;

$sum_amount = 0;

foreach ($listPricebookService as $key => $value) {

    $amount = ($value['price'] - $value['price'] * $value['tax'] / 100) * $value['length'];

    $total += $value['price'] * $value['length'];

    $amount_reduced += $value['price'] * $value['tax'] / 100 * $value['length'];

    $sum_amount += $amount;

    ?>

    <tr class="tick">

        <td><input name="id_invoice_detail[]" type="hidden" value="<?php echo $value['id']; ?>"></td>

        <td><input name="id_service[]" type="hidden" value="<?php echo $value['id_service']; ?>"></td>

        <td><input readonly type="text" class="form-control text" value="<?php echo $value['name']; ?>"></td>

        <td><input name="unit_price[]" readonly type="text" class="form-control autoNum text" value="<?php echo $value['price']; ?>"></td>

        <td><input name="percent_decrease[]" placeholder="Giảm %" min="0" max="100" class="form-control" type="number" value="<?php echo $value['tax']; ?>" onchange="changePercentDecrease();"></td>

        <td><input name="qty[]" readonly type="text" class="form-control text" value="<?php echo $value['length']; ?>"></td>

        <td><input name="amount[]" readonly type="text" class="form-control autoNum text" value="<?php echo $amount; ?>"></td>

    </tr>

<?php

}

?>

<tr>

    <td colspan="5"></td>

    <td style="vertical-align: middle;">Tổng cộng</td>

    <td><input name="total" readonly type="text" class="form-control autoNum text" value="<?php echo $total; ?>"></td>

</tr>

<tr>

    <td colspan="5"></td>

    <td style="vertical-align: middle;">Giảm giá</td>

    <td><input name="amount_reduced" class="form-control autoNum text" type="text" value="<?php echo $amount_reduced; ?>"></td>

</tr>

<tr>

    <td colspan="5"></td>

    <td style="vertical-align: middle;">Phải thu</td>

    <td><input name="sum_amount" readonly type="text" class="form-control autoNum text" value="<?php echo $sum_amount; ?>"></td>

</tr>

<script type="text/javascript">
    $(function() {
        var numberOptions = {
            aSep: '.',
            aDec: ',',
            mDec: 3,
            aPad: false
        };
        $('.autoNum').autoNumeric('init', numberOptions);
    });
</script>