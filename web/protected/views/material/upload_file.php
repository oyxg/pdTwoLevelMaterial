<style>
    body{height:600px;}
</style>
<script>
    $(function(){
        $('a[rel=showpic]').click(function(){
            window.__box=new Maya.Box({
                url : "/material/showPic?src="+$(this).attr('src'),
                width : 500,
                heigh : 400,
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
        $fileName = substr(strchr($file,'move_from_pic/'),14);
        if(!empty($file)):?>
        <tr>
            <td><?=$file?></td>
            <td>&nbsp;&nbsp;
                <a rel="showpic" src="<?=$file;?>">查看</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/material/delFile?formID=<?=$formID?>&name=<?=$fileName?>">删除</a></td>
        </tr>
    <?php endif;
    endforeach;?>
        <tr>
            <form id="form" name="form" class="" action="/material/uploadFile" method="post" enctype="multipart/form-data">
            <td><label>新增附件：</label><input type="file" name="file" />
                <input type="hidden" name="formID" value="<?=$formID?>" /></td>
            <td><button type="submit" class="grid_button">提交</button></td>
            </form>
        </tr>
    </tbody>
</table>