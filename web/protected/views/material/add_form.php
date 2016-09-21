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

    //输入物资编码后，出发onchange事件，通过ajax发到服务器端验证。如果存在相同编码，返回该编码的物资数据。输入到对应框中。并将除数量外的字段设置不可编辑。
    function checkCode(){
        $.post(
            "/material/checkCode",
            {
                goodsCode : $('#goodsCode').val()
            },
            function(data){
                if(data.status==1){
                    maya.notice.success(data.info,function(){
//                        console.info(data.data);
                        $('#storeID').val(data.data['storeID']);
                        $('#goodsName').val(data.data['goodsName']);
                        $('#currCount').val(data.data['currCount']);
                        $('#minCount').val(data.data['minCount']);
                        $('#standard').val(data.data['standard']);
                        $('#price').val(data.data['price']);
                        $('#unit').val(data.data['unit']);
                        $('#validityDate').val(data.data['validityDate']);
                        $('#workCode').val(data.data['workCode']);
                        $('#batchCode').val(data.data['batchCode']);
                        $('#extendCode').val(data.data['extendCode']);
                        $('#erpLL').val(data.data['erpLL']);
                        $('#erpCK').val(data.data['erpCK']);
                        $('#factory').val(data.data['factory']);
                        $('#factory_contact').val(data.data['factory_contact']);
                        $('#factory_tel').val(data.data['factory_tel']);
                        $('#remark').val(data.data['remark']);

//                        $('#storeID').attr({ readonly: 'true' });
                        $('#goodsName').attr({ readonly: 'true' });
//                        $('#currCount').attr({ readonly: 'true' });
//                        $('#minCount').attr({ readonly: 'true' });
//                        $('#standard').attr({ readonly: 'true' });
//                        $('#price').attr({ readonly: 'true' });
//                        $('#unit').attr({ readonly: 'true' });
//                        $('#validityDate').attr({ readonly: 'true' });
//                        $('#workCode').attr({ readonly: 'true' });
//                        $('#batchCode').attr({ readonly: 'true' });
//                        $('#extendCode').attr({ readonly: 'true' });
//                        $('#erpLL').attr({ readonly: 'true' });
//                        $('#erpCK').attr({ readonly: 'true' });
//                        $('#factory').attr({ readonly: 'true' });
//                        $('#factory_contact').attr({ readonly: 'true' });
//                        $('#factory_tel').attr({ readonly: 'true' });
//                        $('#remark').attr({ readonly: 'true' });
                        $('#tip').show();
                        $('input').each(function(){
                            if($(this).attr('readonly')){
                                $(this).css('background','#aaa');
                            }
                        });
                    });
                }else{
                    $('input').each(function(){
                        if($(this).attr('readonly')){
                            $(this).css('background','#fff');
                        }
                    });
//                        $('#storeID').removeAttr("readonly");
                    $('#goodsName').removeAttr("readonly");
//                        $('#currCount').removeAttr("readonly");
                    $('#minCount').removeAttr("readonly");
                    $('#standard').removeAttr("readonly");
                    $('#price').removeAttr("readonly");
                    $('#unit').removeAttr("readonly");
                    $('#validityDate').removeAttr("readonly");
                    $('#workCode').removeAttr("readonly");
//                    $('#batchCode').removeAttr("readonly");
                    $('#extendCode').removeAttr("readonly");
                    $('#erpLL').removeAttr("readonly");
                    $('#erpCK').removeAttr("readonly");
                    $('#factory').removeAttr("readonly");
                    $('#factory_contact').removeAttr("readonly");
                    $('#factory_tel').removeAttr("readonly");
                    $('#remark').removeAttr("readonly");
                    $('#tip').hide();

                }
            },
            "json"
        );
    }
