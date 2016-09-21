<script type="text/javascript" src="/plugin/JSON/json2.js"></script>
<script>
function createAppendOrder(){
	var list=$(':checkbox[alt=select]:checked');
	if(list.length==0){
		maya.notice.fail("请选择物资");
		return;	
	}
	var data=new Array();
	$.each(list,function(index,value){
		data.push({
			materialID : value.value,
			number : $("#number_"+value.value).val()	
		});
	});
        
        
        window.open("/append/add.html?data="+JSON.stringify(data));
        
//	$.post(
//		"/append/add.html",
//		{
//			"data" : JSON.stringify(data),
//			"handlerUserID" : $("#handlerUserID").val()
//		},
//		function(data){
//			if(data.status==1){
//				maya.notice.success(data.info,function(){
//					location.reload();
//				});
//			}else{
//				maya.notice.fail(data.info);
//			}
//		}
//	);
}
</script>

<div id="w" class="easyui-window" title="请选择接收此补库单的专职人员" data-options="closed:true" style="width:300px;padding:10px;"> 专职：
	<select name="handlerUserID" id="handlerUserID"  style="width:120px;">
		<?php foreach (User::getListByItem(AI::R_Pro) as $key=>$user):?>
		<option value="<?php echo $user->id;?>" ><?php echo $user->userName;?></option>
		<?php endforeach;?>
	</select>
	<input type="button" value="确定" class="grid_button grid_button_s" onclick="createAppendOrder()">
</div>
<div class="control_tb">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="400"><?php 
				$this->beginContent("//layouts/breadcrumbs");
				$this->endContent();
				?></td>
				<td align="right"><form method="get" action="<?=Yii::app()->createUrl("material/warning")?>">
						名称：
						<input class="grid_text" name="goodsName" value="<?php echo $_GET['goodsName'];?>">
						<!--分类：
						<select name="category" id="category" onchange="Goods.callGetAjaxTypeList(this.value,true);">
							<option value="">不限</option>
							<?php foreach (Goods::getCategoryList() as $key=>$value):?>
							<option value="<?php echo $key;?>" <?=$key==$_GET['category'] ? "selected=\"selected\"" : ""?>><?php echo $value;?></option>
							<?php endforeach;?>
						</select> -->
						类型：
						<!--<select name="type" id="type">
							<option value="">不限</option>
						</select> -->
						<input type="text" name="style" id="style" value="<?=$_GET['style']?>" class="easyui-combobox" data-options="valueField:'value',textField:'label',url:'/goods/stylecombobox',panelHeight:100" />
						<input type="submit" value="查询" class="grid_button grid_button_s">
					</form></td>
			</tr>
		</tbody>
	</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
	<thead>
		<tr class="row">
			<th width="40" align="center"> <input type="checkbox" onclick="$(':checkbox[alt=select]').attr('checked',($(this).attr('checked')=='checked' ? true : false));;"></th>
			<th width="70" align="center">补库数量</th>
			<th width="180" align="left">名称</th>
			<th align="left">型号</th>
			<th width="60" align="center">当前库存</th>
			<th width="60" align="center">库存定额</th>
                                        <th width="60" align="center">生产厂家</th>
                                                <th width="60" align="center">供货商</th>
			<th width="60" align="center">管理分类</th>
			<th width="60" align="center">单位</th>
			<th width="70" align="center">类型</th>
			<th width="90" align="left">货架编码</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($rsList as $key=>$rs):?>
		<tr>
			<td align="center"><input alt="select" type="checkbox" value="<?=$rs['materialID']?>"></td>
			<td align="center"><input type="number" max="9999" id="number_<?=$rs['materialID']?>" min="1" value="<?=$rs['minCount']-$rs['currCount']?>" size="5" maxlength="4" class="grid_text"></td>
			<td align="left"><?=$rs['goodsName']?></td>
			<td align="left"><?=$rs['property']?></td>
			<td align="center"><?=$rs['currCount']?></td>
			<td align="center"><?=$rs['minCount']?></td>
                        			<td align="center"><?=$rs['factory']?></td>
                        <td align="center"><?php echo Main::model()->find(" gid= {$rs['goodsID']}")->ghs; ?></td>
<td align="center"><?php echo $rs['mtype']=='1'?'重点物资':'备品物资'; ?></td>
			<td align="center"><?=$rs['unit']?></td>
			<td align="center"><?=Goods::getStyleLabel($rs['style'])?></td>
			<td align="left"><?=$rs['position']?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<div align="center" style="padding:15px;">
	<input type="button" onclick="createAppendOrder();" value="将选中的生成补库单" class="grid_button grid_button_l">
</div>
