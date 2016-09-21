<?php

/**
 * 功能：任务书管理
 * 作者：陈天宇
 * 日期：2016-6-23
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class TaskController extends Controller {

    /**
     * 控制器名称
     */
    public $controllerName = "任务书管理";

    /**
     * 填写任务书
     */
    public function actionTaskBook(){
        if (Yii::app()->request->isAjaxRequest) {
            $taskBook = New TaskBook();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(empty($_POST['date'])){
                    throw new Exception("施工日期不能为空",0);
                }
                //处理任务书基本信息
                $taskBook->attributes = $_POST;
                $taskBook->state = 'examine';//0：提交；1:退回；2：审核
                //先统计出当日该仓库，任务书数量
                $hz = sprintf("%03d", $taskBook->countBookCode(date('Ymd'))+1);//3位后缀，不足用0补
                $taskBook->bookCode = date('Ymd').$hz;//单号格式【年月日】+【当月单数+1】
                $taskBook->uID = Yii::app()->user->getId();
                if (!$taskBook->add()) {
                    throw new Exception($taskBook->error->getErrorMessage(),0);
                }
                $taskBookCode = $taskBook->bookCode;
                //处理物资信息
                $userID = User::getID();
                $cacheST = "TTdata".$userID;
                $cache = Yii::app()->cache;
                $mtArr = $cache->get($cacheST);//获取缓存中数据
                if(count($mtArr)<1||!is_array($mtArr)){
                    throw new Exception("亲，您一个物资都没填",0);
                }
                foreach($mtArr as $k){
                    $taskBookMaterial = New TaskBookMaterial();
                    $taskBookMaterial->bookCode = $taskBookCode;
                    $taskBookMaterial->goodsName = $k['goodsName'];
                    $taskBookMaterial->standard = $k['standard'];
                    $taskBookMaterial->unit = $k['unit'];
                    $taskBookMaterial->price = $k['price'];
                    $taskBookMaterial->number = $k['number'];
                    if (!$taskBookMaterial->add()) {
                        throw new Exception($taskBookMaterial->error->getErrorMessage(),0);
                    }
                }
                $transaction->commit();
                $cache->delete($cacheST);//入库成功后删除缓存
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0, $e->getTrace());
            }
            WMessage::ajaxInfo();
        }
        //返回缓存中的数据
        $userID = User::getID();
        $cacheST = "TTdata".$userID;
        $cache = Yii::app()->cache;
//        $cache->delete($cacheST);
        $list = $cache->get($cacheST);
