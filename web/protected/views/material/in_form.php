<script type="text/javascript" src="/plugin/module/material.js"></script>
<!-- 日历插件js & css -->
<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>
<script>
    $(function(){
        //日历插件
        $("#date").calendar({
            format : "yyyy-MM-dd"
        });
        //添加物资到缓存
        $("button[rel=add]").click(function(){
            Material.addForm();
        });
        //修改缓存中的物资信息
        $("a[rel=editMTdata]").click(function(){
            Material.editMTdata($(this).attr('gCode'));
        });
        //删除缓存中的物资信息
        $("a[rel=delMTdata]").click(function(){
            Material.delMTdata($(this).attr('gCode'),function(){
                location.reload();
            });
        });
        //提交
        $("#form").submit(function () {
            if($('#glPro').val()==""&&$('#glProCode').val()==""){
                var con = confirm('未填写关联大修项目和项目编号，是否继续？');
                if(!con)
                {
                    return false;
                }
            }
            var ajaxOpt = {
                dataType: "json",
                error: function () {
                    maya.notice.fail("服务器出现错误", null, 3);
                },
                success: function (data) {
                    maya.notice.close();
                    if (data.status == 0) {
                        maya.notice.fail(data.info);
                    } else {
                        maya.notice.success(data.info, function () {
                            location.reload();
                            //parent.location.reload();
                        });
                    }
                }
            };
            $(form).ajaxSubmit(ajaxOpt);
            return false;
        });

        var hide = true;
        $("button[rel=btnShow]").click(function(){
            if(hide){
                $(".hide").show();
                $(this).html("隐藏部分字段");
                hide = false;
            }else{
                $(".hide").hide();
                $(this).html("显示全部字段");
                hide = true;
            }
        });
    });
</script>

<style type="text/css">
    .hide{display: none;}
</style>

<?php if(!$SHOW):?>
<div class="control_tb">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td width="400"><?php
                $this->beginContent("//layouts/breadcrumbs");
                $this->endContent();
                ?></td>
            <td align="right"></td>
        </tr>
        </tbody>
    </table>
</div>
<?php endif;?>

<form id="form" name="form" class="" action="" method="post" >
<div style="padding:10px">
    <div style="letter-spacing:20px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 入库单 </div>
    <div style="text-align:center;padding:9px;" id="printWin">
        <?php if(!$SHOW):?>
            <button type="button" rel="add" class="grid_button">新增物资</button>
            <button type="submit" class="grid_button">确认提交</button>
        <?php endif;?>

        <button type="button" class="grid_button" rel="btnShow">显示全部字段</button>
        <button type="button" class="grid_button" onclick="print()">打印</button>
    </div>
    <div class="tag"> 基本信息</div>
    <div class="tagc">
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr height="30">
                <td width="90" align="right"><strong>入库单号：</strong></td>
                <td width="170"><input name="informCode" id="informCode" type="text" class="grid_text" disabled value="<?= $inForm->informCode?>" /></td>
                <td width="90" align="right"><strong>入库日期：</strong></td>
                <td width="170"><input name="date" id="date" type="date" class="grid_text"
                                       <?php if(!$inForm->date):?>value="<?php echo date('Y-m-d');?>"<?php else:?> value="<?= $inForm->date?>"<?php endif;?> /></td>
                <td width="90" align="right"><strong>关联大修项目：</strong></td>
                <td width="170"><input name="glPro" id="glPro" type="text" class="grid_text"  value="<?= $inForm->glPro?>" /></td>
                <td width="120" align="right"><strong>关联大修项目编号：</strong></td>
                <td width="170"><input name="glProCode" id="glProCode" type="text" class="grid_text"  value="<?= $inForm->glProCode?>" /></td>

            </tr>
            <tr height="30">
                <td width="90" align="right"><strong>联系人：</strong></td>
                <td width="170"><input name="contact" id="contact" type="text" class="grid_text"  value="<?= $inForm->contact ?>" /></td>
                <td width="90" align="right"><strong>联系人电话：</strong></td>
                <td width="170"><input name="tel" id="tel" type="text" class="grid_text"  value="<?= $inForm->tel ?>" /></td>
                <td width="120" align="right"><strong>备注：</strong></td>
                <td width="170"><input name="remark" id="remark" type="text" class="grid_text"  value="<?= $inForm->remark?>" /></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="tag"> 物资列表 </div>
    <div class="tagc" id="xx" style="height:340px;overflow:auto;">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
            <thead>
            <tr class="row">
                <th align="left">仓库</th>
                <th width="100" align="left">物资描述</th>
                <th align="left">物资编码</th>
                <th align="left">扩展编码</th>
                <th width="70" align="center">入库数量</th>
                <th width="50" align="center">最低库存</th>
                <th width="70" align="left">规格</th>
                <th width="50" align="center">单价</th>
                <th width="50" align="center">单位</th>
                <th width="50" align="center">总额</th>
                <th width="70" align="center">有效期</th>
                <th width="70" align="center" class="hide">工单号</th>
                <th width="70" align="center" class="hide">批次号</th>
                <th width="70" align="center" class="hide">ERP领料单</th>
                <th width="70" align="center" class="hide">ERP出库单</th>
                <th width="70" align="left">厂家</th>
                <th width="70" align="left" class="hide">厂家联系人</th>
                <th width="70" align="left" class="hide">厂家联系电话</th>
                <th align="left">备注</th>
                <?php if(!$SHOW):?>
                    <th width="70" align="center">操作</th>
                <?php endif;?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($list as $v): ?>
                <tr>
                    <td align="left"><?php echo Store::model()->findByPk($v['storeID'])->storeName;?></td>
                    <td align="left"><?php echo $v['goodsName'];?></td>
                    <td align="left"><?php echo $v['goodsCode'];?></td>
                    <td align="left"><?php echo $v['extendCode'];?></td>
                    <td align="center"><?php echo floatval($v['currCount']);?></td>
                    <td align="center"><?php echo $v['minCount'];?></td>
                    <td align="left"><?php echo $v['standard'];?></td>
                    <td align="center"><?php echo $v['price'];?></td>
                    <td align="center"><?php echo $v['unit'];?></td>
                    <td align="center"><?php echo $v['price']*$v['currCount'];?></td>
                    <td align="center"><?php echo $v['validityDate'];?></td>
                    <td align="center" class="hide"><?php echo $v['workCode'];?></td>
                    <td align="center" class="hide"><?php echo $v['batchCode'];?></td>
                    <td align="center" class="hide"><?php echo $v['erpLL'];?></td>
                    <td align="center" class="hide"><?php echo $v['erpCK'];?></td>
                    <td align="left"><?php echo $v['factory'];?></td>
                    <td align="left" class="hide"><?php echo $v['factory_contact'];?></td>
                    <td align="left" class="hide"><?php echo $v['factory_tel'];?></td>
                    <td align="left"><?php echo $v['remark'];?></td>
                    <?php if(!$SHOW):?>
                        <td align="center"><div class="grid_menu_panel" style="width:70px">
                                <div class="grid_menu_btn">操作</div>
                                <div class="grid_menu">
                                    <ul>
                                        <li class="icon_015"><a href="#" gCode="<?php echo $v['goodsCode']; ?>" rel="editMTdata">修改</a></li>
                                        <li class="icon_009"><a href="#" gCode="<?php echo $v['goodsCode']; ?>" rel="delMTdata">删除</a></li>
                                    </ul>
                                </div>
                            </div></td>
                    <?php endif;?>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<style media="print">
    #printWin{display:none;}
</style>


</form>