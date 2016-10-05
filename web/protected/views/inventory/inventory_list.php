<script type="text/javascript" src="/plugin/module/inventory.js"></script>
<?php
//bugfix start
clean_xss($_GET['sdate']);
clean_xss($_GET['edate']);
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
			<td align="right"><form method="get" action="<?= Yii::app()->createUrl("inventory/list") ?>">
					时间范围：
					<input class="grid_text" type="date" name="sdate" value="<?php echo $_GET['sdate']; ?>">
					至
					<input class="grid_text" type="date" name="edate" value="<?php echo $_GET['edate']; ?>">
					<input type="submit" value="查询" class="grid_button grid_button_s">
				</form></td>
		</tr>
		</tbody>
	</table>
</div>
<div id="invertoryPrint">
	<table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
		<thead>
			<tr class="row">
				<th align="left">仓库</th>
				<th align="left">批次编号</th>
				<th align="left">物资名称</th>
				<th align="left">物资编号</th>
				<th align="left">扩展编码</th>
				<th align="center">单位</th>
				<th align="center">单价</th>
				<th align="center">规格</th>
				<th align="center">厂家</th>
				<th align="center">有效日期</th>
				<th align="center">最低库存</th>
				<th align="center">库存数量</th>
				<th align="center">入库数量</th>
				<th align="center">出库数量</th>
				<th align="center">待领料数量</th>
				<th align="center">移库数量</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($rsList as $key=>$material):
				$color = $material['currCount'] < $material['minCount'] ? 'color:red;font-weight:bold;' : '';
				$bgColor = $material['currCount'] < $material['minCount'] ? 'background-color:#FFD4D4;' : '';
				$year = date("Y-m-d",strtotime("+6 month"));//有效期半年
				$color_data = $material['validityDate'] < $year ? 'color:red;font-weight:bold;' : '';
				$bgColor = $material['validityDate'] < $year ? 'background-color:#FFD4D4;' : $bgColor;
				?>
			<tr style="<?= $bgColor ?>">
				<td align="left"><?php echo Store::getName($material['storeID']); ?></td>
				<td align="left"><?php echo $material['batchCode'];?></td>
				<td align="left"><?php echo $material['goodsName'];?></td>
				<td align="left"><?php echo $material['goodsCode'];?></td>
				<td align="left"><?php echo $material['extendCode'];?></td>
				<td align="center"><?php echo $material['unit'];?></td>
				<td align="center"><?php echo $material['price'];?></td>
				<td align="center"><?php echo $material['standard'];?></td>
				<td align="center"><?php echo $material['factory'];?></td>
				<td align="center"><span style="<?= $color_data ?>"><?php echo $material['validityDate']=="0000-00-00"?"":$material['validityDate']; ?></span></td>
				<td align="center"><?php echo floatval($material['minCount']);?></td>
				<td align="center"><strong style="color:blue;"><span style="<?= $color ?>"><?php echo floatval($material['currCount']);?></span></strong></td>
				<td align="center"><?php echo $material['countIn']==''?'0':floatval($material['countIn']);?></td>
				<td align="center"><?php echo $material['countReceive']==''?'0':floatval($material['countReceive']);?></td>
				<td align="center"><?php echo $material['countNoReceive']==''?'0':floatval($material['countNoReceive']);?></td>
				<td align="center"><?php echo $material['countMove']==''?'0':floatval($material['countMove']);?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>

<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>

<style type="text/css" media="print">
button{display:none;}
#invertoryPrint{display:block;}
</style>
<div align="center" style="padding-top:10px;">
	<button type="button" class="grid_button" onclick="window.location='/inventory/Export';">导出为Excel</button>
<!--	<button type="button" class="grid_button" onclick="window.location='/inventory/print';">打印</button>-->
	<button type="button" class="grid_button" onclick="Inventory.clear(function(){location.reload();})">清空数据</button>
</div>


<script>
<?php if($this->action->id=="print"):?>
window.print();
<?php endif;?>
</script>
