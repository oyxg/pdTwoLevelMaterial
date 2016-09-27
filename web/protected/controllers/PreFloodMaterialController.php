<?php

/**
 * 功能：防汛物资管理
 * 作者：陈天宇
 * 日期：2016-7-25
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class PreFloodMaterialController extends Controller {


    /**
     * 控制器名称
     */
    public $controllerName = "防汛物资管理";

    /**
     * 防汛物资列表
     */
    public function actionPreFloodList(){
        $condition[] = "1=1";
        $condition[] = $_GET['className'] == "" ? "" : "AND INSTR(className,'{$_GET['className']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        $condition[] = $_GET['pzlevel'] == "" ? "" : "AND INSTR(pzlevel,'{$_GET['pzlevel']}')>0";
        //模型实例化
        $PreFlood = new PreFloodInfo();
        //条件
        $criteria = new CDbCriteria();
        //$criteria->order = "CONVERT(LEFT(goodsName,1) USING gbk)  asc";//中文排序
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id asc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        //$rsList = $material->findAll("del='0' AND storeID='9'");//问题：category取不到值，明天用原生sql查询
        $rsList = $PreFlood->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread("防汛物资列表");
        $this->render("material_list",array(
            'rsList'=>$rsList
        ));
    }

    /**
     * 防汛物资信息
     */
    public function actionPreFloodInfo(){
        $condition[] = "1=1";
        $condition[] = $_GET['className'] == "" ? "" : "AND INSTR(className,'{$_GET['className']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        $condition[] = $_GET['pzlevel'] == "" ? "" : "AND INSTR(pzlevel,'{$_GET['pzlevel']}')>0";
        $condition[] = $_GET['factory'] == "" ? "" : "AND INSTR(factory,'{$_GET['factory']}')>0";
        $condition[] = $_GET['bh'] == "" ? "" : "AND INSTR(bh,'{$_GET['bh']}')>0";
        $condition[] = $_GET['contact'] == "" ? "" : "AND INSTR(contact,'{$_GET['contact']}')>0";
        //模型实例化
        $PreFlood = new PreFloodInfo();
        //条件
        $criteria = new CDbCriteria();
        //$criteria->order = "CONVERT(LEFT(goodsName,1) USING gbk)  asc";//中文排序
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id asc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        //$rsList = $material->findAll("del='0' AND storeID='9'");//问题：category取不到值，明天用原生sql查询
        $rsList = $PreFlood->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread("防汛物资信息");
        $this->render("material_info",array(
            'rsList'=>$rsList
        ));
    }

    /**
     * 添加防汛物资信息
     */
    public function actionAddPreFloodInfo(){
        if (Yii::app()->request->isAjaxRequest) {
            $preFloodInfo = New PreFloodInfo();
            $preFloodInfo->attributes = $_POST;
//            var_dump($_POST);
//            exit;
            if (!$preFloodInfo->add()) {
                WMessage::ajaxInfo($preFloodInfo->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_info");
    }
    /**
     * 添加防汛物资信息
     */
    public function actionEditPreFloodInfo(){
        if (Yii::app()->request->isAjaxRequest) {
            $preFloodInfo = PreFloodInfo::model()->findByPk($_POST['id']);
            $preFloodInfo->attributes = $_POST;
            if (!$preFloodInfo->edit()) {
                WMessage::ajaxInfo($preFloodInfo->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        $data = PreFloodInfo::model()->findByPk($_GET['id']);
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_info",array(
            'Edit'=>true,
            'data'=>$data
        ));
    }
    /**
     * 设置各班需求（查看、新增、修改）
     */
    public function actionSetPreFloodNeed(){
        //处理提交数据
        if (Yii::app()->request->isAjaxRequest) {
            $res = PreFloodNeed::model()->findAll("mID='{$_POST['mID']}'");
//            var_dump($res);
//            exit();
            $edit = array();
            foreach($res as $row){
                for($i=0;$i<=6;$i++) {
                    if ($row->bzID == $i) {
                        $editRow = PreFloodNeed::model()->find("mID='{$_POST['mID']}' AND bzID='{$i}'");
                        $editRow->needNum = "{$_POST[$i]}";
                        //修改满足条件的班组需求数量（修改）
                        if (!$editRow->edit()) {
                            WMessage::ajaxInfo($editRow->error->getErrorMessage(), 0);
                        }
                        array_push($edit, $i);//将修改过的班组存入edit
                    }
                }
            }
//            var_dump($edit);
//            exit();
            $add = array_diff(array(0,1,2,3,4,5,6),$edit);//获取没有修改的班组
            foreach ($add as $bz){
                $need = new PreFloodNeed();
                $need->mID = "{$_POST['mID']}";
                $need->bzID = "{$bz}";
                $need->needNum = $_POST[$bz]==''?0:$_POST[$bz];
                //新增指定班组的需求记录（新增）
                if (!$need->add()) {
                    WMessage::ajaxInfo($need->error->getErrorMessage(),0);
                }
            }
            WMessage::ajaxInfo();
        }
        //根据物资ID返回各班组需求数量（查看）
        $res = PreFloodNeed::model()->findAll("mID='{$_GET['id']}'");
        $data = array();
        foreach($res as $row){
            for($i=0;$i<=6;$i++){
                if($row->bzID==$i){
                    $data[$i] = "{$row->needNum}";
                }
            }
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("need_form",array(
            'data'=>$data,
            'mID'=>$_GET['id']
        ));
    }


    /**
     * 防汛物资入库
     */
    public function actionPreFloodIn(){
        $condition[] = "1=1";
        $condition[] = $_GET['className'] == "" ? "" : "AND INSTR(className,'{$_GET['className']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        //模型实例化
        $PreFlood = new ViewPreFloodIn();
        //条件
        $criteria = new CDbCriteria();
        //$criteria->order = "CONVERT(LEFT(goodsName,1) USING gbk)  asc";//中文排序
        $criteria->condition = implode(" ", $condition);
//        $criteria->order = "id asc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        //$rsList = $material->findAll("del='0' AND storeID='9'");//问题：category取不到值，明天用原生sql查询
        $rsList = $PreFlood->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread("防汛物资入库");
        $this->render("material_in",array(
            'rsList'=>$rsList
        ));
    }

    /**
     * 新增防汛物资入库记录
     */
    public function actionAddPreFloodIn(){
        if (Yii::app()->request->isAjaxRequest) {
            $preFlood = New PreFloodIn();
            $preFlood->attributes = $_POST;
            if (!$preFlood->add()) {
                throw new Exception($preFlood->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("in_form");
    }
    /**
     * 修改防汛物资入库记录
     */
    public function actionEditPreFloodIn(){

    }
}
