<form method="post" id="form" class="form" name="form">
	<table width="100%" class="github_tb">
<!--		<tr>
			<td align="right">国网编码：</td>
			<td><input type="text" name="stateCode" id="stateCode" value="<?=$material->stateCode?>" /></td>
		</tr>-->
		<tr>
			<td align="right">当前库存：</td>
			<td><input type="text" name="currCount" id="currCount" value="<?=floatval($material->currCount)?>" /></td>
		</tr>
		<tr>
			<td align="right">有效库存：</td>
			<td><input type="text" name="availableCount" id="availableCount" value="<?=floatval($material->availableCount)?>" /></td>
		</tr>
		<tr>
			<td align="right">最低库存：</td>
			<td><input type="text" name="minCount" id="minCount" value="<?=floatval($material->minCount)?>" /></td>
		</tr>
		<tr>
			<td align="right">货架编码：</td>
			<td><input type="text" name="position" id="position" value="<?=$material->position?>" /></td>
		</tr>
		<tr>
			<td align="right">编号：</td>
			<td><input type="text" name="numberCode" id="numberCode" value="<?=$material->numberCode?>" /></td>
		</tr>
		<tr>
			<td align="right">持有人：</td>
			<td><input type="text" name="keeper" id="keeper" value="<?=$material->keeper?>" /></td>
		</tr>
		<tr>
			<td align="right">单位：</td>
			<td><input type="text" name="unit" id="unit" value="<?=$material->unit?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" id="subBtn" value="提交" /></td>
		</tr>
	</table>
</form>
