var UseMaterial={}

//添加到领用单
UseMaterial.addToReceiveForm=function(materialID,fun){
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;
	}
	$.post(
			"/UseMaterial/addToReceiveForm.html",
			{
				materialID : materialID,
				num : $("#m_"+materialID).val()
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info,fun);
				}else{
					maya.notice.fail(data.info);
					setTimeout("location.reload()",1000);
				}
			},
			"json"
	);
}

//从领用单中移除
UseMaterial.RemoveToReceiveForm=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.post(
			"/UseMaterial/RemoveToReceiveForm",
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

//领用单详情
UseMaterial.showReceiveForm=function(id){
	window.__box=new Maya.Box({
		url : "/UseMaterial/showReceiveForm?id="+id,
		width : 1200,
		height : 600,
		text : "领料单详情"
	});
}

//审核领用单详情
UseMaterial.examReceiveForm=function(id){
	window.__box=new Maya.Box({
		url : "/UseMaterial/showReceiveForm?id="+id+"&type=exam",
		width : 1000,
		height : 600,
		text : "领料单详情"
	});
}

//领用单审核退回
UseMaterial.receiveNo=function(formID){
	$.post(
			"/UseMaterial/Examine.html",
			{
				type : 'no',
				formID : formID,
				opinion : $("#opinion").val()
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}

//领用单审核通过
UseMaterial.receiveOk=function(formID){
	var idNumber = [];
	//循环验证数据是否正确
	$("input[type='number']").each(function(){
		if($(this).val()>$(this).attr('max')||$(this).val()<=0){
			maya.notice.fail("【"+$(this).attr('goodname')+"】领用数非法");
			return;
		}
	});
	$.post(
			"/UseMaterial/Examine.html",
			{
				type : 'ok',
				formID : formID
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}

//审核时从领用单中移除
UseMaterial.DelExamine=function(materialID,formID){
	if(!confirm("确定要删除吗？"))return;
	$.post(
			"/UseMaterial/DelExamine",
			{
				formID : formID,
				materialID : materialID
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}

//上传附件
UseMaterial.uploadFile=function(type,formID){
	console.info(formID);
	window.__box=new Maya.Box({
		url : "/UseMaterial/uploadFile?type="+type+"&formID="+formID,
		width : 580,
		height : 500,
		text : "上传附件"
	});
}
/*******************************************退料单*************************************************/

//添加到领用单
UseMaterial.addToReturnForm=function(materialID,formCode,fun,count){
	//alert(count);
	if(materialID==""){
		maya.notice.fail("请选择物资"+materialID);
		return;
	}
	$.post(
			"/UseMaterial/addToReturnForm.html",
			{
				materialID : materialID,
				num : $("#"+count).val(),
				formCode : formCode
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info,fun);
				}else{
					maya.notice.fail(data.info,fun);
				}
			},
			"json"
	);
}

//从领用单中移除
UseMaterial.RemoveToReturnForm=function(materialID,formCode,fun){
	if(!confirm("确定要删除吗？"))return;
	$.post(
			"/UseMaterial/RemoveToReturnForm",
			{
				materialID : materialID,
				formCode : formCode,
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

//领用单详情
UseMaterial.showReturnForm=function(id){
	window.__box=new Maya.Box({
		url : "/UseMaterial/showReturnForm?id="+id,
		width : 1000,
		heigh : 600,
		text : "退料单详情"
	});
}

//审核领用单详情
UseMaterial.examReturnForm=function(id){
	window.__box=new Maya.Box({
		url : "/UseMaterial/showReturnForm?id="+id+"&type=exam",
		width : 1000,
		heigh : 600,
		text : "退料单详情"
	});
}

//领用单审核退回
UseMaterial.returnNo=function(formID){
	$.post(
			"/UseMaterial/ExamineReturn.html",
			{
				type : 'no',
				formID : formID,
				opinion : $("#opinion").val()
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}

//领用单审核通过
UseMaterial.returnOk=function(formID){
	$.post(
			"/UseMaterial/ExamineReturn.html",
			{
				type : 'ok',
				formID : formID
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info);
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}