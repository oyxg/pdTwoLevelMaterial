<!-- 日历插件js & css -->
<script type="text/javascript" src="/plugin/lhgcalendar/lhgcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/lhgcalendar/skins/lhgcalendar.css"/>
<script>
    $(function () {
        //日历插件
        $("#date").calendar({
            format : "yyyy-MM-dd"
        });

        $('#focus').focus();

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
      <?php if($Edit):?>
          action="<?= Yii::app()->createUrl("Instrument/EditInstrumentIn") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("Instrument/AddInstrumentIn") ?>"
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
                            <td width="100" align="right"><label>＊</label>存放地点：</td>
                            <td><select class="grid_text" name="storeAddress" style="height: 24px">
                                    <option></option>
                                    <?php
                                    $Instrument = new InstrumentIn();
                                    $bzs = $Instrument->getBzList();
                                    for($i=0;$i<count($bzs);$i++): ?>
                                        <option value="<?=$i?>"<?php if($i==$data['storeAddress'])echo "selected";?>><?=$bzs[$i]?></option>
                                    <?php endfor;?>
                                </select></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right"><label>＊</label>状态：</td>
                            <td><select name="state" id="state" class="grid_text">
                                    <option value="zc" <?php if($data['state']=="norm")echo "selected";?>>正常</option>
                                    <option value="send" <?php if($data['state']=="send")echo "selected";?>>送修</option>
                                    <option value="scrap" <?php if($data['state']=="scrap")echo "selected";?>>报废</option>
                                </select></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right"><label>＊</label>领用数量：</td>
                            <td><input name="num" type="text" class="grid_text"  value="<?= $data['num']?>"></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">项目编号：</td>
                            <td><input name="projectCode" type="text" class="grid_text"  value="<?= $data['projectCode']?>"></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">项目名称：</td>
                            <td><input name="projectName" type="text" class="grid_text"  value="<?= $data['projectName']?>"></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">物资编码：</td>
                            <td><input name="materialCode" type="text" class="grid_text"  value="<?= $data['materialCode']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">资产卡号：</td>
                            <td><input name="card" type="text" class="grid_text"  value="<?= $data['card']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">SAP编号：</td>
                            <td><input name="SAP" type="text" class="grid_text"  value="<?= $data['SAP']?>" /></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr class="row">
                            <td width="100" align="right">设备编号：</td>
                            <td><input name="equCode" type="text" class="grid_text"  value="<?= $data['equCode']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">生产厂家：</td>
                            <td><input name="factory" type="text" class="grid_text"  value="<?= $data['factory']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">生产编号：</td>
                            <td><input name="factoryCode" type="text" class="grid_text"  value="<?= $data['factoryCode']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">生产日期：</td>
                            <td><input name="factoryDate" id="date" type="text" class="grid_text"  value="<?= $data['factoryDate']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">配送单位：</td>
                            <td><input name="distribution" type="text" class="grid_text"  value="<?= $data['distribution']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">联系人：</td>
                            <td><input name="contact" type="text" class="grid_text"  value="<?= $data['contact']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" align="right">联系电话：</td>
                            <td><input name="tel" type="text" class="grid_text"  value="<?= $data['tel']?>" /></td>
                        </tr>
                        <tr class="row">
                            <td width="100" height="22" align="right">　</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
    </table>

    <div align="center" style="margin:20px auto 20px auto">
        <button type="submit" class="grid_button grid_button_l">确定提交</button>
    </div>
</form>