<iframe  frameborder="0" src="/task/selectlist.html" width="100%" scrolling="no" onload="this.style.height=frames['materialFrm'].document.body.offsetHeight+'px';" name="materialFrm"></iframe>
<div class="tag" style="margin-top:10px;"> 任务书中的物资 </div>
<iframe  frameborder="0" src="/task/selectedlist.html" width="100%" scrolling="no" onload="this.style.height=frames['materialFrm2'].document.body.offsetHeight+'px';" name="materialFrm2"></iframe>
<div class="tag" style="margin-top:10px;"> 任务书基本信息 </div>
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

		//日历插件
		$("#date").calendar({
			format : "yyyy-MM-dd"
		});
	});

</script>
<form method="post" id="form" class="" name="form">
	<table border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr height="30">
			<td width="90" align="right"><strong>施工日期：</strong></td>
			<td width="170"><input name="date" type="text" class="grid_text" value="" id="date" /></td>
			<td width="90" align="right"><strong>责任单位：</strong></td>
			<td width="170"><input name="zrdw" type="text" class="grid_text" value="" /></td>
			<td width="90" align="right"><strong>责任班组：</strong></td>
			<td width="170"><input name="zrbz" type="text" class="grid_text" value="" /></td>
			<td width="90" align="right"><strong>配合单位：</strong></td>
			<td width="170"><input name="phdw" type="text" class="grid_text" value="" /></td>
		</tr>
		<tr height="30">
			<td width="120" align="right"><strong>线路及设备名称：</strong></td>
			<td width="390px" colspan="4"><input style="width:390px;" name="line" type="text" class="grid_text" value="" /></td>
		</tr>
		<tr height="58">
			<td width="90" align="right"><strong>消缺内容：</strong></td>
			<td colspan="9"><textarea name="content" style="width:900px;height: 50px;" class="grid_text"></textarea></td>
		</tr>
		<tr style="height: 50px;">
			<td></td>
			<td><input type="submit" id="subBtn" class="grid_button" value="提交" /></td>
		</tr>
		</tbody>
	</table>

</form>
<!-- 日历插件js & css -->
<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>