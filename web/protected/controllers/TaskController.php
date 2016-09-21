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
            //先接收任务书基础信息，生成id
            //再插入任务书物资
            $session = new CHttpSession();
            $session->open();
            $data = $session->get("task_material");
            if (!is_array($data)) {
                WMessage::ajaxInfo("请先添加物资", 0);
            } else {
                if (count($data) <= 0) {
                    WMessage::ajaxInfo("物资不能为空，请先添加", 0);
                }
            }
            //事务处理
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //新增任务书记录
                $taskBook = New TaskBook();
                if(empty($_POST['date'])){
                    throw new Exception("施工日期不能为空",0);
                }
                $taskBook->attributes = $_POST;
                $taskBook->state = 'examine';//0：提交；1:退回；2：审核
                //先统计出当日该仓库，任务书数量
                $hz = sprintf("%03d", $taskBook->countBookCode(date('Ymd'))+1);//3位后缀，不足用0补
                $taskBook->bookCode = date('Ymd').$hz;//单号格式【年月日】+【当月单数+1】
                $taskBook->uID = Yii::app()->user->getId();
                if (!$taskBook->add()) {
                    throw new Exception($taskBook->error->getErrorMessage());
                }
                $taskBookCode = $taskBook->bookCode;

                //保存任务书中的物资
                for ($i = 0; $i < count($data); $i++) {
                    $_rtm = unserialize($data[$i]);//依旧能拿到之前的对象
                    $_rtm->update();
                    //可申请数减去申请。当前库存要等任务书通过后才减
                    $_rtm->material->applyNum -= $_rtm->number;
                    if (!$_rtm->material->edit()) {
                        throw new Exception($_rtm->material->error->getErrorMessage());
                    }
                    //在任务书物资中添加该物资记录
                    $rfm = new TaskBookMaterial();
                    $rfm->bookCode = $taskBookCode;
                    $rfm->materialID = $_rtm->material->materialID;
                    $rfm->batchCode = $_rtm->material->batchCode;
                    $rfm->goodsCode = $_rtm->material->goodsCode;
                    $rfm->goodsName = $_rtm->material->goodsName;
                    $rfm->standard = $_rtm->material->standard;
                    $rfm->number = $_rtm->number;//请领数
                    $rfm->sfnumber = $_rtm->number;//实发数
                    $rfm->applyNum = $_rtm->number;//退料时可申请数
                    $rfm->unit = $_rtm->material->unit;
                    $rfm->price = $_rtm->material->price;
                    if (!$rfm->add()) {
                        throw new Exception($rfm->error->getErrorMessage());
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0);
            }
            $session->remove("task_material");
            WMessage::ajaxInfo();
        }
        $store = UserStore::getStoreByUserID();
        if (!$store) {
            WMessage::htmlWarn("您没有绑定仓库");
        }
        //渲染视图
        $this->render("task_book",array(
            "userID"=>User::getID()
        ));
    }

    /**
     * 可供领用的物资列表
     */
    public function actionSelectList(){
        //查询参数
        $condition[] = $_GET['batchCode'] == "" ? "" : " AND INSTR(batchCode,'{$_GET['batchCode']}')>0";
        $condition[] = $_GET['goodsName'] == "" ? "" : " AND INSTR(goodsName,'{$_GET['goodsName']}')>0";
        $condition[] = $_GET['goodsCode'] == "" ? "" : " AND INSTR(goodsCode,'{$_GET['goodsCode']}')>0";

        $condition[] = "AND del='0'";
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 10;
        //查找数据
        $storeID = UserStore::getStoreByUserID()->storeID;
        $sql = "SELECT * FROM mod_material";
        $sqlWhere = " WHERE storeID IN ({$storeID}) AND currCount<>0" . $criteria->condition;
        $sqlMerge = $sql . $sqlWhere;
        $command = Yii::app()->db->createCommand($sqlMerge);
        $rsList = ActiveRecord::getRecordByCMD($command, $this->pagination, $criteria);
//        var_dump($rsList);
//        exit();
        //返回所有物资数据
        $this->setLayoutNone();
        $this->setBread("填写任务书");
        $this->render("select_list",array(
            "rsList" => $rsList
        ));
    }
    /**
     * 将物资添加到任务书,通过session缓存
     */
    public function actionAddToTaskBook() {
        $materialID = $_POST['materialID'];
        $number = $_POST['num'];//领用数量
        if (!is_numeric($materialID)) {
            WMessage::ajaxInfo("非法的物资", 0);
        }
        if ($number<=0) {
            WMessage::ajaxInfo("请选择至少选择一个物资", 0);
        }
        $rtm = new WTempUseMaterial($materialID,$number);
        //检查
        try {
            $rtm->validate();
        } catch (Exception $e) {
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        //Session
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("task_material");
        //检查重复
        if ($data != null) {
            for ($i = 0; $i < count($data); $i++) {
                $_rtm = unserialize($data[$i]);
                if ($_rtm->materialID == $rtm->materialID) {
                    WMessage::ajaxInfo("已经存在，请先删除后在操作", 0);
                }
            }
        } else {
            $data = array();
        }
        array_push($data, serialize($rtm));
        $session->add("task_material", $data);
        WMessage::ajaxInfo();
    }
    /**
     * 已经添加进任务书的物资列表
     */
    public function actionSelectedList() {
        if($_GET['type']=='edit'){
            //编辑状态时，数据从数据库取
            $data = TaskBookMaterial::model()->findAll('bookCode='.$_GET['formID']);
            var_dump($data);
            exit;
        }else{
            //Session
            $session = new CHttpSession();
            $session->open();
            $data = $session->get("task_material");
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("selected_list", array(
            "rsList" => $data
        ));
    }
    /**
     * 从任务书中移除
     */
    public function actionRemoveToTaskBook() {
        $materialID = $_POST['materialID'];
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("task_material");
        if ($data != null) {
            for ($i = 0; $i < count($data); $i++) {
                $_rtm = unserialize($data[$i]);
                if ($_rtm->materialID == $materialID) {
                    array_splice($data, $i, 1);
                    $session->add("task_material", $data);
                    WMessage::ajaxInfo();
                }
            }
        }
        WMessage::ajaxInfo("没有数据", 0);
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
        $taskBook = TaskBook::model()->find("bookCode=".$_GET['id']);
        $mList = TaskBookMaterial::model()->findAll("bookCode=".$_GET['id']);
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
        $taskBook = TaskBook::model()->find("bookCode='{$_POST['formID']}'");
        if($_POST['type']=='no'){
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //修改领用物资库存
                $taskBookMaterial = TaskBookMaterial::model()->findAll("bookCode='{$_POST['formID']}'");
                foreach ($taskBookMaterial as $v) {
                    $m = Material::model()->find("materialID='{$v->materialID}'");
                    $m->applyNum += $v->number;//作废应该将可领用数量加回去。
                    if(!$m->edit()){
                        throw new Exception($m->error->getErrorMessage());
                    }
                }
                //修改任务书状态
                $taskBook->state = 'back';
//            $taskBook->opinion = $_POST['back_opinion'];
                if(!$taskBook->edit()){
                    WMessage::ajaxInfo("操作失败", 0);
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0);
            }
        }elseif($_POST['type']=='ok'){
            //通过
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //修改领用物资库存
                $materials = TaskBookMaterial::model()->findAll("bookCode='{$_POST['formID']}'");
                foreach($materials as $v){
                    $m = Material::model()->find("materialID='{$v->materialID}'");
                    $m->currCount -= $v->sfnumber;
                    if(!$m->edit()){
                        throw new Exception($m->error->getErrorMessage());
                    }
                }
                //修改任务书状态
                $taskBook->state = 'adopt';
//                $taskBook->opinion = $_POST['opinion'];
                if(!$taskBook->edit()){
                    WMessage::ajaxInfo("操作失败", 0);
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0);
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
//        $cacheST = "TTdata".$userID.'edit';
        $cacheST = "task_material";
        $cache = Yii::app()->cache;
        //$cache->add('a','hello');
        //$cache->set('a','hello2');
//        $cache->delete($cacheST);
//        $cache->delete("formID");
//        $cache->flush('MTdate');
        $mtArr = $cache->get($cacheST);
        echo var_dump($mtArr);
    }
}