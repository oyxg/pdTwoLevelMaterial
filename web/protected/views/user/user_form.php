<script>
$(function(){
	$("#loginName").focus();
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
//						location.reload();
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
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top"><table width="100%" class="github_tb">
				<tr>
					<td align="right">登录名：</td>
					<td><input type="text" name="loginName" id="loginName" value="<?=$user->loginName?>" /></td>
				</tr>
				<tr>
					<td align="right">登录密码：</td>
					<td><input type="text" name="loginPassword" id="loginPassword" value="" /></td>
				</tr>
				<tr>
					<td align="right">用户姓名：</td>
					<td><input type="text" name="userName" id="userName" value="<?=$user->userName?>" /></td>
				</tr>
				<tr>
					<td align="right">英文姓名：</td>
					<td><input type="text" name="englishName" id="englishName" value="<?=$user->englishName?>" /></td>
				</tr>
				<tr>
					<td align="right">昵称：</td>
					<td><input type="text" name="nickName" id="nickName" value="<?=$user->nickName?>" /></td>
				</tr>
<!--				<tr>-->
<!--					<td align="right">登录次数：</td>-->
<!--					<td><input type="text" name="loginCount" id="loginCount" value="" /></td>-->
<!--				</tr>-->
<!--				<tr>-->
<!--					<td align="right">最后一次登录：</td>-->
<!--					<td><input type="text" name="lastLogin" id="lastLogin" value="" /></td>-->
<!--				</tr>-->
				<tr>
					<td align="right">是否禁用：</td>
					<td><input name="disabled" type="radio" value="1" <?=$user->disabled==="1" ? "checked" : ""?> />
						是
						<input name="disabled" type="radio" value="0" <?=$user->disabled==="0"||$user->disabled===null ? "checked" : ""?> />
						否</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" id="subBtn" class="grid_button grid_button_s" value="提交" /></td>
				</tr>
			</table></td>
			<td valign="top" style="padding-left:10px;"><table width="100%" class="github_tb">
				<tr>
					<td align="right">角色：</td>
					<td>
						<select name="role" id="role" <?=$this->action->id=="edit" ? "disabled" : ""?>>
						<?php foreach($roleList as $key=>$item):?>
							<option value="<?php echo $item->getName();?>" <?php echo Auth::has($item->getName(),$user->id)==true ? "selected" : "";?>><?php echo $item->getDescription();?></option>
						<?php endforeach;?>
						</select></td>
				</tr>
				<tr>
					<td align="right">所属仓库：</td>
					<td>
						<div class="s3" style="height:149px;overflow-y: auto">
							<ul>
								<?php
								$stores = UserStore::getStoreByUserID($_GET['userID'])->storeID;
								$stores = explode(",",$stores);
								foreach($storeList as $key=>$store):?>
									<li><input type="checkbox" name="storeID[]" value="<?= $store->storeID;?>"
									<?php
									if(in_array($store->storeID,$stores)){echo "checked=\"checked\"";}
									if($this->action->id=="edit"){echo "disabled";}
									?>> <?= $store->storeName;?></li>
								<?php endforeach;?>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><?=$this->action->id=="edit" ? "不允许修改角色和仓库，请到其他窗口中操作" : ""?>&nbsp;</td>
				</tr>
			</table></td>
		</tr>
	</table>
</form>
