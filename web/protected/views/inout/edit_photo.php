<form action="<?=Yii::app()->request->url?>" id="form" name="form" enctype="multipart/form-data" style="padding: 10px;" method="post">
        <input name="id" type="hidden" value="<?=$_GET['id']?>">
	<table border="0" cellspacing="0" cellpadding="0" class="github_tb" width="100%">
		<tr>
			<td>出库前照片：</td>
			<td>
			<input type="file" name="in_photo"></td>
		</tr>
		<tr>
			<td>出库后照片：</td>
			<td>
			<input type="file" name="out_photo"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="button" class="grid_button grid_button_s" value="提交"></td>
		</tr>
	</table>
        <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 10px;">
                <tr>
                        <td width="50%" valign="top">
                                <fieldset>
                                        <legend>出库前</legend>
                                        <div style="min-height: 200px;">
                                                <?php
                                                if($rs['in_photo']!=""):
                                                ?><a href="<?="/".$rs['in_photo']?>" target="_blank"><img src="<?="/".$rs['in_photo']?>" width="260" height="200" ></a>
                                                <?php
                                                endif;
                                                ?>
                                        </div>
                                </fieldset>
                        </td>
                        <td valign="top">
                                <fieldset>
                                        <legend>出库后</legend>
                                        <div style="min-height: 200px;">
                                                <?php
                                                if($rs['out_photo']!=""):
                                                        ?><a href="<?="/".$rs['out_photo']?>" target="_blank"><img src="<?="/".$rs['out_photo']?>"  width="260" height="200"></a>
                                                <?php
                                                endif;
                                                ?>
                                        </div>
                                </fieldset>
                        </td>
                </tr>
        </table>
</form>