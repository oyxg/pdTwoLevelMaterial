<script type="text/javascript" src="/plugin/module/material.js"></script>
<script>
var reloadSelectIframe=function(){
	parent.frames['materialFrm2'].location.reload(true);	
}
</script>
<div class="control_tb">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="400"><?php 
				$this->beginContent("//layouts/breadcrumbs");
				$this->endContent();
				?></td>
				<td align="right"style="width: 520px;">
					<form method="get" action="<?=Yii::app()->createUrl("Task/SelectList")?>">
						批次号：
						<input class="grid_text" name="batchCode" value="<?php echo $_GET['batchCode'];?>" />
						物料编码：
						<input class="grid_text" name="goodsCode" value="<?php echo $_GET['goodsCode'];?>" />
						物料描述：
						<input class="grid_text" name="goodsName" value="<?php echo $_GET['goodsName'];?>" />
						<input type="submit" value="查询" class="grid_button grid_button_s">
					</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
	<thead>
		<tr class="row">
			<th width="200" align="left">仓库</th>
			<th width="200" align="left">批次号</th>
			<th width="200" align="left">物料编码</th>
			<th width="200" align="left">物料描述</th>
			<th width="200" align="left">厂家</th>
			<th width="200" align="left">扩展编码</th>
			<th width="100" align="center">单位</th>
			<th width="100" align="center">单价</th>
			<th width="100" align="center">可领用数量</th>
			<th width="100" align="center">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$count = 0;
		foreach ($rsList as $key=>$material):
			$count++;//统计行数
		?>
		<tr>
			<td align="left"><?php echo Store::model()->getName(Material::model()->findByPk($material['materialID'])->storeID); ?></td>
			<td align="left"><?php echo $material['batchCode']; ?></td>
			<td align="left"><?php echo $material['goodsCode']; ?></td>
			<td align="left"><?php echo $material['goodsName']; ?></td>
			<td align="left"><?php echo $material['factory']; ?></td>
			<td align="left"><?php echo $material['extendCode']; ?></td>
			<td align="center"><?php echo $material['unit']; ?></td>
			<td align="center"><?php echo $material['price']; ?></td>
			<td align="center"><input type="number" max="<?php echo floatval($material['applyNum']); ?>" min="1" class="grid_text" style="text-align:center;width:50px;" size="3" maxlength="3" value="<?php echo floatval($material['applyNum']);?>" id="<?php echo 'm_'.$material['materialID'];?>"></td>
			<td align="left"><button class="grid_button" onclick="Material.addToTaskBook(<?php echo $material['materialID'];?>,reloadSelectIframe);">添加到任务书</button></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php if($count<4):?>
<div style="height: 80px;"></div>
<?php endif;?>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>
