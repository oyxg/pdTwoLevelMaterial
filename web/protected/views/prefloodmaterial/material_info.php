<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>
<style>
    .xc{display: none;}
</style>
<script>
    $(function () {
        //修改缓存中的物资信息
        $("a[rel=edit]").click(function(){
            Material.editPreFloodInfo($(this).attr('code'));
        });
        //添加物资
        $("button[rel=add]").click(function(){
            Material.addPreFloodInfo();
        });
        //设置班组需求
        $("a[rel=need]").click(function(){
            Material.setPreFloodNeed($(this).attr('code'));
        });
    });
</script>
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
                <td align="right">
                    <form method="get" action="<?= Yii::app()->createUrl("PreFloodMaterial/PreFloodInfo") ?>">
                        <table>
                        <tr>
                            <td>
                                分类：
                                <select class="grid_text" name="className" id="className" style="height: 24px">
                                    <option></option>
                                    <?php
                                    $PreFlood = new PreFloodInfo();
                                    $types = $PreFlood->model()->getType();
                                    foreach($types as $type): ?>
                                        <option value="<?=$type?>"<?php if($type==$_GET['className'])echo "selected";?>><?=$type?></option>
                                    <?php endforeach;?>
                                </select>
                                物资名称：
                                <input class="grid_text" name="name" value="<?php echo $_GET['name']; ?>">
                                配置级别：
                                <input class="grid_text" name="pzlevel" value="<?php echo $_GET['pzlevel']; ?>">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                厂家：
                                <input class="grid_text" name="factory" value="<?php echo $_GET['factory']; ?>">
                                出厂编号：
                                <input class="grid_text" name="bh" value="<?php echo $_GET['bh']; ?>">
                                联系人：
                                <input class="grid_text" name="contact" value="<?php echo $_GET['contact']; ?>">
                                <input type="submit" value="查询" class="grid_button grid_button_s">
                                <button type="button" rel="add" class="grid_button">新增</button>
                            </td>
                        </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
        <tr class="row">
            <th align="left">分类</th>
            <th align="left">物资名称</th>
            <th align="left">规格型号</th>
            <th align="left">单位</th>
            <th align="center">单价</th>
            <th align="left">技术规范</th>
            <th align="left">配置级别</th>
            <th align="left">配置标准</th>
            <th align="left">厂家</th>
            <th align="left">出厂编号</th>
            <th align="left">联系人</th>
            <th align="left">联系方式</th>
            <th align="left">备注</th>
            <th width="100" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $v):
        ?>
        <tr>
            <td align="left"><?php echo $v->className; ?></td>
            <td align="left"><?php echo $v->name; ?></td>
            <td align="left"><?php echo $v->standard; ?></td>
            <td align="left"><?php echo $v->unit; ?></td>
            <td align="center"><?php echo $v->price; ?></td>
            <td align="left"><?php echo $v->jsgf; ?></td>
            <td align="left"><?php echo $v->pzlevel; ?></td>
            <td align="left"><?php echo $v->configure; ?></td>
            <td align="left"><?php echo $v->factory; ?></td>
            <td align="left"><?php echo $v->bh; ?></td>
            <td align="left"><?php echo $v->contact; ?></td>
            <td align="left"><?php echo $v->tel; ?></td>
            <td align="left"><?php echo $v->remark; ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" code="<?php echo $v->id; ?>" rel="edit">修改</a></li>
                            <li class="icon_015"><a href="#" code="<?php echo $v->id; ?>" rel="need">各班需求</a></li>
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