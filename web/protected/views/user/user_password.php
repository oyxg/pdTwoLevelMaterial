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
	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="github_tb">
		<tr>
			<td align="right"><strong>原密码：</strong></td>
			<td><label for="srcPwd"></label>
				<input type="password" name="srcPwd" id="srcPwd" autocomplete="off"></td>
		</tr>
		<tr>
			<td align="right"><strong>新密码：</strong></td>
			<td><label for="newPwd1"></label>
				<input type="password" name="newPwd1" id="newPwd1" autocomplete="off"></td>
		</tr>
		<tr>
			<td align="right"><strong>确认新密码：</strong></td>
			<td><label for="newPwd2"></label>
				<input type="password" name="newPwd2" id="newPwd2" autocomplete="off"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="button" id="button" value="提交"  class="grid_button grid_button_s" ></td>
		</tr>
	</table>
</form>
