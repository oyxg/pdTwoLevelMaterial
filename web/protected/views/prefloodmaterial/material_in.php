<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>

<script>
    $(function () {

        //修改缓存中的物资信息
        $("a[rel=edit]").click(function(){
            Material.editPreFloodIn($(this).attr('code'));
        });

        //附件
        $("a[rel=file]").click(function(){
            Material.PreFloodFile($(this).attr('code'));
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
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("PreFloodMaterial/PreFloodIn") ?>">
                    <table>
                        <tr>
                            <tb>
                                项目编号：
                                <input class="grid_text" name="projectCode" value="<?php echo $_GET['projectCode']; ?>">
                                项目名称：
                                <input class="grid_text" name="projectName" value="<?php echo $_GET['projectName']; ?>">
                                班组：
                                <select  name="bzID" id="bzID" type="text" class="grid_text" style="height: 24px;">
                                    <option value=""></option>
                                    <?php
                                    $PreFlood = new PreFloodIn();
                                    $bzs = $PreFlood->getBzList();
                                    for($i=0;$i<count($bzs);$i++): ?>
                                        <option value="<?=$i?>"<?php if(!empty($_GET['bzID'])&&$i==$_GET['bzID'])echo "selected";?>><?=$bzs[$i]?></option>
                                    <?php endfor;?>
                                </select>
                            </tb>
                        </tr>
                        <tr>
                            <td>
                                厂家：
                                <input class="grid_text" name="factory" value="<?php echo $_GET['factory']; ?>">
                                物资名称：
                                <input class="grid_text" name="name" value="<?php echo $_GET['name']; ?>">
                                <input type="submit" value="查询" class="grid_button grid_button">
                            </td>
                        </tr>
                        </table>
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
            <td align="center"><?php echo PreFloodIn::getState($v->state); ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" code="<?php echo $v->InID; ?>" rel="edit">修改</a></li>
                            <li class="icon_015"><a href="#" code="<?php echo $v->InID; ?>" rel="file">附件</a></li>
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