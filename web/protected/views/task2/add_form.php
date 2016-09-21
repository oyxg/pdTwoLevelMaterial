
<script>
    $(function () {
        //物资编码获取焦点
        $('#goodsName').focus();
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
<form id="form" name="form" class="" method="post"
      <?php if($edit):?>
          action="<?= Yii::app()->createUrl("task/EditTTdata") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("task/AddForm")?><?php if($add!="add")echo "?edit=edit";?>"
      <?php endif;?>>
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <tr>
            <td>
                <table align="center" class="github_tb">
                    <tbody>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>物资名称：</td>
                        <td><input name="goodsName" id="goodsName" type="text" class="grid_text"  value="<?= $data['goodsName']?>">
                            <input name="old_goodsName" id="old_goodsName" type="hidden"  value="<?= $data['goodsName']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">型号规格及参数：</td>
                        <td><input name="standard" id="standard" type="text" class="grid_text"  value="<?= $data['standard']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">单位：</td>
                        <td><input name="unit" id="unit" type="text" class="grid_text"  value="<?= $data['unit']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">单价：</td>
                        <td><input name="price" id="price" type="text" class="grid_text"  value="<?= $data['price']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>数量：</td>
                        <td><input name="number" id="number" type="text" class="grid_text"  value="<?= $data['number']?>"></td>
                    </tr>
                    </tbody>
                </table>
            </td><!-- 右侧 -->
        </tr>
    </table>
    <div align="center" style="margin:20px auto 20px auto">
        <button type="submit" class="grid_button grid_button_l">确定提交</button>
    </div>
</form>