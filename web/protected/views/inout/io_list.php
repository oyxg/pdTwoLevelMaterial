<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>
<script type="text/javascript" src="/plugin/module/goods.js"></script>
<script>
    $(function () {

        $("#dstart,#dend").calendar({
            format: "yyyy-MM-dd"
        });

        $("a[act=sp]").click(function () {
            showPhoto($(this).attr("io_id"));
            return false;
        });
        $("a[act=all]").click(function () {
            showAll($(this).attr("data"));
            return false;
        });
    });

    function showAll(data) {
        window.__box = new Maya.Box({
            url: "<?= $this->createUrl("showAll") ?>?data=" + data,
            width: 600,
            height: 300
        });
    }
    function showPhoto(id) {
        window.__box = new Maya.Box({
            url: "<?= $this->createUrl("showPhoto") ?>?id=" + id,
            width: 600,
            height: 300
        });
    }
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
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("inout/list") ?>">
                        <table>
                            <tr>
                                <td><input type="hidden" name='inOut' value="<?php echo $_GET['inOut']; ?>"/>
                                    <?php if ($_GET['inOut'] == 'in'): ?>
                                        资产编号
                                        <input class="grid_text" name="bh" value="<?php echo $_GET['bh']; ?>">
                                        型号
                                        <input class="grid_text" name="property" value="<?php echo $_GET['property']; ?>">
                                    <?php else: ?>
                                        领用人：
                                        <input class="grid_text" name="borrowerName" value="<?php echo $_GET['borrowerName']; ?>" size="8">
                                    <?php endif; ?>

                                    <?php if ($_GET['inOut'] == 'out'): ?>
                                        去处：
                                        <input type="text" value="" name="whereGo" class="easyui-combobox" data-options="
                                   valueField: 'qxID',
                                   textField: 'qxName',
                                   width : '200',
                                   panelHeight : 120,
                                   url: '<?= Yii::app()->createUrl("qx/showJson") ?>'
                                   ">
                                        <?php if ($_GET['h'] == '1'): ?>
                                            资产编号
                                            <input class="grid_text" name="bh" value="<?php echo $_GET['bh']; ?>">
                                            <input type="hidden" name='h' value="1"/>
                                        <?php endif; ?>
                                    <?php endif; ?></td>
                            </tr>
                            <tr>
                                <td>物资描述：
                                    <input class="grid_text" name="goodsName" value="<?php echo $_GET['goodsName']; ?>" size="8">


                                    <!--                        <input class="grid_text" name="whereGo" value="<?php echo $_GET['whereGo']; ?>" size="8">-->
                                    <!--
                        出入类型：
                        <select name="ioType" id="ioType">
                        <option value="">不限</option>
                        <?php foreach (InOut::getTypeList() as $key => $value): ?>
                                                <option value="<?php echo $key; ?>" <?= $key == $_GET['ioType'] ? "selected=\"selected\"" : "" ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                        </select>
                        分类：
                        <select name="category" id="category" onchange="Goods.callGetAjaxTypeList(this.value,true);">
                        <option value="">不限</option>
                        <?php foreach (Goods::getCategoryList() as $key => $value): ?>
                                                <option value="<?php echo $key; ?>" <?= $key == $_GET['category'] ? "selected=\"selected\"" : "" ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                        </select>
                        类型：
                        <select name="type" id="type">
                        <option value="">不限</option>
                        </select>
                        -->
                                    日期：
                                    <input class="grid_text" name="dstart" style="width:80px" id="dstart" value="<?php echo $_GET['dstart']; ?>">
                                    -
                                    <input class="grid_text" name="dend" style="width:80px" id="dend" value="<?php echo $_GET['dend']; ?>">
                                    <input type="submit" value="查询" class="grid_button grid_button_s">
                                    <?php if ($_GET['inOut'] == 'out'): ?>
                                        <?php if ($_GET['h'] == '1'): ?>
                                            <input type="button" value="导入" class="grid_button grid_button_s" onclick="location.href = '/inout/import.html'">
                                        <?php else: ?>
                                            <input type="button" value="导出" class="grid_button grid_button_s" onclick="location.href = '/inout/export.html?sql=<?php echo $sql; ?>&page=<?php echo $_GET['page']; ?>'">
                                        <?php endif; ?>
                                    <?php endif; ?>
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
            <th width="100" align="left">仓库</th>
            <th width="160" align="left">物资描述</th>
            <?php if ($_GET['inOut'] == 'in'): ?>
                <th width="130" align="left">物资类型</th>
            <?php endif; ?>
            <th width="60" align="center">数量</th>
