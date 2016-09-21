<script>
$(function(){
	$("#form").submit(function(){
		var ajaxOpt={
			dataType : "json",
			error : function(){
				maya.notice.fail("服务器出现错误",null,3);	
			},
			success : function(data){
				maya.notice.close();
				if(data.status==0){
					maya.notice.fail(data.info);
				}else{
					maya.notice.success(data.info,function(){
						//location.reload();
						parent.location.reload();
					});
				}
			}
		};
		$(form).ajaxSubmit(ajaxOpt);
		return false;
	});
});

</script>
<form method="post" id="form" class="form" name="form">


	<table class="github_tb" width="100%">
		<tr>
			<td align="right">用户：</td>
			<td>
				<?php if($type=='new'):?>
					<select name="userID" id="userID">
						<option>-请选择用户-</option>
						<?php foreach (User::getUserList() as $key=>$user):
							if($user->id==1){
								continue;//超级管理员不能绑定仓库，过滤掉超级管理员
							}
							?>
							<option value="<?php echo $user->id;?>" <?=$userID==$user->id ? "selected" : ""?>><?php echo $user->userName;?></option>
						<?php endforeach;?>
					</select></td>
				<?php else:?>
					<input type="hidden" name="userID" id="userID" value="<?php echo $userID;?>" />
					<select disabled>
						<?php foreach (User::getUserList() as $key=>$user):
							if($user->id==1){
								continue;//超级管理员不能绑定仓库，过滤掉超级管理员
							}
							?>
							<option value="<?php echo $user->id;?>" <?=$userID==$user->id ? "selected" : ""?>><?php echo $user->userName;?></option>
						<?php endforeach;?>
					</select></td>
				<?php endif;?>
		</tr>
                
		<tr>
			<td align="right">仓库：</td>
			<td><div class="s3" style="height:149px;overflow-y: auto">
					<ul>
						<?php
						$stores = UserStore::getStoreByUserID($_GET['userID'])->storeID;
						$stores = explode(",",$stores);
						foreach(Store::model()->findAll() as $key=>$store):?>
							<li><input type="checkbox" name="storeID[]" value="<?= $store->storeID;?>"
										<?php
										if(in_array($store->storeID,$stores)){echo "checked=\"checked\"";}
										if($this->action->id=="edit"){echo "disabled";}
										?>> <?= $store->storeName;?></li>
						<?php endforeach;?>
					</ul>
				</div></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td><input type="submit" id="subBtn" value="提交" class="grid_button" /></td>
		</tr>
	</table>
</form>