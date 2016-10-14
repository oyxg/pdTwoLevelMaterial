<!--  管理员的界面 -->


<div id="navigator">

    <?php //如果有物资的权限?>
    <?php if (Auth::has(AI::T_Material)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">物资管理</a></li>
        </ul>
        <div class="nav_sub">
            <ul>
                <?php if (Auth::has(AI::C_MaterialList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("material/list"); ?>">物资列表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_InForm)&&!Auth::has(AI::R_Visitor)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("material/inform"); ?>">填写入库单</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_InFormList)&&!Auth::has(AI::R_Visitor)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("material/informlist"); ?>">入库单列表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_MoveForm)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("material/moveform"); ?>">填写移库单</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_MoveFormList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("material/moveformlist"); ?>">移库单列表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_Inventory)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("Inventory/list"); ?>">物资盘点</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
    <!--return;receive-->
    <?php if (Auth::has(AI::T_UseMaterial)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">领退料管理</a></li>
        </ul>
        <div class="nav_sub">
            <ul>
                <?php if (Auth::has(AI::C_ReceiveMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReceiveMF"); ?>">填写领料单</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_MyReceiveMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReceiveMFList")."?type=my"; ?>">我提交的领料单</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_ReturnMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReturnMF"); ?>">填写退料单</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_MyReturnMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReturnMFList")."?type=my"; ?>">我提交的退料单</a></li>
                <?php endif; ?>

                <?php if (Auth::has(AI::C_UntreatedReceiveMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReceiveMFList")."?type=unt"; ?>">待处理的领料单
                            <strong style="color:#FF3300">(<?php echo ReceiveForm::model()->count("state='sh'");?>)</strong></a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_TreatedReceiveMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReceiveMFList")."?type=yjt"; ?>">已处理的领料单</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_UntreatedReturnMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReturnMFList")."?type=unt"; ?>">待处理的退料单
                            <strong style="color:#FF3300">(<?php echo ReturnForm::model()->count("state='sh'");?>)</strong></a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_TreatedReturnMF)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/ReturnMFList")."?type=yjt"; ?>">已处理的退料单</a></li>
                <?php endif; ?>

                <?php if (Auth::has(AI::C_ReceiveMaterialList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/UseMaterialList")."?type=receive"; ?>">领料单物资记录</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_ReturnMaterialList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("UseMaterial/UseMaterialList")."?type=return"; ?>">退料单物资记录</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (Auth::has(AI::T_Task)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">配电任务书管理</a></li>
        </ul>
        <div class="nav_sub">
            <ul>
                <?php if (Auth::has(AI::C_TaskBook)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("task/TaskBook"); ?>">填写任务书</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_MyTaskBook)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("task/TaskBookList")."?type=my"; ?>">我提交的任务书</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_UntreatedTaskBook)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("task/TaskBookList")."?type=Untreated"; ?>">待处理的任务书
                            <strong style="color:#FF3300">(<?php echo TaskBook::model()->count("state='examine'");?>)</strong></a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_TreatedTaskBook)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("task/TaskBookList")."?type=Treated"; ?>">已处理的任务书</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (Auth::has(AI::T_PreFloodMaterial)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">防汛物资管理</a></li>
        </ul>
        <div class="nav_sub">
            <ul>
                <?php if (Auth::has(AI::C_PreFloodMaterialList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("prefloodmaterial/PreFloodlist"); ?>">防汛物资列表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_PreFloodMaterialInfo)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("prefloodmaterial/PreFloodInfo"); ?>">防汛物资信息</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_PreFloodMaterialIn)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("prefloodmaterial/PreFloodIn"); ?>">防汛物资台账</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (Auth::has(AI::T_Instrument)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">仪器仪表管理</a></li>
        </ul>
        <div class="nav_sub">
            <ul>
                <?php if (Auth::has(AI::C_InstrumentList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("Instrument/Instrumentlist"); ?>">仪器仪表列表</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (Auth::has(AI::T_Scrap)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">报废管理</a></li>
        </ul>
        <div class="nav_sub">
            <ul>
                <?php if (Auth::has(AI::C_ScrapForm)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("scrap/scrapform"); ?>">填写报废表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_MyScrapForm)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("scrap/ScrapFormList")."?type=my"; ?>">我提交的报废表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_UntreatedScrapForm)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("scrap/ScrapFormList")."?type=Untreated"; ?>">待处理的报废表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_TreatedScrapForm)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("scrap/ScrapFormList")."?type=Treated"; ?>">已处理的报废表</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php //如果有仓库的权限?>
    <?php if (Auth::has(AI::T_Store)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">仓库</a></li>
        </ul>
        <div class="nav_sub">
            <ul>
                <?php if (Auth::has(AI::C_StoreList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("store/list"); ?>">仓库列表</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php //如果有系统设置的权限?>
    <?php if (Auth::has(AI::T_Setting)): ?>
        <ul class="nav_ul">
            <li><a href="javascript:void(0)">系统设置</a></li>
        </ul>
        <div class="nav_sub">
            <ul id="user_setting">
                <?php if (Auth::has(AI::C_UserList)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("user/list"); ?>">用户列表</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_UserStore)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("userstore/list"); ?>">用户仓库设置</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::T_Auth)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("auth/itemlist"); ?>">权限设置</a></li>
                <?php endif; ?>
                <?php if (Auth::has(AI::C_Bz)): ?>
                    <li><a href="<?php echo Yii::app()->createUrl("bz/list"); ?>">班组列表</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>