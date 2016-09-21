<script type="text/javascript" src="/plugin/module/material.js"></script>
<script>
    $(function () {
        //修改缓存中的物资信息
        $("a[rel=show]").click(function(){
            Material.showMoveForm($(this).attr('formID'));
        });
        //上传附件
        $("a[rel=upload]").click(function(){
            Material.uploadFile($(this).attr('formID'));
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
                    <form method="get" action="<?= Yii::app()->createUrl("material/MoveFormList") ?>">
                    <table>
                        <tr><td>
                            移入仓库：
                            <select name="storeID" id="storeID" class="grid_text" style="height: 24px">
                                <option></option>
                                <?php
                                $store = Store::model()->findAll();
                                foreach($store as $key=>$val){
                                    if($_GET['storeID']==$val->storeID){
                                        echo "<option value=\"{$val->storeID}\" selected>{$val->storeName}</option>";
                                    }else{
                                        echo "<option value=\"{$val->storeID}\">{$val->storeName}</option>";
                                    }
                                }
                                ?>
                            </select>
                            移库单号：
                            <input class="grid_text" name="moveFormCode" value="<?php echo $_GET['moveFormCode']; ?>" />
                            批次号：
                            <input class="grid_text" name="batchCode" value="<?php echo $_GET['batchCode']; ?>" />
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
            <th width="200" align="left">移库单号</th>
            <th width="200" align="left">批次号</th>
        <?php if (Auth::has(AI::R_Materialer)): ?>
            <th width="200" align="center">移出仓库</th>
            <th width="200" align="center">移入仓库</th>
        <?php endif; ?>
            <th width="200" align="center">移库日期</th>
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
            <td align="left"><?php echo $value->moveFormCode; ?></td>
            <td align="left"><?php echo $value->batchCode; ?></td>
        <?php if (Auth::has(AI::R_Materialer)): ?>
            <td align="center"><?php echo Store::getName(MaterialMove::model()->findByPk($value['id'])->comeStoreID); ?></td>
            <td align="center"><?php echo Store::getName($value['storeID']); ?></td>
        <?php endif; ?>
            <td align="center"><?php echo $value->date; ?></td>
            <td align="left"><?php echo $value->remark; ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" formID="<?php echo $value['id']; ?>" rel="show">详情</a></li>
                            <li class="icon_015"><a href="#" formID="<?php echo $value['id']; ?>" rel="upload">上传附件</a></li>
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