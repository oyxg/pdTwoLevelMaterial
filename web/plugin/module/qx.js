var Types={}

//添加
Types.add=function(qxID){
	window.__box=new Maya.Box({
		url : "/qx/add.html?qxID="+qxID,
		width : 400,
		heigh : 100,
		text : "添加"	
	});	
}

//修改
Types.edit=function(qxID){
	window.__box=new Maya.Box({
		url : "/qx/edit?qxID="+qxID,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Types.remove=function(qxID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/qx/Remove",
		{
			qxID : qxID
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


