var Auth={}

//设置搜索类型
Auth.setFormType=function(type){
	$("#type").attr("value",type);
	$("#form").submit();
}
//添加
Auth.addItem=function(){
	window.__box=new Maya.Box({
		url : "/auth/ItemAdd.html",
		width : 400,
		heigh : 100,
		text : "添加"	
	});
}
//修改项
Auth.editItem=function(item){
	window.__box=new Maya.Box({
		url : "/auth/ItemEdit.html?item="+item,
		width : 400,
		heigh : 100,
		text : "修改项"	
	});
}
//添加子项
Auth.addItemChild=function(parentItem){
	window.__box=new Maya.Box({
		url : "/auth/ItemChildAdd.html?parentItem="+parentItem,
		width : 700,
		heigh : 100,
		text : "添加子项"	
	});
}


//删除子项
Auth.removeItemChild=function(item,fun){
	if(!confirm("确定要删除吗？依赖此项目的子项都将被删除！"))return;
	$.post(
		"/auth/ItemChildRemove",
		{
			"item" : item
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

Auth.editItemUser=function(userID){
	window.__box=new Maya.Box({
		url : "/auth/ItemUserEdit.html?userID="+userID,
		width : 700,
		heigh : 100,
		text : "设置权限"	
	});
}