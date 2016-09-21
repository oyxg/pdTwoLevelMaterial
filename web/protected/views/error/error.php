<style type="text/css">
* {
	font-family: "微软雅黑";
	font-size: 12px;
}
body {
	background-image: none;
	background-color: #ffffff;
}
button {
	font-size: 12px;
}
#error-wrap {
	border: 1px solid #CCC;
	margin:20px;
}
#error-title {
	padding: 5px;
	background-color: #eee;
	font-size: 14px;
}
#error-body {
	padding: 10px;
}
#error-footer {
	background-color: #eee;
	text-align: center;
	padding: 5px;
}
</style>
<div id="error-wrap">
	<div id="error-title"> <strong>提示</strong> </div>
	<div id="error-body"><?php echo CHtml::encode($message); ?></div>
	<div id="error-footer" style="border-top:0px;">
		<button id="subBtn" type="button" onclick="history.back()" class="btn btn-success" style="width:120px;" >返回上一页</button>
		<button id="subBtn" type="button" onclick="window.location='/';" class="btn btn-success" style="width:100px;" >返回首页</button>
	</div>
</div>
