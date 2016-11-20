
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
    });
</script>
<form id="form" name="form" class="" method="post" action="<?= Yii::app()->createUrl("PreFloodMaterial/AddPreFloodClass") ?>">
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <tr>
            <td width="100" align="right"><label>＊</label>物资分类：</td>
            <td><input name="name" type="text" class="grid_text"  value=""></td>
        </tr>
    </table>

    <div align="center" style="margin:10px auto 10px auto">
        <button type="submit" class="grid_button">确定提交</button>
    </div>
</form>