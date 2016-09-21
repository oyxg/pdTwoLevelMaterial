
//检测是否是IE6
$(function(){
	return;
	var isIE=!!window.ActiveXObject;
	var isIE6=isIE&&!window.XMLHttpRequest;
	if(isIE){
		if(isIE6){
			$("body").prepend('<div style="position:absolute;left:50%;margin-left:-160px;background-color:#fffadf;text-align:center;border:1px solid #ffc990;padding:6px;">您好，本站不支持IE6浏览器，请更新您的浏览器</div>');	
		} 
	}
});

//搜索检测
function returnSearch(){
	if($.trim($("#kw").val())==""){
		alert("请输入要搜索的内容");
		return false;
	}	
	return true;
}



//公共的js
$(function(){
	//设置表格斑马样式
	setTableStyle();
	//设置菜单
	setGridMenu();
})
//设置表格斑马样式
function setTableStyle(){
	var github=document.getElementsByTagName("table");
	for(var i=0;i<github.length;i++){
		if(github[i].className!="github_tb")continue;
		var trs=github[i].rows;
		for(var j=0;j<trs.length;j++){
			if(trs[j].className==""){
				if(j%2==0){
					trs[j].className="row";
				}
			}
		}
	}
}
function setMenu(id){
	$("#nav li").removeClass("");
	$("#"+id).addClass("active");
}
//短信发送后的成功验证
function getMessStatus(id, url) {
	if(id == 0){return;}
	var i = 0;
	function check(){
		$.post(
			url, 
			{id : id}, 
			function(data) {
				if(data.status == 1){
					// if(typeof (window.__Mess) == "undefined"){
					window.__Mess = new Maya.Box({
						text : "提示",
						chtml : "<b>短信发送成功。</b>",
						isAlert : true,
						effect : true,
						position : "rightBottom",
						overlayAlpha : .5,
						inlineAuto : false,
						type : "inline"
					});
					window.clearInterval(window.intv);
					setTimeout("window.__Mess.close()", 3000);
				}else if(i >= 5){
					Maya.Msg("短信发送失败。");
					window.clearInterval(window.intv);
				}
				i++;
			},
			"json"
		);
	}
	window.intv = setInterval(function(){check()},1000);
}
//扫描二维码
function qrScan(obj,fill,callback){
	var str=obj.value;
	var strArr;
	if(str.indexOf("###")>0){
		strArr=str.split("@");
	}else{
		return "";
	}
	//获取货架编码
	var position=strArr[0];
  
	//console.info(position)
	//清空二维码
	obj.value="";
	if(fill){
		obj.value=$.trim(position);
	}
	if(callback!=undefined){
		callback();
	}
	return $.trim(position);
}
//设置菜单
function setGridMenu(){
	$(".grid_menu_panel").on("mouseenter",function(e){
		var gm=$(this).find(".grid_menu");
		$(this).find(".grid_menu")	.show();
		//alert("pageY  -   "+e.pageY+"height  -   "+gm.height()+"document  -   "+($(document).height()-40));
		if(e.pageY+gm.height()>$(document).height()-40){
			gm.css({
				marginTop : -gm.height()
			});	
		}
		
	});
	$(".grid_menu_panel").on("mouseleave",function(){
		$(this).find(".grid_menu")	.hide();
	});
}

var itemType={
	LINE : "线缆",
	TABLE : "表计",
	REPAIR : "维修材料",
	TOOL_MAKE : "施工工器具",
	TOOL_PERSONAL : "个人工器具",
	TOOL_SAFE : "安全工器具"
}
//打印内容
function wPrint(content){
	var new_win=window.open('','','height=600,width=1000,top='+(screen.height-600)/2+',left='+(screen.width-1000)/2+',toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		
	new_win.document.body.innerHTML+='<style>*,body,td{font-size:12px;}</style>';
	new_win.document.body.innerHTML+=content;
	new_win.print();
	new_win.close();
	//new_win.document.body.innerHTML+="<script>window.print();<\/script>";
}
//打开窗口
function owin(url,w,h){
	window.open(url,'','height='+h+',width='+w+',top='+(screen.height-h)/2+',left='+(screen.width-w)/2+',toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
}
//查询预警数据
function queryWaring(){
	$.get(
			"?m=Query&a=getWaring",
			function(data){
				if(data.status==1){
					new Maya.Box({
						text : "提示",
						overlayShow : false,
						chtml : "<div style='padding:20px;'>有"+data.data+"件物资需要补库，<a href='?m=Goods&a=goodsWarning'>点击查看</a></div>",
						type : "inline",
						effect : true,
						width : 240,
						position : "rightBottom"
					});
				}
			},
			"json"
	);
}