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
			Material.addToScrapForm();
		});
		//修改缓存中的物资信息
		$("a[rel=editSTdata]").click(function(){
			Material.editSTdata($(this).attr('gCode'));
		});
		//删除缓存中的物资信息
		$("a[rel=delSTdata]").click(function(){
			Material.delSTdata($(this).attr('gCode'),function(){
				location.reload();
			});
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
							window.location.href="<?= Yii::app()->createUrl("scrap/ScrapFormList").'?type=my' ?>";
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
		<div style="letter-spacing:20px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 物资报废鉴定审批表 </div>
		<div class="tag"> 基本信息</div>
		<div class="tagc">
			<table border="0" cellspacing="0" cellpadding="0">
				<tbody>
				<tr height="30">
					<?php if($edit):?>
					<td width="70" align="right"><strong>日期：</strong></td>
					<td width="170"><input type="text" class="grid_text" value="<?= $scrapForm->date?>" disabled />
						<input name="date" id="date" type="hidden" value="<?= $scrapForm->date?>" /></td>
					<td width="90" align="right"><strong>报废表编号：</strong></td>
					<td width="170"><input type="text" class="grid_text" value="<?= $scrapForm->formCode?>" disabled />
						<input name="formCode" id="formCode" type="hidden" value="<?= $scrapForm->date?>" /></td>
					<?php endif;?>
					<td width="70" align="right"><strong>项目名称：</strong></td>
					<td width="170"><input name="projectName" id="projectName" type="text" class="grid_text" value="<?= $scrapForm->projectName?>" /></td>
					<td width="70" align="right"><strong>项目编号：</strong></td>
					<td width="170"><input name="projectCode" id="projectCode" type="text" class="grid_text" value="<?= $scrapForm->projectCode?>" /></td>
					<td width="80" align="right"><strong>提交给：</strong></td>
					<td width="170"><select class="grid_text" name="Major" id="Major" style="height: 24px">
							<option></option>
							<?php
							$db = Yii::app()->db;
							$sql = "SELECT distinct u.id,u.userName FROM mod_user u,auth_assignment a WHERE (a.itemname='Major' OR a.itemname='Materialer') AND u.id = a.userid";
							$command = $db->createCommand($sql);
							$data = $command->queryAll();
							foreach($data as $key){
								if($scrapForm->zID==$key['id']){
									echo "<option value=\"{$key['id']}\" selected>{$key['userName']}</option>";
								}else
									echo "<option value=\"{$key['id']}\">{$key['userName']}</option>";
							}
							?>
						</select></td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="tag"> 报废物资列表</div>
		<div class="tagc" id="xx" style="min-height:100px;">
			<table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
				<thead>
				<tr class="row">
					<th width="50" align="center">序号</th>
					<th align="70">物资编码</th>
					<th align="center">物资描述</th>
					<th width="70" align="left">规格型号</th>
					<th width="50" align="center">计量单位</th>
					<th width="70" align="center">设计折旧数量</th>
					<th width="50" align="center">实退数量</th>
					<th align="left">备注</th>
					<?php if(!$SHOW):?>
						<th width="70" align="center">操作</th>
					<?php endif;?>
				</tr>
				</thead>
				<tbody>
				<?php
				$i=0;
				foreach ($list as $v):
					$i++;  ?>
					<tr>
						<td align="center"><?php echo $i;?></td>
						<td align="center"><?php echo $v['goodsCode'];?></td>
						<td align="center"><?php echo $v['goodsName'];?></td>
						<td align="center"><?php echo $v['standard'];?></td>
						<td align="center"><?php echo $v['unit'];?></td>
						<td align="center"><?php echo $v['designNum'];?></td>
						<td align="center"><?php echo $v['number'];?></td>
						<td align="left"><?php echo $v['remark'];?></td>
						<?php if(!$SHOW):?>
							<td align="center"><div class="grid_menu_panel" style="width:70px">
									<div class="grid_menu_btn">操作</div>
									<div class="grid_menu">
										<ul>
											<li class="icon_015"><a href="#" gCode="<?php echo $v['goodsCode']; ?>" rel="editSTdata">修改</a></li>
											<li class="icon_009"><a href="#" gCode="<?php echo $v['goodsCode']; ?>" rel="delSTdata">删除</a></li>
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
	<?php if($scrapForm->state==1):?>
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