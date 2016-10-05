<!-- 日历插件js & css -->
<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>
<script type="text/javascript" src="/plugin/module/material.js"></script>
<script>
    $(function () {
        //日历插件
        $(".date").calendar({
            format : "yyyy-MM-dd"
        });
        //修改缓存中的物资信息
        $("a[rel=show]").click(function(){
            Material.showInForm($(this).attr('formID'));
        });
    });

</script>
<?php
//bugfix start
clean_xss($_GET['informCode']);
clean_xss($_GET['glPro']);
clean_xss($_GET['glProCode']);
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
                    <form method="get" action="<?= Yii::app()->createUrl("material/InFormList") ?>">
                    <table>
                        <tr>
                            <td>
                                关联项目编号：
                                <input class="grid_text" name="glProCode" value="<?php echo $_GET['glProCode']; ?>" />
                                入库日期：
                                <input class="grid_text date" name="starDate" value="<?php echo $_GET['starDate']; ?>" style="width:80px" />-
                                <input class="grid_text date" name="endDate" value="<?php echo $_GET['endDate']; ?>" style="width:80px" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                关联项目：
                                <input class="grid_text" name="glPro" value="<?php echo $_GET['glPro']; ?>" />
                                入库单号：
                                <input class="grid_text" name="informCode" value="<?php echo $_GET['informCode']; ?>" />
                                <input type="submit" value="查询" class="grid_button grid_button_s" />
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
            <th width="200" align="left">入库单号</th>
            <th width="200" align="center">入库日期</th>
            <th width="100" align="left">关联大修项目编号</th>
            <th width="200" align="left">关联大修项目</th>
            <th width="100" align="left">备注</th>
<!--            <th align="left">附件</th>-->
            <th width="70" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $value):
        ?>
        <tr style="<?= $bgColor ?>">
            <td align="left"><?php echo $value->informCode; ?></td>
            <td align="center"><?php echo $value->date; ?></td>
            <td align="left"><?php echo $value->glProCode; ?></td>
            <td align="left"><?php echo $value->glPro; ?></td>
            <td align="left"><?php echo $value->remark; ?></td>
            <td align="center"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" formID="<?php echo $value['informCode']; ?>" rel="show">详情</a></li>
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