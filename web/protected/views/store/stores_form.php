<script type="text/javascript" src="/plugin/module/store.js"></script>
<script>
    $(function () {
        $("#form").submit(function () {
            var ajaxOpt = {
                dataType: "json",
                error: function () {
                    maya.notice.fail("服务器出现错误", null, 3);
                },
                success: function (data) {
                    maya.notice.close();
                    if (data.status == 0) {
                        maya.notice.fail(data.info);
                    } else {
                        maya.notice.success(data.info, function () {
                            parent.location.reload();
                        });
                    }
                }
            };
            $(form).ajaxSubmit(ajaxOpt);
            return false;
        });
    });

</script>
<form method="post" id="form" name="form" class="form">
    <table width="100%"  class="github_tb">

        <tr>
            <td align="right">上级仓库：</td>
            <td>
                <select name="parentID" id="parentID" >
                    <option value="0"></option>
                    <?php foreach (Store::getCategoryList() as $value): ?>
                        <?php if ($value['storeID'] == $stores->storeID): ?> 
                            <?php continue; ?>
                        <?php endif; ?>
                        <option value="<?php echo $value['storeID']; ?>" <?= $value['storeID'] == $stores->parentID ? "selected=\"selected\"" : "" ?>><?php echo $value['storeName']; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td align="right">仓库名：</td>
            <td><input type="text" name="storeName" id="storeName" value="<?= $stores->storeName ?>" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" id="subBtn" value="提交" class="grid_button" /></td>
        </tr>
    </table>
</form>
