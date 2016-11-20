<script type="text/javascript" src="/plugin/module/auth.js"></script>
<script>
$(function(){
	$("a[rel=itemChildAdd]").click(function(){
		Auth.addItemChild($(this).attr("item-name"));
	});
	$("a[rel=itemEdit]").click(function(){
		Auth.editItem($(this).attr("item-name"));
	});
	
	$("a[rel=itemChildRemove]").click(function(){
		Auth.removeItemChild($(this).attr("item-name"),function(){
			location.reload();	
		});
	});
	
});
</script>
<?php
//bugfix start
//clean_xss($_GET['name']);
//bugfix end
?>
<div class="control_tb">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="400">
				<?php 
				$this->beginContent("//layouts/breadcrumbs");
				$this->endContent();
				?>
				</td>
				<td align="right"><form id="form" method="get" action="<?=Yii::app()->createUrl("auth/itemlist")?>">
					<input type="hidden" name="type" id="type" />
						名称：
						<input class="grid_text" name="name" value="<?php echo $_GET['name'];?>">
						<input type="submit" value="查询" class="grid_button grid_button_s">
						<input type="button" value="角色" class="grid_button grid_button_s" onclick="Auth.setFormType('2')">
						<input type="button" value="任务" class="grid_button grid_button_s" onclick="Auth.setFormType('1')">
						<input type="button" value="操作" class="grid_button grid_button_s" onclick="Auth.setFormType('0')">
						<input type="button" value="添加项目" class="grid_button grid_button_s" onclick="Auth.addItem()">
					</form></td>
			</tr>
		</tbody>
	</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
	<thead>
		<tr class="row">
			<th width="100" align="left">项目名称</th>
			<th width="90" align="left">项目类型</th>
			<th align="left">描述</th>
			<th align="left">业务规则</th>
			<th align="left">附加数据</th>
			<th width="160" align="center">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($rsList as $key=>$auth):?>
		<tr>
			<td align="left"><?php echo $auth->name;?></td>
			<td align="left"><?php echo AuthItem::getTypeName($auth->type);?></td>
			<td align="left"><?php echo $auth->description;?></td>
			<td align="left"><?php echo $auth->bizrule;?></td>
			<td align="left"><?php echo $auth->data;?></td>
			<td align="left" >
			<?php if($auth->type==AuthItem::TYPE_OPERATIONS):?>
			添加子项
			<?php else:?>
			<a href="#" rel="itemChildAdd" item-name="<?php echo urlencode($auth->name);?>">添加子项</a>
			<?php endif;?>
			<a href="#" rel="itemEdit" item-name="<?php echo urlencode($auth->name);?>">修改</a>
			<a href="#" rel="itemChildRemove" item-name="<?php echo ($auth->name);?>">删除</a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php 
$this->beginContent("//layouts/pagination");
$this->endContent();
?>