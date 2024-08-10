<div class="col-md-12 tableList">
    <div style="text-align: right; color: orange; margin-bottom: 5px;">
        <?php echo $sumBalance; ?>
    </div>

    <table class="table table-condensed table-hover" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Khách hàng</th>
                <th>Văn phòng</th>
                <th>Người tạo</th>
                <th>Ngày thanh toán</th>
                <th>Ngày hoàn tất</th>
                <th>Tổng tiền</th>
                <th>Công nợ</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($InvoiceList == -1) : ?>
                <tr>
                    <td colspan="8">Không có dữ liệu!</td>
                </tr>

            <?php else : ?>
                <?php $expand = "false"; $in = "";
                if ($count == 1) { $expand = "true"; $in = "in"; } ?>

                <?php foreach ($InvoiceList as $key => $v) :
                    $id = $v['id'];
                    $InvoiceDetails = VInvoiceDetail::model()->findAllByAttributes(array('id_invoice' => $v['id']));
                ?>

                    <?php if (count($InvoiceDetails) <= 0) : ?>
                        <?php continue; ?>
                    <?php endif; ?>

                    <?php $invoiceCancel = array_filter($InvoiceDetails, function ($v) use ($id) {
                        if ($v['status'] == -1)
                            return true;
                    }); ?>

                    <?php if ($v['confirm'] == 0 && count($invoiceCancel) == count($InvoiceDetails)) : ?>
                        <?php continue; ?>
                    <?php endif; ?>

                    <tr data-toggle="collapse" data-target="#q<?php echo $v['id']; ?>" class="accordion-toggle<?php if ($key % 2 != 0) echo " tr_col"; ?>" aria-expanded="<?php echo $expand; ?>">
                        <td class="text-left" style="padding: 8px 20px;"><?php echo $v['code']; ?>
                            <?php if ($v['isVat']) : ?>
                                <span class="label" style="background: #f1b51b;">VAT</span>
                            <?php endif ?>

                            <?php if ($v['confirm'] == 0) : ?>
                                <span class="label" style="background: #0b7dda;">Chưa xác nhận</span>
                            <?php endif ?>
                        </td>
                        <td><?php echo $v['customer_name']; ?></td>
                        <td><?php echo $v['branch_name']; ?></td>
                        <td><?php echo $v['author_name']; ?></td>
                        <td><?php echo date_format(date_create($v['create_date']), 'H:i d/m/Y'); ?></td>
                        <td><?php echo date_format(date_create($v['create_date']), 'H:i d/m/Y'); ?></td>
                        <td><?php echo number_format($v['sum_amount'] + $v['sum_amount_usd'], 0, '', '.'); ?></td>
                        <td><?php echo number_format($v['balance'], 0, '', '.'); ?></td>
                    </tr>

                    <tr>
                        <input type="hidden" name="id_invoice" value="<?php echo $v['id']; ?>">
                        <input type="hidden" name="id_customer" value="<?php echo $v['id_customer']; ?>">
                        <input type="hidden" name="confirm" value="<?php echo $v['confirm']; ?>">

                        <td colspan="7" class="hiddenRow">
                            <div aria-expanded="<?php echo $expand; ?>" class="accordian-body collapse <?php echo $in; ?> oView col-md-12" id="q<?php echo $v['id']; ?>">
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
                                                            <th class="text-right">Mã hóa đơn: </th>
                                                            <td class="text-left"><?php echo $v['code']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right">Mã Khách hàng: </th>
                                                            <td class="text-left"><a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/itemsCustomers/Accounts/admin?code_number=<?php echo $v['code_number']; ?>"><?php echo $v['code_number']; ?></a></td>
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
                                                            <th class="text-right">Ngày tạo hóa đơn: </th>
                                                            <td class="text-left"><?php echo $v['create_date']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right">Ngày hết hạn: </th>
                                                            <td class="text-left"><?php echo $v['create_date']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right">Đối tác: </th>
                                                            <td class="text-left"><?php echo $v['name_price_book']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right">Ghi chú: </th>
                                                            <td class="text-left"><?php echo $v['note']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-right"><span>Đơn vị: VNĐ</span></div>

                                    <div class="col-md-12 oViewB">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="border-left: 0;">Người thực hiện</th>
                                                    <th>Sản phẩm và Dịch vụ</th>
                                                    <th>Số lượng</th>
                                                    <th>Đơn giá</th>
                                                    <th>Thuế</th>
                                                    <th style="border-right: 0;">Tổng tiền</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $sv = "";
                                                $pd = ""; ?>
                                                <?php foreach ($InvoiceDetails as $key => $value) : ?>

                                                    <?php if ($v['confirm'] == 0 && $value['status'] == -1) : ?>
                                                        <?php continue; ?>
                                                    <?php endif; ?>

                                                    <?php if ($value['status'] == -3) : ?>
                                                        <?php continue; ?>
                                                    <?php endif; ?>

                                                    <?php if ($value['id_service']) : ?>
                                                        <?php $sv .= $value['id_service'] . ","; ?>
                                                    <?php endif; ?>

                                                    <tr class="deta">
                                                        <td><?php echo $value['user_name']; ?></td>
                                                        <td><?php echo $value['description']; ?>
                                                            <?php if ($value['status'] == -1) : ?>
                                                                <span class="label label-danger">Hủy</span>
                                                            <?php elseif ($value['status'] == -2) : ?>
                                                                <span class="label label-warning">Chuyển</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo $value['qty']; ?></td>
                                                        <td><?php echo number_format($value['unit_price'], 0, '', '.'); ?></td>
                                                        <td><?php echo number_format($value['tax'], 0, '', '.'); ?></td>
                                                        <td>
                                                            <span><?php echo number_format($value['amount'], 0, '', '.'); ?></span> <?php echo ($value["flag_price"] == 1) ? "VND" : "USD"; ?>
                                                        </td>

                                                        <input type="hidden" class="id_inv_<?php echo $v['id'] ?> id_sv_<?php echo $value['id_service']; ?>" value="<?php echo $value['amount']; ?>">
                                                    </tr>
                                                <?php endforeach; ?>

                                                <?php $paymentDetails = Receipt::model()->findAllByAttributes(array('id_invoice' => $v['id'])); ?>

                                                <tr>
                                                    <td colspan="3">
                                                        <input type="hidden" name="lstServices" value="<?php echo $sv; ?>">
                                                        <input type="hidden" name="lstProducts" value="<?php echo $pd; ?>">

                                                        <?php if ($paymentDetails) : ?>
                                                            <div class="col-md-12 text-left" style="margin-bottom: 10px;">
                                                                <h5>lịch sử thanh toán</h5>

                                                                <?php foreach ($paymentDetails as $paykey => $pay) :
                                                                    $pay_type = ($pay['pay_type']) ? $pay['pay_type'] : 0;
                                                                    $trans = '';
                                                                    ?>
                                                                    <div class="col-md-12">
                                                                        <?php echo date_format(date_create($pay['pay_date']), 'H:i d/m/y'); ?> |
                                                                        <span><?php echo number_format($pay['pay_amount'], 0, '', '.'); ?></span> VNĐ  |
                                                                        <?php echo Invoice::$invoice_type[$pay_type] . " " . $trans; ?> | In phiếu thu
                                                                        <a href="" onclick="exportRpt(event,<?php echo $id; ?>,<?php echo $pay['id']; ?>,'vi')"> VN</a> |
                                                                        <a href="" onclick="exportRpt(event,<?php echo $id; ?>,<?php echo $pay['id']; ?>,'en')"> EN</a>
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        <?php endif ?>

                                                        <?php if ($v['code']) : ?>
                                                            <?php $cancelReceipt = VReceivable::model()->findAllByAttributes(array('order_number' => $v['code'])); ?>
                                                            <?php if ($cancelReceipt) : ?>
                                                                <div class="col-md-12 text-left" style="margin-bottom: 10px;">
                                                                    <h5 style="margin-top: 5px;">Lịch sử hoàn trả</h5>
                                                                    <?php foreach ($cancelReceipt as $cancelkey => $cancel) : ?>
                                                                        <div class="col-md-12">
                                                                            <?php echo date_format(date_create($cancel['received_date']), 'd/m/y'); ?> |
                                                                            <span><?php echo number_format($cancel['amount'], 0, '', '.'); ?></span> VNĐ
                                                                        </div>
                                                                    <?php endforeach ?>
                                                                </div>
                                                            <?php endif ?>
                                                        <?php endif; ?>


                                                        <?php $transDL = TransactionInvoice::model()->findAll(array(
                                                            'select' => 'create_date, amount, description',
                                                            'condition' => "id_invoice = " . $v['id'] . " AND debt = " . TransactionInvoice::Delay
                                                        )); ?>

                                                        <?php if ($transDL) : ?>
                                                            <div class="col-md-12 text-left" style="margin-bottom: 10px;">
                                                                <h5 style="margin-top: 5px;">Delay</h5>
                                                                <?php foreach ($transDL as $dl) : ?>
                                                                    <div class="col-md-12">
                                                                        <?php echo date_format(date_create($dl['create_date']), 'H:i d/m/y'); ?> |
                                                                        <span><?php echo number_format($dl['amount'], 0, '', '.'); ?></span> VND (<?php echo $dl['description']; ?>)
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        <?php endif ?>

                                                    </td>
                                                    <td colspan="3">
                                                        <table class="table sum">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-right"><b>Bao gồm thuế</b></td>
                                                                    <td class="text-left"><b><?php echo number_format($v['sum_tax'], 0, '', '.'); ?></b> VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><b>Tổng cộng</b></td>
                                                                    <td class="text-left"><b><?php echo number_format($v['sum_amount'], 0, '', '.'); ?></b> VND</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><b></b></td>
                                                                    <td class="text-left"><b><?php echo number_format($v['sum_amount_usd'], 0, '', '.'); ?></b> USD</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><b>Bảo hiểm bảo lãnh</b></td>
                                                                    <td class="text-left"><b><?php echo number_format($v['sum_insurance'], 0, '', '.'); ?></b> VND</td>
                                                                </tr>
                                                                <tr class="line">
                                                                    <td class="text-right"><b>Đã trả</b></td>
                                                                    <td class="text-left"><b><?php echo number_format(($v['sum_amount'] + $v['sum_amount_usd']) - $v['balance'], 0, '', '.'); ?></b> VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><b>Còn lại</b></td>
                                                                    <td class="text-left"><b><?php echo number_format($v['balance'], 0, '', '.'); ?></b> VNĐ</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <div id="pBtn" class="text-left">
                                                            <div class="form-inline">
                                                                <?php if ($rolePrint == 1) : ?>
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn_bookoke oBtnDetail">&nbsp;In hóa đơn</button>
                                                                        <button type="button" class="btn btn_bookoke oBtnDetail dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="caret"></span>
                                                                            <span class="sr-only">Toggle Dropdown</span>
                                                                        </button>
                                                                        <ul class="dropdown-menu menu-export">
                                                                            <li><a href="#" class="ivLang langVi" data-val="vi">&nbsp;VI</a></li>
                                                                            <li><a href="#" class="ivLang langEn" data-val="en">&nbsp;EN</a></li>
                                                                        </ul>
                                                                    </div>
                                                                <?php endif ?>

                                                                <a type="" class="btn oBtnDetail" id="mailClick" onclick="mailClick('<?php echo $v['email']; ?>','<?php echo $v['code']; ?>','<?php echo $v['id']; ?>');" data-toggle="modal" data-target="#mailinfo" title="">Gửi email</a>

                                                                <?php if ($rolePay == 1) : ?>
                                                                    <?php if ($v['confirm'] == 1 && $v['balance'] > 0) : ?>
                                                                        <a class="btn oBtnDetail iPay">Thanh toán</a>
                                                                    <?php elseif ($v['confirm'] == 0): ?>
                                                                        <a class="btn oBtnDetail iPay">Xác nhận</a>
                                                                    <?php else : ?>
                                                                    <?php endif ?>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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

<div style="clear:both"></div>

<div id="" class="row fix_bottom">
    <?php if ($page_list) echo $page_list; ?>
</div>

<script>
    $(function() {
        win = $(window).height();
        head = $('#headerMenu').height();
        srch = $('#oSrchBar').height();
        $('.tableList .table>tbody').css('max-height', win - head - srch - 120);

        var numberOptions = {
            aSep: '.',
            aDec: ',',
            mDec: 3,
            aPad: false
        };
        $('.autoNum').autoNumeric('init', numberOptions);
    })
</script>