<script type="text/javascript" src="/plugin/module/material.js"></script>
<script>
    $(function(){
        //报废表id
        var bookCode = <?= $taskBook->bookCode;?>;
        //审核通过
        $("button[rel=ok]").click(function(){
            Material.taskOk(bookCode);
            parent.location.reload();
        });
        //退回
        $("button[rel=back]").click(function(){
            Material.taskBack(bookCode);
            parent.location.reload();
        });
    });
</script>


<form id="form" name="form" class="" action="" method="post" >
<div style="padding:10px">
    <div style="letter-spacing:10px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 配电设备检修（抢修）预（结）算任务书 </div>
    <div class="tag"> 基本信息</div>
    <div class="tagc">
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr height="30">
                <td width="90" align="right"><strong>施工日期：</strong></td>
                <td width="170"><?= $taskBook->date?></td>
                <td width="90" align="right"><strong>责任单位：</strong></td>
                <td width="170"><?= $taskBook->zrdw?></td>
                <td width="90" align="right"><strong>责任班组：</strong></td>
                <td width="170"><?= $taskBook->zrbz?></td>
                <td width="90" align="right"><strong>配合单位：</strong></td>
                <td width="170"><?= $taskBook->phdw?></td>
            </tr>
            <tr height="30">
                <td width="120" align="right"><strong>线路及设备名称：</strong></td>
                <td width="390px" colspan="4"><?= $taskBook->line?></td>
            </tr>
            <tr height="58">
                <td width="90" align="right"><strong>消缺内容：</strong></td>
                <td colspan="9"><pre><?= $taskBook->content?></pre></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tag"> 需领材料</div>
    <div class="tagc" id="xx" style="min-height:100px;">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
            <thead>
            <tr class="row">
                <th width="50" align="center">序号</th>
                <th align="left">物资名称</th>
                <th align="left">型号规格及参数</th>
                <th width="50" align="center">单位</th>
                <th width="50" align="center">单价</th>
                <th width="50" align="center">数量</th>
                <th align="center">金额（元）</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach ($list as $v):
                $i++;  ?>
                <tr>
                    <td align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo $v['goodsName'];?></td>
                    <td align="center"><?php echo $v['standard'];?></td>
                    <td align="center"><?php echo $v['unit'];?></td>
                    <td align="center"><?php echo floatval($v['price']);?></td>
                    <td align="center"><?php echo floatval($v['number']);?></td>
                    <td align="center"><?php echo floatval($v['number']*$v['price']);?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>
    <div class="tag"> 应退材料</div>
    <div class="tagc" id="xx" style="min-height:100px;">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
            <thead>
            <tr class="row">
                <th align="left">物资名称</th>
                <th align="left">型号规格及参数</th>
                <th width="50" align="center">单位</th>
                <th width="50" align="center">单价</th>
                <th width="50" align="center">数量</th>
                <th align="center">金额（元）</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=0;$i<5;$i++): ?>
                <tr>
                    <td align="center">　</td>
                    <td align="center">　</td>
                    <td align="center">　</td>
                    <td align="center">　</td>
                    <td align="center">　</td>
                    <td align="center">　</td>
                </tr>
            <?php endfor;?>
            </tbody>
            <tr>
                <td>工作票编号</td><td></td><td colspan="2">变更单编号</td><td colspan="2"></td>
            </tr>
            <tr>
                <td>材料管理员签证</td><td></td><td colspan="2">签证</td><td colspan="2"></td>
            </tr>
            <tr>
                <td>工作负责人签证</td><td></td><td colspan="2">签证日期</td><td colspan="2"></td>
            </tr>
            <tr>
                <td>班长核对</td><td></td><td colspan="2">核对日期</td><td colspan="2"></td>
            </tr>
            <tr>
                <td>专职审核</td><td></td><td colspan="2">审核日期</td><td colspan="2"></td>
            </tr>
            <tr>
                <td>分管领导批准</td><td></td><td colspan="2">批准日期</td><td colspan="2"></td>
            </tr>
        </table>
    </div>
</div>
<style media="print">
    #printWin{display:none;}
</style>
    <?php if($taskBook->state=='back'):?>
        <p style="color: #ff0000;margin: 0;padding:0 0 0 15px;">退回原因：<?= $taskBook->opinion;?></p>
    <?php endif;?>
<div style="text-align:center;padding:9px;" id="printWin">
    <?php if($exam):?>
        <button type="button" rel="back" class="grid_button">退回</button>
        <input id="back_opinion" name="back_opinion" placeholder="退回原因" style="width:200px;line-height:22px;padding-left: 5px;" />

        <button type="button" rel="ok" class="grid_button">通过</button>
    <?php endif;?>
    <button type="button" class="grid_button" onclick="print()">打印</button>
</div>
</form>