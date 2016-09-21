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
<h3>注意事项：</h3>
<p>1.导入的物资前，请核对导入数据是否存在物资列表。如果未匹配到相同（物资名、型号、生产商）的物资会有相应提示</p>
<p>2.如果提示该仓库下未找到，可以去物资列表中添加</p>
<form action="<?=Yii::app()->request->url?>" method="post" enctype="multipart/form-data" name="form" class="" id="form">
		<table align="center" class="github_tb">
			<tbody>
				<tr>
					<td align="right">Excel：</td>
					<td>
					<input type="file" name="file" id="file" />
					<br />
					<a href="/res/mod_in_out.xls">下载模板</a></td>
				</tr>
			</tbody>
		</table>
	<div align="center">
		<button type="submit" class="grid_button grid_button_s">导入</button>
	</div>
</form>
