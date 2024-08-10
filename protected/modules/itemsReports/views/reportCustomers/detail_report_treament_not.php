<p class="tt" style="float:left;">Khách hàng không điều trị</p>
<p style="float: right;"> <?php echo $title; ?></p>

<div class="table table-responsive">
    <table class="table table-hover" id="list_export">
        <thead class="headertable">
            <tr>
                <th>STT</th>
                <th>Thẻ</th>
                <th>SHS</th>
                <th>Họ tên</th>
                <th>Năm sinh</th>
                <th>Số ĐT</th>
                <th>Chuẩn đoán</th>
                <th>Điều trị</th>
                <th>BS</th>
                <th>Tình trạng</th>
                <th>Phản hồi</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($data == 0 || empty($data)) : ?>
                <tr>
                    <td colspan=11>Không có dữ liệu!</td>
                </tr>
            <?php else : ?>
                <?php
                    $customerList = array_unique(array_map(function ($dt) {
                        return $dt['id_customer'];
                    }, $data));
                ?>

                <?php $idx = 1; ?>

                <?php foreach ($customerList as $key => $id_customer) : ?>
                    <?php
                        $reportList = array_filter($data, function ($dt) use ($id_customer) {
                            return $dt['id_customer'] == $id_customer;
                        });

                        $reportNotTreatment = array_filter($reportList, function ($dt) {
                            return $dt['status'] == 0;
                        });

                        if (count($reportNotTreatment) <= 0 ) {
                            continue;
                        }

                        $treatmentAllStr = implode(", ", array_map(function ($dt) {
                            return $dt['code_service'];
                        }, $reportList));

                        $treatmentNotStr = implode(", ", array_map(function ($dt) {
                            return $dt['code_service'];
                        }, $reportNotTreatment));

                        $treatmentNotDentist = implode(", ", array_unique(array_map(function ($dt) {
                            return $dt['user_name'];
                        }, $reportNotTreatment)));

                        $reportData = reset($reportList);
                    ?>

                    <tr>
                        <td><?php echo $idx++; ?></td>
                        <td></td>
                        <td><?php echo $reportData['code_number']; ?></td>
                        <td><?php echo $reportData['fullname']; ?></td>
                        <td><?php echo date_format(date_create($reportData['birthdate']), 'd/m/Y'); ?></td>
                        <td><?php echo $reportData['phone']; ?></td>
                        <td><?php echo $treatmentAllStr; ?></td>
                        <td><?php echo $treatmentNotStr; ?></td>
                        <td><?php echo $treatmentNotDentist; ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>

            <?php endif; ?>
        </tbody>
    </table>
</div>