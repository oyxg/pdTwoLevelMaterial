
<script>
    $(function () {
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
<span style="color: #F00;padding-left: 10px;display: none;" id="tip">* 该物资编码已经存在，除入库数量可以修改，其他数据若要修改请前往物资列表</span>
<form id="form" name="form" class="" method="post"
      <?php if($edit):?>
          action="<?= Yii::app()->createUrl("scrap/EditSTdata") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("scrap/AddForm") ?>"
      <?php endif;?>>
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <tr>
            <td>
                <table align="center" class="github_tb">
                    <tbody>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>资产编号：</td>
                        <td><input name="goodsCode" id="goodsCode" type="text" class="grid_text" <?php if($Edit){echo 'disabled';}//当修改物资时，编号不可改?> value="<?= $data['goodsCode']?>"></td>
                        <?php if($isEdit){echo "<input type=\"hidden\" name=\"oldgCode\" value=\"".$oldgCode."\" />";}?>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>物资描述：</td>
                        <td><input name="goodsName" id="goodsName" type="text" class="grid_text"  value="<?= $data['goodsName']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">规格型号：</td>
                        <td><input name="standard" id="standard" type="text" class="grid_text"  value="<?= $data['standard']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">计量单位：</td>
                        <td><input name="unit" id="unit" type="text" class="grid_text"  value="<?= $data['unit']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">设计折旧数量：</td>
                        <td><input name="designNum" id="designNum" type="text" class="grid_text"  value="<?= $data['designNum']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>实退数量：</td>
                        <td><input name="number" id="number" type="text" class="grid_text"  value="<?= $data['number']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">备注：</td>
                        <td><input name="remark" id="remark" type="text" class="grid_text"  value="<?= $data['remark']?>"></td>
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
