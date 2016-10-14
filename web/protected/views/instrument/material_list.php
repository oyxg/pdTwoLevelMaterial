<script type="text/javascript" src="/plugin/module/material.js"></script>
<style>
    .qha{display: none;}
</style>

<script>
    $(function () {

        //切換
        $("button[rel=change]").click(function(){
            $('th').each(function(){
                if($(this).attr('class')=='qha'){
                    $(this).toggle();
                }
                if($(this).attr('class')=='qhb'){
                    $(this).toggle();
                }
            });
            $('td').each(function(){
                if($(this).attr('class')=='qha'){
                    $(this).toggle();
                }
                if($(this).attr('class')=='qhb'){
                    $(this).toggle();
                }
            });
        });

        //添加
        $("button[rel=add]").click(function(){
            Material.addInstrument();
        });

        //修改
        $("a[rel=edit]").click(function(){
            Material.editInstrument($(this).attr('code'));
        });

        //删除
        $("a[rel=del]").click(function(){
            Material.delInstrument($(this).attr('code'));
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
                <td width="270">
                    <?php
                    $this->beginContent("//layouts/breadcrumbs");
                    $this->endContent();
                    ?>
                </td>
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("Instrument/InstrumentList") ?>">
                    <table>
                        <tr>
                            <td>
                                项目编号：
                                <input class="grid_text" name="projectCode" value="<?php echo $_GET['projectCode']; ?>">
                                项目名称：
                                <input class="grid_text" name="projectName" value="<?php echo $_GET['projectName']; ?>">
                                物料编码：
                                <input class="grid_text" name="materialCode" value="<?php echo $_GET['materialCode']; ?>">
                                物料名称：
                                <input class="grid_text" name="materialName" value="<?php echo $_GET['materialName']; ?>">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                设备编号：
                                <input class="grid_text" name="equCode" value="<?php echo $_GET['equCode']; ?>">
                                SAP编号：
                                <input class="grid_text" name="SAP" value="<?php echo $_GET['SAP']; ?>">
                                生产产家：
                                <input class="grid_text" name="factory" value="<?php echo $_GET['factory']; ?>">
                                规格型号：
                                <input class="grid_text" name="standard" value="<?php echo $_GET['standard']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                资产卡片号：
                                <input class="grid_text" name="card" value="<?php echo $_GET['card']; ?>">
                                存放地点：
                                <select class="grid_text" name="storeAddress" style="height: 24px;width: 124px;">
                                    <option></option>
                                    <?php foreach (Store::getCategoryList() as $value): ?>
                                        <option value="<?php echo $value['storeID']; ?>" <?= $value['storeID'] == $_GET['storeAddress'] ? "selected=\"selected\"" : "" ?>><?php echo $value['storeName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                状态：
                                <select class="grid_text" name="state" style="height: 24px;width: 60px;">
                                    <option></option>
                                    <option value="zc" <?php if($_GET['state']=='zc')echo "selected";?>>正常</option>
                                    <option value="send" <?php if($_GET['state']=='send')echo "selected";?>>送修</option>
                                    <option value="scrap" <?php if($_GET['state']=='scrap')echo "selected";?>>报废</option>
                                </select>
                                <input type="submit" value="查询" class="grid_button grid_button_s">
                                <button type="button" rel="add" class="grid_button">添加</button>
                                <button type="button" rel="change" class="grid_button">切換隐藏字段</button>
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
            <th align="left">资产分类</th>
            <th align="left">存放地点</th>
            <th align="left">物料名称</th>
            <th align="center">数量</th>
            <th align="center">单位</th>
            <th align="center">单价</th>
            <th align="left">规格型号</th>

            <th align="left" class="qhb" style="border-left:2px #999 dashed">项目名称</th>
            <th align="center"  class="qhb">项目编号</th>
            <th align="center" class="qhb">物料编码</th>
            <th align="center" class="qhb">资产卡片号</th>
            <th align="center" class="qhb">设备编号</th>
            <th align="center" class="qhb" style="border-right:2px #999 dashed">SAP编号</th>

            <th align="left" class="qha" style="border-left:2px #999 dashed">生产厂家</th>
            <th align="center" class="qha">出厂编号</th>
            <th align="center" class="qha">出厂时间</th>
            <th align="left" class="qha">配送单位</th>
            <th align="left" class="qha">联系人</th>
            <th align="center" class="qha" style="border-right:2px #999 dashed">联系电话</th>

            <th align="center">状态</th>
            <th align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rsList as $key => $v): ?>
        <tr>
            <td align="center"><?php echo $v->class; ?></td>
            <td align="left"><?php echo Store::getName($v->storeAddress); ?></td>
            <td align="left"><?php echo $v->materialName; ?></td>
            <td align="center"><?php echo $v->num; ?></td>
            <td align="center"><?php echo $v->unit; ?></td>
            <td align="center"><?php echo $v->price; ?></td>
            <td align="left"><?php echo $v->standard; ?></td>

            <td align="left" class="qhb" style="border-left:2px #999 dashed"><?php echo $v->projectName; ?></td>
            <td align="right" class="qhb"><?php echo $v->projectCode; ?></td>
            <td align="right" class="qhb"><?php echo $v->materialCode; ?></td>
            <td align="right" class="qhb"><?php echo $v->card; ?></td>
            <td align="right" class="qhb"><?php echo $v->equCode; ?></td>
            <td align="right" class="qhb" style="border-right:2px #999 dashed"><?php echo $v->SAP; ?></td>

            <td align="left" class="qha" style="border-left:2px #999 dashed"><?php echo $v->factory; ?></td>
            <td align="right" class="qha"><?php echo $v->factoryCode; ?></td>
            <td align="center" class="qha"><?php echo $v->factoryDate; ?></td>
            <td align="left" class="qha"><?php echo $v->distribution; ?></td>
            <td align="left" class="qha"><?php echo $v->contact; ?></td>
            <td align="right" class="qha" style="border-right:2px #999 dashed"><?php echo $v->tel; ?></td>

            <td align="center"><?php echo Instrument::getState($v->state); ?></td>
            <td align="center"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" code="<?php echo $v->id; ?>" rel="edit">修改</a></li>
                            <li class="icon_015"><a href="#" code="<?php echo $v->id; ?>" rel="del">删除</a></li>
                            <li class="icon_015"><a href="#" code="<?php echo $v->id; ?>" rel="file">附件</a></li>
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