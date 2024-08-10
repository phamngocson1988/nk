<?php if ($receivable["paging"]["num_row"] == 0): ?>
	<tr>
		<td colspan="6" class="no-data">Không có dữ liệu!</td>
	</tr>

<?php else: ?>
	<tr class="hidden">
		<td><input type="hidden" class="receivable_page" value="<?php echo $receivable["paging"]["cur_page"]; ?>"></td>
		<td><input type="hidden" class="receivable_num_page" value="<?php echo $receivable["paging"]["num_page"]; ?>"></td>
	</tr>

	<?php foreach ($receivable["data"] as $key => $value): ?>
		<tr>
			<td><?php echo $value["number"]; ?></td>
			<td style="width: 40%;"><?php echo $value["description"]; ?></td>
			<td><?php echo number_format($value["amount"], 0,'','.'); ?></td>
			<td><?php echo $value["user_name"]; ?></td>
			<td><?php echo date_format(date_create($value["received_date"]), 'd/m/Y'); ?></td>
			<td>
				<a href="/itemsAccounting/receivable/printReceivable?id=<?php echo $value["id"] ?>&lang=vi" target="_blank" title="" class="label label-success">In-vi</a>
				<a href="/itemsAccounting/receivable/printReceivable?id=<?php echo $value["id"] ?>&lang=en" target="_blank" title="" class="label label-success">In-en</a>
			</td>
		</tr>
	<?php endforeach ?>
<?php endif ?>