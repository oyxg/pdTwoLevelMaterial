<script type="text/javascript" src="/plugin/module/material.js"></script>
<script>
    $(function(){
        //报废表id
        var formID = <?= $scrapForm->id;?>;
        //审核通过
        $("button[rel=ok]").click(function(){
            Material.scrapOk(formID);
            parent.location.reload();
        });
        //退回
        $("button[rel=back]").click(function(){
            Material.scrapBack(formID);
            parent.location.reload();
        });
    });
</script>


<form id="form" name="form" class="" action="" method="post" >
<div style="padding:10px">
    <div style="letter-spacing:20px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 物资报废鉴定审批表 </div>
    <div class="tag"> 基本信息</div>
    <div class="tagc">
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr height="30">
                <td width="50" align="right"><strong>日期：</strong></td>
                <td width="170"><?= $scrapForm->date?></td>
                <td width="90" align="right"><strong>报废表编号：</strong></td>
                <td width="170"><?= $scrapForm->formCode?></td>
                <td width="70" align="right"><strong>项目名称：</strong></td>
                <td width="170"><?= $scrapForm->projectName?></td>
                <td width="70" align="right"><strong>项目编号：</strong></td>
                <td width="170"><?= $scrapForm->projectCode?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tag"> 报废物资列表</div>
    <div class="tagc" id="xx" style="min-height:100px;">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
            <thead>
            <tr class="row">
                <th width="50" align="center">序号</th>
                <th align="70">资产编号</th>
                <th width="70" align="left">物资描述</th>
                <th width="70" align="left">规格型号</th>
                <th width="50" align="center">计量单位</th>
                <th width="70" align="center">设计折旧数量</th>
                <th width="50" align="center">实退数量</th>
                <th align="left">备注</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach ($list as $v):
                $i++;  ?>
                <tr>
                    <td align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo $v['goodsCode'];?></td>
                    <td align="center"><?php echo $v['goodsName'];?></td>
                    <td align="center"><?php echo $v['standard'];?></td>
                    <td align="center"><?php echo $v['unit'];?></td>
                    <td align="center"><?php echo $v['designNum'];?></td>
                    <td align="center"><?php echo $v['number'];?></td>
                    <td align="left"><?php echo $v['remark'];?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
        <tr class="row">
            <td width="200px" align="center">技术鉴定意见</td>
            <td colspan="4">
                <textarea id="opinion" name="opinion" style="width: 100%;"><?php if($scrapForm->state=="2")echo $scrapForm->opinion;?></textarea>
            </td>
        </tr>
        <tr class="row" style="height: 30px;text-align: center;">
            <td width="200px"style="padding-bottom:80px;">经办人<br />（签字）</td>
            <td width="200px"style="padding-bottom:80px;">填报单位审核意见<br />（签字、盖章）</td>
            <td width="200px"style="padding-bottom:80px;">项目主管部门审核意见<br />（签字、盖章）</td>
            <td width="200px"style="padding-bottom:80px;">专业部门技术鉴定意见<br />（签字、盖章）</td>
            <td width="200px"style="padding-bottom:80px;">财务部门审批意见<br />（签字、盖章）</td>
        </tr>
    </table>
    注：1、本表一式四份，项目部门、专业技术部门、财务部门以及物资部门各存一份。2、技术鉴定意见必须针对报废原因填写简要文字说明

</div>
<style media="print">
    #printWin{display:none;}
</style>
    <?php if($scrapForm->state==1):?>
        <p style="color: #ff0000;margin: 0;padding:0 0 0 15px;">退回原因：<?= $scrapForm->opinion;?></p>
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