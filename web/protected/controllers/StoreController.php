<?php

class StoreController extends Controller {

    public $controllerName = "仓库";

    /**
     * 列表
     */
    public function actionList() {
        $this->setBread("仓库列表");
        //查询参数
        $condition[] = "1=1";
        $condition[] = $_GET['storeName'] == "" ? "" : "AND INSTR(storeName,'{$_GET['storeName']}')>0";
        //模型实例化
        $store = new Store();
        //条件
        $criteria = new CDbCriteria();
        $criteria->order = "CONVERT(LEFT(storeName,1) USING gbk)  asc";
        $criteria->condition = implode(" ", $condition);
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $store->getRecord($criteria, $this->pagination);
        //渲染视图
        $this->render("store_list", array(
            "rsList" => $rsList
        ));
    }


    /**
     * 添加物资
     */
    public function actionAdd() {
        WMessage::checkAccess(AI::C_StoreAdd);
        if (Yii::app()->request->isAjaxRequest) {
            if(Store::model()->find("storeName='{$_POST['storeName']}'")){
                WMessage::ajaxInfo('该仓库名已存在', 0);
            }
            $stores = new Store();
            $stores->attributes = $_POST;
//            $stores->type = Store::TYPE_LINE;
//            $stores->category = Store::CATEGORY_SPARE;
            if ($stores->add()) {
                WMessage::ajaxInfo();
            } else {
                WMessage::ajaxInfo($stores->error->getErrorMessage(), 0);
            }
        }
        $this->setLayoutNone();
        $this->render("stores_form", array(
            "data" => "",
        ));
    }

    /**
     * 修改物资
     */
    public function actionEdit() {
        WMessage::checkAccess(AI::C_StoreEdit);
        if (Yii::app()->request->isAjaxRequest) {
            $stores = Store::model()->findByPk($_GET['storeID']);
            if (!$stores) {
                WMessage::ajaxInfo("没有找到数据", 0);
            }
            if(Store::model()->find("storeName='{$_POST['storeName']}' and parentID='{$_POST['parentID']}'")){
                WMessage::ajaxInfo('该仓库名已存在', 0);
            }
            $stores->attributes = $_POST;
            if ($stores->edit()) {
                WMessage::ajaxInfo();
            } else {
                WMessage::ajaxInfo($stores->error->getErrorMessage(), 0);
            }
        }
        $stores = Store::model()->findByPk($_GET['storeID']);
        if (!$stores) {
            WMessage::htmlWarn("没有找到数据");
        }
        $this->setLayoutNone();
        $this->render("stores_form", array(
            "stores" => $stores,
        ));
    }

    /**
     * 删除物资
     * @throws Exception
     */
    public function actionRemove() {
        WMessage::checkAccess(AI::C_StoreDelete);
        $stores = Store::model()->findByPk($_GET['storeID']);
        if (!$stores) {
            WMessage::ajaxInfo("没有找到数据", 0);
        }
   //     $stores->deleted = 1;
        $transaction = $stores->getDbConnection()->beginTransaction();
        try {
            $stores->delete();
//            if (!$stores->edit()) {
//                throw new Exception($stores->error->getErrorMessage());
//            }
//            $command = Yii::app()->db->createCommand();
//            $command->text = "UPDATE " . Material::model()->tableName() . " SET deleted=1 WHERE storesID=" . $stores->storesID;
//            $command->execute();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        WMessage::ajaxInfo();
    }

}

?>