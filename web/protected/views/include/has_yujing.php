<?php
$storeID=UserStore::getStoreByUserID()->storeID;
$count=Material::model()->count("storeID={$storeID} and currCount<minCount AND deleted=0");
if ($count>0):
?>
<script type="text/javascript">
var b=new Maya.Box({
	text : '预警',
	position : 'rightBottom',
	overlayShow : false,
	width : 260,
	type : 'inline',
	chtml : '<div style="padding:20px;">有 <span style="color:red"><?php echo $count;?></span> 件物资预警，<a href="/material/warning.html">点击这里查看</a></div>'
});
</script>
<?php
endif;
?>