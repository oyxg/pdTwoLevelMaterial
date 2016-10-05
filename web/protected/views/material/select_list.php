<script type="text/javascript" src="/plugin/module/material.js"></script>
<script>
var reloadSelectIframe=function(){
	parent.frames['materialFrm2'].location.reload(true);	
}

</script>
<?php
//bugfix start
clean_xss($_GET['glProCode']);
clean_xss($_GET['goodsName']);
clean_xss($_GET['glPro']);
clean_xss($_GET['goodsCode']);
//bugfix end
?>
<div class="control_tb">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="250"><?php
				$this->beginContent("//layouts/breadcrumbs");
				$this->endContent();
				?></td>
				<td align="right"><form method="get" action="<?=Yii::app()->createUrl("material/SelectList")?>">
					<table border="0" cellspacing="0" cellpadding="0">
						<tbody>
						<tr height="30">
							<td>
								仓库：
								<select  name="storeID" id="storeID" type="text" class="grid_text" style="width:auto;height: 24px;">
									<option></option>
									<?php $storeList = Store::model()->findAll();
									foreach($storeList as $store){
										if($store->storeID== $_GET['storeID']){
											echo "<option value=\"{$store->storeID}\" selected>".$store->storeName."</option>";
										}else{
											echo "<option value=\"{$store->storeID}\">".$store->storeName."</option>";
										}
									}
									?>
								</select>
								物资描述：
								<input class="grid_text" name="goodsName" value="<?php echo $_GET['goodsName'];?>" />
								物资编码：
								<input class="grid_text" name="goodsCode" value="<?php echo $_GET['goodsCode'];?>" />
							</td>
						</tr>
						<tr height="30">
							<td>
								关联大修项目：
								<input class="grid_text" name="glPro" value="<?php echo $_GET['glPro'];?>" />
								关联大修项目编号：
								<input class="grid_text" name="glProCode" value="<?php echo $_GET['glProCode'];?>" />
								<input type="submit" value="查询" class="grid_button grid_button_s" />
							</td>
						</tr>
						</tbody>
					</table>
					</form></td>
			</tr>
		</tbody>
	</table>
</div>
<div style="width:100%;overflow-x: auto;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb" >
		<thead>
			<tr class="row">
				<th width="200" align="center">仓库</th>
				<th width="200" align="left">批次号</th>
				<th width="200" align="left">关联大修项目</th>
				<th width="200" align="left">关联大修项目编号</th>
				<th width="200" align="left">物资编码</th>
				<th width="200" align="left">扩展编码</th>
				<th width="200" align="left">物资描述</th>
				<th width="200" align="left">厂家</th>
				<th width="100" align="center">单位</th>
				<th width="100" align="center">单价</th>
				<th width="100" align="center">当前库存</th>
				<th width="100" align="center">数量</th>
				<th width="100" align="center">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0;
			foreach ($rsList as $key=>$material):
				$materialID="m_".$material['materialID'];
				$count++;//统计行数
			?>
			<tr>
				<td align="center"><?php echo Store::getName($material['storeID']); ?></td>
				<td align="left"><?php echo $material['batchCode']; ?></td>
				<td align="left"><?php echo $material['glPro']; ?></td>
				<td align="left"><?php echo $material['glProCode']; ?></td>
				<td align="left"><?php echo $material['goodsCode']; ?></td>
				<td align="left"><?php echo $material['extendCode']; ?></td>
				<td align="left"><?php echo $material['goodsName']; ?></td>
				<td align="left"><?php echo $material['factory']; ?></td>
				<td align="center"><?php echo $material['unit']; ?></td>
				<td align="center"><?php echo $material['price']; ?></td>
				<td align="center"><?php echo floatval($material['currCount']); ?></td>
				<td align="center"><input type="number" max="<?php echo floatval($material['currCount']); ?>" min="1" class="grid_text" style="text-align:center;width:50px;" size="3" value="<?php echo floatval($material['currCount']);?>" id="<?php echo $materialID;?>"></td>
				<td align="left"><button class="grid_button" onclick="Material.addToMoveForm(<?php echo $material['materialID'];?>,reloadSelectIframe);">添加到移库单</button></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
<?php if($count<4):?>
<div style="height: 80px;"></div>
<?php endif;?>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>
