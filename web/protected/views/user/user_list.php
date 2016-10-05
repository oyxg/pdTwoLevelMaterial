<script type="text/javascript" src="/plugin/module/user.js"></script>
<script type="text/javascript" src="/plugin/module/auth.js"></script>
<script>
$(function(){
	
});
</script>
<?php
//bugfix start
clean_xss($_GET['userName']);
clean_xss($_GET['loginName']);
//bugfix end
?>
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
					<form method="get" action="<?=Yii::app()->createUrl("user/list")?>">
						姓名：
						<input class="grid_text" name="userName" value="<?php echo $_GET['userName'];?>">
						登录名：
						<input class="grid_text" name="loginName" value="<?php echo $_GET['loginName'];?>">
						仓库：
						<select name="storeID" id="storeID" >
							<option></option>
							<?php foreach(Store::model()->findAll() as $key=>$store):?>
							<option value="<?php echo $store->storeID;?>" <?=$storeID==$store->storeID ? "selected" : ""?>><?php echo $store->storeName;?></option>
							<?php endforeach;?>
						</select>
						<input type="submit" value="查询" class="grid_button grid_button_s">
						<input type="button" value="添加用户" class="grid_button grid_button_s" onclick="User.add()">
					</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
	<thead>
		<tr class="row">
			<th width="100" align="left">姓名</th>
			<th align="left">登录名</th>
			<th align="left">角色</th>
			<th align="left">所属仓库</th>
			<th width="140" align="center">上次登录</th>
			<th width="90" align="center">登录次数</th>
			<th width="90" align="center">是否禁用</th>
			<th width="220" align="center">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($rsList as $key=>$user):?>
		<tr>

			<td align="left"><?php echo $user->userName;?></td>
			<td align="left"><?php echo $user->loginName?></td>
            <td align="left"><?php echo Auth::getRoleToString($user->id)?></td>
            <td align="left"><?php echo Store::getName(Userstore::getStoreByUserID($user->id)->storeID); ?></td>
			<td align="center"><?php echo $user->lastLogin;?></td>
			<td align="center"><?php echo $user->loginCount;?></td>
			<td align="center"><?php echo $user->disabled==0?'否':'是';?></td>
			<td align="left" >
				<input type="button" value="修改" class="grid_button grid_button_s" onclick="User.edit(<?php echo $user->id;?>,function(){location.reload();})">
				<input type="button" value="删除" class="grid_button grid_button_s" onclick="User.remove(<?php echo $user->id;?>,function(){location.reload();})">
				<input type="button" value="权限" class="grid_button grid_button_s" onclick="Auth.editItemUser(<?php echo $user->id;?>,function(){location.reload();})">
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php 
$this->beginContent("//layouts/pagination");
$this->endContent();
?>