<!--            <th width="60" align="center">出/入</th>-->
            <!--<th width="90" align="center">类型</th>-->
            <th width="120" align="center">日期</th>
            <th width="80" align="left">操作</th>
            <?php if ($_GET['inOut'] == 'out'): ?>
                <th align="left">去处</th>

                <th align="left">领用人</th>
            <?php endif; ?>
            <th width="90" align="center">资产编码</th>
            <th align="left">型号</th>
            <?php if ($_GET['inOut'] == 'in'): ?>
                <th align="left">入库人员</th>
            <?php endif; ?>
            <th align="left">生产厂家</th>
            <?php if ($_GET['inOut'] == 'out'): ?>
                <th align="left">备注</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($rsList as $key => $rs):
            $color = $rs['inOut'] == InOut::INOUT_OUT ? 'color:red;font-weight:bold;' : 'color:blue;font-weight:bold;';
            ?>
            <tr>
                <td align="left"><?= $rs['storeName'] ?></td>
                <td align="left"><?= $rs['goodsName'] ?></td>
                <?php if ($_GET['inOut'] == 'in'): ?>
                    <td align="left"><?= $rs['wzlx'] == 1 ? '重点物资' : '备品备件' ?></td>
                <?php endif; ?>
        <!--<td align="left"><?= Goods::getTypeName($rs['type']) ?></td>-->
                <td align="center"><?= $rs['count'] ?></td>
    <!--                <td align="center"><span style="<?= $color ?>"><?= InOut::getInOutName($rs['inOut']) ?></span></td>-->
                <!--<td align="center"><?= InOut::getTypeName($rs['ioType']) ?></td>-->
                <td align="center"><?= $rs['date'] ?></td>
                <td align="left">
                    <?php if ($rs['inOut'] == InOut::INOUT_OUT): ?>
                        <a href="#" act="sp" io_id="<?= $rs['id'] ?>">出入照片</a>
                    <?php else: ?>-
                    <?php endif; ?>
                </td>
                <?php if ($_GET['inOut'] == 'out'): ?>
                    <td align="left"><?php  echo is_numeric($rs['whereGo'])?qx::model()->findByPk($rs['whereGo'])->qxName:$rs['whereGo']; ?></td>
                    <td align="left"><?= $rs['borrowerName'] ?></td>
                <?php endif; ?>
                <?php if ($_GET['inOut'] == 'out'): ?>
                    <?php
                    if ($rs['rd']) {
                        $sql = "SELECT a.assets_number from mod_asset_out a where request_detail_id = {$rs['rd']}  ";
                        $an = qx::model()->getDbConnection()->createCommand($sql)->queryAll();
                        foreach ($an as $a) {
                            $arr[] = $a['assets_number'];
                        }
                    }
                    if ($rs['bh']) {
                        $arr = null;
                        $arr = explode(',', $rs['bh']);
                    }
                    ?>
                    <td align = "left">
                        <?php if(!$arr[0]): ?>
                        
                        <?php else: ?>
                        <?php echo $arr[0]; ?>
                        <?php if (count($arr) > 1): ?>
                            <a href="#" act="all" data="<?= !$arr ? '' : implode(',', $arr) ?>">+</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </td>
                <?php else: ?>
                    <td align = "left"><?= $rs['bh'] ?></td>
                <?php endif; ?>
                <td align="left"><?= $rs['property'] ?></td>
                <?php if ($_GET['inOut'] == 'in'): ?>
                    <td align="left"><?= User::model()->findByPk($rs['userID'])->userName ?></td>
                <?php endif; ?>
                <td align="left"><?= $rs['factory'] ?></td>
                <?php if ($_GET['inOut'] == 'out'): ?>

                    <?php
                    if ($rs['rd']) {
                        $sql = "SELECT a.bz from mod_request_detail a where requestDetailId = {$rs['rd']}  ";
                        $an = qx::model()->getDbConnection()->createCommand($sql)->queryRow();
//                        foreach ($an as $a) {
//                            $arr[] = $a['bz'];
//                        }
                    }
                    ?>
                    <td align="left"><?= $rs['comment'] ? $rs['comment'] : $an['bz'] ?></td>
                <?php endif; ?>
            </tr>
                <?php
                $arr = '';
            endforeach;
            ?>
    </tbody>
</table>


        <?php
        $this->beginContent("//layouts/pagination");
        $this->endContent();
        ?>

<div style="text-align: center"><span>总记录：<?php echo $countRs;?></span></div>