var Material={}

//添加
Material.addForm=function(){
	window.__box=new Maya.Box({
		url : "/material/addForm",
		width : 600,
		heigh : 600,
		text : "新增物资"
	});	
}

//修改
Material.editMTdata=function(goodsCode){
	window.__box=new Maya.Box({
		url : "/material/editMTdata?goodsCode="+goodsCode,
		width : 600,
		heigh : 600,
		text : "修改物资"
	});
}

//删除
Material.delMTdata=function(goodsCode,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
			"/material/delMTdata",
			{
				goodsCode : goodsCode
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

//修改物资（物资列表）
Material.edit=function(goodsCode){
	window.__box=new Maya.Box({
		url : "/material/edit?goodsCode="+goodsCode,
		width : 600,
		heigh : 600,
		text : "修改物资"
	});
}

//入库单详情
Material.showInForm=function(id){
	window.__box=new Maya.Box({
		url : "/material/showInForm?id="+id,
		width : 1200,
		heigh : 600,
		text : "入库单详情"
	});
}

//添加到移库单
Material.addToMoveForm=function(materialID,fun){
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;
	}
	$.post(
		"/Material/addToMoveForm.html",
		{
			materialID : materialID,
			num : $("#m_"+materialID).val()
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

//从移库单中移除
Material.removeToMoveForm=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.post(
			"/material/removeToMoveForm",
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

//移库单详情
Material.showMoveForm=function(id){
	window.__box=new Maya.Box({
		url : "/material/showMoveForm?id="+id,
		width : 1200,
		heigh : 600,
		text : "移库单详情"
	});
}

//上传附件
Material.uploadFile=function(formID){
	window.__box=new Maya.Box({
		url : "/material/uploadFile?formID="+formID,
		width : 580,
		heigh : 500,
		text : "上传附件"
	});
}

//----------------------------报废审批表-----------------------------//
//添加到报废审批表
Material.addToScrapForm=function(materialID,fun){
	window.__box=new Maya.Box({
		url : "/scrap/AddForm",
		width : 300,
		heigh : 600,
		text : "新增物资"
	});
}
//修改报废表中物资缓存
Material.editSTdata=function(goodsCode){
	window.__box=new Maya.Box({
		url : "/scrap/editSTdata?goodsCode="+goodsCode,
		width : 300,
		heigh : 600,
		text : "修改物资"
	});
}

//删除报废表中物资缓存
Material.delSTdata=function(goodsCode,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
			"/scrap/delSTdata",
			{
				goodsCode : goodsCode
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

//报废审批表详情
Material.showScrapForm=function(id){
	window.__box=new Maya.Box({
		url : "/Scrap/ShowScrapForm?id="+id,
		width : 1000,
		heigh : 600,
		text : "报废审批表详情"
	});
}

//报废表审核退回
Material.scrapBack=function(formID){
	$.post(
			"/Scrap/Examine.html",
			{
				type : 'back',
				formID : formID,
				back_opinion : $("#back_"+"opinion").val()
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

//报废表审核通过
Material.scrapOk=function(formID){
	$.post(
			"/Scrap/Examine.html",
			{
				type : 'ok',
				formID : formID,
				opinion : $("#"+"opinion").val()
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

//审核报废审批表
Material.examScrapForm=function(id){
	window.__box=new Maya.Box({
		url : "/Scrap/ShowScrapForm?id="+id+"&type=exam",
		width : 1000,
		heigh : 600,
		text : "审核报废审批表"
	});
}
//----------------------------防汛物资-----------------------------//

//新增防汛物资
Material.addPreFloodInfo=function(){
	window.__box=new Maya.Box({
		url : "/PreFloodMaterial/addPreFloodInfo",
		width : 600,
		heigh : 400,
		text : "新增防汛物资"
	});
}
//修改防汛物资
Material.editPreFloodInfo=function(id){
	window.__box=new Maya.Box({
		url : "/PreFloodMaterial/editPreFloodInfo?id="+id,
		width : 600,
		heigh : 600,
		text : "修改防汛物资"
	});
}
//设置各班需求
//Material.setPreFloodNeed=function(id){
//	console.info(id);
//	window.__box=new Maya.Box({
//		url : "/PreFloodMaterial/setPreFloodNeed?id="+id,
//		width : 300,
//		heigh : 600,
//		text : "设置各班需求"
//	});
//}

//新增防汛物资入库记录
Material.addPreFloodIn=function(id){
	window.__box=new Maya.Box({
		url : "/PreFloodMaterial/AddPreFloodIn?id="+id,
		width : 600,
		heigh : 600,
		text : "防汛物资入库"
	});
}
//修改防汛物资入库记录
Material.editPreFloodIn=function(id){
	window.__box=new Maya.Box({
		url : "/PreFloodMaterial/EditPreFloodIn?id="+id,
		width : 600,
		heigh : 600,
		text : "修改防汛物资"
	});
}

//防汛物资附件
Material.PreFloodFile=function(id){
	window.__box=new Maya.Box({
		url : "/PreFloodMaterial/uploadFile?id="+id,
		width : 580,
		heigh : 500,
		text : "上传附件"
	});
}

//显示现存台帐
Material.showPrefloodIn=function(m,b){
	window.__box=new Maya.Box({
		url : "/PreFloodMaterial/showPrefloodIn?m="+m+"&b="+b,
		width : 1200,
		heigh : 600,
		text : "现存台帐"
	});
}

//添加分类
Material.addPreFloodClass=function(){
	window.__box=new Maya.Box({
		url : "/PreFloodMaterial/addPreFloodClass",
		width : 280,
		heigh : 300,
		text : "添加分类"
	});
}

//----------------------------仪器仪表-----------------------------//

//添加分类
Material.addInstrumentClass=function(){
	window.__box=new Maya.Box({
		url : "/Instrument/addInstrumentClass",
		width : 280,
		heigh : 300,
		text : "添加分类"
	});
}
//新增仪器仪表配置
Material.addInstrumentInfo=function(){
	window.__box=new Maya.Box({
		url : "/Instrument/addInstrumentInfo",
		width : 600,
		heigh : 300,
		text : "新增仪器仪表配置"
	});
}
//修改仪器仪表配置
Material.editInstrumentInfo=function(id){
	window.__box=new Maya.Box({
		url : "/Instrument/editInstrumentInfo?id="+id,
		width : 550,
		heigh : 600,
		text : "修改仪器仪表配置"
	});
}
//添加仪器仪表台账
Material.addInstrumentIn=function(id){
	window.__box=new Maya.Box({
		url : "/Instrument/addInstrumentIn?id="+id,
		width : 600,
		heigh : 600,
		text : "仪器仪表台账"
	});
}
//修改仪器仪表台账
Material.editInstrumentIn=function(id){
	window.__box=new Maya.Box({
		url : "/Instrument/EditInstrumentIn?id="+id,
		width : 600,
		heigh : 600,
		text : "修改仪器仪表台账"
	});
}
//显示现存台帐
Material.showInstrumentIn=function(m,b){
	window.__box=new Maya.Box({
		url : "/Instrument/showInstrumentIn?m="+m+"&b="+b,
		width : 1400,
		heigh : 600,
		text : "现存台帐"
	});
}
//删除仪器仪表
Material.delInstrument=function(id,fun){
	if(!confirm("确定要删除吗？"))return;
	$.get(
			"/Instrument/delInstrument",
			{
				id : id
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info,fun);
					location.reload();
				}else{
					maya.notice.fail(data.info);
				}
			},
			"json"
	);
}
//仪器仪表附件
Material.InstrumentFile=function(id){
	window.__box=new Maya.Box({
		url : "/Instrument/uploadFile?id="+id,
		width : 580,
		heigh : 500,
		text : "上传附件"
	});
}

//----------------------------任务书-----------------------------//


//添加到领用单
Material.addToTaskBook=function(materialID,fun){
	if(materialID==""){
		maya.notice.fail("请选择物资");
		return;
	}
	$.post(
			"/Task/addToTaskBook.html",
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
Material.RemoveToTaskBook=function(materialID,fun){
	if(!confirm("确定要删除吗？"))return;
	$.post(
			"/Task/RemoveToTaskBook",
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
Material.showTaskBook=function(id){
	window.__box=new Maya.Box({
		url : "/Task/showTaskBook?id="+id,
		width : 1000,
		heigh : 600,
		text : "领料单详情"
	});
}

//审核领用单详情
Material.examTaskBook=function(id){
	window.__box=new Maya.Box({
		url : "/Task/showTaskBook?id="+id+"&type=exam",
		width : 1000,
		heigh : 600,
		text : "领料单详情"
	});
}

//领用单审核退回
Material.TaskBookNo=function(formID){
	$.post(
			"/Task/Examine.html",
			{
				type : 'no',
				formID : formID
				//opinion : $("#opinion").val()
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
Material.TaskBookOk=function(formID){
	//var idNumber = [];
	////循环验证数据是否正确
	//$("input[type='number']").each(function(){
	//	if($(this).val()>$(this).attr('max')||$(this).val()<=0){
	//		maya.notice.fail("【"+$(this).attr('goodname')+"】领用数非法");
	//		return;
	//	}
	//});
	$.post(
			"/Task/Examine.html",
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
Material.DelExamine=function(materialID,formID){
	if(!confirm("确定要删除吗？"))return;
	$.post(
			"/Task/DelExamine",
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




////添加到任务书
//Material.addToTask=function(add){
//	window.__box=new Maya.Box({
//		url : "/Task/AddForm?add="+add,
//		width : 300,
//		heigh : 600,
//		text : "新增物资"
//	});
//}
//
////修改任务书中物资缓存
//Material.editTTdata=function(goodsName,edit){
//	window.__box=new Maya.Box({
//		url : "/Task/editTTdata?goodsName="+goodsName+"&edit="+edit,
//		width : 300,
//		heigh : 600,
//		text : "修改物资"
//	});
//}
//
////删除任务书中物资缓存
//Material.delTTdata=function(goodsName,fun,edit){
//	if(!confirm("确定要删除吗？"))return;
//	$.get(
//			"/Task/delTTdata",
//			{
//				goodsName : goodsName,
//				edit : edit,
//			},
//			function(data){
//				if(data.status==1){
//					maya.notice.success(data.info,fun);
//				}else{
//					maya.notice.fail(data.info);
//				}
//			},
//			"json"
//	);
//}
//
////任务书详情
//Material.showTaskBook=function(bookCode){
//	window.__box=new Maya.Box({
//		url : "/Task/ShowTaskBook?bookCode="+bookCode,
//		width : 1000,
//		heigh : 600,
//		text : "任务书详情"
//	});
//}
//
////审核任务书
//Material.examTaskBook=function(bookCode){
//	window.__box=new Maya.Box({
//		url : "/Task/ShowTaskBook?bookCode="+bookCode+"&type=exam",
//		width : 1000,
//		heigh : 600,
//		text : "审核任务书"
//	});
//}
//
////任务书审核退回
//Material.taskBack=function(bookCode){
//	$.post(
//			"/Task/Examine.html",
//			{
//				type : 'back',
//				bookCode : bookCode,
//				back_opinion : $("#back_"+"opinion").val()
//			},
//			function(data){
//				if(data.status==1){
//					maya.notice.success(data.info);
//				}else{
//					maya.notice.fail(data.info);
//				}
//			},
//			"json"
//	);
//}
//
////任务书审核通过
//Material.taskOk=function(bookCode){
//	$.post(
//			"/Task/Examine.html",
//			{
//				type : 'ok',
//				bookCode : bookCode,
//				opinion : $("#"+"opinion").val()
//			},
//			function(data){
//				if(data.status==1){
//					maya.notice.success(data.info);
//				}else{
//					maya.notice.fail(data.info);
//				}
//			},
//			"json"
//	);
//}
