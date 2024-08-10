<div class="col-md-12 tableList">
    <table class="table table-condensed table-hover" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>STT</th>
                <th>Đối tác</th>
                <th>Khách hàng</th>
                <th>Mã hóa đơn</th>
                <th>Ngày thực hiện</th>
                <th>Nguồn</th>
                <th>Tổng tiền</th>
                <th>Công nợ bảo hiểm</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($data['count'] <= 0) : ?>
                <tr>
                    <td colspan="8">Không có dữ liệu!</td>
                </tr>
            <?php else : ?>
                <?php foreach ($data['data'] as $key => $v): ?>
                    <tr data-id="<?php echo $v['id']; ?>" data-toggle="collapse" data-target="#ins<?php echo $v['id']; ?>" class="insurance-view insurance-view-<?php echo $v['id']; ?> accordion-toggle <?php if ($key % 2 != 0) echo "tr_col"; ?>" aria-expanded="false">
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo isset($v['partner']) ? $v['partner']['name'] : ''; ?></td>
                        <td><?php echo isset($v['customer']) ? $v['customer']['fullname'] : ''; ?></td>
                        <td><?php echo $v['code_invoice']; ?></td>
                        <td><?php echo date_format(date_create($v['create_date']), 'H:i d/m/Y'); ?></td>
                        <td><?php echo Insurance::$_type[$v['source']]; ?></td>
                        <td><span class="insurance-view-amount"><?php echo number_format($v['amount'], 0, '', '.'); ?></span> VND</td>
                        <td><span class="insurance-view-balance"><?php echo number_format($v['balance'], 0, '', '.'); ?></span> VND</td>
                    </tr>

                    <tr class="insurance-view-<?php echo $v['id']; ?>" style="border-bottom: 1px solid #ccc">
                        <td colspan="8" class="hiddenRow">
                            <div class="accordian-body collapse col-md-12" id="ins<?php echo $v['id']; ?>">
                                <input type="hidden" name="insurance[id]" class="insurance-id" value="<?php echo $v['id']; ?>">
                                <div class="row">
                                    <div class="col-md-4 text-left">
                                        <div class="row">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <th class="text-right">Văn phòng:</th>
                                                        <td class="text-left"><?php echo isset($v['branch']) ? $v['branch']['name'] : ''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right">Mã hóa đơn: </th>
                                                        <td class="text-left"><?php echo $v['code_invoice']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right">Mã Khách hàng: </th>
                                                        <td class="text-left"><a target="_blank" href="<?php echo Yii::app()->baseUrl; ?>/itemsCustomers/Accounts/admin?code_number=<?php echo $v['customer']['code_number']; ?>"><?php echo $v['customer']['code_number']; ?></a></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right">Khách hàng: </th>
                                                        <td class="text-left"><?php echo $v['customer']['fullname']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-md-offset-3">
                                        <div class="row">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <th class="text-right">Đối tác:</th>
                                                        <td class="text-left"><?php echo isset($v['partner']) ? $v['partner']['name'] : ''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right">Ngày tạo: </th>
                                                        <td class="text-left"><?php echo date_format(date_create($v['create_date']), 'H:i d/m/Y'); ?></td>
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

                                <div class="col-md-12 text-right"><span>Đơn vị: VND</span></div>

                                <div class="row oViewB" style="background: white;">
                                    <table class="col-md-12 table">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Người thực hiện</th>
                                                <th>Ngày thực hiện</th>
                                                <th>Hình thức</th>
                                                <th>Số tiền</th>
                                                <th>Lý do</th>
                                            </tr>
                                        </thead>

                                        <tbody class="insurance-info">
                                            <tr>
                                                <td colspan="6">Chưa có lịch sử giao dịch!</td>
                                            </tr>
                                        </tbody>

                                        <tbody>
                                            <tr class="innsurance-summary" style="border-top: 2px solid #e1e7eb; background: white;">
                                                <td colspan="4" class="text-right"><b>Bảo hiểm bảo lãnh:</b></td>
                                                <td class="text-right"><b class="insurance-view-amount"><?php echo number_format($v['amount'], 0, '', '.'); ?></b></td>
                                                <td class="text-left">VND</td>
                                            </tr>

                                            <tr style="background: white;">
                                                <td colspan="4" class="text-right"><b>Tổng BH thanh toán:</b></td>
                                                <td class="text-right">
                                                    <b class="insurance-view-pay">
                                                        <?php echo number_format($v['amount']-$v['balance'], 0, '', '.'); ?>
                                                    </b>
                                                </td>
                                                <td class="text-left">VND</td>
                                            </tr>

                                            <tr style="background: white;">
                                                <td colspan="4" class="text-right"><b>Công nợ BH:</b></td>
                                                <td class="text-right"><b class="insurance-view-balance"><?php echo number_format($v['balance'], 0, '', '.'); ?></b></td>
                                                <td class="text-left">VND</td>
                                            </tr>

                                            <tr style="background: white;">
                                                <td colspan="6">
                                                    <div class="col-md-8 text-left">
                                                        <a class="btn oBtnDetail insurance-update">Cập nhật</a>
                                                        <a class="btn oBtnDetail insurance-paid">BH thanh toán</a>
                                                    </div>

                                                    <div class="col-md-4 text-right">
                                                        <a class="btn btn-danger insurance-cancel">Hủy</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif ?>
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

    $('.tableList>.table>tbody').css('max-height', height - menu - oSrchBar - 130 + 'px');
</script>