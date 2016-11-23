<?php

/**
 * 功能：领退料管理
 * 作者：陈天宇
 * 日期：2016-4-13
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class UseMaterialController extends Controller {

    /**
     * 控制器名称
     */
    public $controllerName = "领退料管理";

    /**
     * 填写领料单
     */
    public function actionReceiveMF(){
        if (Yii::app()->request->isAjaxRequest) {
            //先接收领料单基础信息，生成id
            //再插入领料单物资
            $session = new CHttpSession();
            $session->open();
            $data = $session->get("receive_material");
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
                //新增领料单记录
                $receiveForm = new ReceiveForm();
                $hz = sprintf("%03d", $receiveForm->countFormCode(date('Ymd'))+1);//3位后缀，不足用0补
                $receiveForm->formCode = date("Ymd").$hz;//单号格式【年月日】+【当月单数+1】
                $receiveForm->userID = Yii::app()->user->getId();
                $receiveForm->storeID = UserStore::getStoreByUserID()->storeID;
                $receiveForm->nature = $_POST['nature'];
                $receiveForm->glPro = $_POST['glPro'];
                $receiveForm->glProCode = $_POST['glProCode'];
//                $receiveForm->batchCode = $_POST['batchCode'];
                $receiveForm->remark = $_POST['remark'];
                $receiveForm->pic = $_POST['pic'];
                $receiveForm->state = "sh";//状态：sh:审核;zf:作废;tg:通过;
                $receiveForm->date = date("Y-m-d");//领料单生成日期
                $receiveForm->outTime = date("Y-m-d");//领料单生成日期
                $receiveForm->bz = $_POST['bz'];//班组
                if (!$receiveForm->add()) {
                    throw new Exception($receiveForm->error->getErrorMessage());
                }
                //得到最后插入数据的id
                $formID = Yii::app()->db->getLastInsertID();

                //保存领料单中的物资
                for ($i = 0; $i < count($data); $i++) {
                    $_rtm = unserialize($data[$i]);//依旧能拿到之前的对象
                    $_rtm->update();
                    //可申请数减去申请。当前库存要等领料单通过后才减
                    $_rtm->material->applyNum -= $_rtm->number;
                    if (!$_rtm->material->edit()) {
                        throw new Exception($_rtm->material->error->getErrorMessage());
                    }
                    //在领料单物资中添加该物资记录
                    $rfm = new ReceiveFormMaterial();
                    $rfm->formID = $formID;
                    $rfm->materialID = $_rtm->material->materialID;
                    $rfm->batchCode = $_rtm->material->batchCode;
                    $rfm->goodsCode = $_rtm->material->goodsCode;
                    $rfm->goodsName = $_rtm->material->goodsName;
                    $rfm->factory = $_rtm->material->factory;
                    $rfm->extendCode = $_rtm->material->extendCode;
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
            $session->remove("receive_material");
            WMessage::ajaxInfo();
        }
        $store = UserStore::getStoreByUserID();
        if (!$store) {
            WMessage::htmlWarn("您没有绑定仓库");
        }
        //班组
        $bz = Bz::model()->findAll();
        //渲染视图
        $this->render("ReceiveMF",array(
            "userID"=>User::getID(),
            "bz"=>$bz
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
        $this->setBread("填写领料单");
        $this->render("select_list",array(
            "rsList" => $rsList
        ));
    }
    /**
     * 将物资添加到领料单,通过session缓存
     */
    public function actionAddToReceiveForm() {
        $materialID = $_POST['materialID'];
        $number = $_POST['num'];//实退数量
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
        $data = $session->get("receive_material");
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
        $session->add("receive_material", $data);
        WMessage::ajaxInfo();
    }
    /**
     * 已经添加进领料单的物资列表
     */
    public function actionSelectedList() {
        if($_GET['type']=='edit'){
            //编辑状态时，数据从数据库取
            $data = ScrapFormMaterial::model()->findAll('formID='.$_GET['formID']);
            var_dump($data);
            exit;
        }else{
            //Session
            $session = new CHttpSession();
            $session->open();
            $data = $session->get("receive_material");
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("selected_list", array(
            "rsList" => $data
        ));
    }
    /**
     * 从领料单中移除
     */
    public function actionRemoveToReceiveForm() {
        $materialID = $_POST['materialID'];
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("receive_material");
        if ($data != null) {
            for ($i = 0; $i < count($data); $i++) {
                $_rtm = unserialize($data[$i]);
                if ($_rtm->materialID == $materialID) {
                    array_splice($data, $i, 1);
                    $session->add("receive_material", $data);
                    WMessage::ajaxInfo();
                }
            }
        }
        WMessage::ajaxInfo("没有数据", 0);
    }

    /**
     * 领料单列表
     */
    public function actionReceiveMFList(){
        //查询参数
        $condition[] = "1=1";
        if($_GET['type']=='my'){
            $userID = Yii::app()->user->getId();
            $condition[] = "AND userID="."{$userID}";
            $qz = "我提交的";
        }elseif($_GET['type']=='unt'){
            $condition[] = "AND state='sh'";
            $qz = "待处理的";
        }elseif($_GET['type']=='yjt'){
            $condition[] = "AND state<>'sh'";
            $qz = "已处理的";
        }

        $condition[] = $_GET['formCode'] == "" ? "" : "AND INSTR(formCode,'{$_GET['formCode']}')>0";
        $condition[] = $_GET['glProCode'] == "" ? "" : "AND INSTR(glProCode,'{$_GET['glProCode']}')>0";
        $condition[] = $_GET['glPro'] == "" ? "" : "AND INSTR(glPro,'{$_GET['glPro']}')>0";
        $condition[] = $_GET['nature'] == "" ? "" : "AND nature='{$_GET['nature']}'";
        $condition[] = $_GET['bz'] == "" ? "" : "AND INSTR(bz,'{$_GET['bz']}')>0";
        $condition[] = $_GET['batchCode'] == "" ? "" : "AND INSTR(batchCode,'{$_GET['batchCode']}')>0";

        //模型实例化
        $receiveForm = New ReceiveForm();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id desc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $receiveForm->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread($qz."领料单");
        $this->render("receive_form_list",array(
            'rsList'=>$rsList,
            'type'=>$qz
        ));
    }
    /**
     * 领料单详情
     */
    public function actionShowReceiveForm(){
        $receiveForm = ReceiveForm::model()->findByPk($_GET['id']);
        $mList = ReceiveFormMaterial::model()->findAll("formID=".$_GET['id']);
//        var_dump($receiveForm);
//        var_dump($mList);
//        exit();
        $type = $_GET['type']=="exam"?true:false;
        //渲染视图
        $this->setLayoutNone();
        $this->render("receive_form_show",array(
            'exam'=>$type,
            'receiveForm'=>$receiveForm,
            'list'=>$mList
        ));
    }
    /**
     * 查看领料单照片
     */
    public function actionShowReceivePhoto() {
        //如果是添加照片
        if (Yii::app()->request->isPostRequest) {
            if ($_FILES['pic']['name'] == "") {
                exit("请选择照片后提交");
            }
            $id = $_POST['id'];
            $rs = ReceiveForm::model()->findByPk($id);
            $path = "upload/receive_pic/";
            if (!file_exists($path)) {
                mkdir($path);
            }
            if ($_FILES['pic']['name'] != "") {
                $upload = new WUpload($_FILES['pic']);
                $upload->init();
                $upload->setSavePath($path);
                $upload->setFileName($rs->formCode);
                try {
                    $upload->save();
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
                $rs['pic'] = $upload->getFileSaveFullName();
            }
            if ($rs->edit()) {
                echo "操作成功";
            } else {
                echo "保存失败";
            }
        }
        //如果是查看
        if (Yii::app()->request->requestType == "GET") {
            $id = $_GET['id'];
            $rs = ReceiveForm::model()->findByPk($id);
            $this->setLayoutNone();
            $this->render("edit_photo", array(
                "rs" => $rs
            ));
        }
    }
    /**
     * 领料单审核
     */
    public function actionExamine(){
        $receiveForm = ReceiveForm::model()->findByPk($_POST['formID']);
        if($_POST['type']=='no'){
            //作废
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $receiveForm->opinion = $_POST['opinion'];
                $receiveForm->state = 'zf';
                if(!$receiveForm->edit()){
                    throw new Exception($receiveForm->error->getErrorMessage());
                }
                $materials = ReceiveFormMaterial::model()->findAll("formID='{$_POST['formID']}'");
                foreach($materials as $k){
                    $m = Material::model()->find("materialID='{$k->materialID}'");
                    $m->applyNum += $k->number;//作废应该将可领用数量加回去。
                    if(!$m->edit()){
                        throw new Exception($m->error->getErrorMessage());
                    }
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
                $receiveForm->state = 'tg';
                if(!$receiveForm->edit()){
                    throw new Exception($receiveForm->error->getErrorMessage());
                }
                //物资表中的物资库存数，减去领料单中的该物资领用数
                $materials = ReceiveFormMaterial::model()->findAll("formID='{$_POST['formID']}'");
                foreach($materials as $k){
                    $m = Material::model()->find("materialID='{$k->materialID}'");
                    $m->currCount -= $k->sfnumber;
                    if(!$m->edit()){
                        throw new Exception($m->error->getErrorMessage());
                    }
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
     * 审核领料单时修改领料数量
     */
    public function actionEditExamine(){
        $material = ReceiveFormMaterial::model()->find("formID='{$_POST['formID']}' AND materialID='{$_POST['materialID']}'");
        $m = Material::model()->find("materialID='{$_POST['materialID']}'");
        $applyNum = $m->applyNum + $material->sfnumber;//可申请数，应该是物资表中可申请数+已经申请还未通过的数量
        if(!$material){
            WMessage::ajaxInfo("未找到该物资", 0);
        }
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if($_POST['number']>$material->number){
                throw new Exception("实发数不能超过请领数");
            }
            if($_POST['number']<=0){
                throw new Exception("实发数不能小于或等于零");
            }
            $material->sfnumber = $_POST['number'];
            $material->applyNum = $_POST['number'];
            if(!$material->edit()){
                throw new Exception($material->error->getErrorMessage());
            }
            //修改好领料单物资领用数量后，还要修改物资的可申请数
            $m->applyNum = $applyNum - $_POST['number'];//可申请数，等于原可申请数-现申请数
            if(!$m->edit()){
                throw new Exception($m->error->getErrorMessage());
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        WMessage::ajaxInfo("修改成功");
    }
    /**
     * 审核领料单时编辑物资备注
     */
    public function actionEditRemark(){
        $material = ReceiveFormMaterial::model()->find("formID='{$_POST['formID']}' AND materialID='{$_POST['materialID']}'");
        if(!$material){
            WMessage::ajaxInfo("未找到该物资", 0);
        }
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $material->remark = $_POST['remark'];
            if(!$material->edit()){
                throw new Exception($material->error->getErrorMessage());
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        WMessage::ajaxInfo();
    }
    /**
     * 审核领料单时删除某物资
     */
    public function actionDelExamine(){
//        WMessage::ajaxInfo("asdf",0);
        $material = ReceiveFormMaterial::model()->find("formID='{$_POST['formID']}' AND materialID='{$_POST['materialID']}'");
        if(!$material){
            WMessage::ajaxInfo("未找到该物资", 0);
        }
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if(!$material->delete()){
                throw new Exception($material->error->getErrorMessage());
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        WMessage::ajaxInfo();
    }
/****************************************************** 退料 *********************************************************/

    /**
     * 填写退料单
     */
    public function actionReturnMF(){
//        $session = new CHttpSession();
//        $session->open();
//        $session->remove("return_material");
        if (Yii::app()->request->isAjaxRequest) {
            //先接收退料单基础信息，生成id
            //再插入退料单物资
            $session = new CHttpSession();
            $session->open();
            $data = $session->get("return_material");
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
                //新增退料单记录
                $returnForm = new ReturnForm();
                $hz = sprintf("%03d", $returnForm->countFormCode(date('Ymd'))+1);//3位后缀，不足用0补
                $returnForm->formCode = date("Ymd").$hz;//单号格式【年月日】+【当月单数+1】
                $returnForm->userID = Yii::app()->user->getId();
                $returnForm->storeID = UserStore::getStoreByUserID()->storeID;
                $returnForm->nature = $_POST['nature'];
                $returnForm->glPro = $_POST['glPro'];
                $returnForm->glProCode = $_POST['glProCode'];
                //退料单批次号自动生成
                $qz = 'TL'.date('ym');
                $pc = sprintf("%05d",$returnForm->countBatchCode($qz)+1);//5位后缀，不足用0补，注意这边统计当月
                $returnForm->batchCode = $qz.$pc;//批次号格式【前缀】+【批次+1】
                $returnForm->remark = $_POST['remark'];
                $returnForm->date = date('Y-m-d');
                $returnForm->state = "sh";//状态：sh:审核;zf:作废;tg:通过;
                if (!$returnForm->add()) {
                    throw new Exception($returnForm->error->getErrorMessage());
                }
                //得到最后插入数据的id
                $formID = Yii::app()->db->getLastInsertID();

                //保存退料单中的物资
                for ($i = 0; $i < count($data); $i++) {
                    $_rtm = unserialize($data[$i]);//依旧能拿到之前的对象
                    $_rtm->update();
                    //可申请数减去申请。当前库存要等退料单通过后才减
//                    $_rtm->material->applyNum += $_rtm->number;
//                    $_rtm->material->currCount += $_rtm->number;
//                    if (!$_rtm->material->edit()) {
//                        throw new Exception($_rtm->material->error->getErrorMessage());
//                    }
//                    var_dump($_rtm->formID);
//                    echo "asdf";
//                    var_dump($_rtm->materialID);
//                    exit;
                    //领料单中可退数量-申请数
                    $lfm = ReceiveFormMaterial::model()->findBySql("SELECT rfm.* FROM mod_receive_form_material rfm,mod_receive_form rf
WHERE rf.id = rfm.formID AND rf.formCode='{$_rtm->formCode}' AND rfm.materialID='{$_rtm->materialID}'");
//                    var_dump($lfm);
//                    exit();
                    $lfm->applyNum -= $_rtm->number;
                    if (!$lfm->edit()) {
                        throw new Exception($lfm->error->getErrorMessage());
                    }
                    //在退料单物资中添加该物资记录
                    $rfm = new ReturnFormMaterial();
                    $rfm->formID = $formID;
                    $rfm->batchCode = $_rtm->material->batchCode;
                    $rfm->materialID = $_rtm->material->materialID;
                    $rfm->goodsCode = $_rtm->material->goodsCode;
                    $rfm->goodsName = $_rtm->material->goodsName;
                    $rfm->factory = $_rtm->material->factory;
                    $rfm->extendCode = $_rtm->material->extendCode;
                    $rfm->number = $_rtm->number;//实退数量
                    $rfm->unit = $_rtm->material->unit;
                    $rfm->price = $_rtm->material->price;
                    $rfm->receiveFormCode = $_rtm->formCode;//关联领料单
                    if (!$rfm->add()) {
                        throw new Exception($rfm->error->getErrorMessage());
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0);
            }
            $session->remove("return_material");
            WMessage::ajaxInfo();
        }
        $store = UserStore::getStoreByUserID();
        if (!$store) {
            WMessage::htmlWarn("您没有绑定仓库");
        }
        //渲染视图
        $this->render("ReturnMF",array(
            "userID"=>User::getID()
        ));
    }
    /**
     * 退料单可选的物资列表(从这里选择)
     */
    public function actionSelectList2(){
        //查询参数
        $condition[] = $_GET['batchCode'] == "" ? "" : " AND INSTR(fm.batchCode,'{$_GET['batchCode']}')>0";
        $condition[] = $_GET['goodsName'] == "" ? "" : " AND INSTR(fm.goodsName,'{$_GET['goodsName']}')>0";
        $condition[] = $_GET['goodsCode'] == "" ? "" : " AND INSTR(fm.goodsCode,'{$_GET['goodsCode']}')>0";
        $condition[] = $_GET['glPro'] == "" ? "" : " AND INSTR(f.glPro,'{$_GET['glPro']}')>0";

        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 10;
        //查找数据
        $sql = "SELECT distinct fm.*,f.state,f.formCode FROM mod_receive_form_material fm,mod_receive_form f ";
        $sqlWhere = " WHERE fm.applyNum<>0 AND f.state='tg' AND fm.formID = f.id " . $criteria->condition;
        $sqlMerge = $sql . $sqlWhere;
        $command = Yii::app()->db->createCommand($sqlMerge);
        $rsList = ActiveRecord::getRecordByCMD($command, $this->pagination, $criteria);
//        var_dump($rsList);
//        exit();
        //返回所有物资数据
        $this->setLayoutNone();
        $this->setBread("填写退料单");
        $this->render("select_list2",array(
            "rsList" => $rsList
        ));
    }
    /**
     * 将物资添加到退料单,通过session缓存
     */
    public function actionAddToReturnForm() {
        $materialID = $_POST['materialID'];
        $number = $_POST['num'];//实退数量
//        WMessage::ajaxInfo($number, 0);
        $formCode = $_POST['formCode'];
        if (!is_numeric($materialID)) {
            WMessage::ajaxInfo("非法的物资", 0);
        }
        if ($number<=0) {
            WMessage::ajaxInfo("请选择至少选择一个物资", 0);
        }
        $rtm = new WTempUseMaterial($materialID,$number,$formCode);
        //检查
        try {
            $rtm->validate2();
        } catch (Exception $e) {
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        //Session
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("return_material");
        //检查重复
        if ($data != null) {
            for ($i = 0; $i < count($data); $i++) {
                $_rtm = unserialize($data[$i]);
                if ($_rtm->materialID == $rtm->materialID&&$_rtm->formCode == $rtm->formCode) {
                    WMessage::ajaxInfo("已经存在，请先删除后在操作", 0);
                }
            }
        } else {
            $data = array();
        }
        array_push($data, serialize($rtm));
        $session->add("return_material", $data);
        WMessage::ajaxInfo();
    }
    /**
     * 已经添加进退料单的物资列表
     */
    public function actionSelectedList2() {
        if($_GET['type']=='edit'){
            //编辑状态时，数据从数据库取
            $data = ReturnFormMaterial::model()->findAll('formID='.$_GET['formID']);
            var_dump($data);
            exit;
        }else{
            //Session
            $session = new CHttpSession();
            $session->open();
            $data = $session->get("return_material");
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("selected_list2", array(
            "rsList" => $data
        ));
    }
    /**
     * 从退料单中移除
     */
    public function actionRemoveToReturnForm() {
        $materialID = $_POST['materialID'];
        $formCode = $_POST['formCode'];
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("return_material");
        if ($data != null) {
            for ($i = 0; $i < count($data); $i++) {
                $_rtm = unserialize($data[$i]);
                if ($_rtm->materialID == $materialID && $_rtm->formCode == $formCode) {
                    array_splice($data, $i, 1);
                    $session->add("return_material", $data);
                    WMessage::ajaxInfo();
                }
            }
        }
        WMessage::ajaxInfo("没有数据1", 0);
    }

    /**
     * 退料单列表
     */
    public function actionReturnMFList(){
        //查询参数
        $condition[] = "1=1";
        if($_GET['type']=='my'){
            $userID = Yii::app()->user->getId();
            $condition[] = "AND userID="."{$userID}";
            $qz = "我提交的";
        }elseif($_GET['type']=='unt'){
            $condition[] = "AND state='sh'";
            $qz = "待处理的";
        }elseif($_GET['type']=='yjt'){
            $condition[] = "AND state<>'sh'";
            $qz = "已处理的";
        }

        $condition[] = $_GET['formCode'] == "" ? "" : "AND INSTR(formCode,'{$_GET['formCode']}')>0";
        $condition[] = $_GET['glProCode'] == "" ? "" : "AND INSTR(glProCode,'{$_GET['glProCode']}')>0";
        $condition[] = $_GET['glPro'] == "" ? "" : "AND INSTR(glPro,'{$_GET['glPro']}')>0";
        $condition[] = $_GET['batchCode'] == "" ? "" : "AND INSTR(batchCode,'{$_GET['batchCode']}')>0";
        $condition[] = $_GET['nature'] == "" ? "" : "AND nature='{$_GET['nature']}'";

        //模型实例化
        $returnForm = New ReturnForm();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id desc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $returnForm->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread($qz."退料单");
        $this->render("return_form_list",array(
            'rsList'=>$rsList,
            'type'=>$qz
        ));
    }

    /**
     * 退料单详情
     */
    public function actionShowReturnForm(){
        $returnForm = ReturnForm::model()->findByPk($_GET['id']);
        $mList = ReturnFormMaterial::model()->findAll("formID=".$_GET['id']);
//        var_dump($returnForm);
//        var_dump($mList);
//        exit();
        $type = $_GET['type']=="exam"?true:false;
        //渲染视图
        $this->setLayoutNone();
        $this->render("return_form_show",array(
            'exam'=>$type,
            'returnForm'=>$returnForm,
            'list'=>$mList
        ));
    }
    /**
     * 查看退料单照片
     */
    public function actionShowReturnPhoto() {
        //如果是添加照片
        if (Yii::app()->request->isPostRequest) {
            if ($_FILES['pic']['name'] == "") {
                exit("请选择照片后提交");
            }
            $id = $_POST['id'];
            $rs = ReturnForm::model()->findByPk($id);
            $path = "upload/return_pic/";
            if (!file_exists($path)) {
                mkdir($path);
            }
            if ($_FILES['pic']['name'] != "") {
                $upload = new WUpload($_FILES['pic']);
                $upload->init();
                $upload->setSavePath($path);
                $upload->setFileName($rs->formCode);
                try {
                    $upload->save();
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
                $rs['pic'] = $upload->getFileSaveFullName();
            }
            if ($rs->edit()) {
                echo "操作成功";
            } else {
                echo "保存失败";
            }
        }
        //如果是查看
        if (Yii::app()->request->requestType == "GET") {
            $id = $_GET['id'];
            $rs = ReturnForm::model()->findByPk($id);
            $this->setLayoutNone();
            $this->render("edit_photo", array(
                "rs" => $rs
            ));
        }
    }
    /**
     * 退料单审核
     */
    public function actionExamineReturn(){
//        $materials = ReturnFormMaterial::model()->findAll("formID='{$_GET['formID']}'");
//        foreach($materials as $k){
//            $m = Material::model()->find("goodsCode='{$k->goodsCode}'");
//            $m->currCount += $k->number;
//            $m->applyNum += $k->number;
//            var_dump($m);
//        }
//        var_dump($materials);
//        exit();
        $returnForm = ReturnForm::model()->findByPk($_POST['formID']);
        if($_POST['type']=='no'){
            //作废
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $returnForm->opinion = $_POST['opinion'];
                $returnForm->state = 'zf';
                if(!$returnForm->edit()){
                    throw new Exception($returnForm->error->getErrorMessage());
                }
                //领用物资表中的物资库存数，减去退料单中的该物资领用数
                $materials = ReturnFormMaterial::model()->findAll("formID='{$_POST['formID']}'");
                foreach($materials as $k){
                    $formID = ReceiveForm::model()->find("formCode='{$k->receiveFormCode}'")->id;
                    $m = ReceiveFormMaterial::model()->find("formID='{$formID}' AND goodsCode='{$k->goodsCode}' AND batchCode='{$k->batchCode}'");
                    $m->applyNum += $k->number;
                    if(!$m->edit()){
                        throw new Exception($m->error->getErrorMessage());
                    }
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
                $returnForm->state = 'tg';
                if(!$returnForm->edit()){
                    throw new Exception($returnForm->error->getErrorMessage());
                }
                //物资表中的物资库存数，退料单中的物资库存和可申请数都加上领用数
                $materials = ReturnFormMaterial::model()->findAll("formID='{$_POST['formID']}'");
                foreach($materials as $k){
                    $m = Material::model()->find("materialID='{$k->materialID}'");
                    $m->currCount += $k->number;
                    $m->applyNum += $k->number;
                    if(!$m->edit()){
                        throw new Exception($m->error->getErrorMessage());
                    }
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
     * 领/退料单物资记录
     */
    public function actionUseMaterialList(){
//        var_dump($_GET['type']);
//        exit;
        //查询参数
        $condition[] = $_GET['nature'] == "" ? "" : " AND f.nature='{$_GET['nature']}'";
        $condition[] = $_GET['glPro'] == "" ? "" : " AND INSTR(f.glPro,'{$_GET['glPro']}')>0";
        $condition[] = $_GET['formCode'] == "" ? "" : " AND INSTR(f.formCode,'{$_GET['formCode']}')>0";
        $condition[] = $_GET['batchCode'] == "" ? "" : " AND INSTR(f.batchCode,'{$_GET['batchCode']}')>0";
        $condition[] = $_GET['goodsName'] == "" ? "" : " AND INSTR(fm.goodsName,'{$_GET['goodsName']}')>0";
        $condition[] = $_GET['goodsCode'] == "" ? "" : " AND INSTR(fm.goodsCode,'{$_GET['goodsCode']}')>0";
        $condition[] = $_GET['storeID'] == "" ? "" : " AND m.storeID='{$_GET['storeID']}'";

        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $sql = "SELECT distinct m.storeID,m.currCount,f.formCode,f.nature,f.state,f.batchCode as fbatchCode,f.glPro,f.glProCode,fm.* ";
        if($_GET['type']=='receive'){
            $sql .= "FROM mod_receive_form_material fm,mod_receive_form f,mod_material m ";
            $type = "领料";
        }else if($_GET['type']=='return'){
            $sql .= "FROM mod_return_form_material fm,mod_return_form f,mod_material m ";
            $type = "退料";
        }
        $sqlWhere = " WHERE fm.formID = f.id AND m.materialID=fm.materialID" . $criteria->condition;
        $sqlMerge = $sql . $sqlWhere ." ORDER BY f.formCode desc";
//        echo $sqlMerge;
//        exit();
        $command = Yii::app()->db->createCommand($sqlMerge);
        $rsList = ActiveRecord::getRecordByCMD($command, $this->pagination, $criteria);
//        var_dump($rsList);
//        exit();
        //返回所有物资数据
        $this->setBread($type."单物资记录");
        $this->render("use_material_list",array(
            "rsList" => $rsList
        ));
    }



    /**
     * 上传附件
     */
    public function actionUploadFile(){
        //如果是添加照片
        if (Yii::app()->request->isPostRequest) {

            if ($_FILES['file']['name'] == "") {
                exit("请选择上传的附件");
            }
            $formID = $_POST['formID'];
            if($_POST['type']=='receive'){
                $rs = ReceiveForm::model()->findByPk($formID);
            }else{
                $rs = ReturnForm::model()->findByPk($formID);
            }
            $save_path = $_POST['type']=='receive'?'receive_pic/':'return_pic/';
            $path = "upload/".$save_path;
            if (!file_exists($path)) {
                mkdir($path);
            }
            if ($_FILES['file']['name'] != "") {

                $upload = new WUpload($_FILES['file']);
                $upload->init();
                $upload->setSavePath($path);
                //将字串分割成数组
                $fileArr = explode(',',$rs['pic']);
                $maxNum = 0;
                if(count($fileArr)>1){
                    foreach($fileArr as $fileSrc){
                        //获取路径最后的编号
                        $num = substr(strrchr($fileSrc,'_'),1);//截取到123.jpg
                        //先反序字符串，gpj.321，后截取从点到最后的字串，再去掉点，最后反序就是正确的数字了
                        $num = strrev(substr(strrchr(strrev($num),'.'),1));
                        //判断该移库单所有附件中最大的编号
                        $maxNum = $maxNum < $num ? $num : $maxNum;
                    }
                }

                //产生自增编号
                $maxNum++;
                //保存文件名，格式：表单ID+下划线+自增编号
                $upload->setFileName($formID.'_'.$maxNum);
                try {
                    $upload->save();
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }

                //将文件存放路径添加到数组
                array_push($fileArr,$upload->getFileSaveFullName());
                $rs['pic'] = implode(',',$fileArr);
            }
            if (!$rs->edit()) {
                WMessage::ajaxInfo("保存失败", 0);
            }
        }
        if($_GET['formID']) {
            $formID = $_GET['formID'];
        }else if($_POST['formID']){
            $formID = $_POST['formID'];
        }else{
            WMessage::ajaxInfo("请求失败", 0);
        }
        $type = $_GET['type']==""?$_POST['type']:$_GET['type'];
        if($type=='receive'){
            $form = ReceiveForm::model()->findByPk($formID);
        }else{
            $form = ReturnForm::model()->findByPk($formID);
        }

        $fileArr = explode(',',$form->pic);

        //渲染视图
        $this->setLayoutNone();
        $this->render("upload_file",array(
            'fileArr'=>$fileArr,
            'formID'=>$formID,
            'type'=>$type
        ));
    }

    //查看图片附件
    public function actionShowPic(){
        $src = $_GET['src'];
//        $ext = strrchr($src,'.');
//        if($ext=='.xls'){
//            $view = "show_file";
//        }else{
//            $view = "show_pic";
//        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("show_pic",array(
            'src'=>$src
        ));
    }

    //删除附件
    public function actionDelFile(){
        $path = $_GET['type']=='receive'?'receive_pic/':'return_pic/';
        $name = $_GET['name'];
        $formID = $_GET['formID'];
        if($_GET['type']=='receive'){
            $form = ReceiveForm::model()->findByPk($formID);
        }else{
            $form = ReturnForm::model()->findByPk($formID);
        }
        $fileArr = explode(',',$form->pic);
        foreach($fileArr as $file){
            $num = $_GET['type']=="receive"?12:11;
            $fileName = substr(strchr($file,$path),$num);
            if($fileName == $name){
                if(unlink($file)){
                    $fileArr = array_diff($fileArr,array($file));
                    $form->pic = implode(',',$fileArr);
                    try {
                        $form->save();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        exit();
                    }
                    break;
                }else{
                    echo "删除失败";
                    exit();
                }
            }
        }
        $this->setLayoutNone();
        $this->render("upload_file",array(
            'fileArr'=>$fileArr,
            'formID'=>$formID,
            'type'=>$_GET['type']
        ));
    }
}