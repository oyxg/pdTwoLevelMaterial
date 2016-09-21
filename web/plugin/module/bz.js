var Bz={}

//添加
Bz.add=function(id){
	window.__box=new Maya.Box({
		url : "/bz/add.html?id="+id,
		width : 400,
		heigh : 100,
		text : "添加"	
	});	
}

//修改
Bz.edit=function(id){
	window.__box=new Maya.Box({
		url : "/bz/edit?id="+id,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Bz.remove=function(id,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/bz/Remove",
		{
			id : id
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