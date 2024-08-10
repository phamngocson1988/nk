<table class="table table-condensed table-hover">
    <thead>
        <tr> 
            <th>Kho</th>
            <th>Mã nguyên vật liệu</th>
            <th>Tên nguyên vật liệu</th>
            <th>Số lượng</th>
            <th class="text-left" style="width: 350px">Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php if($data['status'] == 'error'): ?>
            <tr><td colspan="4">Không có dữ liệu !</td></tr>
        <?php else: 
            $arr    = array();
            $date   = date("Y-m-d");
            foreach ($data['data'] as $key => $value): 
                if(isset($value['content']) && $value['content']):
                    foreach ($value['content'] as $v):
                       $arr[$v['expiration_date']][] = $v;
                    endforeach;
                endif;
        ?>
                <tr>
                    <td><?php echo $value['name_repository']; ?></td>
                    <td><?php echo $value['code_material'] ?></td>
                    <td><?php echo $value['name_material'] ?></td>
                    <td><?php echo $value['qty'] ?></td>
                    <td class="text-left" style="width: 350px">
                        <?php 
                            foreach ($arr as $key => $val):
                                $sumQty = 0;
                                foreach ($val as $key => $t):
                                    if($t['id_material'] == $v['id_material']):
                                        $sumQty += $t['qty'];
                                    endif;
                                endforeach;
                                if($sumQty >0):
                                    $lable = '';
                                    if($val[0]['expiration_date'] < $date){
                                        $lable = 'Hết hạn';
                                    }else{
                                        $lable = '';
                                    }
                                    if($lable){
                                        echo '<div class="mt-10">- Ngày hết hạn: '.$val[0]['expiration_date'].' , Số lượng: '.$sumQty.' <span>'.$lable.'</span></div>';
                                    }else{
                                        echo '<div class="mt-10">- Ngày hết hạn: '.$val[0]['expiration_date'].' , Số lượng: '.$sumQty.'</div>';
                                    }
                                endif;
                            endforeach;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
    </tbody>
</table>