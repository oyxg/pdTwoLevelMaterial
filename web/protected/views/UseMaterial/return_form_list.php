<script type="text/javascript" src="/plugin/module/use_material.js"></script>
<script>

    $(function () {
        //查看退料单
        $("a[rel=show]").click(function(){
            UseMaterial.showReturnForm($(this).attr('formID'));
        });
        //审核退料单
        $("a[rel=exam]").click(function(){
            UseMaterial.examReturnForm($(this).attr('formID'));
        });
        $("a[act=sp]").click(function () {
            showPhoto($(this).attr("pic_id"));
            return false;
        });
        //上传附件
        $("a[rel=upload]").click(function(){
            UseMaterial.uploadFile('return',$(this).attr('formID'));
        });
        function showPhoto(id) {
            window.__box = new Maya.Box({
                url: "<?= $this->createUrl("showReturnPhoto") ?>?id=" + id,
                width: 600,
                height: 300
            });
        }
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
                    <form method="get" action="<?= Yii::app()->createUrl("UseMaterial/ReturnMFList") ?>">
                    <table>
                        <tr><td>
                            <input type="hidden" name="type" value="<?php echo $_GET['type'];?>">
                            退料性质：
                            <select class="grid_text" name="nature" style="width:100px;height: 24px;">
                                <option></option>
                                <option value="dx" <?php if($_GET['nature']=="dx"){echo "selected";}?>>大修</option>
                                <option value="qx" <?php if($_GET['nature']=="qx"){echo "selected";}?>>抢修</option>
                            </select>
                            退料单号：
                            <input class="grid_text" name="formCode" value="<?php echo $_GET['formCode']; ?>" />
                            项目名称：
                            <input class="grid_text" name="glPro" value="<?php echo $_GET['glPro']; ?>" />
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
            <th width="200" align="left">退料单号</th>
            <th width="200" align="center">退料性质</th>
            <th width="200" align="left">项目编号</th>
            <th width="200" align="left">项目名称</th>
            <th width="200" align="left">批次号</th>
            <th width="200" align="left">备注</th>
            <th width="200" align="center">领料时间</th>
<!--            <th width="200" align="center">附件</th>-->
            <th width="200" align="center">状态</th>
            <th width="70" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $value):
        ?>
        <tr style="<?= $bgColor ?>">
            <td align="left"><?php echo $value->formCode; ?></td>
            <td align="center"><?php echo $value->nature=='dx'?"大修":"抢修"; ?></td>
            <td align="left"><?php echo $value->glProCode; ?></td>
            <td align="left"><?php echo $value->glPro; ?></td>
            <td align="left"><?php echo $value->batchCode; ?></td>
            <td align="center"><?php echo $value->remark; ?></td>
            <td align="center"><?php echo $value->outTime; ?></td>
<!--            <td align="center"><a href="#" act="sp" pic_id="--><!--">照片</a></td>-->
            <td align="center"><?php $receiveForm=new ReceiveForm();echo $receiveForm->getState($value->state); ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:100px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <?php if($type=="待处理的"):?>
                                <li class="icon_015"><a href="#" formID="<?php echo $value->id; ?>" rel="exam">审核</a></li>
                            <?php endif;?>
                            <?php if($type=="我提交的"||$type=="已处理的"):?>
                                <li class="icon_015"><a href="#" formID="<?php echo $value->id; ?>" rel="show">详情</a></li>
                            <?php endif;?>
                                <li class="icon_015"><a href="#" formID="<?php echo $value->id; ?>" rel="upload">上传附件</a></li>
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