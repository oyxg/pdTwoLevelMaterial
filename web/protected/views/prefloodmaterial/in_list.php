<script type="text/javascript" src="/plugin/module/material.js"></script>

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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
    <tr class="row">
        <th align="left">日期</th>
        <th align="left">物资名称</th>
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

    <?php
    $max = 15;
    $init = 0;
//    var_dump($rsList);
    foreach ($rsList as $key => $v): ?>
        <tr>
            <td align="left"><?php echo $v->date; ?></td>
            <td align="left"><?php echo $v->name; ?></td>
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
            <td align="center">
                <a href="#" code="<?php echo $v->InID; ?>" rel="edit">修改</a>
                <a href="#" code="<?php echo $v->InID; ?>" rel="file">附件</a>
            </td>
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
            </tr>";
        }
    ?>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>