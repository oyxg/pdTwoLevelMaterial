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
	
	$('#qrCode').focus();
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
<form id="form" name="form" class="" method="post" >
		<table align="center" class="github_tb">
			<tbody>
				<tr>
					<td align="right">二维码：</td>
					<td><input name="qrCode" id="qrCode" class="grid_text" style="" onkeyup="qrScan(this,true,function(){$('#number').focus();})" value="">
					<input type="button" onclick="$('#qrCode').attr('value','');$('#qrCode').focus();" class="grid_button grid_button" value="清空"></td>
				</tr>
<!--				<tr class="row">
					<td width="100" align="right">设备编号：</td>
					<td><input name="number" id="number" type="text" class="grid_text"  value=""></td>
				</tr>-->
                <tr class="row">
					<td width="100" align="right">入库数量：</td>
					<td><input name="count" id="count" type="text" class="grid_text"  value="1"></td>
            	</tr>
			</tbody>
		</table>
	<div align="center">
		<button type="submit" class="grid_button grid_button_l">确定入库</button>
	</div>
</form>
