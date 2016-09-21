var Main={}

//添加
Main.add=function(goodsID){
	window.__box=new Maya.Box({
		url : "/main/add.html?goodsID="+goodsID,
		width : 400,
		heigh : 100,
		text : "添加"	
	});	
}

//修改
Main.edit=function(mid){
	window.__box=new Maya.Box({
		url : "/main/edit.html?mid="+mid,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Main.remove=function(mid,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/main/Remove.html",
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

//修改重点物资
Main.editlist=function(mid){
	window.__box=new Maya.Box({
		url : "/main/editlist.html?mid="+mid,
		width : 400,
		heigh : 100,
		text : "修改"
	});
}