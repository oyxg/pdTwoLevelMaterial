var Deploy={}

Deploy.addMaterial=function(materialID,fun){
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;	
	}
	$.post(
		"/deploy/MaterialAdd.html",
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

Deploy.removeMaterial=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;	
	}
	$.post(
		"/deploy/MaterialRemove.html",
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

Deploy.showDetail=function(deployID){
	window.__box=new Maya.Box({
		url : "/deploy/detail.html?deployID="+deployID,
		width : 1000,
		heigh : 300,
		text : "详细"	
	});	
}

