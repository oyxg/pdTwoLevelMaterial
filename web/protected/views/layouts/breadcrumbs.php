<?php 
$this->widget("zii.widgets.CBreadcrumbs",array(
					"homeLink"=>"<strong>当前位置：</strong> 主页",
					"links"=>$this->breadcrumbs,
					"separator"=>" &gt; ",
					"htmlOptions"=>array(
						"class"=>"breadcrumb"
					)
				));?>