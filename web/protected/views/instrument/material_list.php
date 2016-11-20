<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>
<style>
    .xq{display: none;}
    label{color:#999;}
    .a_in{color: #000;font-weight: bold;cursor: pointer;}
    .a_in:hover{color: #000;}
</style>

<script>
    $(function () {

        var bottonStr = "显示现存";
        $('#controlDisplay').click(function(){
            $('th').each(function(){
                if($(this).attr('class')=='xc'){
                    $(this).toggle();
                }
                if($(this).attr('class')=='xq'){
                    $(this).toggle();
                }
            });
            $('td').each(function(){
                if($(this).attr('class')=='xc'){
                    $(this).toggle();
                }
                if($(this).attr('class')=='xq'){
                    $(this).toggle();
                }
            });
            $(this).val(bottonStr);
            if(bottonStr=="显示需求"){
                bottonStr="显示现存";
            }else{
                bottonStr="显示需求";
            }
        });

        //显示显存台帐
        $("a[rel=show]").click(function(){
            Material.showInstrumentIn($(this).attr('mID'), $(this).attr('bID'));
        });
    });
</script>
<div class="control_tb">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td width="400">
                    <?php
                    $this->beginContent("//layouts/breadcrumbs");
                    $this->endContent();
                    ?>
                </td>
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("Instrument/InstrumentList") ?>">
                        物资分类：
                        <select  name="className" type="text" class="grid_text" style="width:140px;height: 24px;">
                            <option value="">-请选择-</option>
                            <?php
                            $instrumentClass = new InstrumentClass();
                            $class = $instrumentClass->model()->getList();
                            foreach($class as $row): ?>
                                <option value="<?=$row->name?>"<?php if($row->name==$_GET['className'])echo "selected";?>><?=$row->name?></option>
                            <?php endforeach;?>
                        </select>
                        物资名称：
                        <input class="grid_text" name="name" value="<?php echo $_GET['name']; ?>">
                        规格型号：
                        <input class="grid_text" name="standard" value="<?php echo $_GET['standard']; ?>">
                        技术规范：
                        <input class="grid_text" name="jsgf" value="<?php echo $_GET['jsgf']; ?>">
                        <input type="submit" value="查询" class="grid_button grid_button_s">
                        <input type="button" class="grid_button grid_button_s" id="controlDisplay" value="显示需求" />
                    </form></td>
            </tr>
        </tbody>
    </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
        <tr class="row">
            <th align="left">物资分类</th>
            <th align="left">物资名称</th>
            <th align="center">配置数量</th>
            <th align="center">单位</th>
            <th align="center">单价</th>
            <th align="left">规格型号</th>
            <th align="left">技术规范</th>

            <th align="center" class="xc">工区现存</th>
            <th align="center" class="xc">一班现存</th>
            <th align="center" class="xc">二班现存</th>
            <th align="center" class="xc">三班现存</th>
            <th align="center" class="xc">四班现存</th>
            <th align="center" class="xc">五班现存</th>
            <th align="center" class="xc">六班现存</th>
            <th align="center" class="xc">合计现存</th>
            <th align="center" class="xc">采购总价</th>

            <th align="center" class="xq">工区需求</th>
            <th align="center" class="xq">一班需求</th>
            <th align="center" class="xq">二班需求</th>
            <th align="center" class="xq">三班需求</th>
            <th align="center" class="xq">四班需求</th>
            <th align="center" class="xq">五班需求</th>
            <th align="center" class="xq">六班需求</th>
            <th align="center" class="xq">合计需求</th>
            <th align="center" class="xq">采购总价</th>

        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $v):
        $view = ViewInstrumentList::model()->findAll("mID='{$v->id}'");
//        var_dump($view);
//        exit();
        $i = 0;
        $xc = array();//现存
        for($bz = 10;$bz >= 0;$bz--){
            foreach($view as $row => $bzInfo){
                if($bzInfo->address==$bz){
                    $xc[$bz] = $bzInfo->num;
                }
            }
        }
        $html = "<label>0</label>";
        $a = "<a class='a_in' rel='show' mID='{$v->id}'";
        ?>
        <tr>

            <td align="left"><?php echo $v->className; ?></td>
            <td align="left"><?php echo $v->name; ?></td>
            <td align="center"><?php echo $v->num;//配置数量 ?></td>
            <td align="center"><?php echo $v->unit; ?></td>
            <td align="center"><?php echo $v->price; ?></td>
            <td align="left"><?php echo $v->standard; ?></td>
            <td align="left"><?php echo $v->jsgf; ?></td>

            <td align="center" class="xc"><?php echo $xc[0]==''?$html:"{$a} bID='0'>"."{$xc[0]}</a>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[1]==''?$html:"{$a} bID='1'>"."{$xc[1]}</a>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[2]==''?$html:"{$a} bID='2'>"."{$xc[2]}</a>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[3]==''?$html:"{$a} bID='3'>"."{$xc[3]}</a>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[4]==''?$html:"{$a} bID='4'>"."{$xc[4]}</a>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[5]==''?$html:"{$a} bID='5'>"."{$xc[5]}</a>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[6]==''?$html:"{$a} bID='6'>"."{$xc[6]}</a>"; ?></td>
            <td align="center" class="xc"><?php echo $sun_xc = array_sum($xc); ?></td>
            <td align="center" class="xc"><?php echo floatval($sun_xc * $v->price); ?></td>

            <?php $t = $v->num;?>
            <td align="center" class="xq"><?php $res = $t-$xc[0]; echo $res<=0?$html:"<b>{$res}</b>"; ?></td>
            <td align="center" class="xq"><?php $res = $t-$xc[1]; echo $res<=0?$html:"<b>{$res}</b>"; ?></td>
            <td align="center" class="xq"><?php $res = $t-$xc[2]; echo $res<=0?$html:"<b>{$res}</b>"; ?></td>
            <td align="center" class="xq"><?php $res = $t-$xc[3]; echo $res<=0?$html:"<b>{$res}</b>"; ?></td>
            <td align="center" class="xq"><?php $res = $t-$xc[4]; echo $res<=0?$html:"<b>{$res}</b>"; ?></td>
            <td align="center" class="xq"><?php $res = $t-$xc[5]; echo $res<=0?$html:"<b>{$res}</b>"; ?></td>
            <td align="center" class="xq"><?php $res = $t-$xc[6]; echo $res<=0?$html:"<b>{$res}</b>"; ?></td>

            <td align="center" class="xq"><?php echo $sun_xq = array_sum($xq); ?></td>
            <td align="center" class="xq"><?php echo floatval($sun_xq * $v->price); ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>