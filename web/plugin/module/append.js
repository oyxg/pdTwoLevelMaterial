var Append={}

//查看补库单详细
Append.detail=function(appendID){
	window.__box=new Maya.Box({
		text : "补库单详细",
		width : 800,
		height : 300,
		url : "/append/detail.html?appendID="+appendID	
	});	
}