</script>
<div style="letter-spacing:20px; text-align:center;padding:15px 0px 15px 0px ;font-size:18px;font-weight:bold;"> 物资信息 </div>
<span style="color: #F00;padding-left: 10px;display: none;" id="tip">* 该物资编码已经存在，除【入库数量】、【仓库】、【工单号】、【批次号】、【ERP领料单】、【ERP领料单】可以修改，其他数据请前往物资列表修改</span>
<form id="form" name="form" class="" method="post"
      <?php if($Edit):?>
          action="<?= Yii::app()->createUrl("material/edit") ?>"
      <?php else:?>
          action="<?= Yii::app()->createUrl("material/AddForm") ?>"
      <?php endif;?>>
    <table align="center" class="github_tb" style="margin-top: 0px;">
        <tr>
            <td>
                <table align="center" class="github_tb">
                    <tbody>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>仓库：</td>
                        <td><select  name="storeID" id="storeID" type="text" class="grid_text" style="width:140px;height: 24px;">
                                <option value="">请选择</option>
                                <?php $storeList = Store::model()->findAll();
                                foreach($storeList as $store){
                                    if($store->storeID==$data['storeID']){
                                        echo "<option value=\"{$store->storeID}\" selected>".$store->storeName."</option>";
                                    }else{
                                        echo "<option value=\"{$store->storeID}\">".$store->storeName."</option>";
                                    }
                                }
                                ?>
                            </select></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>物资描述：</td>
                        <td><input name="goodsName" id="goodsName" type="text" class="grid_text"  value="<?= $data['goodsName']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label>物资编码：</td>
                        <td><input name="goodsCode" id="goodsCode" type="text" onchange="checkCode()" class="grid_text" <?php if($Edit){echo 'disabled';}//当修改物资时，编号不可改?> value="<?= $data['goodsCode']?>"></td>
                        <?php if($isEdit){echo "<input type=\"hidden\" name=\"oldgCode\" value=\"".$oldgCode."\" />";}?>
                        <?php if($Edit){echo "<input type=\"hidden\" name=\"materialID\" value=\"".$data['materialID']."\" />";}?>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right"><label>＊</label><?= $Edit?'当前库存：':'入库数量：';?></td>
                        <td><input name="currCount" id="currCount" type="text" class="grid_text"  value="<?= floatval($data['currCount'])?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">最低库存：</td>
                        <td><input name="minCount" id="minCount" type="text" class="grid_text"  value="<?= $data['minCount']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">规格：</td>
                        <td><input name="standard" id="standard" type="text" class="grid_text"  value="<?= $data['standard']?>"></td>
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
                        <td width="100" align="right">有效期：</td>
                        <td><input name="validityDate" id="validityDate" type="date" class="grid_text"  value="<?= $data['validityDate']=="0000-00-00"?"":$data['validityDate'];?>"></td>
                    </tr>
                    </tbody>
                </table>
            </td><!-- 左侧 -->
            <td>
                <table align="center" class="github_tb">
                    <tbody>
                    <tr class="row">
                        <td width="100" align="right">工单号：</td>
                        <td><input name="workCode" id="workCode" type="text" class="grid_text"  value="<?= $data['workCode']?>" /></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">批次号：</td>
                        <td><input name="batchCode" id="batchCode" type="text" class="grid_text"  value="<?= $data['batchCode']?>" /></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">扩展编码：</td>
                        <td><input name="extendCode" id="extendCode" type="text" class="grid_text"  value="<?= $data['extendCode']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">ERP领料单：</td>
                        <td><input name="erpLL" id="erpLL" type="text" class="grid_text"  value="<?= $data['erpLL']?>" /></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">ERP出库单：</td>
                        <td><input name="erpCK" id="erpCK" type="text" class="grid_text"  value="<?= $data['erpCK']?>" /></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">厂家：</td>
                        <td><input name="factory" id="factory" type="text" class="grid_text"  value="<?= $data['factory']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">厂家联系人：</td>
                        <td><input name="factory_contact" id="factory_contact" type="text" class="grid_text"  value="<?= $data['factory_contact']?>"></td>
                    </tr>
                    <tr class="row">
                        <td width="100" align="right">厂家联系电话：</td>
                        <td><input name="factory_tel" id="factory_tel" type="text" class="grid_text"  value="<?= $data['factory_tel']?>"></td>
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
<!--
storeID
goodsName
goodsCode
currCount
minCount
standard
price
unit
validityDate
workCode
batchCode
extendCode
erpLL
erpCK
factory
factory_contact
factory_tel
remark
-->