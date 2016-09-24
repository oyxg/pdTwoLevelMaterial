<?php

/**
 * 功能：物资报废管理
 * 作者：陈天宇
 * 日期：2016-4-13
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class ScrapController extends Controller {

    /**
     * 控制器名称
     */
    public $controllerName = "物资报废管理";

    /**
     * 填写报废单
     */
    public function actionScrapForm(){
        if (Yii::app()->request->isAjaxRequest) {
            $storeID = UserStore::getStoreByUserID()->storeID;
            if ($storeID == null) {
                WMessage::ajaxInfo("非法操作，请联系超级管理员绑定仓库", 0);
            }
            $scrapForm = New ScrapForm();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //处理报废单基本信息
                $scrapForm->attributes = $_POST;
                $scrapForm->storeID = $storeID;
                $scrapForm->zID = $_POST['Major'];
                $scrapForm->bID = $userID = Yii::app()->user->getId();
                $scrapForm->state = '0';//0：提交；1:退回；2：审核
                //先统计出当日该仓库，报废单数量
                $hz = sprintf("%03d", $scrapForm->countFormCode(date('Ymd'))+1);//3位后缀，不足用0补
                $scrapForm->formCode = date('Ymd').$hz;//单号格式【年月日】+【当月单数+1】
                $scrapForm->date = date('Y-m-d');
                if (!$scrapForm->add()) {
                    throw new Exception($scrapForm->error->getErrorMessage(),0);
                }
                $scrapFormID = Yii::app()->db->getLastInsertID();//得到最后插入数据的id
                //处理物资信息
                $userID = User::getID();
                $cacheST = "STdata".$userID;
                $cache = Yii::app()->cache;
                $mtArr = $cache->get($cacheST);//获取缓存中数据
                if(count($mtArr)<1||!is_array($mtArr)){
                    throw new Exception("亲，您一个物资都没填",0);
                }
                foreach($mtArr as $k){
                    $scrapFormMaterial = New ScrapFormMaterial();
                    $scrapFormMaterial->formID = $scrapFormID;
                    $scrapFormMaterial->goodsCode = $k['goodsCode'];
                    $scrapFormMaterial->goodsName = $k['goodsName'];
                    $scrapFormMaterial->standard = $k['standard'];
                    $scrapFormMaterial->unit = $k['unit'];
                    $scrapFormMaterial->designNum = $k['designNum'];
                    $scrapFormMaterial->number = $k['number'];
                    $scrapFormMaterial->remark = $k['remark'];
                    if (!$scrapFormMaterial->add()) {
                        throw new Exception($scrapFormMaterial->error->getErrorMessage(),0);
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
        $cacheST = "STdata".$userID;
        $cache = Yii::app()->cache;
//        $cache->delete($cacheST);
        $list = $cache->get($cacheST);
//        var_dump($list);
//        exit;
        //渲染视图
        $this->setBread("填写报废审批表");
        $this->render("scrap_form",array(
            'list'=> $list
        ));
    }
    /**
     * 将物资添加到报废表,通过缓存
     */
    public function actionAddForm() {
        if (Yii::app()->request->isAjaxRequest) {
            $userID = User::getID();
            $cacheST = "STdata".$userID;
            $cache = Yii::app()->cache;
            $mtArr = $cache->get($cacheST);

            //验证数据格式
            if(empty($_POST['goodsCode'])){
                WMessage::ajaxInfo('资产编号不能为空',0);
            }
            //新增物资时判断入库单中是否存在相同物资编号
            if(empty($_POST['oldgCode'])) {
                foreach ($mtArr as $k) {
                    if (array_search($_POST['goodsCode'], $k)) {
                        WMessage::ajaxInfo('入库单中已经存在相同资产编号', 0);
                    }
                }
            }
            if(empty($_POST['goodsName'])){
                WMessage::ajaxInfo('物资描述不能为空',0);
            }
            if(empty($_POST['number'])){
                WMessage::ajaxInfo('实退数量不能为空',0);
            }
            if(!is_numeric($_POST['number'])){
                WMessage::ajaxInfo('实退数量格式不正确',0);
            }
            //整理数据
            $mt=array(
                "goodsCode"=>$_POST['goodsCode'],
                "goodsName"=>$_POST['goodsName'],
                "standard"=>$_POST['standard'],
                "unit"=>$_POST['unit'],
                "designNum"=>$_POST['designNum'],
                "number"=>$_POST['number'],
                "remark"=>$_POST['remark']
            );
            //修改物资时，判断编号在当前缓存是否已经存在
            if(!empty($_POST['oldgCode'])){
                $i=0;
                foreach($mtArr as $k){
                    if(array_search($_POST['oldgCode'], $k)){
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
        $this->render("add_form");
    }
    /**
     * 修改缓存中指定的物资信息
     */
    public function actionEditSTdata(){
        $userID = User::getID();
        $cacheST = "STdata".$userID;
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheST);
        //找到指定物资的下标
        $i=0;//计算下标
        foreach($mtArr as $mt){
            if(array_search($_GET['goodsCode'], $mt)){
                $data = $mtArr[$i];
            }
            $i++;
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_form",array(
            'data'=>$data,
            'isEdit'=>true,
            'oldgCode'=>$_GET['goodsCode']
        ));
    }
    /**
     * 删除缓存中指定的物资信息
     */
    public function actionDelSTdata(){
        $userID = User::getID();
        $cacheST = "STdata".$userID;
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheST);
        //判断编号在当前缓存是否已经存在,找到后删除该编号的物资信息
        $i=0;//计算下标
        foreach($mtArr as $mt){
            if(array_search($_GET['goodsCode'], $mt)){
                array_splice($mtArr, $i, 1);//删除mtArr中第i个元素，只删一个
                $cache->set($cacheST,$mtArr,7200);//删除后更新缓存
                WMessage::ajaxInfo();
            }
            $i++;
        }
        WMessage::ajaxInfo("删除失败",0);
    }

    /**
     * 报废表列表
     */
    public function actionScrapFormList(){
        //查询参数
        $condition[] = "1=1";
        $userID = Yii::app()->user->getId();
        if($_GET['type']=='my'){
            //我提交的报废列表
            $condition[] = "AND bID='{$userID}'";
            $type = "我提交的";
        }elseif($_GET['type']=='Treated'){
            //已处理的报废列表
            $condition[] = "AND zID='{$userID}' AND state<>'0'";
            $type = "已处理的";
        }elseif($_GET['type']=='Untreated'){
            //待处理的报废列表
            $condition[] = "AND zID='{$userID}' AND state='0'";
            $type = "待处理的";
        }
        $condition[] = $_GET['formCode'] == "" ? "" : "AND INSTR(formCode,'{$_GET['formCode']}')>0";
        $condition[] = $_GET['projectName'] == "" ? "" : "AND INSTR(projectName,'{$_GET['projectName']}')>0";

        //模型实例化
        $scrapForm = New ScrapForm();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id desc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $scrapForm->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread($type."报废列表");
        $this->render("scrap_form_list",array(
            'rsList'=>$rsList,
            'type'=>$type
        ));
    }
    /**
     * 报废单详情
     */
    public function actionShowScrapForm(){
        $scrapForm = ScrapForm::model()->findByPk($_GET['id']);
        $mList = ScrapFormMaterial::model()->findAll("formID=".$_GET['id']);
//        var_dump($scrapForm);
//        var_dump($mList);
//        exit();
        $type = $_GET['type']=="exam"?true:false;
        //渲染视图
        $this->setLayoutNone();
        $this->render("scrap_form_show",array(
            'exam'=>$type,
            'scrapForm'=>$scrapForm,
            'list'=>$mList
        ));
    }

    /**
     * 报废表审核
     */
    public function actionExamine(){
        $scrapForm = ScrapForm::model()->findByPk($_POST['formID']);
        if($_POST['type']=='back'){
            //退回
            $scrapForm->opinion = $_POST['back_opinion'];
            $scrapForm->state = '1';
            if(!$scrapForm->edit()){
                WMessage::ajaxInfo("退回操作失败", 0);
            }
        }elseif($_POST['type']=='ok'){
            //通过
            $scrapForm->opinion = $_POST['opinion'];
            $scrapForm->state = '2';
            if(!$scrapForm->edit()){
                WMessage::ajaxInfo("审核操作失败", 0);
            }
        }
        WMessage::ajaxInfo();
    }

    /**
     * 修改报废单
     */
    public function actionEditScrapForm(){
        if (Yii::app()->request->isAjaxRequest) {
            /**
             * 修改报废表
             * 1.原报废表基本数据进行修改
             * 2.报废表物资数据，原有的修改，没有的新增
             */
            $storeID = UserStore::getStoreByUserID()->storeID;
            if ($storeID == null) {
                WMessage::ajaxInfo("非法操作，请联系超级管理员绑定仓库", 0);
            }

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $scrapFormID = $_GET['formID'];
                //处理报废单基本信息
                $scrapForm = New ScrapForm();
                $scrapForm = $scrapForm->model()->findByPk($scrapFormID);
                $scrapForm->projectCode = $_POST['projectCode'];
                $scrapForm->projectName = $_POST['projectName'];
                $scrapForm->zID = $_POST['Major'];
                $scrapForm->state = '0';//0：提交；1:退回；2：通过
                if (!$scrapForm->edit()) {
                    throw new Exception($scrapForm->error->getErrorMessage(),0);
                }
                //处理物资信息
                $userID = User::getID();
                $cacheST = "STdata".$userID;
                $cache = Yii::app()->cache;
                $mtArr = $cache->get($cacheST);//获取缓存中数据
                if(count($mtArr)<1||!is_array($mtArr)){
                    throw new Exception("亲，您一个物资都没填",0);
                }
                //查出订单中所有物资，匹配物资编号，如果不存在缓存中，就删除
                $scrapMaterial = New ScrapFormMaterial();
                $scrapMaterials = $scrapMaterial->model()->findAll("formID={$scrapFormID}");
                foreach($scrapMaterials as $v){
                    $dbMaterial[] = "{$v['goodsCode']}";
                }
                foreach($mtArr as $k){
                    $scrapFormMaterial = New ScrapFormMaterial();
                    $material = $scrapFormMaterial->model()->find("formID={$scrapFormID} AND goodsCode='{$k['goodsCode']}'");
                    //如果物资存在，修改，不存在新增
                    if($material){
                        $material->formID = $scrapFormID;
                        $material->goodsName = $k['goodsName'];
                        $material->standard = $k['standard'];
                        $material->unit = $k['unit'];
                        $material->designNum = $k['designNum'];
                        $material->number = $k['number'];
                        $material->remark = $k['remark'];
                        if (!$material->edit()) {
                            throw new Exception($material->error->getErrorMessage(),0);
                        }
                    }else{
                        $scrapFormMaterial->formID = $scrapFormID;
                        $scrapFormMaterial->goodsCode = $k['goodsCode'];
                        $scrapFormMaterial->goodsName = $k['goodsName'];
                        $scrapFormMaterial->standard = $k['standard'];
                        $scrapFormMaterial->unit = $k['unit'];
                        $scrapFormMaterial->designNum = $k['designNum'];
                        $scrapFormMaterial->number = $k['number'];
                        $scrapFormMaterial->remark = $k['remark'];
                        if (!$scrapFormMaterial->add()) {
                            throw new Exception($scrapFormMaterial->error->getErrorMessage(),0);
                        }
                    }
                    $cacheMaterial[] = "{$k['goodsCode']}";
                }
                $cache->delete($cacheST);//成功后删除缓存
                $cache->delete("formID");
                //整理出数据库中有，缓存中没有的物资编号，然后删除
                $dbMaterial = array_diff($dbMaterial,$cacheMaterial);
                $goodsCode = implode("','", $dbMaterial);
                $scrapMaterial->model()->deleteAll("goodsCode IN('{$goodsCode}')");
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0, $e->getTrace());
            }
            WMessage::ajaxInfo();
        }
        $userID = User::getID();
        $cacheST = "STdata".$userID;
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheST);
        $cacheFormID = $cache->get("formID");
        //如果缓存中的表单ID为空或者不是接收到的ID
        if($cacheFormID){
            if($cacheFormID!=$_GET['formID']){
//                echo $cacheFormID."#".$_GET['formID'];
//                exit;
                $cache->delete($cacheST);//不同报废单时清理缓存
                $mtArr = $cache->get($cacheST);
                $cache->set("formID",$_GET['formID'],7200);//重设表单ID缓存
                $list = ScrapFormMaterial::model()->findAll('formID='.$_GET['formID']);//报废表物资
                foreach($list as $k){
                    $mt=array(
                        "goodsCode"=>$k->goodsCode,
                        "goodsName"=>$k->goodsName,
                        "standard"=>$k->standard,
                        "unit"=>$k->unit,
                        "designNum"=>$k->designNum,
                        "number"=>$k->number,
                        "remark"=>$k->remark
                    );
                    $mtArr[] = $mt;
                    $cache->set($cacheST,$mtArr,7200);//存入缓存
                }
            }
        }else{
            //没有缓存时
            $cache->set("formID",$_GET['formID'],7200);//将表单ID存入缓存
            $list = ScrapFormMaterial::model()->findAll('formID='.$_GET['formID']);//报废表物资
            foreach($list as $k){
                $mt=array(
                    "goodsCode"=>$k->goodsCode,
                    "goodsName"=>$k->goodsName,
                    "standard"=>$k->standard,
                    "unit"=>$k->unit,
                    "designNum"=>$k->designNum,
                    "number"=>$k->number,
                    "remark"=>$k->remark
                );
                $mtArr[] = $mt;
                $cache->set($cacheST,$mtArr,7200);//存入缓存
            }
        }
        $scrapForm = ScrapForm::model()->findByPk($_GET['formID']);
        //-------------------------------------------
        //渲染视图
        $this->setBread("修改报废审批表");
        $this->render("scrap_form",array(
            "userID"=>User::getID(),
            "edit"=>true,
            "scrapForm"=>$scrapForm,
            'list'=> $mtArr
        ));
    }

    public function actionTest(){
        $userID = User::getID();
        $cacheST = "STdata".$userID;
        $cache = Yii::app()->cache;
        //$cache->add('a','hello');
        //$cache->set('a','hello2');
        $cache->delete($cacheST);
        $cache->delete("formID");
//        $cache->flush('MTdate');
        $mtArr = $cache->get($cacheST);
        echo var_dump($mtArr);
    }
}