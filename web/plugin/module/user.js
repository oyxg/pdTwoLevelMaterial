var User={}

//添加
User.add=function(){
	window.__box=new Maya.Box({
		url : "/user/add.html",
		width : 700,
		heigh : 100,
		text : "添加"	
	});	
}

//修改
User.edit=function(userID){
	window.__box=new Maya.Box({
		url : "/user/edit.html?userID="+userID,
		width : 700,
		heigh : 100,
		text : "修改"	
	});	
}

//删除
User.remove=function(userID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
		"/user/remove",
		{
			userID : userID
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

//修改密码
User.updatePassword=function(){
	window.__box=new Maya.Box({
		url : "/user/updatePassword.html",
		width : 400,
		heigh : 100,
		text : "修改密码"	
	});	
}