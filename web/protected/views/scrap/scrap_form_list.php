<script type="text/javascript" src="/plugin/module/material.js"></script>
<script>

    $(function () {
        //查看报废单
        $("a[rel=show]").click(function(){
            Material.showScrapForm($(this).attr('formID'));
        });
        //审核报废单
        $("a[rel=exam]").click(function(){
            Material.examScrapForm($(this).attr('formID'));
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
                <td align="right">
                    <form method="get" action="<?= Yii::app()->createUrl("scrap/ScrapFormList") ?>">
                    <table>
                        <tr><td>
                            <input type="hidden" value="<?php echo $_GET['type'];?>" name="type" />
                            报废单号：
                            <input class="grid_text" name="formCode" value="<?php echo $_GET['formCode']; ?>" />
                            项目名称：
                            <input class="grid_text" name="projectName" value="<?php echo $_GET['projectName']; ?>" />
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
            <th width="200" align="left">报废表单号</th>
            <th width="200" align="left">项目编号</th>
            <th width="200" align="left">项目名称</th>
            <th width="200" align="center">提交日期</th>
            <?php if (Auth::has(AI::R_Major)):?>
            <th width="200" align="center">提交人</th>
            <?php endif;?>
            <?php if (Auth::has(AI::R_Group)):?>
            <th width="200" align="center">处理人</th>
            <?php endif;?>
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
            <td align="left"><?php echo $value->formCode; ?></td>
            <td align="left"><?php echo $value->projectCode; ?></td>
            <td align="left"><?php echo $value->projectName; ?></td>
            <td align="center"><?php echo $value->date; ?></td>
        <?php if (Auth::has(AI::R_Major)):?>
            <td align="center"><?php echo $user->model()->getUserByID($value->bID)->userName; ?></td>
        <?php endif;?>
        <?php if (Auth::has(AI::R_Group)):?>
            <td align="center"><?php echo $user->model()->getUserByID($value->zID)->userName; ?></td>
        <?php endif;?>
            <td align="center"><?php $scrapForm=new ScrapForm();echo $scrapForm->getState($value->state); ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <?php if($type=="我提交的"):?>
                                <li class="icon_015"><a href="#" formID="<?php echo $value->id; ?>" rel="show">详情</a></li>
                                <?php if($value->state=="1"): //退回时候需要修改?>
                                    <li class="icon_015"><a href="<?php echo Yii::app()->createUrl("scrap/editScrapForm")."?formID=".$value->id;?>">修改</a></li>
                                <?php endif;?>
                            <?php endif;?>
                            <?php if($type=="已处理的"):?>
                                <li class="icon_015"><a href="#" formID="<?php echo $value->id; ?>" rel="show">详情</a></li>
                            <?php endif;?>
                            <?php if($type=="待处理的"):?>
                                <li class="icon_015"><a href="#" formID="<?php echo $value->id; ?>" rel="exam">审核</a></li>
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