<iframe  frameborder="0" src="/material/selectlist.html" width="100%" scrolling="no" onload="this.style.height=frames['materialFrm'].document.body.offsetHeight+'px';" name="materialFrm"></iframe>
<div class="tag" style="margin-top:10px;"> 移库单中的设备 </div>
<iframe  frameborder="0" src="/material/selectedlist.html" width="100%" scrolling="no" onload="this.style.height=frames['materialFrm2'].document.body.offsetHeight+'px';" name="materialFrm2"></iframe>
<div class="tag" style="margin-top:10px;"> 移库单的基本信息 </div>
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
	<table width="100%"  class="github_tb">
		<tr>
			<td align="right">移库日期：</td>
			<td><input class="grid_text" name="date" id="date" type="date"  value="<?php echo date('Y-m-d');?>"></td>
		</tr>
		<tr>
			<td align="right">移入仓库：</td>
			<td><select class="grid_text" name="storeID" id="storeID" style="height: 24px">
					<option></option>
					<?php
					$store = Store::model()->findAll();
					foreach($store as $key=>$val){
						echo "<option value=\"{$val->storeID}\">{$val->storeName}</option>";
					}
					?>
				</select></td>
		</tr>
		<tr>
			<td align="right">批次号：</td>
			<td><input name="batchCode" id="batchCode" type="text" class="grid_text"  value="<?= $inForm->batchCode?>" /></td>
		</tr>
		<tr>
			<td width="100" align="right">备注：</td>
			<td><input name="remark" id="remark" type="text" class="grid_text" value="<?= $inForm->remark?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" id="subBtn" class="grid_button" value="提交" /></td>
		</tr>
	</table>
</form>
