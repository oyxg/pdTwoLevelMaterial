<?php

/**
 * 功能：仪器仪表管理
 * 作者：陈天宇
 * 日期：2016-10-11
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class InstrumentController extends Controller {


    /**
     * 控制器名称
     */
    public $controllerName = "仪器仪表管理";

    /**
     * 仪器仪表配置
     */
    public function actionInstrumentInfo(){
        $condition[] = "1=1";
        $condition[] = $_GET['className'] == "" ? "" : "AND INSTR(className,'{$_GET['className']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        $condition[] = $_GET['standard'] == "" ? "" : "AND INSTR(standard,'{$_GET['standard']}')>0";
        $condition[] = $_GET['jsgf'] == "" ? "" : "AND INSTR(jsgf,'{$_GET['jsgf']}')>0";
        //模型实例化
        $instrumentInfo = new InstrumentInfo();
        //条件
        $criteria = new CDbCriteria();
        //$criteria->order = "CONVERT(LEFT(goodsName,1) USING gbk)  asc";//中文排序
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id asc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $instrumentInfo->getRecord($criteria, $this->pagination);
        //渲染视图
        $this->setBread("仪器仪表配置");
        $this->render("material_info",array(
            'rsList'=>$rsList
        ));
    }
    /**
     * 添加分类
     */
    public function actionAddInstrumentClass(){
        if (Yii::app()->request->isAjaxRequest) {
            $instrumentClass = New InstrumentClass();
            if($instrumentClass->count("name='{$_POST['name']}'")>0){
                WMessage::ajaxInfo("已存在",0);
            }else{
                $instrumentClass->attributes = $_POST;
                if (!$instrumentClass->add()) {
                    WMessage::ajaxInfo($instrumentClass->error->getErrorMessage(),0);
                }
                WMessage::ajaxInfo();
            }
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_class");
    }
    /**
     * 添加仪器仪表
     */
    public function actionAddInstrumentInfo(){
        if (Yii::app()->request->isAjaxRequest) {
            $instrumentInfo = New InstrumentInfo();
            $res = $instrumentInfo->count("className='{$_POST['className']}' AND name='{$_POST['name']}'");
            if($res > 0) {
                WMessage::ajaxInfo('该配置已存在，不能重复添加',0);
            }
            $instrumentInfo->attributes = $_POST;
            if (!$instrumentInfo->add()) {
                WMessage::ajaxInfo($instrumentInfo->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_info");
    }

    /**
     * 修改仪器仪表
     */
    public function actionEditInstrumentInfo(){
        if (Yii::app()->request->isAjaxRequest) {
            $instrumentInfo = InstrumentInfo::model()->findByPk($_POST['id']);
            $instrumentInfo->attributes = $_POST;
            if (!$instrumentInfo->edit()) {
                WMessage::ajaxInfo($instrumentInfo->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        $data = InstrumentInfo::model()->findByPk($_GET['id']);
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_info",array(
            'Edit'=>true,
            'data'=>$data
        ));
    }

    /**
     * 仪器仪表台账
     */
    public function actionAddInstrumentIn(){
        if (Yii::app()->request->isAjaxRequest) {
            $InstrumentIn = New InstrumentIn();
            $InstrumentIn->attributes = $_POST;
            $InstrumentIn->date = date('Y-m-d');
            if (!$InstrumentIn->add()) {
                WMessage::ajaxInfo($InstrumentIn->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("in_form",array(
            'mID'=>$_GET['id']
        ));
    }
    /**
     * 仪器仪表台账
     */
    public function actionInstrumentIn(){
        $condition[] = "1=1";
        $condition[] = $_GET['projectCode'] == "" ? "" : "AND INSTR(projectCode,'{$_GET['projectCode']}')>0";
        $condition[] = $_GET['projectName'] == "" ? "" : "AND INSTR(projectName,'{$_GET['projectName']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        $condition[] = $_GET['card'] == "" ? "" : "AND INSTR(card,'{$_GET['card']}')>0";
        $condition[] = $_GET['SAP'] == "" ? "" : "AND INSTR(SAP,'{$_GET['SAP']}')>0";
        $condition[] = $_GET['equCode'] == "" ? "" : "AND INSTR(equCode,'{$_GET['equCode']}')>0";
        $condition[] = $_GET['materialCode'] == "" ? "" : "AND INSTR(materialCode,'{$_GET['materialCode']}')>0";
        $condition[] = $_GET['materialName'] == "" ? "" : "AND INSTR(materialName,'{$_GET['materialName']}')>0";
        $condition[] = $_GET['factory'] == "" ? "" : "AND INSTR(factory,'{$_GET['factory']}')>0";
        $condition[] = $_GET['storeAddress'] == "" ? "" : "AND storeAddress='{$_GET['storeAddress']}'";
        $condition[] = $_GET['state'] == "" ? "" : "AND state='{$_GET['state']}'";
        //模型实例化
        $PreFlood = new ViewInstrumentIn();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "inID DESC ";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $PreFlood->getRecord($criteria, $this->pagination);
        //渲染视图
        $this->setBread("仪器仪表台账");
        $this->render("material_in",array(
            'rsList'=>$rsList
        ));
    }
    /**
     * 修改仪器仪表台账
     */
    public function actionEditInstrumentIn(){
        if (Yii::app()->request->isAjaxRequest) {
            $InstrumentIn = New InstrumentIn();
            $InstrumentIn = $InstrumentIn->model()->findByPk($_POST['id']);
            $InstrumentIn->attributes = $_POST;
            if (!$InstrumentIn->edit()) {
                WMessage::ajaxInfo($InstrumentIn->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        $InstrumentIn = New InstrumentIn();
        $data = $InstrumentIn->model()->findByPk($_GET['id']);
        //渲染视图
        $this->setLayoutNone();
        $this->render("in_form",array(
            'data'=>$data,
            'Edit'=>true
        ));
    }




    /**
     * 仪器仪表汇总
     */
    public function actionInstrumentList(){
        $condition[] = "1=1";
        $condition[] = $_GET['className'] == "" ? "" : "AND INSTR(className,'{$_GET['className']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        $condition[] = $_GET['standard'] == "" ? "" : "AND INSTR(standard,'{$_GET['standard']}')>0";
        $condition[] = $_GET['jsgf'] == "" ? "" : "AND INSTR(jsgf,'{$_GET['jsgf']}')>0";
        //模型实例化
        $instrument = new InstrumentInfo();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "id asc";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $instrument->getRecord($criteria, $this->pagination);
        //渲染视图
        $this->setBread("仪器仪表汇总");
        $this->render("material_list",array(
            'rsList'=>$rsList
        ));
    }
    /**
     * 显示现存台账
     */
    public function actionShowInstrumentIn(){
        $condition[] = "1=1";
        $condition[] = "AND mID={$_GET['m']}";
        $condition[] = "AND storeAddress={$_GET['b']}";
        //模型实例化
        $PreFlood = new ViewInstrumentIn();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "InID DESC";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $PreFlood->getRecord($criteria, $this->pagination);
        $this->setLayoutNone();
        $this->render("in_list",array(
            'rsList'=>$rsList
        ));
    }
//    /**
//     * 仪器仪表入库
//     */
//    public function actionAddInstrument(){
//        if (Yii::app()->request->isAjaxRequest) {
//            $instrument = New Instrument();
//            $instrument->attributes = $_POST;
//            if (!$instrument->add()) {
//                WMessage::ajaxInfo($instrument->error->getErrorMessage(),0);
//            }
//            WMessage::ajaxInfo();
//        }
//        //渲染视图
//        $this->setLayoutNone();
//        $this->render("in_form");
//    }
//    /**
//     * 修改仪器仪表
//     */
//    public function actionEditInstrument(){
//        if (Yii::app()->request->isAjaxRequest) {
//            $instrument = New Instrument();
//            $instrument = $instrument->model()->findByPk($_POST['id']);
//            $instrument->attributes = $_POST;
//            if (!$instrument->edit()) {
//                WMessage::ajaxInfo($instrument->error->getErrorMessage(),0);
//            }
//            WMessage::ajaxInfo();
//        }
//        $instrument = New Instrument();
//        $data = $instrument->model()->findByPk($_GET['id']);
//        //渲染视图
//        $this->setLayoutNone();
//        $this->render("in_form",array(
//            'data'=>$data,
//            'Edit'=>true
//        ));
//    }

    /**
     * 删除仪器仪表
     */
    public function actionDelInstrument(){
        if (Yii::app()->request->isAjaxRequest) {
            $instrument = New Instrument();
            if (!$instrument->deleteByPk($_GET['id'])) {
                WMessage::ajaxInfo($instrument->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
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
            $inID = $_POST['inID'];
            $rs = InstrumentIn::model()->findByPk($inID);
            $path = "upload/instrument_file/";
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
                //保存文件名，格式：入库记录ID+下划线+自增编号
                $upload->setFileName($inID.'_'.$maxNum);
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
        if($_GET['id']) {
            $inID = $_GET['id'];
        }else if($_POST['inID']){
            $inID = $_POST['inID'];
        }else{
            WMessage::ajaxInfo("请求失败", 0);
        }
        $instrument = InstrumentIn::model()->findByPk($inID);
        $fileArr = explode(',',$instrument->file);

        //渲染视图
        $this->setLayoutNone();
        $this->render("upload_file",array(
            'fileArr'=>$fileArr,
            'inID'=>$inID
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
    public function actionDelFile(){
        $name = $_GET['name'];
        $inID = $_GET['inID'];
        $instrument = InstrumentIn::model()->findByPk($inID);
        $fileArr = explode(',',$instrument->file);
        foreach($fileArr as $file){
            $fileName = substr(strchr($file,'instrument_file/'),16);
            if($fileName == $name){
                if(unlink($file)){
                    $fileArr = array_diff($fileArr,array($file));
                    $instrument->file = implode(',',$fileArr);
                    try {
                        $instrument->save();
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
            'inID'=>$inID
        ));
    }
}
