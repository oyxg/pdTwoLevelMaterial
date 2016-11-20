<script type="text/javascript" src="/plugin/module/material.js"></script>
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

        //添加分类
        $("a[rel=addClass]").click(function(){
            Material.addInstrumentClass();
        });
    });
</script>
<form id="form" name="form" class="" method="post"
      <?php if($Edit):?>
          action="<?= Yii::app()->createUrl("Instrument/EditInstrumentInfo") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("Instrument/AddInstrumentInfo") ?>"
      <?php endif;?>>
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <?php if($Edit):?>
            <input name="id" id="id" type="hidden" value="<?= $data['id']?>">
        <?php endif; ?>
        <tr>
            <td>
                <table>
                    <tr>
                        <td width="70" align="right"><label>＊</label>物资分类：</td>
            <!--            <td><input name="cID" type="text" class="grid_text"  value="--><?//= $data['className']?><!--"></td>-->
                        <td>
                            <select  name="className" type="text" class="grid_text" style="width:100px;height: 24px;">
                                <option value="">-请选择-</option>
                                <?php
                                $instrumentClass = new InstrumentClass();
                                $class = $instrumentClass->model()->getList();
                                foreach($class as $row): ?>
                                    <option value="<?=$row->name?>"<?php if($row->name==$data['className'])echo "selected";?>><?=$row->name?></option>
                                <?php endforeach;?>
                            </select>
                            <a href="#" rel="addClass">添加分类</a>
                        </td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right"><label>＊</label>物资名称：</td>
                        <td><input name="name" type="text" class="grid_text"  value="<?= $data['name']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right"><label>＊</label>配置数量：</td>
                        <td><input name="num" type="text" class="grid_text"  value="<?= $data['num']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right"><label>＊</label>配置单价：</td>
                        <td><input name="price" type="text" class="grid_text"  value="<?= $data['price']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right">配置单位：</td>
                        <td><input name="unit" type="text" class="grid_text"  value="<?= $data['unit']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right">规格型号：</td>
                        <td><input name="standard" type="text" class="grid_text"  value="<?= $data['standard']?>"></td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr class="row">
                        <td width="70" align="right">物资编号：</td>
                        <td><input name="mbh" type="text" class="grid_text"  value="<?= $data['mbh']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right">公司编号：</td>
                        <td><input name="cbh" type="text" class="grid_text"  value="<?= $data['cbh']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right">技术规范：</td>
                        <td><input name="jsgf" type="text" class="grid_text"  value="<?= $data['jsgf']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right">是/否标配：</td>
                        <td style="height: 24px">
                            <input name="isBp" type="radio" value="y" <?=$data['isBp']==="y"||$data['isBp']===null ? "checked" : ""?> />
                            是
                            <input name="isBp" type="radio" value="n" <?=$data['isBp']==="n" ? "checked" : ""?> />
                            否
                        </td>
                    </tr>
                    <tr class="row">
                        <td width="70" align="right">是/否资产：</td>
                        <td style="height: 24px">
                            <input name="isZc" type="radio" value="y" <?=$data['isZc']==="y"||$data['isZc']===null ? "checked" : ""?> />
                            是
                            <input name="isZc" type="radio" value="n" <?=$data['isZc']==="n" ? "checked" : ""?> />
                            否
                        </td>
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