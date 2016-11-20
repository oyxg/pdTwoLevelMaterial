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
     * 防汛物资汇总
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
        $criteria->order = "id DESC";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        //$rsList = $material->findAll("del='0' AND storeID='9'");//问题：category取不到值，明天用原生sql查询
        $rsList = $PreFlood->getRecord($criteria, $this->pagination);
//        var_dump($rsList);
//        exit();
        //渲染视图
        $this->setBread("防汛物资汇总");
        $this->render("material_list",array(
            'rsList'=>$rsList
        ));
    }

    /**
     * 防汛物资配置
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
        $this->setBread("防汛物资配置");
        $this->render("material_info",array(
            'rsList'=>$rsList
        ));
    }

    /**
     * 添加防汛物资
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
     * 添加分类
     */
    public function actionAddPreFloodClass(){
        if (Yii::app()->request->isAjaxRequest) {
            $Class = New PreFloodClass();
            if($Class->count("name='{$_POST['name']}'")>0){
                WMessage::ajaxInfo("已存在",0);
            }else{
                $Class->attributes = $_POST;
                if (!$Class->add()) {
                    WMessage::ajaxInfo($Class->error->getErrorMessage(),0);
                }
                WMessage::ajaxInfo();
            }
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_class");
    }
    /**
     * 修改防汛物资
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
//    public function actionSetPreFloodNeed(){
//        //处理提交数据
//        if (Yii::app()->request->isAjaxRequest) {
//            $res = PreFloodNeed::model()->findAll("mID='{$_POST['mID']}'");
////            var_dump($res);
////            exit();
//            $edit = array();
//            foreach($res as $row){
//                for($i=0;$i<=6;$i++) {
//                    if ($row->bzID == $i) {
//                        $editRow = PreFloodNeed::model()->find("mID='{$_POST['mID']}' AND bzID='{$i}'");
//                        $editRow->needNum = "{$_POST[$i]}";
//                        //修改满足条件的班组需求数量（修改）
//                        if (!$editRow->edit()) {
//                            WMessage::ajaxInfo($editRow->error->getErrorMessage(), 0);
//                        }
//                        array_push($edit, $i);//将修改过的班组存入edit
//                    }
//                }
//            }
////            var_dump($edit);
////            exit();
//            $add = array_diff(array(0,1,2,3,4,5,6),$edit);//获取没有修改的班组
//            foreach ($add as $bz){
//                $need = new PreFloodNeed();
//                $need->mID = "{$_POST['mID']}";
//                $need->bzID = "{$bz}";
//                $need->needNum = $_POST[$bz]==''?0:$_POST[$bz];
//                //新增指定班组的需求记录（新增）
//                if (!$need->add()) {
//                    WMessage::ajaxInfo($need->error->getErrorMessage(),0);
//                }
//            }
//            WMessage::ajaxInfo();
//        }
//        //根据物资ID返回各班组需求数量（查看）
//        $res = PreFloodNeed::model()->findAll("mID='{$_GET['id']}'");
//        $data = array();
//        foreach($res as $row){
//            for($i=0;$i<=6;$i++){
//                if($row->bzID==$i){
//                    $data[$i] = "{$row->needNum}";
//                }
//            }
//        }
//        //渲染视图
//        $this->setLayoutNone();
//        $this->render("need_form",array(
//            'data'=>$data,
//            'mID'=>$_GET['id']
//        ));
//    }


    /**
     * 防汛物资台账
     */
    public function actionPreFloodIn(){
        $condition[] = "1=1";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        $condition[] = $_GET['factory'] == "" ? "" : "AND INSTR(factory,'{$_GET['factory']}')>0";
        $condition[] = $_GET['bzID'] == "" ? "" : "AND bzID='{$_GET['bzID']}'";
        $condition[] = $_GET['projectCode'] == "" ? "" : "AND INSTR(projectCode,'{$_GET['projectCode']}')>0";
        $condition[] = $_GET['projectName'] == "" ? "" : "AND INSTR(projectName,'{$_GET['projectName']}')>0";
        //模型实例化
        $PreFlood = new ViewPreFloodIn();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        $criteria->order = "date DESC ,inID DESC ";
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $PreFlood->getRecord($criteria, $this->pagination);
        //渲染视图
        $this->setBread("防汛物资台账");
        $this->render("material_in",array(
            'rsList'=>$rsList
        ));
    }

    /**
     * 防汛物资入库
     */
    public function actionAddPreFloodIn(){
        if (Yii::app()->request->isAjaxRequest) {
            $preFloodIn = New PreFloodIn();
            $preFloodIn->attributes = $_POST;
            $preFloodIn->date = date('Y-m-d');
            if (!$preFloodIn->add()) {
                WMessage::ajaxInfo($preFloodIn->error->getErrorMessage(),0);
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
     * 修改防汛物资入库记录
     */
    public function actionEditPreFloodIn(){
        if (Yii::app()->request->isAjaxRequest) {
            $preFloodIn = New PreFloodIn();
            $preFloodIn = $preFloodIn->model()->findByPk($_POST['id']);
            $preFloodIn->attributes = $_POST;
            if (!$preFloodIn->edit()) {
                WMessage::ajaxInfo($preFloodIn->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        $preFloodIn = New PreFloodIn();
        $data = $preFloodIn->model()->findByPk($_GET['id']);
        //渲染视图
        $this->setLayoutNone();
        $this->render("in_form",array(
            'data'=>$data,
            'Edit'=>true
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
            $inID = $_POST['inID'];
            $rs = PreFloodIn::model()->findByPk($inID);
            $path = "upload/preflood_file/";
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
        $preFloodIn = PreFloodIn::model()->findByPk($inID);
        $fileArr = explode(',',$preFloodIn->file);

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
        $preFloodIn = PreFloodIn::model()->findByPk($inID);
        $fileArr = explode(',',$preFloodIn->file);
        foreach($fileArr as $file){
            $fileName = substr(strchr($file,'preflood_file/'),14);
            if($fileName == $name){
                if(unlink($file)){
                    $fileArr = array_diff($fileArr,array($file));
                    $preFloodIn->file = implode(',',$fileArr);
                    try {
                        $preFloodIn->save();
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

    /**
     * 显示防汛台账
     */
    public function actionShowPrefloodIn(){
        $condition[] = "1=1";
        $condition[] = "AND mID={$_GET['m']}";
        $condition[] = "AND bzID={$_GET['b']}";
        //模型实例化
        $PreFlood = new ViewPreFloodIn();
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

    /**
     * 获得配置信息
     */
    public function actionGetPzInfo(){
        $m = $_POST['mid'];
//        $b = $_POST['bzID'];
        $PreFloodInfo = new PreFloodInfo();
        $res = $PreFloodInfo->find("id='{$m}'");
        echo json_encode($res);
        exit;
    }
}
