<script type="text/javascript" src="/plugin/module/use_material.js"></script>
<script>
var reloadSelf=function(){
	location.reload(true);
}
</script>
<?php if(is_array($rsList)):?>
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
			<th width="100" align="center">库存数量</th>
			<th width="100" align="center">领用数量</th>
			<th width="100" align="center">总额</th>
			<th width="100" align="center">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($rsList as $key=>$rtm):
			$rtm=unserialize($rtm);
		?>
		<tr>
			<td align="left"><?php echo Store::model()->getName(Material::model()->findByPk($rtm->material->materialID)->storeID); ?></td>
			<td align="left"><?php echo $rtm->material->batchCode; ?></td>
			<td align="left"><?php echo $rtm->material->goodsCode; ?></td>
			<td align="left"><?php echo $rtm->material->goodsName; ?></td>
			<td align="left"><?php echo $rtm->material->factory; ?></td>
			<td align="left"><?php echo $rtm->material->extendCode; ?></td>
			<td align="center"><?php echo $rtm->material->unit; ?></td>
			<td align="center"><?php echo $rtm->material->price; ?></td>
			<td align="center"><?php echo floatval($rtm->material->currCount); ?></td>
			<td align="center"><?php echo floatval($rtm->number); ?></td>
			<td align="center"><?php echo floatval($rtm->number*$rtm->material->price); ?></td>
			<td align="left"><button class="grid_button" onclick="UseMaterial.RemoveToReceiveForm(<?php echo $rtm->material->materialID;?>,reloadSelf);">删除</button></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php else:?>
<div align="center" style="color: #666">没有记录</div>
<?php endif;?>