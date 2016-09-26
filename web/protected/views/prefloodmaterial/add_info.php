<!-- 日历插件js & css -->
<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>
<script>
    $(function () {
        //日历插件
        $("#validityDate").calendar({
            format : "yyyy-MM-dd"
        });
        //物资编码获取焦点
        $('#goodsCode').focus();
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
    });
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
<form id="form" name="form" class="" method="post"
      <?php if($Edit):?>
          action="<?= Yii::app()->createUrl("PreFloodMaterial/EditPreFloodInfo") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("PreFloodMaterial/AddPreFloodInfo") ?>"
      <?php endif;?>>
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <?php if($Edit):?>
            <input name="id" id="id" type="hidden" value="<?= $data['id']?>">
        <?php endif; ?>
        <tr>
            <td width="100" align="right"><label>＊</label>分类：</td>
            <td><select  name="className" id="className" type="text" class="grid_text" style="width:140px;height: 24px;">
                    <option value="">-请选择-</option>
                    <?php
                    $PreFlood = new PreFloodInfo();
                    $types = $PreFlood->model()->getType();
                    foreach($types as $type): ?>
                        <option value="<?=$type?>"<?php if($type==$data['className'])echo "selected";?>><?=$type?></option>
                    <?php endforeach;?>
                </select></td>
        </tr>
        <tr class="row">
            <td width="100" align="right"><label>＊</label>物资名称：</td>
            <td><input name="name" id="name" type="text" class="grid_text"  value="<?= $data['name']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">单价：</td>
            <td><input name="price" id="price" type="text" class="grid_text"  value="<?= $data['price']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">单位：</td>
            <td><input name="unit" id="unit" type="text" class="grid_text"  value="<?= $data['unit']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">规格型号：</td>
            <td><input name="standard" id="standard" type="text" class="grid_text"  value="<?= $data['standard']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">技术规范：</td>
            <td><input name="jsgf" id="jsgf" type="text" class="grid_text"  value="<?= $data['jsgf']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">配置级别：</td>
            <td><input name="pzlevel" id="pzlevel" type="text" class="grid_text"  value="<?= $data['pzlevel']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">配置标准：</td>
            <td><input name="configure" id="configure" type="text" class="grid_text" value="<?= $data['configure']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">厂家：</td>
            <td><input name="factory" id="factory" type="text" class="grid_text"  value="<?= $data['factory']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">出厂编号：</td>
            <td><input name="bh" id="bh" type="text" class="grid_text"  value="<?= $data['bh']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">联系人：</td>
            <td><input name="contact" id="contact" type="text" class="grid_text"  value="<?= $data['contact']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">联系方式：</td>
            <td><input name="tel" id="tel" type="text" class="grid_text"  value="<?= $data['tel']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">备注：</td>
            <td><input name="remark" id="remark" type="text" class="grid_text"  value="<?= $data['remark']?>"></td>
        </tr>
    </table>

    <div align="center" style="margin:20px auto 20px auto">
        <button type="submit" class="grid_button grid_button_l">确定提交</button>
    </div>
</form>