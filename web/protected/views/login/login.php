<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->getPageTitle()?> - <?=Yii::app()->name?></title>
<link rel="stylesheet" href="/images/login/login.css" />
<link rel="stylesheet" type="text/css" href="/plugin/mayanotice/maya.notice.css"/>
<script language="javascript" src="/plugin/jquery.min.js"></script>
<script language="javascript" src="/plugin/jquery.form.js"></script>
<script language="javascript" src="/plugin/mayanotice/maya.notice.js"></script>
<script language="javascript">
$(function(){
	$("#form").submit(function(){
		if($("#loginName").val()==""){
			maya.notice.fail("请输入登录名");
			return false;
		}
		if($("#loginPassword").val()==""){
			maya.notice.fail("请输入登录密码");
			return false;
		}
		maya.notice.wait("登录中，请稍候……");
		document.getElementById("loginBtn").disabled=true;
		var ajaxOption={
			dataType: 'json',
			success : 	function(data){
				if(data.status==0){
					maya.notice.close(function(){
						maya.notice.fail(data.info,null,3);
						document.getElementById("loginBtn").disabled=false;
					});
				}else{
					window.location=data.data.url;
				}
			}
		}
		$("#form").ajaxSubmit(ajaxOption);
		return false;
	});
	checkHeight();
});
function checkHeight(){
	if($(document).height()<=800){
		$("body").addClass("body_low");
		$("#login_panel").addClass("login_panel_low");
	}
}
</script>
</head>

<body>
<?php
$form=$this->beginWidget('CActiveForm',array(
				"htmlOptions"=>array(
							"id"=>"form",
						)
					)

); ?>
<div class="login_panel" id="login_panel">
<table  border="0" align="center" cellpadding="0" cellspacing="0" class=" login_table">
	<tbody>
	<tr>
		<td width="60" height="40" align="right">帐　号：</td>
		<td>
			<input name="loginName" placeholder="" type="text" class="text" id="loginName" value="<?=$cookieList['lname']?>"  />
		</td>
	</tr>
	<tr>
		<td height="40" align="right">密　码：</td>
		<td>
			<input name="loginPassword" placeholder="" type="password" class="text" id="loginPassword"  value="<?=base64_decode($cookieList['lpassword'])?>" />
		</td>
	</tr>
	<tr>
		<td height="20" align="right"></td>
		<td><label for="remember"><input type="checkbox" name="remember" id="remember" value="yes" <?php if($cookieList['lname']!="")echo 'checked="checked"';?> />
			记住密码</label></td>
	</tr>
	<tr>
		<td height="40">&nbsp;</td>
		<td style="padding-left:2px;">
			<button class="button" style="*width:50px;" type="submit" id="loginBtn"><b>登　录</b></button>
		</td>
	</tr></tbody>
</table>
</div>
<?php $this->endWidget(); ?>
<div style="padding-top:10px;text-align:center;color:#666;">
	<p><a href="../../../res/google_chrome.zip">下载谷歌浏览器</a></p>
	<p>浏览账号：ll；密码：123</p>
	Copyright ©  <?php echo date("Y");?> <?=Yii::app()->ao->copyTitle?>  保留所有权利
</div>
</body>
</html>