<div class="col-md-12 tableList"> 
    <table class="table table-condensed table-hover" id="oListT" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Labo</th>
                <th>Địa chỉ</th> 
                <th>SDT liên hệ</th>
                <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
	       	<?php if ($listLabo == -1): ?>
			    <tr><td colspan="5" >Không có dữ liệu!</td></tr>
			<?php else: ?>
				<?php 
                    foreach ($listLabo as $key => $v): 
                ?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $v['name']; ?></td>
						<td><?php echo $v['address']; ?></td>
						<td><?php echo $v['phone']; ?></td>
						<td>
                            <button type="button" class="btn btn-sm btn-border-radius-default" title="Edit" onclick="editLabo('<?php echo $v['id']?>');">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button type="button" class="btn btn-sm btn-border-radius-default" title="Delete" onclick="deleteLabo('<?php echo $v['id']?>');">
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
