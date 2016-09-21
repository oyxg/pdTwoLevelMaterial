var Request={}

Request.addMaterial=function(materialID,fun){
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;	
	}
	$.post(
		"/request/MaterialAdd.html",
		{
			materialID : materialID,
			number : $("#m_"+materialID).val()
		},
		function(data){
			if(data.status==1){
				maya.notice.success(data.info,fun);
			}else{
				maya.notice.fail(data.info);	
			}
		},
		"json"
	);
}

Request.removeMaterial=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;	
	}
	$.post(
		"/request/MaterialRemove.html",
		{
			materialID : materialID
		},
		function(data){
			if(data.status==1){
				maya.notice.success(data.info,fun);
			}else{
				maya.notice.fail(data.info);	
			}
		},
		"json"
	);
}

Request.showDetail=function(requestID){
	window.__box=new Maya.Box({
		url : "/request/detail.html?requestID="+requestID,
		width : 1000,
		heigh : 300,
		text : "详细"	
	});	
}

Request.cancel=function(requestID,fun){
	if(!confirm("确定要取消吗？"))return;
	if(requestID==""){
		maya.notice.fail("请选择申请单");
		return;	
	}
	$.get(
		"/request/cancel.html",
		{
			requestID : requestID
		},
		function(data){
			if(data.status==1){
				maya.notice.success(data.info,fun);
			}else{
				maya.notice.fail(data.info);	
			}
		},
		"json"
	);
}


Request.check=function(requestID){
	window.__box=new Maya.Box({
		url : "/request/check.html?requestID="+requestID,
		width : 600,
		heigh : 100,
		text : "审核"	
	});	
}


Request.handler=function(requestID){
	window.__box=new Maya.Box({
		url : "/request/handler.html?requestID="+requestID,
		width : 900,
		heigh : 100,
		text : "出库审核"	
	});	
}


Request.giveBack=function(requestID){
	window.__box=new Maya.Box({
		url : "/request/giveBack.html?requestID="+requestID,
		width : 900,
		heigh : 100,
		text : "归还物资"	
	});	
}

//==================================借用单=====================================

var Borrow={}

Borrow.addMaterial=function(materialID,fun){
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;
	}
	$.post(
			"/Instrument/InstrumentAdd.html",
			{
				materialID : materialID,
				bh : $("#m_"+materialID).combobox('getText')
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info,fun);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}

Borrow.removeMaterial=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;
	}
	$.post(
			"/Instrument/InstrumentRemove.html",
			{
				materialID : materialID
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info,fun);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}

Borrow.showDetail=function(formID){
	window.__box=new Maya.Box({
		url : "/Instrument/detail.html?formID="+formID,
		width : 1000,
		heigh : 300,
		text : "详细"
	});
}

Borrow.cancel=function(requestID,fun){
	if(!confirm("确定要取消吗？"))return;
	if(requestID==""){
		maya.notice.fail("请选择申请单");
		return;
	}
	$.get(
			"/Instrument/cancel.html",
			{
				requestID : requestID
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info,fun);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}

//更新要归还的编号
//var backBh=new Array()
//Borrow.giveBack=function(bh){
//	for(var i=0;i<backBh.length;i++){
//		if(backBh[i]==bh){
//			backBh.remove(bh);
//			return false;//已存在
//		}
//	}
//	backBh.push(bh);
//	return true;//已添加
//}

//归还仪器设备
Borrow.giveBack=function(formID){
	var cbox=$(":checkbox[name=cbox]");
	var temp=new Array();
	var id='';
	var date='';
	$(":checkbox[checked=checked][name=cbox]").each(function(index, element) {
		var wz=new Array();
		id = element.value;
		date = $(":input[bh="+id+"]").val();
		wz.push(id+':'+date);
		temp.push(wz);
	});
	var data=temp.join(",");
	console.info(data);
	$.post(
		"/Instrument/BackInstrument",
		{
			formID : formID,
			data : data
		},
		function(data){
			if(data.status==1){
				maya.notice.success(data.info,function(){
					location.reload();
				});
			}else{
				maya.notice.fail(data.info);
			}
		},
		"json"
	);
}

Borrow.del=function(formID){
	if(!confirm("确定要删除吗？"))return;
	if(formID==""){
		maya.notice.fail("请选择要删除的借用单");
		return;
	}
	$.post(
			"/Instrument/BorrowRemove.html",
			{
				formID : formID
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info);
					location.reload();
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}