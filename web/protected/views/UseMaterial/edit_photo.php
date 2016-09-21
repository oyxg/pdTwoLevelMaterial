<form action="<?=Yii::app()->request->url?>" id="form" name="form" enctype="multipart/form-data" style="padding: 10px;" method="post">
        <input name="id" type="hidden" value="<?=$_GET['id']?>">
	<table border="0" cellspacing="0" cellpadding="0" class="github_tb" width="100%">
		<tr>
			<td>照片：</td>
			<td>
			<input type="file" name="pic"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="button" class="grid_button grid_button_s" value="提交"></td>
		</tr>
	</table>
        <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 10px;">
                <tr>
                        <td width="100%" valign="top">
                                <fieldset>
                                        <div style="min-height: 200px;text-align: center;">
                                                <?php
                                                if($rs['pic']!=""):
                                                ?><a href="<?="/".$rs['pic']?>" target="_blank"><img src="<?="/".$rs['pic']?>" ></a>
                                                <?php
                                                endif;
                                                ?>
                                        </div>
                                </fieldset>
                        </td>
                </tr>
        </table>
</form>