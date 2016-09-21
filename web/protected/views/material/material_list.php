<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>
<script>
    $(function () {
        //修改缓存中的物资信息
        $("a[rel=edit]").click(function(){
            Material.edit($(this).attr('gCode'));
        });
    });

</script>
<div class="control_tb">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td width="400">
                    <?php
                    $this->beginContent("//layouts/breadcrumbs");
                    $this->endContent();
                    ?>
                </td>
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("material/list") ?>">
                        物资编码：
                        <input class="grid_text" name="goodsCode" value="<?php echo $_GET['goodsCode']; ?>">
                        物资描述：
                        <input class="grid_text" name="goodsName" value="<?php echo $_GET['goodsName']; ?>">
                        <?php if (Auth::has(AI::R_Materialer)): ?>
                        仓库：
                        <select class="grid_text" name="storeID" id="storeID" style="height: 24px">
                            <option></option>
                            <?php
                            $store = Store::model()->findAll();
                            foreach($store as $key=>$val){
                                echo "<option value=\"{$val->storeID}\">{$val->storeName}</option>";
                            }
                            ?>
                        </select>
                        <?php endif; ?>
                        <input type="submit" value="查询" class="grid_button grid_button_s">
                        <?php if (Auth::has(AI::C_InForm)): ?>
                            <a href="<?= Yii::app()->createUrl("material/InForm") ?>">
                                <input type="button" id="addItemBtn" value="填写入库单" class="grid_button" />
                            </a>
                        <?php endif; ?>
                    </form></td>
            </tr>
        </tbody>
    </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
        <tr class="row">
            <th width="40" align="center"> <input type="checkbox" onclick="var s = this.checked ? 'checked' : false;
                    $(':checkbox[name=cbox]').attr('checked', s)" checked="checked"></th>
            <th width="200" align="left">批次号</th>
            <th width="200" align="left">物资编码</th>
            <th width="200" align="left">扩展编码</th>
            <?php if (Auth::has(AI::R_Materialer)): ?>
                <th width="200" align="center">仓库</th>
            <?php endif; ?>
            <th width="200" align="left">物资描述</th>
            <th width="200" align="left">厂家</th>
            <th width="200" align="left">规格</th>
            <th width="100" align="center">单位</th>
            <th width="100" align="center">当前库存</th>
            <th width="100" align="center">最低库存</th>
            <th width="100" align="center">单价</th>
            <th width="100" align="center">有效期</th>
            <th width="200" align="left">备注</th>
<!--            <th align="left">附件</th>-->
            <th width="70" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $material):
        $color = $material['currCount'] < $material['minCount'] ? 'color:red;font-weight:bold;' : '';
        $bgColor = $material['currCount'] < $material['minCount'] ? 'background-color:#FFD4D4;' : '';
        $year = date("Y-m-d",strtotime("+6 month"));//有效期半年
        $color_data = $material['validityDate'] < $year ? 'color:red;font-weight:bold;' : '';
        $bgColor = $material['validityDate'] < $year ? 'background-color:#FFD4D4;' : $bgColor;
        ?>
        <tr style="<?= $bgColor ?>">
            <td align="center"><input type="checkbox" name="cbox" value="<?php echo $material->materialID; ?>" checked="checked"></td>
            <td align="left"><?php echo $material->batchCode; ?></td>
            <td align="left"><?php echo $material->goodsCode; ?></td>
            <td align="left"><?php echo $material->extendCode; ?></td>
            <?php if (Auth::has(AI::R_Materialer)): ?>
                <td align="center"><?php echo Store::getName($material['storeID']); ?></td>
            <?php endif; ?>
            <td align="left"><?php echo $material->goodsName; ?></td>
            <td align="left"><?php echo $material->factory; ?></td>
            <td align="left"><?php echo $material->standard; ?></td>
            <td align="center"><?php echo $material->unit; ?></td>
            <td align="center"><span style="<?= $color ?>"><?php echo floatval($material->currCount); ?></span></td>
            <td align="center"><?php echo floatval($material->minCount); ?></td>
            <td align="center"><?php echo floatval($material->price); ?></td>
            <td align="center"><span style="<?= $color_data ?>"><?php echo $material->validityDate=="0000-00-00"?"":$material->validityDate; ?></span></td>
            <td align="left"><?php echo $material->remark; ?></td>
<!--            <td align="left">--><?php //echo $material->accessory; ?><!--</td>-->
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" gCode="<?php echo $material->materialID; ?>" rel="edit">修改</a></li>
                        </ul>
                    </div>
                </div></td>
        </tr>
    <?php endforeach; ?>
        <tr class="row">
            <td colspan="15">
                <input type="button" class="grid_button grid_button_s" name="button" id="addpd_btn" value="加入盘点" onclick="Inventory.apply()">
                <input type="button" class="grid_button grid_button_l" name="button" id="" value="全部加入盘点" onclick="Inventory.applyAll()">
            </td>
        </tr>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>