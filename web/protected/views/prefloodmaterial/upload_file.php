<style>
    body{height:600px;}
</style>
<script>
    $(function(){
        $('a[rel=showPic]').click(function(){
            window.__box=new Maya.Box({
                url : "/PreFloodMaterial/ShowPic?src="+$(this).attr('src'),
                width : 500,
                height : 400,
                text : "查看"
            });
        });
    });
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="github_tb">
    <thead>
        <tr>
            <th>文件名</th>
            <th width="80">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($fileArr as $file):
        $fileName = substr(strchr($file,'preflood_file/'),14);
        if(!empty($file)):?>
        <tr>
            <td><?=$file?></td>
            <td>&nbsp;&nbsp;
                <?php
                $ext = strrchr($file,'.');
                if($ext=='.xls'||$ext=='.docx'||$ext=='.doc'||$ext=='.pdf'):
                    ?>
                    <a href="../<?=$file;?>">下载</a>
                <?php  else:  ?>
                    <a rel="showPic" src="<?=$file;?>">查看</a>
                <?php endif;?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/PreFloodMaterial/DelFile?inID=<?=$inID?>&name=<?=$fileName?>">删除</a></td>
        </tr>
    <?php endif;
    endforeach;?>
        <tr>
            <form id="form" name="form" class="" action="/PreFloodMaterial/UploadFile" method="post" enctype="multipart/form-data">
            <td><label>新增附件：</label><input type="file" name="file" />
                <input type="hidden" name="inID" value="<?=$inID?>" /></td>
            <td><button type="submit" class="grid_button">提交</button></td>
            </form>
        </tr>
    </tbody>
</table>