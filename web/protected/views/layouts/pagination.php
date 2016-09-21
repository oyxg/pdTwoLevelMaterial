	
	<?php if($this->pagination->pageCount>1):?>
	<div style="padding-top:14px;text-align:center; padding:20px 0 20px 0;">
		<div class="pagination pagination-centered">

		 <?php    
		    $this->widget('CLinkPager',array(
		    		'header'=>"",
				'firstPageLabel' => '首页',    
				'lastPageLabel' => '末页',    
				'prevPageLabel' => '上一页',    
				'nextPageLabel' => '下一页',    
				'pages' => $this->pagination,
				'cssFile'=>null,    
				'maxButtonCount'=>10    
			)    
		    );    
		    ?>
		</div>
	</div>
	<?php endif;?>