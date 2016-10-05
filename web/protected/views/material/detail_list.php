<?php
//bugfix start
clean_xss($_GET['goodsName']);
//bugfix end
?>

<div class="control_tb">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="400"><?php 
				$this->beginContent("//layouts/breadcrumbs");
				$this->endContent();
				?></td>
				<td align="right"><form method="get" action="<?=Yii::app()->createUrl("material/detaillist")?>">
						名称：
						<input class="grid_text" name="goodsName" value="<?php echo $_GET['goodsName'];?>">
						<input type="submit" value="查询" class="grid_button grid_button_s">
					</form></td>
			</tr>
		</tbody>
	</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
	<thead>
		<tr>
			<th width="100" align="left">仓库</th>
			<th width="100" align="left">名称</th>
			<th align="left">型号</th>
<!--			<th width="100" align="left">国网编码</th>-->
			<th width="60" align="center">当前库存</th>
			<th width="60" align="center">可用库存</th>
			<th width="60" align="center">库存定额</th>
			<th width="60" align="center">单位</th>
			<th width="70" align="center">类型</th>
			<th width="90" align="left">货架编码</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($rsList as $key=>$material):?>
		<tr>
			<td align="left"><?php echo Store::getName($material['storeID']);?></td>
			<td align="left"><?php echo $material['goodsName'];?></td>
			<td align="left"><?php echo $material['property'];?></td>
<!--			<td align="left"><?php echo $material['stateCode'];?></td>-->
			<td align="center"><?php echo $material['currCount'];?></td>
			<td align="center"><?php echo $material['availableCount'];?></td>
			<td align="center"><?php echo $material['minCount'];?></td>
			<td align="center"><?php echo $material['unit'];?></td>
			<td align="center"><?php echo Goods::getTypeName($material['type']);?></td>
			<td align="left"><?php echo $material['position'];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php 
$this->beginContent("//layouts/pagination");
$this->endContent();
?>