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
<div style="letter-spacing:20px; text-align:center;padding:15px 0px 15px 0px ;font-size:18px;font-weight:bold;"> 物资信息 </div>
<form id="form" name="form" class="" method="post"
      <?php if($Edit):?>
          action="<?= Yii::app()->createUrl("PreFloodMaterial/edit") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("PreFloodMaterial/AddForm") ?>"
      <?php endif;?>>
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <tr class="row">
            <td width="100" align="right"><label>＊</label>分类：</td>
            <td><select  name="className" id="className" type="text" class="grid_text" style="width:140px;height: 24px;">
                    <option value="">-请选择-</option>
                    <option value="个人防护用品">个人防护用品</option>
                    <option value="排水物资">排水物资</option>
                    <option value="挡水物资">挡水物资</option>
                    <option value="照明工具">照明工具</option>
                    <option value="辅助配套物资">辅助配套物资</option>
                </select></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">配置级别：</td>
            <td><input name="pzlevel" id="pzlevel" type="text" class="grid_text"  value="<?= $data['pzlevel']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">单位：</td>
            <td><input name="unit" id="unit" type="text" class="grid_text"  value="<?= $data['unit']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">技术规范：</td>
            <td><input name="jsgf" id="jsgf" type="text" class="grid_text"  value="<?= $data['jsgf']?>"></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">一班需求：</td>
            <td><input name="a_xq" id="a_xq" type="text" class="grid_text"  value="<?= $data['a_xq']?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">二班需求：</td>
            <td><input name="b_xq" id="b_xq" type="text" class="grid_text"  value="<?= $data['b_xq']?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">三班需求：</td>
            <td><input name="c_xq" id="c_xq" type="text" class="grid_text"  value="<?= $data['c_xq']?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">四班需求：</td>
            <td><input name="d_xq" id="d_xq" type="text" class="grid_text"  value="<?= $data['d_xq']?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">五班需求：</td>
            <td><input name="e_xq" id="e_xq" type="text" class="grid_text"  value="<?= $data['e_xq']?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">六班需求：</td>
            <td><input name="f_xq" id="f_xq" type="text" class="grid_text"  value="<?= $data['f_xq']?>" /></td>
        </tr>
    </table>

    <div align="center" style="margin:20px auto 20px auto">
        <button type="submit" class="grid_button grid_button_l">确定提交</button>
    </div>
</form>