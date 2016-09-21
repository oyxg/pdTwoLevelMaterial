<script type="text/javascript" src="/plugin/module/material.js"></script>
<script type="text/javascript" src="/plugin/module/inventory.js"></script>
<style>
    .xc{display: none;}
</style>
<script>
    $(function () {
        //修改缓存中的物资信息
        $("a[rel=edit]").click(function(){
            Material.edit($(this).attr('gCode'));
        });
        //添加物资
        $("button[rel=add]").click(function(){
            Material.addPreFloodForm();
        });
        var bottonStr = "显示需求";
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
                <td align="right"><form method="get" action="<?= Yii::app()->createUrl("PreFloodMaterial/list") ?>">
                        分类：
                        <select class="grid_text" name="className" id="className" style="height: 24px">
                            <option></option>
                            <option value="个人防护用品" <?php if($_GET['className']=="个人防护用品")echo "selected";?>>个人防护用品</option>
                            <option value="排水物资"<?php if($_GET['className']=="排水物资")echo "selected";?>>排水物资</option>
                            <option value="挡水物资"<?php if($_GET['className']=="挡水物资")echo "selected";?>>挡水物资</option>
                            <option value="照明工具"<?php if($_GET['className']=="照明工具")echo "selected";?>>照明工具</option>
                            <option value="辅助配套物资"<?php if($_GET['className']=="辅助配套物资")echo "selected";?>>辅助配套物资</option>
                        </select>
                        物资名称：
                        <input class="grid_text" name="name" value="<?php echo $_GET['name']; ?>">
                        <input type="submit" value="查询" class="grid_button grid_button_s">
                        <button type="button" rel="add" class="grid_button">新增</button>
                        <input type="button" class="grid_button grid_button_s" id="controlDisplay" value="显示现存" />
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
            <th align="left">技术规范</th>
            <th align="left">备注</th>
            <th align="left">配置级别</th>
            <th align="center" class="xc">一班现存</th>
            <th align="center" class="xq">一班需求</th>
            <th align="center" class="xc">二班现存</th>
            <th align="center" class="xq">二班需求</th>
            <th align="center" class="xc">三班现存</th>
            <th align="center" class="xq">三班需求</th>
            <th align="center" class="xc">四班现存</th>
            <th align="center" class="xq">四班需求</th>
            <th align="center" class="xc">五班现存</th>
            <th align="center" class="xq">五班需求</th>
            <th align="center" class="xc">六班现存</th>
            <th align="center" class="xq">六班需求</th>
            <th align="center" class="xc">合计现存</th>
            <th align="center" class="xq">合计需求</th>
            <th align="center">单价</th>
            <th align="center">采购总价</th>
            <th width="70" align="center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rsList as $key => $v):
        ?>
        <tr>
            <td align="left"><?php echo $v->className; ?></td>
            <td align="left"><?php echo $v->name; ?></td>
            <td align="left"><?php echo $v->configure; ?></td>
            <td align="left"><?php echo $v->unit; ?></td>
            <td align="left"><?php echo $v->jsgf; ?></td>
            <td align="left"><?php echo $v->remark; ?></td>
            <td align="left"><?php echo $v->pzlevel; ?></td>
            <td align="center" class="xc"><?php echo $v->a_xc; ?></td>
            <td align="center" class="xq"><?php echo $v->a_xq; ?></td>
            <td align="center" class="xc"><?php echo $v->b_xc; ?></td>
            <td align="center" class="xq"><?php echo $v->b_xq; ?></td>
            <td align="center" class="xc"><?php echo $v->c_xc; ?></td>
            <td align="center" class="xq"><?php echo $v->c_xq; ?></td>
            <td align="center" class="xc"><?php echo $v->d_xc; ?></td>
            <td align="center" class="xq"><?php echo $v->d_xq; ?></td>
            <td align="center" class="xc"><?php echo $v->e_xc; ?></td>
            <td align="center" class="xq"><?php echo $v->e_xq; ?></td>
            <td align="center" class="xc"><?php echo $v->f_xc; ?></td>
            <td align="center" class="xq"><?php echo $v->f_xq; ?></td>
            <td align="center" class="xc"><?php echo $sun_xc = $v->a_xc + $v->b_xc + $v->c_xc + $v->d_xc + $v->e_xc + $v->f_xc; ?></td>
            <td align="center" class="xq"><?php echo $sun_xq = $v->a_xq + $v->b_xq + $v->c_xq + $v->d_xq + $v->e_xq + $v->f_xq; ?></td>
            <td align="center"><?php echo $v->price; ?></td>
            <td align="center"><?php echo floatval($sun_xq*$v->price); ?></td>
            <td align="left"><div class="grid_menu_panel" style="width:70px">
                    <div class="grid_menu_btn">操作</div>
                    <div class="grid_menu">
                        <ul>
                            <li class="icon_015"><a href="#" gCode="<?php echo $v->id; ?>" rel="edit">修改</a></li>
                        </ul>
                    </div>
                </div></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$this->beginContent("//layouts/pagination");
$this->endContent();
?>