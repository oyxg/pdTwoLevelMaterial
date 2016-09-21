/**
 * 出入库记录对象
 */
var InOutRecord={};
/**
 * 加载图表所需要的数据
 * @param storeID 仓库ID
 * @param dstart 起始日期
 * @param dend 截止日期
 * @param function(data) 回调函数
 */
InOutRecord.getData=function(storeID,dstart,dend,fun){
	maya.notice.wait("正在加载中……请稍后");
	$.get(
		"/report/AjaxIORecode.html",
		{
			"storeID" : storeID,
			"dstart" : dstart,
			"dend" : dend
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
InOutRecord.onSubmit=function(){
	var storeID=$("#store").val();
	var dstart=$("#dstart").val();
	var dend=$("#dend").val();
	if(storeID=="" || dstart=="" || dend=="")return;
	InOutRecord.getData(storeID,dstart,dend,function(data){
		//console.info(data);	
		InOutRecord.renderPlot(data);
	});
}
/**
 * 渲染图表
 * @param data 服务器返回的数据
 */
InOutRecord.renderPlot=function(data){
	//图表名称
	var title=data.storeName;
	//进的次数
	var inCount=data.inCount;
	//出的次数
	var outCount=data.outCount;
	//进的数量
	var inTotal=data.inTotal;
	//出的数量
	var outTotal=data.outTotal;
	//分类名称
	var typeName=data.typeName;
	//次数
	var countTotal=data.countTotal;
	//物资数量
	var total=data.total;
	//清空图表
	$("#replot").html("");
	//创建图表
	$.jqplot('replot', [countTotal,total],{
		title : title+" - 出入库记录统计详情",
		animate: !$.jqplot.use_excanvas, //是否动画显示  
		series: [
			{
				label: '次数'
			},
			{
				label: '物资数量'
			}
		],
		highlighter:{
			show: true,
			tooltipOffset : 10,
			showMarker : false,
			tooltipAxes : "y",
			tooltipLocation : 'se',
			sizeAdjust: 7.5
		},
		legend: {
			show: true,
			placement: 'outsideGrid'
		},
		seriesColors: [ "#25A81E", "#FF9900", "#0099FF", "#FF3300"],
		seriesDefaults:{
			pointLabels: { show:true } ,
			renderer:$.jqplot.BarRenderer,
			shadow : false,
			rendererOptions: {
				barMargin : 20,
				barWidth : 10
			}
	        },
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: typeName
			},
			yaxis: {
				tickOptions: {
					formatString: '%d '
				}
			}
		}
	});
}
