var Spare={}

//添加
Spare.add=function(goodsID){
	window.__box=new Maya.Box({
		url : "/spare/add.html?goodsID="+goodsID,
		width : 400,
		heigh : 100,
		text : "添加"
	});	
}

//修改
Spare.edit=function(materialID){
	window.__box=new Maya.Box({
		url : "/spare/edit?materialID="+materialID,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Spare.remove=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/spare/Remove",
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