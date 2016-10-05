<?php
//bugfix start
clean_xss($_GET['name']);
//bugfix end
?>
<div style="height:30px;"></div>
<div id="top_header">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                        <td style="padding-left:20px;" align="left" width="500">欢迎您进入 <strong><?php echo Yii::app()->name;?></strong></td>
                        <td style="padding-right:20px;" align="right" width="600">欢迎您：
                                <span style="color:#fff"><?php echo Yii::app()->user->getState("userName");?> (<?php echo Auth::getRoleToString();?>)</span>
                                <span class="hr">|</span>
                                <a href="/login/out" style="color:#fff">退出</a> <span class="hr">|</span>
                                <a href="#" width="400" height="300" style="color:#fff" onclick="User.updatePassword()">修改密码</a>

                        </td>
                </tr>
        </table>
</div>
<div id="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                        <td width="591"><div class="logo" style="font-size: 28px;font-weight: bold;color: #427d8e;padding-left: 10px;"><?php echo Yii::app()->name;?></div></td>
                        <td align="right">
                                <form action="" method="get" style="display:none;">
                                        <div class="so_panel">
                                                <div class="so_panel_div">
                                                        <input type="text" name="name"  value="<?php echo $_GET['name'];?>" class="so_input_text" />
                                                </div>
                                                <button type="submit" class="so_input_btn">搜索</button>
                                        </div>
                                </form>
                        </td>
                </tr>
        </table>
</div>
<div style="background:url(/old_images/common/top_hr.gif) repeat-x;height:4px; overflow:hidden;"></div>
