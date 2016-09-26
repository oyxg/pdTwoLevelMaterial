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
<form id="form" name="form" class="" method="post" action="<?= Yii::app()->createUrl("PreFloodMaterial/SetPreFloodNeed") ?>">
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <input name="mID" id="mID" type="hidden"  value="<?php echo $_GET['id'];?>" />
        <tr class="row">
            <td width="100" align="right">一班需求：</td>
            <td><input name="1" id="1" type="text" class="grid_text"  value="<?php echo $data[1]?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">二班需求：</td>
            <td><input name="2" id="2" type="text" class="grid_text"  value="<?php echo $data[2]?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">三班需求：</td>
            <td><input name="3" id="3" type="text" class="grid_text"  value="<?php echo $data[3]?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">四班需求：</td>
            <td><input name="4" id="4" type="text" class="grid_text"  value="<?php echo $data[4]?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">五班需求：</td>
            <td><input name="5" id="5" type="text" class="grid_text"  value="<?php echo $data[5]?>" /></td>
        </tr>
        <tr class="row">
            <td width="100" align="right">六班需求：</td>
            <td><input name="6" id="6" type="text" class="grid_text"  value="<?php echo $data[6]?>" /></td>
        </tr>
    </table>

    <div align="center" style="margin:20px auto 20px auto">
        <button type="submit" class="grid_button grid_button_l">确定提交</button>
    </div>
</form>