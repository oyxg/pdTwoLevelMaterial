<style>
    body{height:600px;}
</style>
<script>
    $(function(){
        $('a[rel=showpic]').click(function(){
            window.__box=new Maya.Box({
                url : "/UseMaterial/showPic?src="+$(this).attr('src'),
                width : 500,
                heigh : 400,
                text : "查看"+$(this).attr('src')
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
        $num = $type=="receive"?12:11;
        $fileName = substr(strchr($file,$type),$num);
        if(!empty($file)):?>
        <tr>
            <td><?=$file?></td>
            <td>&nbsp;&nbsp;
                <?php
                $ext = strrchr($file,'.');
                if($ext=='.xls'):
                ?>
                    <a href="../<?=$file;?>">下载</a>
                <?php else: ?>
                    <a rel="showpic" src="<?=$file;?>">查看</a>
                <?php endif;?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/UseMaterial/delFile?type=<?=$type?>&formID=<?=$formID?>&name=<?=$fileName?>">删除</a></td>
        </tr>
    <?php endif;
    endforeach;?>
        <tr>
            <form id="form" name="form" class="" action="/UseMaterial/uploadFile" method="post" enctype="multipart/form-data">
            <td><label>新增附件：</label><input type="file" name="file" />
                <input type="hidden" name="formID" value="<?=$formID?>" /></td>
                <input type="hidden" name="type" value="<?=$type?>" /></td>
            <td><button type="submit" class="grid_button">提交</button></td>
            </form>
        </tr>
    </tbody>
</table>