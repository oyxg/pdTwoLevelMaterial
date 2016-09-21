var Instrument={}

//添加
Instrument.add=function(goodsID){
	window.__box=new Maya.Box({
		url : "/Instrument/add.html?goodsID="+goodsID,
		width : 400,
		heigh : 100,
		text : "添加"
	});	
}

//修改
Instrument.edit=function(materialID){
	window.__box=new Maya.Box({
		url : "/Instrument/edit?instrumentID="+materialID,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Instrument.remove=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/Instrument/Remove",
		{
			instrumentID : materialID
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

//Instrument.showQRCode=function(materialID){
//	window.__box=new Maya.Box({
//		url :"/Instrument/ShowQRCode/materialID/"+materialID,
//		width : 450,
//		height : 314,
//		iframeScroll : "no",
//		text : "查看"
//	});
//
//}


//修改仪器设备
Instrument.editlist=function(mid){
	window.__box=new Maya.Box({
		url : "/instrument/editlist.html?mid="+mid,
		width : 400,
		heigh : 100,
		text : "修改"
	});
}

//删除仪器设备
Instrument.removeList=function(mid,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
			"/instrument/RemoveList.html",
			{
				mid : mid
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