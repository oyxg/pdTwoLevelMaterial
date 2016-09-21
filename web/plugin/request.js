$(function(){
	$(".remote-data").each(function(i){
		$(this).load("/request/requestgoodsajax?requestID="+$(this).attr("action-id"));		
	});
});