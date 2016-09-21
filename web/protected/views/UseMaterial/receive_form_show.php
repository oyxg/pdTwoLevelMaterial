<script type="text/javascript" src="/plugin/module/use_material.js"></script>
<script>
    $(function(){
        //报废表id
        var formID = <?= $receiveForm->id;?>;
        //审核通过
        $("button[rel=ok]").click(function(){
            UseMaterial.receiveOk(formID);
            parent.location.reload();
        });
        //退回
        $("button[rel=no]").click(function(){
            UseMaterial.receiveNo(formID);
            parent.location.reload();
        });
        $("input[type='number']").change(function(){
            $.post(
                "/UseMaterial/EditExamine.html",
                {
                    formID : formID,
                    materialID : $(this).attr('materialID'),
                    number : $(this).val()
                },
                function(data){
                    if(data.status==1){
                        maya.notice.success(data.info);
                    }else{
                        maya.notice.fail(data.info);
                    }
                },
                "json"
            );
        });
        //备注变化时更新
        $(".remark").change(function(){
            $.post(
                "/UseMaterial/EditRemark.html",
                {
                    formID : formID,
                    materialID : $(this).attr('materialID'),
                    remark : $(this).val()
                },
                function(data){
                    if(data.status==1){
                        maya.notice.success(data.info);
                    }else{
                        maya.notice.fail(data.info);
                    }
                },
                "json"
            );
        });
    });
</script>


<form id="form" name="form" class="" action="" method="post" >
<div style="padding:10px">
    <div style="letter-spacing:20px; text-align:center;padding:0px 0px 5px 0px ;font-size:20px;font-weight:bold;"> 领料单 </div>
    <div class="tag"> 基本信息</div>
    <div class="tagc">
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr height="30">
                <td width="90" align="right"><strong>单号：</strong></td>
                <td width="170"><?= $receiveForm->formCode?></td>
                <td width="70" align="right"><strong>项目名称：</strong></td>
                <td width="170"><?= $receiveForm->glPro?></td>
                <td width="70" align="right"><strong>项目编号：</strong></td>
                <td width="170"><?= $receiveForm->glProCode?></td>
                <td width="70" align="right"><strong>领料性质：</strong></td>
                <td width="170"><?= $receiveForm->batchCode?></td>
            </tr>
            <tr height="30">
                <td width="70" align="right"><strong>班组：</strong></td>
                <td width="170"><?= $receiveForm->bz?></td>
                <td width="70" align="right"><strong>备注：</strong></td>
                <td width="170" colspan="3"><?= $receiveForm->remark?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tag"> 领料物资列表</div>
    <div class="tagc" id="xx" style="min-height:100px;">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="github_tb">
            <thead>
            <tr class="row">
                <th align="center">序号</th>
                <th align="center">仓库</th>
                <th align="center">批次号</th>
                <th align="center">物资编码</th>
                <th width="70" align="left">物资描述</th>
                <th width="70" align="left">扩展编码</th>
                <th width="50" align="center">单位</th>
                <th width="50" align="center">单价</th>
                <?php if($exam):?>
                    <th width="70" align="center">可领用数</th>
                <?php endif;?>
                <th width="70" align="center">请领数</th>
                <th width="70" align="center">实发数</th>
                <th width="50" align="center">总价</th>
                <th width="70" align="center">备注</th>
                <?php if($exam):?>
                <th width="50" align="center">操作</th>
                <?php endif;?>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach ($list as $v):
                $i++;  ?>
                <tr>
                    <td align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo Store::model()->getName(Material::model()->find("materialID='{$v['materialID']}'")->storeID);?></td>
                    <td align="center"><?php echo $v['batchCode'];?></td>
                    <td align="center"><?php echo $v['goodsCode'];?></td>
                    <td align="center"><?php echo $v['goodsName'];?></td>
                    <td align="center"><?php echo $v['extendCode'];?></td>
                    <td align="center"><?php echo $v['unit'];?></td>
                    <td align="center"><?php echo floatval($v['price']);?></td>
                <?php if($exam){?>
                    <td align="center"><?php echo $applyNum = floatval(Material::model()->find("materialID='{$v['materialID']}'")->applyNum+$v['number']);?></td>
                    <td align="center"><?php echo floatval($v['number']);?></td>
                    <td align="center"><input type="number" class="grid_text" style="text-align:center;width:50px;" size="3" maxlength="3" materialID="<?=$v['materialID']?>" value="<?php echo floatval($v['number']);?>"></td>
                <?php }else{?>
                    <td align="center"><?php echo floatval($v['number']);?></td>
                    <td align="center"><?php echo floatval($v['sfnumber']);?></td>
                <?php }?>
                    <td align="center"><?php echo floatval($v['price']*$v['number']);?></td>
                <?php if($exam){?>
                    <td align="center"><input type="text" class="grid_text remark" style="text-align:left;width:70px;" materialID="<?=$v['materialID']?>" value="<?php echo $v['remark'];?>"></td>
                    <td align="left"><button  onclick="UseMaterial.DelExamine(<?=$v['materialID'];?>,<?= $receiveForm->id;?>);">删除</button></td>
                <?php }else{?>
                    <td align="center"><?php echo $v['remark'];?></td>
                <?php }?>
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
            <td width="200px"style="padding-bottom:50px;color:#666">领料人<br />（签字）</td><?php /* $receiveForm->batchCode*/ ?>
            <td width="200px"style="padding-bottom:50px;color:#666">领料时间<br /><?=empty($receiveForm->outTime)?"__________年_____月_____日":$receiveForm->outTime;?></td>
        </tr>
    </table>
    <?php if($receiveForm->state=='zf'):?>
    <label style="color: #f00">作废原因：<?=$receiveForm->opinion;?></label>
    <?php endif;?>
</div>
<style media="print">
    #printWin{display:none;}
</style>
<div style="text-align:center;padding:9px;" id="printWin">
    <?php if($exam):?>
        <button type="button" rel="no" class="grid_button">作废</button>
        <input typ="text" id="opinion" name="opinion" placeholder="作废原因" style="width:200px;line-height:22px;padding-left: 5px;margin-right: 15px;" />

        <button type="button" rel="ok" class="grid_button">通过</button>
    <?php endif;?>
    <button type="button" class="grid_button" onclick="print()">打印</button>
</div>
</form>
