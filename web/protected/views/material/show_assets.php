


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
	<thead>
		<tr>
			<th align="left">设备编号</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($rsList as $key=>$assets):?>
		<tr>
			<td align="left"><?php echo $assets['number'];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>