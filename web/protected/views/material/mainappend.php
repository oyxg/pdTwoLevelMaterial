<script>
    $(function () {
        $("#form").submit(function () {
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
                        });
                    }
                }
            };
            $(form).ajaxSubmit(ajaxOpt);
            return false;
        });

        $('#qrCode').focus();
    });
</script>
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
<script>
    function pre(goodname) {
        $.ajax({
            type: 'POST',
            url: '/material/Getpre',
            data: {goodname: goodname},
            success: function (msg) {
                $('#sx').html(msg);
            }
        })
    }
    $(function () {
        var goodname = "<?=Yii::app()->session['goodName'];?>";
        if(goodname){
            pre(goodname);
        }
    });
</script>
<form id="form" name="form" class="" method="post" >
    <table align="center" class="github_tb">
        <tbody>
            <tr class="row">
                <td width="100" align="right">物资描述：</td>
                <td>
                    <select onchange="javascript:pre(this.value)" id="name" type="text" />
                    <option><?=$goodName;?></option>
                    <?php
                    $db = Yii::app()->db;
                    $storeID = UserStore::getStoreByUserID()->storeID;
                    $sql = "SELECT distinct g.goodsName FROM mod_material m,mod_goods g WHERE m.goodsID=g.goodsID AND m.storeID = {$storeID} AND g.mtype=1";
                    $command = $db->createCommand($sql);
                    $data = $command->queryAll();
                    foreach ($data as $k => $v) {
                        if(Yii::app()->session['goodName']==$v['goodsName']){
                        ?>
                            <option  value="<?php echo $v['goodsName']; ?>" selected="selected"><?php echo $v['goodsName']; ?></option>
                        <?php }else{?>
                            <option  value="<?php echo $v['goodsName']; ?>"><?php echo $v['goodsName']; ?></option>
                        <?php
                    }}
                    ?>
                    </select>
                </td>
            </tr>
            <tr class="row">
                <td width="100" align="right">型号：</td>
                <td id="sx">

                </td>
            </tr>
            <tr class="row">
                <td width="100" align="right">资产编号：</td>
                <td><input name="bh" id="bh" type="text" class="grid_text"  value=""></td>
            </tr>
            <tr class="row">
                <td width="100" align="right">产品参数：</td>
                <td><input name="cs" id="cs" type="text" class="grid_text"  value=""></td>
            </tr>
            <tr class="row">
                <td width="100" align="right">生产时间：</td>
                <td><input name="sj1" id="sj1" type="date" class="grid_text"  value=""></td>
            </tr>
            <tr class="row">
                <td width="100" align="right">入库时间：</td>
                <td><input name="sj2" id="sj2" type="date" class="grid_text"  value="<?=$time;?>"></td>
            </tr>
            <tr class="row">
                <td width="100" align="right">摘要：</td>
                <td><input name="zy" id="zy" type="text" class="grid_text"  value=""></td>
            </tr>
            <tr class="row">
                <td width="100" align="right">供货商：</td>
                <td><input name="ghs" id="ghs" type="text" class="grid_text"  value=""></td>
            </tr>
        </tbody>
    </table>
    <div align="center">
        <button type="submit" class="grid_button grid_button_l">确定入库</button>
    </div>
</form>
