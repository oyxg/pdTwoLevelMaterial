<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>
<style>
    .xq{display: none;}
    label{color:#999;}
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
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("PreFloodMaterial/PreFloodList") ?>">
                        分类：
                        <select class="grid_text" name="className" id="className" style="height: 24px">
                            <option></option>
                            <?php
                            $PreFlood = new PreFloodInfo();
                            $types = $PreFlood->model()->getType();
                            foreach($types as $type): ?>
                                <option value="<?=$type?>"<?php if($type==$_GET['className'])echo "selected";?>><?=$type?></option>
                            <?php endforeach;?>
                        </select>
                        物资名称：
                        <input class="grid_text" name="name" value="<?php echo $_GET['name']; ?>">
                        配置级别：
                        <input class="grid_text" name="pzlevel" value="<?php echo $_GET['pzlevel']; ?>">
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
            <th align="left">分类</th>
            <th align="left">物资名称</th>
            <th align="left">配置标准</th>
            <th align="left">单位</th>
            <th align="center">单价</th>
            <th align="left">技术规范</th>
            <th align="left">备注</th>
            <th align="left">配置级别</th>

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
//    var_dump($rsList);
//    exit;
    foreach ($rsList as $key => $v):
        $view = ViewPreFloodList::model()->findAll("mID='{$v->id}'");
        $i = 0;
        $xq = array();//需求
        $xc = array();//现存
        foreach($view as $bzInfo){
            if($bzInfo->bzID==$i){
                $xq[$i] = $bzInfo->needNum;
                $xc[$i] = $bzInfo->nowNum;
            }
            $i++;
        }
        $html = "<label>0</label>";
//        var_dump($xq);
//        var_dump($xc);
//        exit;
        ?>
        <tr>
            <td align="left"><?php echo $v->className; ?></td>
            <td align="left"><?php echo $v->name; ?></td>
            <td align="left"><?php echo $v->configure; ?></td>
            <td align="left"><?php echo $v->unit; ?></td>
            <td align="center"><?php echo $v->price; ?></td>
            <td align="left"><?php echo $v->jsgf; ?></td>
            <td align="left"><?php echo $v->remark; ?></td>
            <td align="left"><?php echo $v->pzlevel; ?></td>

            <td align="center" class="xc"><?php echo $xc[0]==''?$html:"<b>{$xc[0]}</b>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[1]==''?$html:"<b>{$xc[1]}</b>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[2]==''?$html:"<b>{$xc[2]}</b>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[3]==''?$html:"<b>{$xc[3]}</b>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[4]==''?$html:"<b>{$xc[4]}</b>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[5]==''?$html:"<b>{$xc[5]}</b>"; ?></td>
            <td align="center" class="xc"><?php echo $xc[6]==''?$html:"<b>{$xc[6]}</b>"; ?></td>
            <td align="center" class="xc"><?php echo $sun_xc = array_sum($xc); ?></td>
            <td align="center" class="xc"><?php echo floatval($sun_xc*$v->price); ?></td>

            <td align="center" class="xq"><?php echo $xq[0]==''?$html:"<b>{$xq[0]}</b>"; ?></td>
            <td align="center" class="xq"><?php echo $xq[1]==''?$html:"<b>{$xq[1]}</b>"; ?></td>
            <td align="center" class="xq"><?php echo $xq[2]==''?$html:"<b>{$xq[2]}</b>"; ?></td>
            <td align="center" class="xq"><?php echo $xq[3]==''?$html:"<b>{$xq[3]}</b>"; ?></td>
            <td align="center" class="xq"><?php echo $xq[4]==''?$html:"<b>{$xq[4]}</b>"; ?></td>
            <td align="center" class="xq"><?php echo $xq[5]==''?$html:"<b>{$xq[5]}</b>"; ?></td>
            <td align="center" class="xq"><?php echo $xq[6]==''?$html:"<b>{$xq[6]}</b>"; ?></td>
            <td align="center" class="xq"><?php echo $sun_xq = array_sum($xq); ?></td>
            <td align="center" class="xq"><?php echo floatval($sun_xq*$v->price); ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>