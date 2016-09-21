/**
 * 实时库存对象
 */
var RealtimeStockStore={};
/**
 * 加载图表所需要的数据
 * @param storeID 仓库ID
 * @param function(data) 回调函数
 */
RealtimeStockStore.getData=function(storeID,fun){
	maya.notice.wait("正在加载中……请稍后");
	$.get(
		"/report/AjaxRealtimeStockForStore.html",
		{
			"storeID" : storeID	
		},
		function(data){
			maya.notice.close();
			if(data.status==1){
				fun(data.data);
			}else{
				maya.notice.fail(data.info);	
			}
		},
		"json"
	);
}
/**
 * 当下拉框改变的时候拉取数据
 */
RealtimeStockStore.onStoreChange=function(){
	var storeID=$("#store").val();
	if(storeID=="")return;
	RealtimeStockStore.getData(storeID,function(data){
		//console.info(data);	
		RealtimeStockStore.renderPlot(data);
	});
}
/**
 * 渲染图表
 * @param data 服务器返回的数据
 */
RealtimeStockStore.renderPlot=function(data){
	//图表名称
	var title=data.storeName;
	//库存
	var total=data.total;
	//最大数值
	var totalMax=Math.max.apply(null, total);
	//分类名称
	var typeName=data.typeName;
	//清空图表
	$("#replot").html("");
	$("#replot_pie").html("");
	//创建饼图图表
	$.jqplot('replot_pie', [data.pie], {
		animate: !$.jqplot.use_excanvas,
		seriesDefaults: {
			shadow : false,
			renderer: jQuery.jqplot.PieRenderer,
			rendererOptions: {
				showDataLabels: true,
				dataLabels: 'value'
			}
		},
		highlighter:{
			show: true,
			sizeAdjust: 7.5
		},
		legend: {
			show: true,
			location: 'e'
		}
	});
	//创建柱形图表
	$.jqplot('replot', [total],{
		title : title+" - 库存",
		animate: !$.jqplot.use_excanvas, //是否动画显示  
		seriesColors: [ "#25A81E"],
		seriesDefaults:{
			pointLabels: { show:true } ,
			renderer:$.jqplot.BarRenderer,
			shadow : false,
			rendererOptions: {
				barMargin : 20,
				barWidth : 20
			}
	        },
		axesDefaults: {
			show: false,
			min: 0,
			max: totalMax*0.2+totalMax
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: typeName
			},
			yaxis: {
				tickOptions: {
					formatString: '%d 件'
				}
			}
		}
	});
}
