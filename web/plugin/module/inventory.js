var Inventory={}

//添加
Inventory.add=function(materialIDs,fun){
	$.post(
		"/Inventory/Add",
		{
			materialIDs : materialIDs
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

//删除
Inventory.remove=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/Inventory/Remove",
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

//清空
Inventory.clear=function(fun){
	if(!confirm("确定要清空吗？"))return;
	$.get(
		"/Inventory/clear",
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
//加入盘点
Inventory.apply=function(){
	var cbox=$(":checkbox[name=cbox]");
	var ids=new Array();
	$(":checkbox[checked=checked][name=cbox]").each(function(index, element) {
		ids.push(element.value);
	});
	var materialIDs=ids.join(",");
	Inventory.add(materialIDs);
}

//加入全部盘点
Inventory.applyAll=function(materialIDs,fun){
	$.post(
		"/Inventory/Add",
		{
			is_all : 1	
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
