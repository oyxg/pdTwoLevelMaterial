<?php 
$this->beginContent("//layouts/head");
$this->endContent();
?>
<body>
<?php 
$this->beginContent("//layouts/layout_header");
$this->endContent();
?>
<div class="wraper">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="170" style="min-width:170px;"  valign="top">
	<?php 
	$this->beginContent("//layouts/left");
	$this->endContent();
	?>
	</td>
	<td valign="top" class="mright">
	<?php echo $content;?>
	</td>
	</tr>
	</table>
</body>
</html>
