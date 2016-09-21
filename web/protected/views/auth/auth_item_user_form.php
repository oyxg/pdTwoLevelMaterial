<link rel="stylesheet" type="text/css" href="/plugin/module/auth.css"/>
<script>
$(function(){

	$(":checkbox").click(function(){
		var checkbox=$(this);
		var checked=$(this).attr("checked");
		var method=checked=="checked" ? "allow" : "deny";
		$.post(
			"/auth/ItemUserEdit",
			{
				"userID" : "<?=$userID?>",
				"method" : method,
				"item" : $(this).attr("item")
			},
			function(data){
				if(data.status==1){
					maya.notice.success(data.info,null,0.3);
				}else{
					if(checked=="checked"){
						checkbox.removeAttr("checked")
					}else{
						checkbox.attr("checked","checked");
					}
					maya.notice.fail(data.info);	
				}
			},
			"json"
		);	
	});
});
</script>
<form method="post" id="form" class="form" name="form">
	<div class="easyui-tabs" style="height: 450px">
	<?php foreach (AuthItem::getTypeList() as $key=>$type):?>
	<div title="<?php echo $type;?>" style="padding: 10px">
			<div>
			<?php foreach (Auth::getAuthManager()->getAuthItems($key) as $index=>$item):?>
			<label class="label" title="<?php echo $item->description;?>">
			<input  type="checkbox" item="<?php echo $item->name;?>" <?=$item->isAssigned($userID) ? "checked" : ""?>><?php echo $item->description;?> </label>
			<?php endforeach;?>
			</div>
		</div>
	<?php endforeach;?>
	</div>
</form>
