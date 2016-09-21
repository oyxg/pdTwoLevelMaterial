var Goods={}
/**
 * 获取物资类型列表
 * @param string 分类
 * @param bool 是否有“不限”选项
 * @param function|null 回调函数
 */
Goods.getAjaxTypeList=function(category,hasLimit,fun){
	$.get(
		"/goods/AjaxGetTypeList",
		{
			category : category,
			hasLimit : hasLimit
		},
		function(data){
			if(typeof(fun)=="function"){
				fun(data);	
			}
		},
		"html"
	);
}
/**
 * 渲染物资类型列表
 * @param string 服务器返回来的数据
 */
Goods.renderAjaxTypeList=function(data){
	$("#type").html(data);
}
/**
 * 调用获取物资类型
 * @param string 分类
 * @param bool 是否有“不限”选项
 */
Goods.callGetAjaxTypeList=function(category,hasLimit){
	Goods.getAjaxTypeList(category,hasLimit,Goods.renderAjaxTypeList);
}

//添加物资
Goods.add=function(){
	window.__box=new Maya.Box({
		url : "/goods/add",
		width : 400,
		heigh : 100,
		text : "添加物资"	
	});	
}

//修改物资
Goods.edit=function(goodsID){
	window.__box=new Maya.Box({
		url : "/goods/edit?goodsID="+goodsID,
		width : 400,
		heigh : 100,
		text : "修改物资"	
	});	
}

//删除物资
Goods.remove=function(goodsID,fun){
	if(!confirm("确定要删除吗？删除后所有仓库的物资也将被删除！"))return;
	$.get(
		"/goods/Remove",
		{
			goodsID : goodsID
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