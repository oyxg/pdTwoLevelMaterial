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
    public function actionList(){
        $condition[] = "1=1";
        $condition[] = $_GET['className'] == "" ? "" : "AND INSTR(className,'{$_GET['className']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        //模型实例化
        $PreFlood = new PreFlood();
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
     * 物资添加表单
     */
    public function actionAddForm(){
        if (Yii::app()->request->isAjaxRequest) {

            //验证数据
            if(empty($_POST['className'])){
                WMessage::ajaxInfo('分类不能为空',0);
            }
            if(empty($_POST['name'])){
                WMessage::ajaxInfo('物资名称不能为空',0);
            }
            $preFlood = New PreFlood();
            $preFlood->attributes = $_POST;
            if (!$preFlood->add()) {
                throw new Exception($preFlood->error->getErrorMessage(),0);
            }
            WMessage::ajaxInfo();
        }
        //渲染视图
        $this->setLayoutNone();
        $this->render("add_form");
    }
    /**
     * 修改防汛物资列表中的信息
     */
    public function actionEdit(){

    }

    /**
     * 防汛物资信息
     */
    public function actionMaterialInfo(){
        $condition[] = "1=1";
        $condition[] = $_GET['className'] == "" ? "" : "AND INSTR(className,'{$_GET['className']}')>0";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        //模型实例化
        $PreFlood = new PreFlood();
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
        $this->render("material_info",array(
            'rsList'=>$rsList
        ));
    }

    /**
     * 防汛各班需求
     */
    public function actionMaterialNeed(){

    }

}
