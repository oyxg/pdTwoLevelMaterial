<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>

<script>
    $(function () {

        //修改缓存中的物资信息
        $("a[rel=edit]").click(function(){
            Material.editPreFloodIn($(this).attr('code'));
        });

        //添加物资
        $("button[rel=add]").click(function(){
            Material.addPreFloodIn();
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
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("PreFloodMaterial/PreFloodList") ?>">
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
                        <input type="submit" value="查询" class="grid_button grid_button_s">
                        <button type="button" rel="add" class="grid_button">入库</button>
                    </form></td>
            </tr>
        </tbody>
    </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
        <tr class="row">
            <th align="left">班组</th>
            <th align="left">物资名称</th>
            <th align="left">出厂编号</th>
            <th align="center">单价</th>
            <th align="center">单位</th>
            <th align="center">数量</th>
            <th align="left">厂家</th>
            <th align="left">联系人</th>
            <th align="left">联系方式</th>
            <th align="left">项目编号</th>
            <th align="left">项目名称</th>
            <th align="left">工单号</th>
            <th align="left">ERP领料单</th>
            <th align="left">附件</th>
            <th align="center">状态</th>
            <th width="70" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rsList as $key => $v): ?>
        <tr>
            <td align="left"><?php echo PreFloodIn::getBz($v->bzID); ?></td>
            <td align="left"><?php echo $v->name; ?></td>
            <td align="left"><?php echo $v->bh; ?></td>
            <td align="center"><?php echo $v->price; ?></td>
            <td align="center"><?php echo $v->unit; ?></td>
            <td align="center"><?php echo $v->num; ?></td>
            <td align="left"><?php echo $v->factory; ?></td>
            <td align="left"><?php echo $v->contact; ?></td>
            <td align="left"><?php echo $v->tel; ?></td>
            <td align="left"><?php echo $v->projectCode; ?></td>
            <td align="left"><?php echo $v->projectName; ?></td>
            <td align="left"><?php echo $v->workCode; ?></td>
            <td align="left"><?php echo $v->erpLL; ?></td>
            <td align="left"><?php echo $v->file; ?></td>
            <td align="center"><?php echo PreFloodIn::getState($v->state); ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" code="<?php echo $v-InID; ?>" rel="edit">修改</a></li>
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