<script type="text/javascript" src="/plugin/module/material.js"></script>
<!-- 日历插件js & css -->
<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>
<script>

    $(function () {
        //日历插件
        $(".date").calendar({
            format : "yyyy-MM-dd"
        });
        //查看报废单
        $("a[rel=show]").click(function(){
            Material.showTaskBook($(this).attr('bookCode'));
        });
        //审核报废单
        $("a[rel=exam]").click(function(){
            Material.examTaskBook($(this).attr('bookCode'));
        });
    });

</script>
<?php
//bugfix start
clean_xss($_GET['type']);
clean_xss($_GET['zrbz']);
clean_xss($_GET['edate']);
clean_xss($_GET['sdate']);
//bugfix end
?>
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
                <td align="right">
                    <form method="get" action="<?= Yii::app()->createUrl("Task/TaskBookList") ?>">
                    <table>
                        <tr><td>
                            <input type="hidden" value="<?php echo $_GET['type'];?>" name="type" />
                            施工日期：
                            <input class="grid_text date" type="date" name="sdate" value="<?php echo $_GET['sdate']; ?>" />
                            至
                            <input class="grid_text date" type="date" name="edate" value="<?php echo $_GET['edate']; ?>" />
                            责任班组：
                            <input class="grid_text" name="zrbz" value="<?php echo $_GET['zrbz']; ?>" />
                            <input type="submit" value="查询" class="grid_button grid_button_s" />
                            </td></tr>
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
            <th width="200" align="left">施工日期</th>
            <th width="200" align="left">责任单位</th>
            <th width="200" align="left">责任班组</th>
            <th width="200" align="center">配合施工单位</th>
            <th width="200" align="center">线路及设备名称</th>
            <th width="200" align="center">状态</th>
            <th width="70" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $value):
        $user = new User();
        ?>
        <tr style="<?= $bgColor ?>">
            <td align="left"><?php echo $value->date; ?></td>
            <td align="left"><?php echo $value->zrdw; ?></td>
            <td align="left"><?php echo $value->zrbz; ?></td>
            <td align="center"><?php echo $value->phdw; ?></td>
            <td align="center"><?php echo $value->line; ?></td>
            <td align="center"><?php echo TaskBook::model()->getState($value->state); ?></td>
            <td align="center"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <?php if($type=="我提交的"):?>
                                <li class="icon_015"><a href="#" bookCode="<?php echo $value->bookCode; ?>" rel="show">详情</a></li>
                                <?php if(false)://if($value->state=="back"): ?>
                                    <li class="icon_015"><a href="<?php echo Yii::app()->createUrl("task/editTaskBook")."?formID=".$value->bookCode;?>">修改</a></li>
                                <?php endif;?>
                            <?php endif;?>
                            <?php if($type=="已处理的"):?>
                                <li class="icon_015"><a href="#" bookCode="<?php echo $value->bookCode; ?>" rel="show">详情</a></li>
                            <?php endif;?>
                            <?php if($type=="待处理的"):?>
                                <li class="icon_015"><a href="#" bookCode="<?php echo $value->bookCode; ?>" rel="exam">审核</a></li>
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