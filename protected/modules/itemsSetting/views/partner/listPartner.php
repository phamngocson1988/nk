<div class="col-md-12 tableList"> 
    <table class="table table-condensed table-hover" id="oListT" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã đối tác</th>
                <th>Tên đối tác</th>
                <th>Mô tả</th> 
                <th>Bảng giá</th>
                <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
	       	<?php if ($listPartner == -1): ?>
			    <tr><td colspan="6" >Không có dữ liệu!</td></tr>
			<?php else: ?>
				<?php 
                    foreach ($listPartner as $key => $v): 
                        $price_list = PriceBook::model()->findByPk($v['id_price_book']);
                ?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $v['code']; ?></td>
						<td><?php echo $v['name']; ?></td>
						<td><?php echo $v['description']; ?></td>
                        <td>
                            <?php if($price_list){ echo $price_list['name'];}else{ echo "N/A";} ?>
                        </td>
						<td>
                            <button type="button" class="btn btn-sm btn-border-radius-default" title="Edit" onclick="editPartner('<?php echo $v['id']?>');">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button type="button" class="btn btn-sm btn-border-radius-default" title="Delete" onclick="deletePartner('<?php echo $v['id']?>');">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
        </tbody>
   </table>
</div>

<div style="clear:both"></div>
<div id="" class="row fix_bottom">
    <?php if($page_list) echo $page_list;?>
</div>
