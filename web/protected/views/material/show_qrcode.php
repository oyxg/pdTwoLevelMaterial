
<style type="text/css">
#panel div{}
.ln{height:32px;line-height:32px;font-size:12px;}
</style>
<style media="print">
#printWin {display:none;}
body{background-color:white;}
</style>
<img src="/<?php echo $qrcodeImg;?>" style="position:absolute;left: 18px;top: 35px;width: 80px;" />
<img src="/images/common/tpl_small.png" width="290" height="150" />
<img src="/images/common/water.jpg" style="position: absolute; left: 52px; top: 65px;" width="16" height="16" />
<div id="panel" style="position:absolute;left:100px;top:100px;top:10px;left:146px;">
	<div class="ln"><?php echo $goods->goodsName;?></div>
	<!--<div style="padding-top:20px;"><?php echo $goods->property;?></div>-->
        <div class="ln" style=""><?php echo $goods->property=="" ? "" : $goods->property;?></div>
	<div class="ln" style=""><?php echo $goods->style=="" ? "" : Goods::getTypeName($goods->style);?></div>
	<div class="ln" style="padding-left:25px;"><?php echo $material->position;?></div>
</div>
<div style="text-align:center;padding:9px;" id="printWin"><button type="button"  onclick="window.print();">打印</button></div>

