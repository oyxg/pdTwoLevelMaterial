<?php
//bugfix start
clean_xss($_GET['userName']);
//bugfix end
?>
<script type="text/javascript" src="/plugin/module/store.js"></script>
<div class="control_tb">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="400">
				<?php 
				$this->beginContent("//layouts/breadcrumbs");
				$this->endContent();
				?>
				</td>
				<td align="right">
					<form method="get" action="<?= Yii::app()->createUrl("userstore/list") ?>">
						用户：
						<input class="grid_text" name="userName" value="<?php echo $_GET['userName']; ?>">

						<input type="submit" value="查询" class="grid_button grid_button_s">
						<input type="button" value="绑定用户仓库" class="grid_button" onclick="Store.bindUser()" />
					</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
	<thead>
		<tr class="row">
			<th width="200" align="left">用户</th>
			<th align="left">仓库</th>
			<th width="140" align="center">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($rsList as $key=>$userStore):?>
		<tr>
			<td align="left"><?php echo $userStore['userName'];?></td>
			<td align="left"><?php echo Store::getName(Userstore::getStoreByUserID($userStore['userID'])->storeID); ?></td>
			<td align="center" style="padding:0px;">
			<input type="button" value="修改" class="grid_button grid_button_s" onclick="Store.editUserStore(<?php echo $userStore['userID'].",".$userStore['storeID'];?>)">
			<input type="button" value="删除" class="grid_button grid_button_s" onclick="Store.removeUserStore(<?php echo $userStore['userID'];?>)">
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php 
$this->beginContent("//layouts/pagination");
$this->endContent();
?>