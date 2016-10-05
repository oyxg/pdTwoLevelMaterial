<script type="text/javascript" src="/plugin/module/use_material.js"></script>
<script>

    $(function () {
        //查看报废单
        $("a[rel=show]").click(function(){
            UseMaterial.showReceiveForm($(this).attr('formID'));
        });
        //审核报废单
        $("a[rel=exam]").click(function(){
            UseMaterial.examReceiveForm($(this).attr('formID'));
        });
    });

</script>
<?php
//bugfix start
clean_xss($_GET['goodsCode']);
clean_xss($_GET['goodsName']);
clean_xss($_GET['type']);
clean_xss($_GET['formCode']);
clean_xss($_GET['batchCode']);
clean_xss($_GET['glPro']);
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
                    <form method="get" action="<?= Yii::app()->createUrl("UseMaterial/UseMaterialList") ?>">
                        <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />
                        <?php $typeName = $_GET['type']=="receive"?"领料":"退料";?>
                    <table>
                        <tr><td>
                            物资编号：
                            <input class="grid_text" name="goodsCode" value="<?php echo $_GET['goodsCode']; ?>" />
                            物资描述：
                            <input class="grid_text" name="goodsName" value="<?php echo $_GET['goodsName']; ?>" />
                            项目名称：
                            <input class="grid_text" name="glPro" value="<?php echo $_GET['glPro']; ?>" style="width:100px;" />
                            <?=$typeName;?>性质：
                            <select class="grid_text" name="nature" style="height: 24px;">
                                <option></option>
                                <option value="dx" <?php if($_GET['nature']=="dx"){echo "selected";}?>>大修</option>
                                <option value="qx" <?php if($_GET['nature']=="qx"){echo "selected";}?>>抢修</option>
                            </select>

                            </td></tr>
                        <tr><td>
                            <?=$typeName;?>批次号：
                            <input class="grid_text" name="batchCode" value="<?php echo $_GET['batchCode']; ?>" />
                            <?=$typeName;?>单号：
                            <input class="grid_text" name="formCode" value="<?php echo $_GET['formCode']; ?>" />
                            库存地址：
                            <select class="grid_text" name="storeID" id="storeID" style="width:130px;height: 24px">
                                <option></option>
                                <?php
                                $store = Store::model()->findAll();
                                foreach($store as $key=>$val){
                                    echo "<option value=\"{$val->storeID}\">{$val->storeName}</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />
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
            <th width="200" align="left"><?=$typeName;?>单号</th>
            <th width="200" align="center"><?=$typeName;?>性质</th>
            <th width="200" align="left">项目编号</th>
            <th width="200" align="left">项目名称</th>
            <th width="200" align="left"><?=$typeName;?>批次号</th>
            <th width="200" align="left">库存地址</th>
            <th width="200" align="left">物资编号</th>
            <th width="200" align="left">扩展编码</th>
            <th width="200" align="left">物资描述</th>
            <th width="200" align="center">库存数量</th>
            <th width="200" align="center"><?=$typeName;?>数量</th>
            <th width="200" align="left">厂家</th>
            <th width="200" align="center">状态</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $value):
        ?>
        <tr style="<?= $bgColor ?>">
            <td align="left"><?php echo $value['formCode']; ?></td>
            <td align="center"><?php echo $value['nature']=='dx'?"大修":"抢修"; ?></td>
            <td align="left"><?php echo $value['glProCode']; ?></td>
            <td align="left"><?php echo $value['glPro']; ?></td>
            <td align="left"><?php echo $value['fbatchCode']; ?></td>
            <td align="left"><?php echo Store::model()->findByPk($value['storeID'])->storeName; ?></td>
            <td align="left"><?php echo $value['goodsCode']; ?></td>
            <td align="left"><?php echo $value['extendCode']; ?></td>
            <td align="left"><?php echo $value['goodsName']; ?></td>
            <td align="center"><?php echo $value['currCount']; ?></td>
            <td align="center"><?php echo $value['number']; ?></td>
            <td align="left"><?php echo $value['factory']; ?></td>
            <td align="center"><?php $receiveForm=new ReceiveForm();echo $receiveForm->getState($value['state']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>