<div class="row">

    <div class="col-md-12 tableList">
        <table class="table table-condensed table-hover" id="oListT" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th class="w1">Mã báo giá</th>
                    <th class="w2">Khách hàng</th>
                    <th class="w3">Văn phòng</th>
                    <th class="w4">Người tạo</th>
                    <th class="w5">Ngày tạo báo giá</th>
                    <th class="w6">Ngày hết hạn</th>
                    <th class="w7">Tổng tiền</th>
                </tr>
            </thead>
            <tbody>

                <?php if ($quotationList == -1) : ?>
                    <tr>
                        <td colspan="8">Không có dữ liệu!</td>
                    </tr>
                <?php else : ?>

                    <?php foreach ($quotationList as $key => $v) :
                        $id = $v['id']; ?>

                        <tr data-toggle="collapse" data-target="#q<?php echo $key; ?>" class="accordion-toggle <?php if ($key % 2 != 0) echo "tr_col"; ?>">
                            <td class="w1"><?php echo $v['code']; ?></td>
                            <td class="w2"><?php echo $v['customer_name']; ?></td>
                            <td class="w3"><?php echo $v['branch_name']; ?></td>
                            <td class="w4"><?php echo $v['author_name']; ?></td>
                            <td class="w5"><?php echo date_format(date_create($v['create_date']), 'd/m/Y'); ?></td>
                            <td class="w6"><?php echo date_format(date_create($v['complete_date']), 'd/m/Y'); ?></td>
                            <td class="w7 autoNum text-right"><?php echo $v['sum_amount']; ?></td>
                        </tr>

                        <tr>
                            <input type="hidden" name="id_quotation" value="<?php echo $id; ?>">
                            <td colspan="7" class="hiddenRow">
                                <div class="accordian-body collapse oView col-md-12" id="q<?php echo $key; ?>">
                                    <div class="oViewDetail col-md-12">
                                        <div id="oInfo" class="col-md-12">
                                            <div class="col-md-6 text-left">
                                                <div class="row">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <th class="text-right">Văn phòng:</th>
                                                                <td class="text-left"><?php echo $v['branch_name']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-right">Mã báo giá: </th>
                                                                <td class="text-left"><?php echo $v['code']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-right">Khách hàng: </th>
                                                                <td class="text-left"><?php echo $v['customer_name']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <table class="pull-right">
                                                        <tbody>
                                                            <tr>
                                                                <th class="text-right">Ngày tạo báo giá: </th>
                                                                <td class="text-left"><?php echo $v['create_date']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-right">Ngày hết hạn: </th>
                                                                <td class="text-left"><?php echo $v['complete_date']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 oViewB">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tên dịch vụ</th>
                                                        <th>Trạng thái</th>
                                                        <th>Số răng</th>
                                                        <th>Số lượng</th>
                                                        <th>Đơn giá</th>
                                                        <th>Thuế</th>
                                                        <th>Tổng tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $quoteDetail = array_filter($quotationDetail, function ($v) use ($id) {
                                                        if ($v['id_quotation'] == $id)
                                                            return true;
                                                    });
                                                    ?>
                                                    <?php $order = 0;
                                                    foreach ($quoteDetail as $key => $value) :
                                                        $order = ($order == 1) ? $order : $value['status'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $value['description']; ?>
                                                            </td>
                                                            <td><?php echo ($value['status'] == 1) ? 'Điều trị' : 'Báo giá'; ?></td>
                                                            <td><?php echo $value['teeth']; ?></td>
                                                            <td><?php echo $value['qty']; ?></td>
                                                            <td class="autoNum text-right"><?php echo $value['unit_price']; ?></td>
                                                            <td class="autoNum text-right"><?php echo $value['tax']; ?></td>
                                                            <td class="text-right"><span class="autoNum"><?php echo $value['amount']; ?></span>
                                                                <?php if ($value["flag_price"] == 1) : ?> VND
                                                                <?php else : ?> USD
                                                                <?php endif ?>
                                                            </td>
                                                        </tr>

                                                    <?php endforeach ?>

                                                </tbody>
                                            </table>
                                            <div class="col-md-5 pull-right">
                                                <table class="table sum">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-right"><b>Bao gồm thuế</b></td>
                                                            <td class="text-right autoNum"><b><?php echo $v['sum_tax']; ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right"><b>Tổng cộng</b></td>
                                                            <td class="text-right"><b><span class="autoNum"><?php echo $v['sum_amount']; ?></b></span> VND</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right"><b></b></td>
                                                            <td class="text-right"><b><span class="autoNum"><?php echo $v['sum_amount_usd']; ?></b></span> USD</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div id="pBtn" class="text-left">
                                                <input type="hidden" class="cus_mail" value="<?php echo $v['email']; ?>">

                                                <?php
                                                $group_id =  Yii::app()->user->getState('group_id');
                                                if ($group_id != 5) :
                                                    ?>

                                                    <a type="" class="btn oBtnDetail qUpdate" data-toggle="modal" data-target="#update_quote_modal" title="">Cập nhật</a>
                                                <?php endif; ?>
                                                <!-- <button type="button" class="btn oBtnDetail" onclick="exportQuote(<?php //echo $id;
                                                                                                                        ?>);">In báo giá</button> -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn_bookoke oBtnDetail">&nbsp;In báo giá</button>
                                                    <button type="button" class="btn btn_bookoke oBtnDetail dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu menu-export">
                                                        <li><a href="#" onclick="exportQuote(<?php echo $id; ?>, 'vi');">&nbsp;VI</a></li>
                                                        <li><a href="#" onclick="exportQuote(<?php echo $id; ?>, 'en');">&nbsp;EN</a></li>
                                                    </ul>
                                                </div>

                                                <a class="btn oBtnDetail" id="mailClick" onclick="mailClick('<?php echo $v['email']; ?>','<?php echo $v['code']; ?>','<?php echo $id; ?>');" data-toggle="modal" data-target="#mailinfo" title="">Gửi email</a>

                                                <?php if ($delQuote == 1) : ?>
                                                    <span class="pull-right"><button type="button" class="btn btn-danger" onclick="deleteQuotation(<?php echo $id; ?>,<?php echo $order; ?>);">Xóa</button></span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<div style="clear:both"></div>
<div id="" class="row fix_bottom">
    <?php if ($page_list) echo $page_list; ?>
</div>

<script>
    $(function() {
        var numberOptions = {
            aSep: '.',
            aDec: ',',
            mDec: 3,
            aPad: false
        };
        $('.autoNum').autoNumeric('init', numberOptions);
    })
</script>