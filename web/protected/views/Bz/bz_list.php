<script type="text/javascript" src="/plugin/module/bz.js"></script>
<script type="text/javascript" src="/plugin/module/tool.js"></script>
<script>

</script>
<div class="control_tb">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td width="400"><?php
                    $this->beginContent("//layouts/breadcrumbs");
                    $this->endContent();
                    ?></td>
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("bz/list") ?>">
                        名称：
                        <input class="grid_text" name="name" value="">
                        <input type="submit" value="查询" class="grid_button grid_button_s">
                        <?php if (Auth::has(AI::C_Bz)): ?>
                            <input type="button" id="addItemBtn" value="添加班组" class="grid_button" onclick="Bz.add()">
                        <?php endif; ?>	
                    </form></td>
            </tr>
        </tbody>
    </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
        <tr >
            <th width="100" align="left">仓库名称</th>
     
            <th width="120" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rsList as $key => $bz): ?>
            <tr>
                <td align="left"><?php echo $bz->name; ?></td>
                <td align="left" style="padding:5px;">
        			<div class="grid_menu_panel" style="width:120px">
					<div class="grid_menu_btn">操作</div>
					<div class="grid_menu">
						<ul>
				<li><a href="#" rel="edit" onclick="Bz.edit(<?php echo $bz->id;?>)">修改</a></li>
				<li><a href="#" rel="edit" onclick="Bz.remove(<?php echo $bz->id;?>,function(){location.reload();})">删除数据</a></li>

			</ul>
					</div>
				</div></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>
