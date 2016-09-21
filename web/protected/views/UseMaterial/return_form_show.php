<script type="text/javascript" src="/plugin/module/use_material.js"></script>
<script>
    $(function(){
        //报废表id
        var formID = <?= $returnForm->id;?>;
        //审核通过
        $("button[rel=ok]").click(function(){
            UseMaterial.returnOk(formID);
            parent.location.reload();
        });
        //退回
        $("button[rel=no]").click(function(){
            UseMaterial.returnNo(formID);
            parent.location.reload();
        });
    });
</script>


<form id="form" name="form" class="" action="" method="post" >
<div style="padding:10px">
    <div style="letter-spacing:20px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 退料单 </div>
    <div class="tag"> 基本信息</div>
    <div class="tagc">
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr height="30">
                <td width="90" align="right"><strong>单号：</strong></td>
                <td width="170"><?= $returnForm->formCode?></td>
                <td width="70" align="right"><strong>项目名称：</strong></td>
                <td width="170"><?= $returnForm->glPro?></td>
                <td width="70" align="right"><strong>项目编号：</strong></td>
                <td width="170"><?= $returnForm->glProCode?></td>
                <td width="70" align="right"><strong>退料性质：</strong></td>
                <td width="170"><?= $returnForm->batchCode?></td>
            </tr>
            <tr height="30">
                <td width="70" align="right"><strong>备注：</strong></td>
                <td width="170" colspan="3"><?= $returnForm->remark?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tag"> 退料物资列表</div>
    <div class="tagc" id="xx" style="min-height:100px;">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
            <thead>
            <tr class="row">
                <th width="50" align="center">序号</th>
                <th align="70">批次号</th>
                <th align="70">物资编码</th>
                <th width="70" align="left">物资描述</th>
                <th width="70" align="center">厂家</th>
                <th width="70" align="left">扩展编码</th>
                <th width="50" align="center">计量单位</th>
                <th width="70" align="center">退料数量</th>
                <th width="50" align="center">单价</th>
                <th width="50" align="center">总价</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach ($list as $v):
                $i++;  ?>
                <tr>
                    <td align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo $v['batchCode'];?></td>
                    <td align="center"><?php echo $v['goodsCode'];?></td>
                    <td align="center"><?php echo $v['goodsName'];?></td>
                    <td align="center"><?php echo $v['factory'];?></td>
                    <td align="center"><?php echo $v['extendCode'];?></td>
                    <td align="center"><?php echo $v['unit'];?></td>
                    <td align="center"><?php echo floatval($v['number']);?></td>
                    <td align="center"><?php echo floatval($v['price']);?></td>
                    <td align="center"><?php echo floatval($v['price']*$v['number']);?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
        <tr class="row" style="height: 30px;text-align: center;">
            <td width="200px"style="padding-bottom:50px;color:#666">工区专职<br />（签字）</td>
            <td width="200px"style="padding-bottom:50px;color:#666">工区领导<br />（签字）</td>
            <td width="200px"style="padding-bottom:50px;color:#666">发料人<br />（签字）</td>
            <td width="200px"style="padding-bottom:50px;color:#666">领料人<br />（签字）</td>
            <td width="200px"style="padding-bottom:50px;color:#666">发料时间<br />________年_____月______日</td>
        </tr>
    </table>
    <?php if($returnForm->state=='zf'):?>
    <label style="color: #f00">作废原因：<?=$returnForm->opinion;?></label>
    <?php endif;?>
</div>
<style media="print">
    #printWin{display:none;}
</style>
<div style="text-align:center;padding:9px;" id="printWin">
    <?php if($exam):?>
        <button type="button" rel="no" class="grid_button">作废</button>
        <input id="opinion" name="opinion" placeholder="作废原因" style="width:200px;line-height:22px;padding-left: 5px;margin-right: 15px;" />

        <button type="button" rel="ok" class="grid_button">通过</button>
    <?php endif;?>
    <button type="button" class="grid_button" onclick="print()">打印</button>
</div>
</form>