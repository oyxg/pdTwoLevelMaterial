<iframe  frameborder="0" src="/usematerial/selectlist.html" width="100%" scrolling="no" onload="this.style.height=frames['materialFrm'].document.body.offsetHeight+'px';" name="materialFrm"></iframe>
<div class="tag" style="margin-top:10px;"> 领料单中的物资 </div>
<iframe  frameborder="0" src="/usematerial/selectedlist.html" width="100%" scrolling="no" onload="this.style.height=frames['materialFrm2'].document.body.offsetHeight+'px';" name="materialFrm2"></iframe>
<div class="tag" style="margin-top:10px;"> 领料单的基本信息 </div>
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
							location.reload();
						});
					}
				}
			};
			$(form).ajaxSubmit(ajaxOpt);
			return false;
		});
	});

</script>
<form method="post" id="form" class="" name="form">
	<table border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr style="height: 50px;">
			<td width="60" align="right"><strong>领料性质：</strong></td>
			<td width="100"><select class="grid_text" name="nature" id="nature" style="height: 24px;width: 140px;">
					<option></option>
					<option value="qx">抢修</option>
					<option value="dx">大修</option>
				</select></td>
			</td>
			<td width="60" align="right"><strong>班组：</strong></td>
			<td width="100">
				<input type="text" name="bz" id="bz" class="grid_text" value="<?php
				$userID = User::getID();
				$user = User::model()->findByPk($userID);
				echo $user->loginName;
				?>">
<!--				<select class="grid_text" name="bz" id="bz" style="height: 24px;width: 140px;">-->
<!--					<option></option>-->
<!--					--><?php //foreach($bz as $v):?>
<!--						<option value="--><?//=$v['name'];?><!--">--><?//=$v['name'];?><!--</option>-->
<!--					--><?php //endforeach;?>
<!--				</select></td>-->
		</tr>
		<tr style="height: 30px;">
			<td width="60" align="right"><strong>项目名称：</strong></td>
			<td width="100"><input name="glPro" id="glPro" type="text" class="grid_text"  value="" /></td>
			<td align="right"><strong>项目编号：</strong></td>
			<td width="100"><input name="glProCode" id="glProCode" type="text" class="grid_text"  value="" /></td>
		</tr>
		<tr style="height: 80px;">
			<td width="70" align="right"><strong>备注：</strong></td>
			<td colspan="3"><textarea name="remark" id="remark" class="grid_text" style="width: 100%;height: 50px;"></textarea></td>
		</tr>
<!--		<tr style="height: 20px;">-->
<!--			<td width="70" align="right"><strong>附件：</strong></td>-->
<!--			<td width="100"><input id="pic" name="pic" type="file" /></td>-->
<!--			<td colspan="3" style="color: #8F8F8F">预算封面，领料单照片</td>-->
<!--		</tr>-->
		<tr style="height: 50px;">
			<td></td>
			<td><input type="submit" id="subBtn" class="grid_button" value="提交" /></td>
		</tr>
		</tbody>
	</table>

</form>
