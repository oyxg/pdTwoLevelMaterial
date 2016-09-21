var Store={}

//添加
Store.add=function(storeID){
	window.__box=new Maya.Box({
		url : "/store/add.html?storeID="+storeID,
		width : 400,
		heigh : 100,
		text : "添加"	
	});	
}

//修改
Store.edit=function(storeID){
	window.__box=new Maya.Box({
		url : "/store/edit?storeID="+storeID,
		width : 400,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
Store.remove=function(storeID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/store/Remove",
		{
			storeID : storeID
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



//绑定用户仓库
Store.bindUser=function(){
	window.__box=new Maya.Box({
		url : "/userstore/bindUser.html?type=new",
		width : 400,
		heigh : 100,
		text : "绑定"	
	});	
}

//修改用户仓库
Store.editUserStore=function(userID,storeID){
	window.__box=new Maya.Box({
		url : "/userstore/bindUser.html?userID="+userID+"&storeID="+storeID,
		width : 400,
		heigh : 100,
		text : "绑定"	
	});	
}


//删除用户仓库
Store.removeUserStore=function(userID){
	if(!confirm("确定要删除吗？"))return;
	$.post(
		"/userstore/removeUser",
		{
			userID : userID
		},
		function(data){
			if(data.status==1){
				maya.notice.success(data.info,function(){
					location.reload();	
				});	
			}else{
				maya.notice.fail(data.info);	
			}
		},
		"json"
	);
}