//        var_dump($list);
//        exit;
        //渲染视图
        $this->setBread("填写任务书");
        $this->render("Task_Book",array(
            'list'=> $list,
            'add'=> $_GET['add'],
        ));
    }
    /**
     * 将物资添加到任务书,通过缓存
     */
    public function actionAddForm() {
        if (Yii::app()->request->isAjaxRequest) {
            $userID = User::getID();
//            WMessage::ajaxInfo($_GET['edit'],0);
            $userID .= $_GET['edit']=='edit'?'edit':'';
            $cacheST = "TTdata".$userID;
            $cache = Yii::app()->cache;
            $mtArr = $cache->get($cacheST);
            //新增物资时判断入库单中是否存在相同物资
            if(!empty($_POST['goodsName'])) {
                foreach ($mtArr as $k) {
                    if (array_search($_POST['goodsName'], $k)) {
                        WMessage::ajaxInfo('已存在相同物资', 0);
                    }
                }
            }else{
                WMessage::ajaxInfo('物资名称不能为空',0);
            }
            if(empty($_POST['number'])){
                WMessage::ajaxInfo('数量不能为空',0);
            }
            if(!is_numeric($_POST['number'])){
                WMessage::ajaxInfo('数量格式不正确',0);
            }
            //整理数据
            $mt=array(
                "goodsName"=>$_POST['goodsName'],
                "standard"=>$_POST['standard'],
                "unit"=>$_POST['unit'],
                "number"=>$_POST['number'],
                "price"=>$_POST['price']
            );
            //修改物资时，判断物资名称在当前缓存是否已经存在
            if(!empty($_POST['old_goodsName'])){
                $i=0;
                foreach($mtArr as $k){
                    if(array_search($_POST['old_goodsName'], $k)){
                        $mtArr[$i]=$mt;
                        $cache->set($cacheST,$mtArr,7200);//缓存两小时
                        WMessage::ajaxInfo();
                    }
                    $i++;
                }
            }
            //然后存入缓存
            $mtArr[] = $mt;
            $cache->set($cacheST,$mtArr,7200);
            WMessage::ajaxInfo();
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_form",array(
            "edit"=>false,
            "add"=>$_GET['add'],
        ));
    }
    /**
     * 修改缓存中指定的物资信息
     */
    public function actionEditTTdata(){
        $userID = User::getID();
        $userID .= $_GET['edit']=='edit'?'edit':'';
        $cacheST = "TTdata".$userID;
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheST);
        //找到指定物资的下标
        $i=0;//计算下标
        foreach($mtArr as $mt){
            if(array_search($_GET['goodsName'], $mt)){
                $data = $mtArr[$i];
            }
            $i++;
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_form",array(
            'data'=>$data,
            'isEdit'=>true,
            'goodsName'=>$_GET['goodsName']
        ));
    }
    /**
     * 删除缓存中指定的物资信息
     */
    public function actionDelTTdata(){
        $userID = User::getID();
        $userID .= $_GET['edit']=='edit'?'edit':'';
        $cacheST = "TTdata".$userID;
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheST);
        //判断编号在当前缓存是否已经存在,找到后删除该编号的物资信息
        $i=0;//计算下标
        foreach($mtArr as $mt){
            if(array_search($_GET['goodsName'], $mt)){
                array_splice($mtArr, $i, 1);//删除mtArr中第i个元素，只删一个
                $cache->set($cacheST,$mtArr,7200);//删除后更新缓存
                WMessage::ajaxInfo();
            }
            $i++;
        }
        WMessage::ajaxInfo("删除失败",0);
    }

    /**
     * 任务书列表
     */
    public function actionTaskBookList(){
        //查询参数
        $condition[] = "1=1";
        $userID = Yii::app()->user->getId();
        if($_GET['type']=='my'){
            //我提交的报废列表
            $condition[] = "AND uID='{$userID}'";
            $type = "我提交的";
        }elseif($_GET['type']=='Treated'){
            //已处理的报废列表
            $condition[] = " AND (state='adopt' || state='back')";
            $type = "已处理的";
        }elseif($_GET['type']=='Untreated'){
            //待处理的报废列表
            $condition[] = " AND state='examine'";
            $type = "待处理的";
        }
        if(!empty($_GET['sdate'])||!empty($_GET['edate'])){
            $condition[] = " AND (date>='{$_GET['sdate']}' AND date<='{$_GET['edate']}')";
        }
        $condition[] = $_GET['zrbz'] == "" ? "" : "AND INSTR(zrbz,'{$_GET['zrbz']}')>0";

        //模型实例化
        $taskBook = New TaskBook();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id desc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $taskBook->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread($type."任务书");
        $this->render("task_book_list",array(
            'rsList'=>$rsList,
            'type'=>$type
        ));
    }
    /**
     * 移库单详情
     */
    public function actionShowTaskBook(){
        $taskBook = TaskBook::model()->find("bookCode=".$_GET['bookCode']);
        $mList = TaskBookMaterial::model()->findAll("bookCode=".$_GET['bookCode']);
//        var_dump($taskBook);
//        var_dump($mList);
//        exit();
        $type = $_GET['type']=="exam"?true:false;
        //渲染视图
        $this->setLayoutNone();
        $this->render("task_book_show",array(
            'exam'=>$type,
            'taskBook'=>$taskBook,
            'list'=>$mList
        ));
    }

    /**
     * 任务书审核
     */
    public function actionExamine(){
        $taskBook = TaskBook::model()->find("bookCode='{$_POST['bookCode']}'");
        if($_POST['type']=='back'){
            //退回
            $taskBook->opinion = $_POST['back_opinion'];
            $taskBook->state = 'back';
            if(!$taskBook->edit()){
                WMessage::ajaxInfo("退回操作失败", 0);
            }
        }elseif($_POST['type']=='ok'){
            //通过
            $taskBook->opinion = $_POST['opinion'];
            $taskBook->state = 'adopt';
            if(!$taskBook->edit()){
                WMessage::ajaxInfo("审核操作失败", 0);
            }
        }
        WMessage::ajaxInfo();
    }

    /**
     * 修改任务书
     */
    public function actionEditTaskBook(){
        if (Yii::app()->request->isAjaxRequest) {
            /**
             * 修改任务书
             * 1.原任务书基本数据进行修改
             * 2.任务书物资数据，已有的修改，没有的新增
             */
            $storeID = UserStore::getStoreByUserID()->storeID;
            if ($storeID == null) {
                WMessage::ajaxInfo("非法操作，请联系超级管理员绑定仓库", 0);
            }

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $taskBookID = $_GET['formID'];
                //处理任务书基本信息
                $taskBook = New TaskBook();
                $taskBook = $taskBook->model()->find("bookCode={$taskBookID}");
                $taskBook->state = TaskBook::STATE_S;//0：提交；1:退回；2：通过
                if (!$taskBook->edit()) {
                    throw new Exception($taskBook->error->getErrorMessage(),0);
                }
                //处理物资信息
                $userID = User::getID();
                $cacheST = "TTdata".$userID."edit";
                $cache = Yii::app()->cache;
                $mtArr = $cache->get($cacheST);//获取缓存中数据
                if(count($mtArr)<1||!is_array($mtArr)){
                    throw new Exception("亲，您一个物资都没填",0);
                }
                //查出订单中所有物资，匹配物资编号，如果不存在缓存中，就删除
                $scrapMaterial = New TaskBookMaterial();
                $scrapMaterials = $scrapMaterial->model()->findAll("bookCode={$taskBookID}");
                foreach($scrapMaterials as $v){
                    $dbMaterial[] = "{$v['goodsName']}";
                }
                foreach($mtArr as $k){
                    $taskBookMaterial = New TaskBookMaterial();
                    $material = $taskBookMaterial->model()->find("bookCode={$taskBookID} AND goodsName='{$k['goodsName']}'");
                    //如果物资存在，修改，不存在新增
                    if($material){
                        $material->goodsName = $k['goodsName'];
                        $material->standard = $k['standard'];
                        $material->unit = $k['unit'];
                        $material->number = $k['number'];
                        $material->price = $k['price'];
                        if (!$material->edit()) {
                            throw new Exception($material->error->getErrorMessage(),0);
                        }
                    }else{
                        $taskBookMaterial->bookCode = $taskBookID;
                        $taskBookMaterial->goodsName = $k['goodsName'];
                        $taskBookMaterial->standard = $k['standard'];
                        $taskBookMaterial->unit = $k['unit'];
                        $taskBookMaterial->number = $k['number'];
                        $taskBookMaterial->price = $k['price'];
                        if (!$taskBookMaterial->add()) {
                            throw new Exception($taskBookMaterial->error->getErrorMessage(),0);
                        }
                    }
                    $cacheMaterial[] = "{$k['goodsName']}";
                }
                $cache->delete($cacheST);//成功后删除缓存
                $cache->delete("formID");
                //整理出数据库中有，缓存中没有的物资名称，然后删除
                $dbMaterial = array_diff($dbMaterial,$cacheMaterial);
                $goodsName = implode("','", $dbMaterial);
                $scrapMaterial->model()->deleteAll("bookCode={$taskBookID} AND goodsName IN('{$goodsName}')");
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0, $e->getTrace());
            }
            WMessage::ajaxInfo();
        }
        $userID = User::getID();
        $cacheST = "TTdata".$userID."edit";
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheST);
        $cacheFormID = $cache->get("bookCode");
        if($cacheFormID){
//            WMessage::ajaxInfo($cacheFormID,0);
            //如果缓存中的表单ID为空或者不是接收到的ID
            if($cacheFormID!=$_GET['formID']){
                WMessage::ajaxInfo($cacheFormID,0);
//                echo $cacheFormID."#".$_GET['formID'];
//                exit;
                $cache->delete($cacheST);//不同任务书时清理缓存
                $mtArr = $cache->get($cacheST);
                $cache->set("bookCode",$_GET['formID'],7200);//重设表单ID缓存
                $list = TaskBookMaterial::model()->findAll('bookCode='.$_GET['formID']);//任务书物资
                foreach($list as $k){
                    $mt=array(
                        "goodsName"=>$k->goodsName,
                        "standard"=>$k->standard,
                        "unit"=>$k->unit,
                        "number"=>$k->number,
                        "price"=>$k->price
                    );
                    $mtArr[] = $mt;
                    $cache->set($cacheST,$mtArr,7200);//存入缓存
                }
            }else{
                $mtArr = $cache->get($cacheST);
                if($mtArr==[]){
                    $list = TaskBookMaterial::model()->findAll('bookCode='.$_GET['formID']);//任务书物资
                    foreach($list as $k){
                        $mt=array(
                            "goodsName"=>$k->goodsName,
                            "standard"=>$k->standard,
                            "unit"=>$k->unit,
                            "number"=>$k->number,
                            "price"=>$k->price
                        );
                        $mtArr[] = $mt;
                        $cache->set($cacheST,$mtArr,7200);//存入缓存
                    }
                }
            }
        }else{
            //缓存中没有时
            $cache->set("bookCode",$_GET['formID'],7200);//将表单ID存入缓存
            $list = TaskBookMaterial::model()->findAll('bookCode='.$_GET['formID']);//任务书物资
            foreach($list as $k){
                $mt=array(
                    "goodsName"=>$k->goodsName,
                    "standard"=>$k->standard,
                    "unit"=>$k->unit,
                    "number"=>$k->number,
                    "price"=>$k->price
                );
                $mtArr[] = $mt;
                $cache->set($cacheST,$mtArr,7200);//存入缓存
            }
        }
        $taskBook = TaskBook::model()->find('bookCode='.$_GET['formID']);
        //-------------------------------------------
        //渲染视图
        $this->setBread("修改配电任务书");
        $this->render("task_book",array(
            "userID"=>User::getID(),
            "edit"=>true,
            "taskBook"=>$taskBook,
            'list'=> $mtArr
        ));
    }

    public function actionTest(){
        $userID = User::getID();
        $cacheST = "TTdata".$userID.'edit';
        $cache = Yii::app()->cache;
        //$cache->add('a','hello');
        //$cache->set('a','hello2');
        $cache->delete($cacheST);
//        $cache->delete("formID");
//        $cache->flush('MTdate');
        $mtArr = $cache->get($cacheST);
        echo var_dump($mtArr);
    }
}