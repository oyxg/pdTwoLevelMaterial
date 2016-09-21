<script type="text/javascript" src="/plugin/module/store.js"></script>
<script type="text/javascript" src="/plugin/module/spare.js"></script>
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
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("store/list") ?>">
                        名称：
                        <input class="grid_text" name="storeName" value="">
                        <input type="submit" value="查询" class="grid_button grid_button_s">
                        <?php if (Auth::has(AI::C_StoreAdd)): ?>
                            <input type="button" id="addItemBtn" value="添加仓库" class="grid_button" onclick="Store.add()">
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
        <?php foreach ($rsList as $key => $store): ?>
            <tr>
                <td align="left"><?php echo $store->storeName; ?></td>
                <td align="left" style="padding:5px;">
        			<div class="grid_menu_panel" style="width:120px">
					<div class="grid_menu_btn">操作</div>
					<div class="grid_menu">
						<ul>
				<?php if (Auth::has(AI::C_StoreEdit)):?>
				<li><a href="#" rel="edit" onclick="Store.edit(<?php echo $store->storeID;?>)">修改</a></li>
				<?php endif;?>
				<?php if (Auth::has(AI::C_StoreDelete)):?>
				<li><a href="#" rel="edit" onclick="Store.remove(<?php echo $store->storeID;?>,function(){location.reload();})">删除数据</a></li>
				<?php endif;?>

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
