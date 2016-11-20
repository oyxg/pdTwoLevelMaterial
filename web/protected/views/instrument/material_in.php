<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>

<script>
    $(function () {

        //修改
        $("a[rel=edit]").click(function(){
            Material.editInstrumentIn($(this).attr('code'));
        });

        //附件
        $("a[rel=file]").click(function(){
            Material.InstrumentFile($(this).attr('code'));
        });

    });
</script>
<div class="control_tb">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td width="300">
                    <?php
                    $this->beginContent("//layouts/breadcrumbs");
                    $this->endContent();
                    ?>
                </td>
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("Instrument/InstrumentIn") ?>">
                    <table>
                        <tr>
                            <td>
                                项目编号：
                                <input class="grid_text" name="projectCode" value="<?php echo $_GET['projectCode']; ?>">
                                项目名称：
                                <input class="grid_text" name="projectName" value="<?php echo $_GET['projectName']; ?>">
                                物资编码：
                                <input class="grid_text" name="materialCode" value="<?php echo $_GET['materialCode']; ?>">
                                物资名称：
                                <input class="grid_text" name="name" value="<?php echo $_GET['name']; ?>">
                                资产卡号：
                                <input class="grid_text" name="card" value="<?php echo $_GET['card']; ?>">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                设备编号：
                                <input class="grid_text" name="equCode" value="<?php echo $_GET['equCode']; ?>">
                                SAP编号：
                                <input class="grid_text" name="SAP" value="<?php echo $_GET['SAP']; ?>">
                                生产厂家：
                                <input class="grid_text" name="factory" value="<?php echo $_GET['factory']; ?>">
                                存放地点：
                                <select class="grid_text" name="storeAddress" style="height: 24px;">
                                    <option></option>
                                    <?php
                                    $Instrument = new InstrumentIn();
                                    $bzs = $Instrument->getBzList();
                                    for($i=0;$i<count($bzs);$i++): ?>
                                        <option value="<?=$i?>"<?php if($_GET['storeAddress']!=''&&$i==$_GET['storeAddress'])echo "selected";?>><?=$bzs[$i]?></option>
                                    <?php endfor;?>
                                </select>
                                状态：
                                <select class="grid_text" name="state" style="height: 24px;width: 60px;">
                                    <option></option>
                                    <option value="zc" <?php if($_GET['state']=='zc')echo "selected";?>>正常</option>
                                    <option value="send" <?php if($_GET['state']=='send')echo "selected";?>>送修</option>
                                    <option value="scrap" <?php if($_GET['state']=='scrap')echo "selected";?>>报废</option>
                                </select>
                                <input type="submit" value="查询" class="grid_button grid_button_s">
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
            <th align="left">物资分类</th>
            <th align="left">物资名称</th>
            <th align="center">存放地点</th>
            <th align="center">领用数量</th>
            <th align="left">物资编码</th>
            <th align="left">项目编号</th>
            <th align="left">项目名称</th>
            <th align="left">设备编号</th>
            <th align="left">资产卡号</th>
            <th align="left">SAP编号</th>
            <th align="left">生产厂家</th>
            <th align="left">生产编号</th>
            <th align="center">生产日期</th>
            <th align="left">配送单位</th>
            <th align="left">联系人</th>
            <th align="left">联系电话</th>
            <th align="center">状态</th>
            <th width="70" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rsList as $key => $v): ?>
        <tr>
            <td align="left"><?php echo $v->className; ?></td>
            <td align="left"><?php echo $v->name; ?></td>
            <td align="center"><?php echo InstrumentIn::getBz($v->storeAddress); ?></td>
            <td align="center"><?php echo $v->num; ?></td>
            <td align="left"><?php echo $v->materialCode; ?></td>
            <td align="left"><?php echo $v->projectCode; ?></td>
            <td align="left"><?php echo $v->projectName; ?></td>
            <td align="left"><?php echo $v->equCode; ?></td>
            <td align="left"><?php echo $v->card; ?></td>
            <td align="left"><?php echo $v->SAP; ?></td>
            <td align="left"><?php echo $v->factory; ?></td>
            <td align="left"><?php echo $v->factoryCode; ?></td>
            <td align="center"><?php echo $v->factoryDate=='0000-00-00'?'':$v->factoryDate; ?></td>
            <td align="left"><?php echo $v->distribution; ?></td>
            <td align="left"><?php echo $v->contact; ?></td>
            <td align="left"><?php echo $v->tel; ?></td>
            <td align="center"><?php echo InstrumentIn::getState($v->state); ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" code="<?php echo $v->inID; ?>" rel="edit">修改</a></li>
                            <li class="icon_015"><a href="#" code="<?php echo $v->inID; ?>" rel="file">附件</a></li>
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