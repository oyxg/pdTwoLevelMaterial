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
<form action="<?=Yii::app()->request->url?>" method="post" enctype="multipart/form-data" name="form" class="" id="form">
		<table align="center" class="github_tb">
			<tbody>
				<tr>
					<td align="right">二维码：</td>
					<td>
					<input type="file" name="file" id="file" />
					<br />
					<a href="/res/material_import.xls">下载模板</a></td>
				</tr>
			</tbody>
		</table>
	<div align="center">
		<button type="submit" class="grid_button grid_button_s">导入</button>
	</div>
</form>
