
<script>
    $(function () {
        //提交事件
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
                            //location.reload();
                            parent.location.reload();
                        });
                    }
                }
            };
            $(form).ajaxSubmit(ajaxOpt);
            return false;
        });

        function getPz(){
            var mID = $("input[name='mID']").val();
            $.ajax({
                type: 'POST',
                url: '/PreFloodMaterial/GetPzInfo',
                data: {
                    mid: mID
//                    bzID: bzID
                },
                success: function (msg) {
                    console.info(msg);
                    $('#pz_level').val(msg.pzlevel);
                    $('#pz_num').val(msg.configure);
                    $('#pz_unit').val(msg.unit);
                },
                dataType: "json"
            });
        }
        getPz();
        $('#bzID').change(function(){
            getPz();
        });
    });
//    function pre(goodname) {
//        $.ajax({
//            type: 'POST',
//            url: '/material/Getpre',
//            data: {goodname: goodname},
//            success: function (msg) {
//                $('#sx').html(msg);
//            }
//        })
//    }
//    $(function () {
//        var goodname = "<?//=Yii::app()->session['goodName'];?>//";
//        if(goodname){
//            pre(goodname);
//        }
//    });



</script>

<form id="form" name="form" class="" method="post"
      <?php if($Edit):?>
          action="<?= Yii::app()->createUrl("PreFloodMaterial/EditPreFloodIn") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("PreFloodMaterial/AddPreFloodIn") ?>"
      <?php endif;?>>
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <?php if($Edit):?>
            <input type="hidden" name="id" value="<?=$data['id'];?>" />
        <?php endif;?>
        <input type="hidden" name="mID" value="<?=$mID==""?$data['mID']:$mID;?>" />
        <tr>
            <td>
                <table>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>班组：</td>
                        <td><select  name="bzID" id="bzID" type="text" class="grid_text" style="width:100px;height: 24px;">
                                <option value="">-请选择-</option>
                                <?php
                                $PreFlood = new PreFloodIn();
                                $bzs = $PreFlood->getBzList();
                                for($i=0;$i<count($bzs);$i++): ?>
                                    <option value="<?=$i?>"<?php if($i==$data['bzID'])echo "selected";?>><?=$bzs[$i]?></option>
                                <?php endfor;?>
                            </select></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>状态：</td>
                        <td><select name="state" id="state" class="grid_text">
                                <option value="zc" <?php if($data['state']=="zc")echo "selected";?>>正常</option>
                                <option value="send" <?php if($data['state']=="send")echo "selected";?>>送修</option>
                                <option value="scrap" <?php if($data['state']=="scrap")echo "selected";?>>报废</option>
                            </select></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>领用数量：</td>
                        <td><input name="num" id="num" type="text" class="grid_text"  value="<?= $data['num']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">项目编号：</td>
                        <td><input name="projectCode" id="projectCode" type="text" class="grid_text"  value="<?= $data['projectCode']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">项目名称：</td>
                        <td><input name="projectName" id="projectName" type="text" class="grid_text"  value="<?= $data['projectName']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">工单号：</td>
                        <td><input name="workCode" id="workCode" type="text" class="grid_text"  value="<?= $data['workCode']?>" /></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">ERP领料单：</td>
                        <td><input name="erpLL" id="erpLL" type="text" class="grid_text"  value="<?= $data['erpLL']?>" /></td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="100" align="right">配置级别：</td>
                        <td><input id="pz_level" class="grid_text" value="" disabled /></td>
                    </tr>
                    <tr>
                        <td width="100" align="right">配置数量：</td>
                        <td><input id="pz_num" class="grid_text" value="" disabled /></td>
                    </tr>
                    <tr>
                        <td width="100" align="right">配置单位：</td>
                        <td><input id="pz_unit" class="grid_text" value="" disabled /></td>
                    </tr>
                    <tr class="row">
                        <td style="height: 24px">　</td>
                        <td>　</td>
                    </tr>
                    <tr class="row">
                        <td style="height: 24px">　</td>
                        <td>　</td>
                    </tr>
                    <tr class="row">
                        <td style="height: 24px">　</td>
                        <td>　</td>
                    </tr>
                    <tr class="row">
                        <td style="height: 24px">　</td>
                        <td>　</td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <div align="center" style="margin:20px auto 20px auto">
        <button type="submit" class="grid_button grid_button_l">确定提交</button>
    </div>
</form>