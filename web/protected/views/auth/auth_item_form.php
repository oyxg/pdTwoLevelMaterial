<script>
$(function(){
	$("#name").focus();
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
						$("#name").focus();
						//location.reload();
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
	<table width="100%" class="github_tb">
		<tr>
			<td align="right">项目名称：</td>
			<td><input type="text" name="name" id="name" value="<?=isset($auth_item) ? $auth_item->getName() : ""?>" /><input type="hidden" name="oldName" id="oldName" value="<?=isset($auth_item) ? $auth_item->getName() : ""?>" /></td>
		</tr>
		<tr>
			<td align="right">项目类型：</td>
			<td>
			<select name="type" id="type">
			<?php foreach (AuthItem::getTypeList() as $key=>$value):?>
			<option value="<?php echo $key;?>" <?=$key==(isset($auth_item) ? $auth_item->getType() : "") ? "selected=\"selected\"" : ""?>><?php echo $value;?></option>
			<?php endforeach;?>
			</select></td>
		</tr>
		<tr>
			<td align="right">任务选项：</td>
			<td><label for="other"><input style="position:relative;top:2px;" type="checkbox" name="other" id="other" value="yes" />
			增加（列表、增加、删除、修改）操作			</label></td>
		</tr>
		<tr>
			<td align="right">操作绑定任务：</td>
			<td>
				<label>
					<input type="radio" name="bindTask" value="1" id="bindTask_0" />
					是</label> 
				<label>
					<input type="radio" name="bindTask" value="0" id="bindTask_1" />
					否</label></td>
		</tr>
		<tr>
			<td align="right">描述：</td>
			<td><input type="text" name="description" id="description" value="<?php if(isset($auth_item)){echo $auth_item->getDescription();}?>" /></td>
		</tr>
		<tr>
			<td align="right">业务规则：</td>
			<td><textarea name="bizrule" rows="4" id="bizrule"><?php if(isset($auth_item)){echo $auth_item->getBizRule();}?></textarea></td>
		</tr>
		<tr>
			<td align="right">附加数据：</td>
			<td><textarea name="data" rows="4" id="data"><?php if(isset($auth_item)){echo $auth_item->getData();}?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" id="subBtn" value="提交" class="grid_button grid_button_s" /></td>
		</tr>
	</table>
</form>
