var Types={}

//添加
Types.add=function(typeID){
	window.__box=new Maya.Box({
		url : "/types/add.html?typeID="+typeID,
		width : 400,
		heigh : 100,
		text : "添加"	
	});	
}

//修改
Types.edit=function(typeID){
	window.__box=new Maya.Box({
		url : "/types/edit?typeID="+typeID,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Types.remove=function(typeID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/types/Remove",
		{
			typeID : typeID
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


