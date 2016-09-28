<?php

/**
 * 功能：物资
 * 作者：陈天宇
 * 日期：2016-3-25
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class MaterialController extends Controller {

    /**
     * 控制器名称
     */
    public $controllerName = "物资管理";

    /**
     * 测试缓存
     */
    public function actionTest(){
        $userID = User::getID();
        $cacheMT = "MTdata".$userID;
        $cache = Yii::app()->cache;
        //$cache->add('a','hello');
        //$cache->set('a','hello2');
        //$cache->delete('MTdate');
//        $cache->flush('MTdate');
        $mtArr = $cache->get($cacheMT);
        echo var_dump($mtArr);
    }
    /**
     * 物资列表
     */
    public function actionList(){
        $storeID = UserStore::getStoreByUserID()->storeID;
        //如果是材料管理员身份。可以看到工区所有下属仓库的物资
        if($_GET['storeID']){
            //如果接收到搜索条件
            $condition[] = $_GET['storeID'] == "" ? "" : "storeID='{$_GET['storeID']}'";
        }else{
            if (Auth::has(AI::R_Materialer)){
                $res = Store::model()->findAll("parentID IN ({$storeID})");
                foreach($res as $k){
                    $arr[] = $k->storeID;
                }
                if(count($arr)>0){
                    $str = implode(",", $arr);
                    $condition[] = "storeID IN ({$str},{$storeID})";
                }else{
                    $condition[] = "storeID IN ({$storeID})";
                }
            }else{
                $condition[] = "storeID IN ({$storeID})";
            }
        }
        $condition[] = "AND del='0'";
        $condition[] = $_GET['batchCode'] == "" ? "" : "AND INSTR(batchCode,'{$_GET['batchCode']}')>0";
        $condition[] = $_GET['goodsCode'] == "" ? "" : "AND INSTR(goodsCode,'{$_GET['goodsCode']}')>0";
        $condition[] = $_GET['goodsName'] == "" ? "" : "AND INSTR(goodsName,'{$_GET['goodsName']}')>0";
        $condition[] = $_GET['factory'] == "" ? "" : "AND INSTR(factory,'{$_GET['factory']}')>0";
        //模型实例化
        $material = new Material();
        //条件
        $criteria = new CDbCriteria();
        //$criteria->order = "CONVERT(LEFT(goodsName,1) USING gbk)  asc";//中文排序
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "materialID asc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        //$rsList = $material->findAll("del='0' AND storeID='9'");//问题：category取不到值，明天用原生sql查询
        $rsList = $material->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread("物资列表");
        $this->render("material_list",array(
            'rsList'=>$rsList
        ));
    }
    /**
     * 修改物资列表中的物资信息
     */
    public function actionEdit(){

        if (Yii::app()->request->isAjaxRequest) {
            //验证数据格式
            if(empty($_POST['currCount'])){
                WMessage::ajaxInfo('入库数量不能为空',0);
            }
            if(!is_numeric($_POST['currCount'])){
                WMessage::ajaxInfo('入库数量格式不正确',0);
            }
            if($_POST['minCount']&&!is_numeric($_POST['minCount'])){
                WMessage::ajaxInfo('最低库存格式不正确',0);
            }
            if($_POST['price']&&!is_numeric($_POST['price'])){
                WMessage::ajaxInfo('单价格式不正确',0);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $obj = New Material();
                $material = $obj->model()->findByPk($_POST['materialID']);
                $material->extendCode = $_POST['extendCode'];
                $material->goodsName = $_POST['goodsName'];
                $material->standard = $_POST['standard'];
                $material->validityDate = $_POST['validityDate']==""?null:$_POST['validityDate'];
                $material->currCount = $_POST['currCount'];
                $material->minCount = $_POST['minCount'];
                $material->price = $_POST['price'];
                $material->unit = $_POST['unit'];
                $material->remark = $_POST['remark'];
                if (!$material->edit()) {
                    throw new Exception($material->error->getErrorMessage(),0);
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo('操作失败', 0, $e->getTrace());
            }
            WMessage::ajaxInfo();
        }
        //接收到物资ID后
        $data = Material::model()->findByPk($_GET['goodsCode']);
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_form",array(
            'data'=>$data,
            'Edit'=>true
        ));
    }
    /**
     * 填写入库单
     */
    public function actionInForm(){
        /**
         * 思路：
         * 如果是post请求，将数据验证后插入数据库，并清空缓存
         * 先插入入库单基本信息，生成入库单id后插入物资
         */
        if (Yii::app()->request->isAjaxRequest) {

            $inForm = New InForm();
//            $materialIn = New MaterialIn();
//            $material = New Material();
            if(empty($_POST['date'])){
                WMessage::ajaxInfo('入库日期不能为空',0);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //处理入库单基本信息
                $inForm->attributes = $_POST;
                //先统计出当日该仓库，入库单数量
                $hz = sprintf("%03d", $inForm->countFormCode(date('Ymd'))+1);//3位后缀，不足用0补
                $inForm->informCode = date('Ymd').$hz;//单号格式【年月日】+【当月单数+1】
//                $inForm->date = date('Y-m-d');
                //无批次号，自动生成
                if (!$inForm->add()) {
                    throw new Exception($inForm->error->getErrorMessage(),0);
                }
//                $informID = Yii::app()->db->getLastInsertID();//得到最后插入数据的id
                //处理物资信息
                $userID = User::getID();
                $cacheMT = "MTdata".$userID;
                $cache = Yii::app()->cache;
                $mtArr = $cache->get($cacheMT);//获取缓存中数据
                if(count($mtArr)<1||!is_array($mtArr)){
                    throw new Exception("亲，您一个物资都没填",0);
                }
                foreach($mtArr as $k){
                    $material = New Material();
                    //存入物资数据
                    $mobj = $material->findByAttributes(
                        array('goodsCode' => $k['goodsCode'], 'storeID' => $k['storeID'],'batchCode' => $k['batchCode'],'factory' => $k['factory'])
                    );
                    //如果该物资编号已经存在
                    if ($mobj) {
                        $mobj->currCount += $k['currCount'];//更新该物资的库存
                        $mobj->applyNum += $k['currCount'];//更新该物资的可申请数
                        if (!$mobj->edit()) {
                            throw new Exception($mobj->error->getErrorMessage(),0);
                        }
                        $materialID = $mobj->materialID;
//                        throw new Exception("<strong>".$k['goodsName']."</strong>"."的【批次号】已存在",0);
                    }else{
                        $material = New Material();
                        $batchCode = $k['batchCode'];
                        if($batchCode==null){
                            $qz = 'WZ'.date('ym').'RK';
                            $pc = sprintf("%05d",$material->countBatchCode($qz)+1);//5位后缀，不足用0补，注意这边统计当月
                            $batchCode = $qz.$pc;//批次号格式【前缀】+【批次+1】
                        }
                        $material->storeID = $k['storeID'];
                        $material->batchCode = $batchCode;
                        $material->goodsCode = $k['goodsCode'];
                        $material->extendCode = $k['extendCode'];
                        $material->goodsName = $k['goodsName'];
                        $material->workCode = $k['workCode'];
                        $material->erpLL = $k['erpLL'];
                        $material->erpCK = $k['erpCK'];
                        $material->factory = $k['factory'];
                        $material->factory_contact = $k['factory_contact'];
                        $material->factory_tel = $k['factory_tel'];
                        $material->standard = $k['standard'];
                        $material->unit = $k['unit'];
                        $material->price = $k['price'];
                        $material->validityDate = $k['validityDate']==""?null:$k['validityDate'];
                        $material->remark = $k['remark'];
                        $material->minCount = $k['minCount'];
                        $material->currCount = $k['currCount'];
                        $material->applyNum = $k['currCount'];
                        if (!$material->add()) {
                            throw new Exception($material->error->getErrorMessage(),0);
                        }
                        $materialID = Yii::app()->db->getLastInsertID();//得到最后插入数据的id
                    }
                    //存入物资入库记录，不再验证，只是将本次入库的数据做个备份，方便后期入库单详情时查询
                    $materialIn = New MaterialIn();
                    $materialIn->materialID = $materialID;
                    $materialIn->storeID = $k['storeID'];
                    $materialIn->batchCode = $batchCode;
                    $materialIn->goodsCode = $k['goodsCode'];
                    $materialIn->extendCode = $k['extendCode'];
                    $materialIn->goodsName = $k['goodsName'];
                    $materialIn->workCode = $k['workCode'];
                    $materialIn->erpLL = $k['erpLL'];
                    $materialIn->erpCK = $k['erpCK'];
                    $materialIn->factory = $k['factory'];
                    $materialIn->factory_contact = $k['factory_contact'];
                    $materialIn->factory_tel = $k['factory_tel'];
                    $materialIn->standard = $k['standard'];
                    $materialIn->unit = $k['unit'];
                    $materialIn->price = $k['price'];
                    $materialIn->validityDate = $k['validityDate']==""?null:$k['validityDate'];
                    $materialIn->remark = $k['remark'];
                    $materialIn->minCount = $k['minCount'];
                    $materialIn->currCount = $k['currCount'];
                    $materialIn->informID = $inForm->informCode;//关联入库单号
                    if (!$materialIn->add()) {
                        throw new Exception($materialIn->error->getErrorMessage(),0);
                    }
                }
                $transaction->commit();
                $cache->delete($cacheMT);//入库成功后删除缓存
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0, $e->getTrace());
            }
            WMessage::ajaxInfo();
        }
        //返回缓存中的数据
        $userID = User::getID();
        $cacheMT = "MTdata".$userID;
        $cache = Yii::app()->cache;
        $list = $cache->get($cacheMT);
        //渲染视图
        $this->setBread("填写入库单");
        $this->render("in_form",array(
            'list'=> $list
        ));
    }
    /**
     * 物资添加表单
     */
    public function actionAddForm(){
        if (Yii::app()->request->isAjaxRequest) {
            $userID = User::getID();
            $cacheMT = "MTdata".$userID;
            $cache = Yii::app()->cache;
            $mtArr = $cache->get($cacheMT);

            //验证数据格式
            if(empty($_POST['storeID'])){
                WMessage::ajaxInfo('仓库不能为空',0);
            }
            if(empty($_POST['goodsCode'])){
                WMessage::ajaxInfo('物资编码不能为空',0);
            }
            //新增物资时判断入库单中是否存在相同物资编号
//            if(empty($_POST['oldgCode'])) {
//                foreach ($mtArr as $k) {
//                    if (array_search($_POST['goodsCode'], $k)) {
//                        WMessage::ajaxInfo('入库单中已经存在相同物资编码', 0);
//                    }
//                }
//            }
            if(empty($_POST['currCount'])){
                WMessage::ajaxInfo('入库数量不能为空',0);
            }
            if(empty($_POST['goodsName'])){
                WMessage::ajaxInfo('物资描述不能为空',0);
            }
            if(!is_numeric($_POST['currCount'])){
                WMessage::ajaxInfo('入库数量格式不正确',0);
            }
            if($_POST['minCount']&&!is_numeric($_POST['minCount'])){
                WMessage::ajaxInfo('最低库存格式不正确',0);
            }
            if($_POST['price']&&!is_numeric($_POST['price'])){
                WMessage::ajaxInfo('单价格式不正确',0);
            }
            //整理数据
            $mt=array(
                "storeID"=>$_POST['storeID'],
                "goodsName"=>$_POST['goodsName'],
                "goodsCode"=>$_POST['goodsCode'],
                "currCount"=>$_POST['currCount'],
                "minCount"=>$_POST['minCount'],
                "standard"=>$_POST['standard'],
                "price"=>$_POST['price'],
                "unit"=>$_POST['unit'],
                "validityDate"=>$_POST['validityDate'],
                "workCode"=>$_POST['workCode'],
                "batchCode"=>$_POST['batchCode'],
                "extendCode"=>$_POST['extendCode'],
                "erpLL"=>$_POST['erpLL'],
                "erpCK"=>$_POST['erpCK'],
                "factory"=>$_POST['factory'],
                "factory_contact"=>$_POST['factory_contact'],
                "factory_tel"=>$_POST['factory_tel'],
                "remark"=>$_POST['remark']
            );
            //修改物资时，判断编号在当前缓存是否已经存在
            if(!empty($_POST['oldgCode'])){
                $i=0;
                foreach($mtArr as $k){
                    if(array_search($_POST['oldgCode'], $k)){
                        $mtArr[$i]=$mt;
                        $cache->set($cacheMT,$mtArr,7200);//缓存两小时
                        WMessage::ajaxInfo();
                    }
                    $i++;
                }
            }

            //然后存入缓存
            $mtArr[] = $mt;
            $cache->set($cacheMT,$mtArr,7200);
            WMessage::ajaxInfo();
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_form");
    }
    /**
     * 验证物资编号是否存在
     */
    public function actionCheckCode(){
        $goodsCode = $_POST['goodsCode'];
        $data = Material::model()->find("goodsCode='{$goodsCode}'");
        if($data){
            echo json_encode(array(
                "info"=>'该物资编码已存在',
                "status"=>1,
                "data"=>$data
            ));
            exit();
        }else{
            echo json_encode(array(
                "status"=>0
            ));
            exit();
        }
    }
    /**
     * 修改缓存中指定的物资信息
     */
    public function actionEditMTdata(){
        $userID = User::getID();
        $cacheMT = "MTdata".$userID;
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheMT);
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
    public function actionDelMTdata(){
        $userID = User::getID();
        $cacheMT = "MTdata".$userID;
        $cache = Yii::app()->cache;
        $mtArr = $cache->get($cacheMT);
        //判断编号在当前缓存是否已经存在,找到后删除该编号的物资信息
        $i=0;//计算下标
        foreach($mtArr as $mt){
            if(array_search($_GET['goodsCode'], $mt)){
                array_splice($mtArr, $i, 1);//删除mtArr中第i个元素，只删一个
                $cache->set($cacheMT,$mtArr,7200);//删除后更新缓存
                WMessage::ajaxInfo();
            }
            $i++;
        }
        WMessage::ajaxInfo("删除失败",0);
    }
    /**
     * 入库单列表
     */
    public function actionInFormList(){
        //查询参数
        $condition[] = "del='0'";
        $condition[] = $_GET['informCode'] == "" ? "" : "AND INSTR(informCode,'{$_GET['informCode']}')>0";
        $condition[] = $_GET['glProCode'] == "" ? "" : "AND INSTR(glProCode,'{$_GET['glProCode']}')>0";
        $condition[] = $_GET['glPro'] == "" ? "" : "AND INSTR(glPro,'{$_GET['glPro']}')>0";
        $condition[] = $_GET['starDate'] == "" ? "" : "AND date>='{$_GET['starDate']}'";
        $condition[] = $_GET['endDate'] == "" ? "" : "AND date<='{$_GET['endDate']}'";

        //模型实例化
        $material = New InForm();
        //条件
        $criteria = new CDbCriteria();
        //$criteria->order = "CONVERT(LEFT(goodsName,1) USING gbk)  asc";//中文排序
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id desc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        //$rsList = $material->findAll("del='0' AND storeID='9'");//问题：category取不到值，明天用原生sql查询
        $rsList = $material->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread("入库单列表");
        $this->render("in_form_list",array(
            'rsList'=>$rsList
        ));
    }
    /**
     * 入库单详情
     */
    public function actionShowInForm(){
        $inForm = InForm::model()->find("informCode='{$_GET['id']}'");
        $mList = MaterialIn::model()->findAll("informID=".$_GET['id']);
//        var_dump($inForm);
//        var_dump($mList);
//        exit();
        //渲染视图
        $this->setLayoutNone();
        $this->render("in_form",array(
            'SHOW'=>true,
            'inForm'=>$inForm,
            'list'=>$mList
        ));
    }
    /**
     * 填写移库单
     */
    public function actionMoveForm(){
        if (Yii::app()->request->isAjaxRequest) {
            /**
             * 思路：
             * 新增移库单记录
             * 物资表若没有该物资新增物资记录，有该物资只增加物资数
             * 物资表原物资的库存数减去移库数
             * 物资移库表新增移库物资记录
             *
             * 注意检查每个物资与目标仓库是否相同，如果相同提示该物资不可移动
             */
            $session = new CHttpSession();
            $session->open();
            $data = $session->get("move_material");
            if (!is_array($data)) {
                WMessage::ajaxInfo("请先添加物资", 0);
            } else {
                if (count($data) <= 0) {
                    WMessage::ajaxInfo("物资不能为空，请先添加", 0);
                }
            }
            if (!$_POST['storeID']) {
                WMessage::ajaxInfo("移入仓库不能为空", 0);
            }
            $storeID = UserStore::getStoreByUserID()->storeID;
            //事务处理
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //新增移库单记录
                $moveForm = new MoveForm();
                $moveForm->attributes = $_POST;
                $hz = sprintf("%03d", $moveForm->countFormCode(date('Ymd'))+1);//3位后缀，不足用0补
                $moveForm->moveFormCode = date('Ymd').$hz;//单号格式【年月日】+【当月单数+1】
//                $inForm->date = date('Y-m-d');

                if (!$moveForm->add()) {
                    throw new Exception($moveForm->error->getErrorMessage());
                }
                //得到最后插入数据的id
                $moveformID = Yii::app()->db->getLastInsertID();
                //目标仓库
                $moveStoreID = $_POST['storeID'];
                //保存移库单中的物资
                for ($i = 0; $i < count($data); $i++) {
                    $_rtm = unserialize($data[$i]);//依旧能拿到之前的对象
                    $_rtm->update();
                    //判断物资当前库是否是目标库
                    if($_rtm->material->storeID==$moveStoreID){
                        throw new Exception($_rtm->material->goodsName."已存在该仓库");
                    }
                    //判断目标库中是否存在相同物资
                    $mobj = Material::model()->findByAttributes(
                        array('goodsCode' => $_rtm->material->goodsCode, 'storeID' => $moveStoreID,'batchCode'=>$_rtm->material->batchCode)
                    );
                    if($mobj){
                        //如果存在，物资表中目标库中该物资库存增加
                        $mobj->currCount += $_rtm->number;
                        $mobj->applyNum += $_rtm->number;
                        if (!$mobj->edit()) {
                            throw new Exception($mobj->error->getErrorMessage());
                        }
                        $materialID = $_rtm->material->materialID;
                    }else{
                        //如果不存在，物资表新增一条物资记录
                        $material = new Material();
                        $material->storeID = $moveStoreID;
                        $material->goodsCode = $_rtm->material->goodsCode;
                        $material->extendCode = $_rtm->material->extendCode;
                        $material->goodsName = $_rtm->material->goodsName;
                        $material->standard = $_rtm->material->standard;
                        $material->unit = $_rtm->material->unit;
                        $material->currCount = $_rtm->number;
                        $material->applyNum = $_rtm->number;
                        $material->price = $_rtm->material->price;
                        $material->minCount = $_rtm->material->minCount;
                        $material->validityDate = $_rtm->material->validityDate;
                        $material->remark = $_rtm->material->remark;
                        $material->del = $_rtm->material->del;
                        $material->batchCode = $_rtm->material->batchCode;
                        $material->workCode = $_rtm->material->workCode;
                        $material->erpLL = $_rtm->material->erpLL;
                        $material->erpCK = $_rtm->material->erpCK;
                        $material->factory = $_rtm->material->factory;
                        $material->factory_contact = $_rtm->material->factory_contact;
                        $material->factory_tel = $_rtm->material->factory_tel;
                        if (!$material->add()) {
                            throw new Exception($material->error->getErrorMessage());
                        }
                        $materialID = Yii::app()->db->getLastInsertID();
                    }
                    //原物资减去移出数
                    $_rtm->material->applyNum -= $_rtm->number;
                    $_rtm->material->currCount -= $_rtm->number;
                    if (!$_rtm->material->edit()) {
                        throw new Exception($_rtm->material->error->getErrorMessage());
                    }
                    //产生一条移库记录
                    $material_move = new MaterialMove();
                    $material_move->storeID = $moveStoreID;//目标库ID
                    $material_move->comeStoreID = $_rtm->material->storeID;//来源库ID
                    $material_move->comeMaterialID = $_rtm->material->materialID;//来源库ID
                    $material_move->moveformID = $moveformID;
                    $material_move->materialID = $materialID;
                    $material_move->goodsCode = $_rtm->material->goodsCode;
                    $material_move->extendCode = $_rtm->material->extendCode;
                    $material_move->goodsName = $_rtm->material->goodsName;
                    $material_move->standard = $_rtm->material->standard;
                    $material_move->unit = $_rtm->material->unit;
                    $material_move->price = $_rtm->material->price;
                    $material_move->number = $_rtm->number;
                    $material_move->minCount = $_rtm->material->minCount;
                    $material_move->validityDate = $_rtm->material->validityDate;
                    $material_move->remark = $_rtm->material->remark;
                    $material_move->batchCode = $_rtm->material->batchCode;
                    $material_move->workCode = $_rtm->material->workCode;
                    $material_move->erpLL = $_rtm->material->erpLL;
                    $material_move->erpCK = $_rtm->material->erpCK;
                    $material_move->factory = $_rtm->material->factory;
                    $material_move->factory_contact = $_rtm->material->factory_contact;
                    $material_move->factory_tel = $_rtm->material->factory_tel;
                    if (!$material_move->add()) {
                        throw new Exception($material_move->error->getErrorMessage());
                    }

                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                WMessage::ajaxInfo($e->getMessage(), 0);
            }
            $session->remove("move_material");
            WMessage::ajaxInfo();
        }
        $store = UserStore::getStoreByUserID();
        if (!$store) {
            WMessage::htmlWarn("您没有绑定仓库");
        }
        //渲染视图
        $this->setBread("填写移库单");
        $this->render("move_form",array(
            "userID"=>User::getID()
        ));
    }
    /**
     * 马上要添加到移库单的物资列表(从这里选择)
     */
    public function actionSelectList(){
        $condition[] = "AND a.del='0' AND a.currCount<>0";
        $condition[] = $_GET['glPro'] == "" ? "" : " AND INSTR(i.glPro,'{$_GET['glPro']}')>0";
        $condition[] = $_GET['glProCode'] == "" ? "" : " AND INSTR(i.glProCode,'{$_GET['glProCode']}')>0";
        $condition[] = $_GET['storeID'] == "" ? "" : " AND INSTR(m.storeID,'{$_GET['storeID']}')>0";
        $condition[] = $_GET['goodsName'] == "" ? "" : " AND INSTR(m.goodsName,'{$_GET['goodsName']}')>0";
        $condition[] = $_GET['goodsCode'] == "" ? "" : " AND INSTR(m.goodsCode,'{$_GET['goodsCode']}')>0";

        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $sql = "SELECT a.*,i.glProCode,i.glPro FROM mod_material a,mod_in_form i,mod_material_in m";
        $sqlWhere = " WHERE i.informCode = m.informID AND a.materialID = m.materialID " . $criteria->condition;
        $sql2 = "SELECT a.*,i.glProCode,i.glPro FROM mod_material a,mod_move_form i,mod_material_move m";
        $sqlWhere2 = " WHERE i.id = m.moveformID AND a.materialID = m.materialID " . $criteria->condition;
        $sqlMerge = $sql . $sqlWhere .' UNION '. $sql2 . $sqlWhere2;
//        $sqlMerge = $sql . $sqlWhere;
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        $command = Yii::app()->db->createCommand($sqlMerge);
        $rsList = ActiveRecord::getRecordByCMD($command, $this->pagination, $criteria);

        //返回所有物资数据
        $this->setLayoutNone();
        $this->setBread("填写移库单");
        $this->render("select_list",array(
            "rsList" => $rsList
        ));
    }
    /**
     * 将物资添加到移库单,通过session缓存
     */
    public function actionAddToMoveForm() {
        $materialID = $_POST['materialID'];
        $number = $_POST['num'];
        if (!is_numeric($materialID)) {
            WMessage::ajaxInfo("非法的物资", 0);
        }
        if ($number<=0) {
            WMessage::ajaxInfo("请选择至少选择一个物资", 0);
        }
        $rtm = new WTempMaterial($materialID, $number);
        //检查
        try {
            $rtm->validate();
        } catch (Exception $e) {
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        //Session
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("move_material");
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
        $session->add("move_material", $data);
        WMessage::ajaxInfo();
    }
    /**
     * 已经添加进移库单的物资列表
     */
    public function actionSelectedList() {
        //Session
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("move_material");
        //渲染视图
        $this->setLayoutNone();
        $this->render("selected_list", array(
            "rsList" => $data
        ));
    }
    /**
     * 从移库单中移除
     */
    public function actionRemoveToMoveForm() {
        $materialID = $_POST['materialID'];
        $session = new CHttpSession();
        $session->open();
        $data = $session->get("move_material");
        if ($data != null) {
            for ($i = 0; $i < count($data); $i++) {
                $_rtm = unserialize($data[$i]);
                if ($_rtm->materialID == $materialID) {
                    array_splice($data, $i, 1);
                    $session->add("move_material", $data);
                    WMessage::ajaxInfo();
                }
            }
        }
        WMessage::ajaxInfo("没有数据", 0);
    }

    /**
     * 移库单列表
     */
    public function actionMoveFormList(){
        //查询参数
        $condition[] = "1=1 AND del='0'";
        $condition[] = $_GET['moveFormCode'] == "" ? "" : "AND INSTR(moveFormCode,'{$_GET['moveFormCode']}')>0";
        $condition[] = $_GET['batchCode'] == "" ? "" : "AND INSTR(batchCode,'{$_GET['batchCode']}')>0";
        $condition[] = $_GET['storeID'] == "" ? "" : "AND storeID='{$_GET['storeID']}'";
        $condition[] = $_GET['starDate'] == "" ? "" : "AND date>='{$_GET['starDate']}'";
        $condition[] = $_GET['endDate'] == "" ? "" : "AND date<='{$_GET['endDate']}'";
        //模型实例化
        $material = New MoveForm();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id desc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $material->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread("移库单列表");
        $this->render("move_form_list",array(
            'rsList'=>$rsList
        ));
    }
    /**
     * 移库单详情
     */
    public function actionShowMoveForm(){
        $moveForm = MoveForm::model()->findByPk($_GET['id']);
        $mList = MaterialMove::model()->findAll("moveformID=".$_GET['id']);
//        var_dump($inForm);
//        var_dump($mList);
//        exit();
        //渲染视图
        $this->setLayoutNone();
        $this->render("move_form_show",array(
            'SHOW'=>true,
            'moveForm'=>$moveForm,
            'list'=>$mList
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
            $rs = MoveForm::model()->findByPk($formID);
            $path = "upload/move_from_pic/";
            if (!file_exists($path)) {
                mkdir($path);
            }
            if ($_FILES['file']['name'] != "") {

                $upload = new WUpload($_FILES['file']);
                $upload->init();
                $upload->setSavePath($path);
                //将字串分割成数组
                $fileArr = explode(',',$rs['file']);
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
                $rs['file'] = implode(',',$fileArr);
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
        $moveForm = MoveForm::model()->findByPk($formID);
        $fileArr = explode(',',$moveForm->file);

        //渲染视图
        $this->setLayoutNone();
        $this->render("upload_file",array(
            'fileArr'=>$fileArr,
            'formID'=>$formID
        ));
    }

    //查看图片附件
    public function actionShowPic(){
        $src = $_GET['src'];
        //渲染视图
        $this->setLayoutNone();
        $this->render("show_pic",array(
            'src'=>$src
        ));
    }

    //删除附件
    public function actionDelfile(){
        $name = $_GET['name'];
        $formID = $_GET['formID'];
        $moveForm = MoveForm::model()->findByPk($formID);
        $fileArr = explode(',',$moveForm->file);
        foreach($fileArr as $file){
            $fileName = substr(strchr($file,'move_from_pic/'),14);
            if($fileName == $name){
                if(unlink($file)){
                    $fileArr = array_diff($fileArr,array($file));
                    $moveForm->file = implode(',',$fileArr);
                    try {
                        $moveForm->save();
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
            'formID'=>$formID
        ));
    }
}
