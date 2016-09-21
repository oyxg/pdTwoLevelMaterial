/**
 * 出入库记录对象
 */
var InOutTrend={};
/**
 * 加载图表所需要的数据
 * @param storeID 仓库ID
 * @param dstart 起始日期
 * @param dend 截止日期
 * @param function(data) 回调函数
 */
InOutTrend.getData=function(storeID,dstart,dend,fun){
	maya.notice.wait("正在加载中……请稍后");
	$.get(
		"/report/AjaxIOTrend.html",
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
InOutTrend.onSubmit=function(){
	var storeID=$("#store").val();
	var dstart=$("#dstart").val();
	var dend=$("#dend").val();
	if(storeID=="" || dstart=="" || dend=="")return;
	InOutTrend.getData(storeID,dstart,dend,function(data){
		//console.info(data);	
		InOutTrend.renderPlot(data);
	});
}
/**
 * 渲染图表
 * @param data 服务器返回的数据
 */
InOutTrend.renderPlot=function(data){
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
	var date=data.date;
	//次数
	var countTotal=data.countTotal;
	//物资数量
	var total=data.total;
	
	//清空图表
	$("#trend").html("");
	//创建图表
	$.jqplot('trend', [countTotal,total],{
		title : title+" - 出入库记录趋势详情",
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
			tooltipAxes : "y",
			sizeAdjust: 7.5
		},
		cursor: {
			show: true,
			zoom:true, 
		},
		legend: {
			show: true,
			placement: 'outsideGrid'
		},
		seriesColors: [ "#25A81E", "#FF9900", "#0099FF", "#FF3300"],
		seriesDefaults:{
			pointLabels: { show:false } ,
			showMarker:false,
			shadow : false
	        },
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer
				//ticks: date
			},
			yaxis: {
				tickOptions: {
					formatString: '%d '
				}
			}
		}
	});
}
