/**----------------------------------
  功能：消息提示
  日期：2014-03-02
  作者：武仝
  更新：
		2014-03-10 修正了IE6下不能正确显示的问题
		2014-03-24 更改了每种提示都显示背景
-----------------------------------*/

if(maya==undefined)
	var maya={};

//显示自定义的消息框
maya.notice=function(config){
	if(window.maya_notice_time!=undefined){
		window.clearTimeout(window.maya_notice_time);
	}
	//基本参数
	var text="",second=3,overlay=false,type="alert",callback=null;
	//重新设置参数
	for(param in config){
		eval(param+"=config[param]");
	}
	//左侧图标和右侧边框宽度
	var otherWidth=45+6;
	//屏幕参数
	var bw=document.documentElement.clientWidth;
	var bh=document.documentElement.clientHeight;
	var sl=document.body.scrollLeft || document.documentElement.scrollLeft;
	var st=document.body.scrollTop || document.documentElement.scrollTop;
	var sh=document.documentElement.scrollHeight;
	var end_left=parseInt(bw/2)+sl;
	var end_top=parseInt(bh/2)+st;
	//显示背景
	if(overlay){
		var overlayID="noticeOverlay";
		var overlayObj=document.getElementById(overlayID);
		//如果已经存在背景
		if(overlayObj==null){
			var overlayEle=document.createElement("div");
			overlayEle.id=overlayID;
			document.body.appendChild(overlayEle);
			overlayObj=document.getElementById(overlayID);
		}else{
			overlayObj.style.display="block";
		}
		overlayObj.style.width=bw+sl+"px";
		overlayObj.style.height=Math.max(sh,bh)+"px";
	}
	//显示提示框
	var noticeWrapID="noticeWraper";
	var noticeWrapObj=document.getElementById(noticeWrapID);
	if(noticeWrapObj==null){
		var noticeWrapEle=document.createElement("div");
		noticeWrapEle.id=noticeWrapID;
		noticeWrapEle.innerHTML=''+
		'<div id="contLeft"><div id="contLoad"></div></div>'+
		'<div id="contRight"></div>'+
		'<div id="contCenter"></div>';
		document.body.appendChild(noticeWrapEle);
		noticeWrapObj=document.getElementById(noticeWrapID);
	}else{
		noticeWrapObj.style.display="block";
	}
	document.getElementById("contLeft").className='t_'+type;
	document.getElementById("contCenter").innerHTML=text;
	noticeWrapObj.style.left="-9999px";
	//重新定位提示框的位置
	noticeWrapObj.style.top=end_top-(noticeWrapObj.scrollHeight/2)+"px";
	noticeWrapObj.style.left=end_left-(noticeWrapObj.scrollWidth/2)+otherWidth/2+"px";
	//隐藏消息框计时
	if(second!=0){
		window.maya_notice_time=window.setTimeout(function(){
			maya.notice.close(callback);
		},second*1000);
	}
}
//关闭消息框
maya.notice.close=function(callback){
	var overlayID="noticeOverlay";
	var overlayObj=document.getElementById(overlayID);
	if(overlayObj!=null){
		overlayObj.style.display="none";
	}
	var noticeWrapID="noticeWraper";
	var noticeWrapObj=document.getElementById(noticeWrapID);
	if(noticeWrapObj!=null){
		noticeWrapObj.style.display="none";
	}
	if(window.maya_notice_time!=undefined){
		window.clearTimeout(window.maya_notice_time);
	}
	if(callback!=null && callback!=undefined){
		callback();	
	}
}
//成功的消息框
maya.notice.success=function(text,callback,second){
	var second=second==undefined ? 1.3 : second;
	maya.notice({
		"text" : text	,
		"overlay" : true,
		"type" : "success",
		"callback" : callback,
		"second" : second
	});
}
//失败的消息框
maya.notice.fail=function(text,callback,second){
	var second=second==undefined ? 1.3 : second;
	maya.notice({
		"text" : text	,
		"overlay" : true,
		"type" : "fail",
		"callback" : callback,
		"second" : second
	});
}
//警告的消息框
maya.notice.alert=function(text,callback,second){
	var second=second==undefined ? 1.3 : second;
	maya.notice({
		"text" : text	,
		"overlay" : true,
		"type" : "alert",
		"callback" : callback,
		"second" : second
	});
}
//等待的消息框
maya.notice.wait=function(text){
	maya.notice({
		"text" : text	,
		"overlay" : true,
		"type" : "wait",
		"second" : 0
	});
}