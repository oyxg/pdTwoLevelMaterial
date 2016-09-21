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
    });
</script>

<form id="form" name="form" class="" action="" method="post" >
    <div style="padding:10px">
        <div style="letter-spacing:20px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 移库单 </div>
        <div class="tag"> 基本信息</div>
        <div class="tagc">

            <table border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr height="30">
                    <td width="90" align="right"><strong>移库单号：</strong></td>
                    <td width="170"><input name="moveFormCode" id="moveFormCode" type="text" class="grid_text" disabled value="<?= $moveForm->moveFormCode?>" /></td>
                    <td width="90" align="right"><strong>移库日期：</strong></td>
                    <td width="170"><input name="date" id="date" type="date" class="grid_text"  value="<?= $moveForm->date?>" /></td>
                    <td width="90" align="right"><strong>批次号：</strong></td>
                    <td width="170"><input name="batchCode" id="batchCode" type="text" class="grid_text"  value="<?= $moveForm->batchCode?>" /></td>
                    <td width="120" align="right"><strong>备注：</strong></td>
                    <td width="170"><input name="remark" id="remark" type="text" class="grid_text"  value="<?= $moveForm->remark?>" /></td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="tag"> 物资列表 </div>
        <div class="tagc" id="xx" style="height:340px;overflow:auto;">
            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
                <thead>
                <tr class="row">
                    <th width="100" align="left">移出仓库</th>
                    <th width="100" align="left">物资描述</th>
                    <th align="left">物资编码</th>
                    <th align="left">扩展编码</th>
                    <th width="70" align="left">规格</th>
                    <th width="50" align="center">单位</th>
                    <th width="50" align="center">移库数量</th>
                    <th width="50" align="center">单价</th>
                    <th width="50" align="center">总额</th>
                    <th width="70" align="center">有效期</th>
                    <th width="70" align="center" class="hide">批次号</th>
                    <th width="70" align="left">厂家</th>
                    <th align="left">备注</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($list as $v): ?>
                    <tr>
                        <td align="left"><?php echo Store::model()->getName($v['comeStoreID']);?></td>
                        <td align="left"><?php echo $v['goodsName'];?></td>
                        <td align="left"><?php echo $v['goodsCode'];?></td>
                        <td align="left"><?php echo $v['extendCode'];?></td>
                        <td align="left"><?php echo $v['standard'];?></td>
                        <td align="center"><?php echo $v['unit'];?></td>
                        <td align="center"><?php echo $v['number'];?></td>
                        <td align="center"><?php echo $v['price'];?></td>
                        <td align="center"><?php echo $v['price']*$v['number'];?></td>
                        <td align="center"><?php echo $v['validityDate'];?></td>
                        <td align="center" class="hide"><?php echo $v['batchCode'];?></td>
                        <td align="left"><?php echo $v['factory'];?></td>
                        <td align="left"><?php echo $v['remark'];?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <style media="print">
        #printWin{display:none;}
    </style>
    <div style="text-align:center;padding:9px;" id="printWin">
        <button type="button" class="grid_button" onclick="print()">打印</button>
    </div>
</form>