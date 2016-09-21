<script type="text/javascript" src="/plugin/module/material.js"></script>
<!-- 日历插件js & css -->
<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>
<script>
	$(function(){
		//日历插件
		$("#date").calendar({
			format : "yyyy-MM-dd"
		});
		//添加物资到缓存
		$("button[rel=add]").click(function(){
			Material.addToTask(<?php if($add)echo "'add'"; else echo "";?>);
		});
		//修改缓存中的物资信息
		$("a[rel=editTTdata]").click(function(){
			Material.editTTdata($(this).attr('gName'),"<?php if($edit)echo "edit";?>");
		});
		//删除缓存中的物资信息
		$("a[rel=delTTdata]").click(function(){
			Material.delTTdata($(this).attr('gName'),function(){
				location.reload();
			},"<?php if($edit)echo "edit";?>");
		});
		//提交
		$("#form").submit(function () {
			var ajaxOpt = {
				dataType: "json",
				error: function () {
					maya.notice.fail("服务器出现错误", null, 3);
				},
				success: function (data) {
					maya.notice.close();
					if (data.status == 0) {
						maya.notice.fail(data.info);
					} else {
						maya.notice.success(data.info, function () {
//							location.reload();
							//parent.location.reload();
							window.location.href="<?= Yii::app()->createUrl("Task/TaskBookList").'?type=my' ?>";
						});
					}
				}
			};
			$(form).ajaxSubmit(ajaxOpt);
			return false;
		});
	});
</script>

<div class="control_tb">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width="400"><?php
				$this->beginContent("//layouts/breadcrumbs");
				$this->endContent();
				?></td>
			<td align="right"></td>
		</tr>
		</tbody>
	</table>
</div>
<form id="form" name="form" class="" action="" method="post" >
	<div style="padding:10px">
		<div style="letter-spacing:10px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 配电设备检修（抢修）预（结）算任务书 </div>
		<div class="tag"> 基本信息</div>
		<div class="tagc">
			<table border="0" cellspacing="0" cellpadding="0">
				<tbody>
				<tr height="30">
					<td width="90" align="right"><strong>施工日期：</strong></td>
					<td width="170"><input name="date" type="text" class="grid_text" value="<?= $taskBook->date?>" id="date" /></td>
					<td width="90" align="right"><strong>责任单位：</strong></td>
					<td width="170"><input name="zrdw" type="text" class="grid_text" value="<?= $taskBook->zrdw?>" /></td>
					<td width="90" align="right"><strong>责任班组：</strong></td>
					<td width="170"><input name="zrbz" type="text" class="grid_text" value="<?= $taskBook->zrbz?>" /></td>
					<td width="90" align="right"><strong>配合单位：</strong></td>
					<td width="170"><input name="phdw" type="text" class="grid_text" value="<?= $taskBook->phdw?>" /></td>
				</tr>
				<tr height="30">
					<td width="120" align="right"><strong>线路及设备名称：</strong></td>
					<td width="390px" colspan="4"><input style="width:390px;" name="line" type="text" class="grid_text" value="<?= $taskBook->line?>" /></td>
				</tr>
				<tr height="58">
					<td width="90" align="right"><strong>消缺内容：</strong></td>
					<td colspan="9"><textarea name="content" style="width:900px;height: 50px;" class="grid_text"><?= $taskBook->content?></textarea></td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="tag"> 需领材料</div>
		<div class="tagc" id="xx" style="min-height:100px;">
			<table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
				<thead>
				<tr class="row">
					<th width="20" align="center">序号</th>
					<th align="center">物资名称</th>
					<th align="center">型号规格及参数</th>
					<th width="50" align="center">单位</th>
					<th width="70" align="center">单价</th>
					<th width="50" align="center">数量</th>
					<th align="center">金额（元）</th>
					<th width="70" align="center">操作</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$i=0;
				foreach ($list as $v):
					$i++;  ?>
					<tr>
						<td align="center"><?php echo $i;?></td>
						<td align="center"><?php echo $v['goodsName'];?></td>
						<td align="center"><?php echo $v['standard'];?></td>
						<td align="center"><?php echo $v['unit'];?></td>
						<td align="center"><?php echo floatval($v['price']);?></td>
						<td align="center"><?php echo floatval($v['number']);?></td>
						<td align="center"><?php echo floatval($v['number']*$v['price']);?></td>
						<?php if(!$SHOW):?>
							<td align="center"><div class="grid_menu_panel" style="width:70px">
									<div class="grid_menu_btn">操作</div>
									<div class="grid_menu">
										<ul>
											<li class="icon_015"><a href="#" gName="<?php echo $v['goodsName']; ?>" rel="editTTdata">修改</a></li>
											<li class="icon_009"><a href="#" gName="<?php echo $v['goodsName']; ?>" rel="delTTdata">删除</a></li>
										</ul>
									</div>
								</div></td>
						<?php endif;?>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>

		</div>

	</div>
	<style media="print">
		#printWin{display:none;}
	</style>
	<?php if($scrapForm->state=='back'):?>
	<p style="color: #ff0000;margin: 0;padding:0 0 0 15px;">退回原因：<?= $scrapForm->opinion;?></p>
	<?php endif;?>
	<div style="text-align:center;padding:9px;" id="printWin">
		<?php if(!$SHOW):?>
			<button type="button" rel="add" class="grid_button">新增物资</button>
			<button type="submit" class="grid_button">确认提交</button>
		<?php endif;?>
		<button type="button" class="grid_button" onclick="print()">打印</button>
	</div>
</form>