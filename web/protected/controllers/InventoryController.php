<?php

/**
 * 功能：盘点
 * 作者：陈天宇
 * 日期：2016-5-26 下午14:56:32
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class InventoryController extends Controller {

    /**
     * 控制器名称
     */
    public $controllerName = "物资管理";
    /**
     * 添加物资到盘点
     */
    public function actionAdd() {
        if ($_POST['is_all'] == "1") {
            $materialIDArr = array();
            $userID = Yii::app()->user->getId();
            $store = UserStore::model()->findAll("userID=".$userID);
//            var_dump($store[0]->storeID);
//                exit();
            if (!$store) {
                WMessage::ajaxInfo("你没有绑定仓库", 0);
            }
            if (Auth::has(AI::R_Storer)){
                //查询参数
//                $condition[] = "1=1";
//                $condition[] = "AND storeID=" . $store->storeID;
//                $condition[] = "AND del=0";
//                $criteria = new CDbCriteria();
//                $criteria->condition = implode(" ", $condition);
//                $Material = new Material();
                $rsList = Material::model()->findAll("storeID in ({$store[0]->storeID})");
//                var_dump($rsList);
//                exit();
            }else{
                $rsList = Material::model()->findAll();
            }
            if ($rsList) {
                foreach ($rsList as $k => $rs) {
                    $materialIDArr[] = $rs['materialID'];
                }
            } else {
                WMessage::ajaxInfo("没有物资", 0);
            }
        } else {
            $materialIDs = $_POST['materialIDs'];
            if ($materialIDs == "") {
                WMessage::ajaxInfo("物资不能为空", 0);
            }
            $materialIDArr = explode(",", $materialIDs);
        }
//        var_dump($materialIDArr);
//        exit();
        //保存在session中的盘点数据
        $session = new CHttpSession();
        $session->open();
        //获取之前保存的盘点
        $oldInventory = $session->get("inventory");
        //如果不为空的话就合并新的和旧的
        if ($oldInventory != null) {
            $newInvertory = array_merge($oldInventory, $materialIDArr);
            //去除重复
            $newInvertory = array_unique($newInvertory);
        } else {
            $newInvertory = $materialIDArr;
        }
        //添加到session
        $session->add("inventory", $newInvertory);
        WMessage::ajaxInfo("操作成功", 1, $newInvertory);
    }

    /**
     * 盘点列表
     */
    public function actionList() {
        //保存在session中的盘点数据
        $session = new CHttpSession();
        $session->open();
        //获取之前保存的盘点
        $inventoryArr = $session->get("inventory");
        $inventory = implode(",", $inventoryArr);
        //SQL
        if(!empty($inventory)){
            $sqlMerge = "SELECT * FROM mod_material WHERE materialID IN({$inventory})";
            //分页
            $this->pagination = new CPagination();
            $this->pagination->pageSize = 15;
            $command = Yii::app()->db->createCommand($sqlMerge);
            $rsArr = ActiveRecord::getRecordByCMD($command, $this->pagination);
//            var_dump($rsArr);
//            exit;
            //循环所有物资数据，通过物资id统计出指定时间段内总领料数、总退料数、总入库数
            foreach($rsArr as $rs){
                $mid =  $rs['materialID'];
                if(!empty($_GET['sdate'])||!empty($_GET['edate'])){
                    $sql_date = " AND (r.date>'{$_GET['sdate']}' AND r.date<'{$_GET['edate']}')";
                }
                //退料数量
//                $sql = "SELECT SUM(rm.number) as count_return
//FROM mod_return_form r,mod_return_form_material rm
//WHERE r.id = rm.formID AND rm.materialID = '{$mid}'{$sql_date}";
//                $countReturn = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_return'];
//                $returnArr = array("countReturn"=>$countReturn);
                //入库数量=入库+移入库
                $sql = "SELECT SUM(rm.currCount) as count_in
FROM mod_in_form r,mod_material_in rm
WHERE r.informCode = rm.informID AND rm.materialID = '{$mid}'{$sql_date}";
                $countIn = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_in'];
//                $sql = "SELECT SUM(rm.number) as count_move
//FROM mod_move_form r,mod_material_move rm
//WHERE r.id = rm.moveformID AND rm.comeMaterialID = '{$mid}'  {$sql_date}";
//                $countMoveIN = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_move'];//统计移入库数量
                $inArr = array("countIn"=>$countIn);

                //出库数量（通过状态的领料物资）
                $sql = "SELECT SUM(rm.number) as count_rective
FROM mod_receive_form r,mod_receive_form_material rm
WHERE r.state = 'tg' AND r.id = rm.formID AND rm.materialID = '{$mid}'{$sql_date}";
                $countReceive = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_rective'];
                $receiveArr = array("countReceive"=>$countReceive);

                //待领料数量(审核状态的领料物资)
                $sql = "SELECT SUM(rm.number) as count_no_receive
FROM mod_receive_form r,mod_receive_form_material rm
WHERE r.state = 'sh' AND r.id = rm.formID AND rm.materialID = '{$mid}'{$sql_date}";
                $countNoReceive = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_no_receive'];
                $noReceiveArr = array("countNoReceive"=>$countNoReceive);
                //移库数量（移出库）
                $sql = "SELECT SUM(rm.number) as count_move
FROM mod_move_form r,mod_material_move rm
WHERE r.id = rm.moveformID AND rm.comeMaterialID = '{$mid}' {$sql_date}";
                $countMoveOut = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_move'];
                $moveArr = array("countMove"=>$countMoveOut);
                //先合并多个字段后，再合并到结果集中
                $colArr = array_merge($receiveArr,$inArr,$moveArr,$noReceiveArr);
                $rsList[] = array_merge($rs,$colArr);
            }
        }else{
            $rsList = [];
        }
        $session->add("inventoryRsArr", $rsList);//盘点结果集，导出excel时用
        //渲染
        $this->setBread("物资盘点");
        $this->render("inventory_list", array(
            "rsList" => $rsList
        ));
    }

    /**
     * 清空所有
     */
    public function actionClear() {
        $session = new CHttpSession();
        $session->open();
        //$session->destroySession("inventory");
        $session->add("inventory", array());
        WMessage::ajaxInfo();
    }

    /**
     * 生成电子表
     * @throws CHttpException
     */
    public function actionExport() {
        //保存在session中的盘点数据
        $session = new CHttpSession();
        $session->open();

        $inventoryArr = $session->get("inventory");
        $inventory = implode(",", $inventoryArr);
        //SQL
        if(!empty($inventory)){
            $sqlMerge = "SELECT * FROM mod_material WHERE materialID IN({$inventory})";
            //分页
            $this->pagination = new CPagination();
            $this->pagination->pageSize = 1000;
            $command = Yii::app()->db->createCommand($sqlMerge);
            $rsArr = ActiveRecord::getRecordByCMD($command, $this->pagination);
//            var_dump($rsArr);
//            exit;
            //循环所有物资数据，通过物资id统计出指定时间段内总领料数、总退料数、总入库数
            foreach($rsArr as $rs){
                $mid =  $rs['materialID'];
                if(!empty($_GET['sdate'])||!empty($_GET['edate'])){
                    $sql_date = " AND (r.date>'{$_GET['sdate']}' AND r.date<'{$_GET['edate']}')";
                }
                //退料数量
//                $sql = "SELECT SUM(rm.number) as count_return
//FROM mod_return_form r,mod_return_form_material rm
//WHERE r.id = rm.formID AND rm.materialID = '{$mid}'{$sql_date}";
//                $countReturn = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_return'];
//                $returnArr = array("countReturn"=>$countReturn);
                //入库数量
                $sql = "SELECT SUM(rm.currCount) as count_in
FROM mod_in_form r,mod_material_in rm
WHERE r.informCode = rm.informID AND rm.materialID = '{$mid}'{$sql_date}";
                $countIn = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_in'];
                $inArr = array("countIn"=>$countIn);

                //出库数量（通过状态的领料物资）
                $sql = "SELECT SUM(rm.number) as count_rective
FROM mod_receive_form r,mod_receive_form_material rm
WHERE r.state = 'tg' AND r.id = rm.formID AND rm.materialID = '{$mid}'{$sql_date}";
                $countReceive = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_rective'];
                $receiveArr = array("countReceive"=>$countReceive);

                //待领料数量(审核状态的领料物资)
                $sql = "SELECT SUM(rm.number) as count_no_receive
FROM mod_receive_form r,mod_receive_form_material rm
WHERE r.state = 'sh' AND r.id = rm.formID AND rm.materialID = '{$mid}'{$sql_date}";
                $countNoReceive = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_no_receive'];
                $noReceiveArr = array("countNoReceive"=>$countNoReceive);
                //移库数量
                $sql = "SELECT SUM(rm.number) as count_move
FROM mod_move_form r,mod_material_move rm
WHERE r.id = rm.moveformID AND rm.comeMaterialID = '{$mid}'{$sql_date}";
                $countMove = ActiveRecord::getRecordByCMD(Yii::app()->db->createCommand($sql))[0]['count_move'];
                $moveArr = array("countMove"=>$countMove);
                //先合并三个字段后，再合并到结果集中
                $colArr = array_merge($receiveArr,$inArr,$moveArr,$noReceiveArr);
                $rsList[] = array_merge($rs,$colArr);
            }
        }else{
            $rsList = [];
        }

        if (!is_array($rsList)) {
            WMessage::htmlWarn("请先将物资添加到盘点单");
        }
        //渲染
        $excel = new MayaExcelWriter();
        //保存文件名
        $fileName = date('Y-m-d')."盘点单";
        //标题
        $excel->setSubject($fileName);
        //列字段
        $excel->setFields(array(
            array("name" => "仓库", "width" => 17),
            array("name" => "批次编号", "width" => 20),
            array("name" => "物资名称", "width" => 20),
            array("name" => "物资编号", "width" => 17),
            array("name" => "扩展编码", "width" => 17),
            array("name" => "单位", "width" => 17),
            array("name" => "单价", "width" => 17),
            array("name" => "规格", "width" => 17),
            array("name" => "厂家", "width" => 17),
            array("name" => "有效日期", "width" => 17),
            array("name" => "最低库存", "width" => 17),
            array("name" => "当前库存", "width" => 17),
            array("name" => "入库数量", "width" => 17),
            array("name" => "出库数量", "width" => 17),
            array("name" => "待领料数量", "width" => 17),
            array("name" => "移库数量", "width" => 17),
        ));
        $data = array();
        $i = 0;
        foreach ($rsList as $key => $rs) {
            $data[$i]['storeID'] = Store::getName($rs['storeID']);
            $data[$i]['batchCode'] = $rs['batchCode'];
            $data[$i]['goodsName'] = $rs['goodsName'];
            $data[$i]['goodsCode'] = $rs['goodsCode'];
            $data[$i]['extendCode'] = $rs['extendCode'];
            $data[$i]['unit'] = $rs['unit'];
            $data[$i]['price'] = $rs['price'];
            $data[$i]['standard'] = $rs['standard'];
            $data[$i]['factory'] = $rs['factory'];
            $data[$i]['validityDate'] = $rs['validityDate']=="0000-00-00"?"":$rs['validityDate'];
            $data[$i]['minCount'] = floatval($rs['minCount']);
            $data[$i]['currCount'] = floatval($rs['currCount']);
            $data[$i]['countIn'] = $rs['countIn']==''?'0':floatval($rs['countIn']);
            $data[$i]['countReceive'] = $rs['countReceive']==''?'0':floatval($rs['countReceive']);
            $data[$i]['countNoReceive'] = $rs['countNoReceive']==''?'0':floatval($rs['countNoReceive']);
            $data[$i]['countMove'] = $rs['countMove']==''?'0':floatval($rs['countMove']);
            $i++;
        }
        //设置数据
        $excel->setData($data);
        //运行
        $excel->run();
        //保存输出到浏览器
        $excel->saveBrowser($fileName);
    }

}
