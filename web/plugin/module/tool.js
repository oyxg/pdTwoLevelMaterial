var Tool={}

//添加
Tool.add=function(goodsID){
	window.__box=new Maya.Box({
		url : "/tool/add.html?goodsID="+goodsID,
		width : 400,
		heigh : 100,
		text : "添加"	
	});	
}

//修改
Tool.edit=function(materialID){
	window.__box=new Maya.Box({
		url : "/tool/edit?materialID="+materialID,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Tool.remove=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/tool/Remove",
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

Tool.addTry=function(materialID){
	window.__box=new Maya.Box({
		url : "/tool/addTry.html?materialID="+materialID,
		width : 400,
		heigh : 100,
		text : "添加试验周期"	
	});	
}

Tool.editTry=function(tryID){
	window.__box=new Maya.Box({
		url : "/tool/editTry.html?tryID="+tryID,
		width : 400,
		heigh : 100,
		text : "修改试验周期"	
	});	
}

//删除
Tool.removeTry=function(tryID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/tool/removeTry",
		{
			tryID : tryID
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