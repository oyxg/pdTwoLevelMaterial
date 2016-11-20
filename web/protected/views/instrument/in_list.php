<script type="text/javascript" src="/plugin/module/material.js"></script>

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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
    <tr class="row">
<!--        <th align="left">日期</th>-->
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

    <?php
    $max = 15;
    $init = 0;
//    var_dump($rsList);
    foreach ($rsList as $key => $v): ?>
        <tr>
<!--            <td align="left">--><?php //echo $v->date; ?><!--</td>-->
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
    <?php
        $init++;
    endforeach;
        for($init;$init<=$max;$init++){
            echo "<tr>
            <td>　</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>";
        }
    ?>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>