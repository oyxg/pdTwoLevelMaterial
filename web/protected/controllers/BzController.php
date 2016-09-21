<?php

class BzController extends Controller {

    public $controllerName = "班组";

    /**
     * 列表
     */
    public function actionList() {
        $this->setBread("班组列表");
        //查询参数
        $condition[] = "1=1";
        $condition[] = $_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
        //模型实例化
        $bz = new Bz();
        //条件
        $criteria = new CDbCriteria();
        $criteria->condition = implode(" ", $condition);
        //分页
        $this->pagination = new CPagination();
        $this->pagination->pageSize = 15;
        //查找数据
        $rsList = $bz->getRecord($criteria, $this->pagination);
        //渲染视图
        $this->render("bz_list", array(
            "rsList" => $rsList
        ));
    }


    /**
     * 添加班组
     */
    public function actionAdd() {
        if (Yii::app()->request->isAjaxRequest) {
            if(Bz::model()->find("name='{$_POST['name']}'")){
                WMessage::ajaxInfo('该班组已存在', 0);
            }
            $bz = new Bz();
            $bz->attributes = $_POST;
//            $stores->type = Store::TYPE_LINE;
//            $stores->category = Store::CATEGORY_SPARE;
            if ($bz->add()) {
                WMessage::ajaxInfo();
            } else {
                WMessage::ajaxInfo($bz->error->getErrorMessage(), 0);
            }
        }
        $this->setLayoutNone();
        $this->render("bz_form", array(
            "data" => "",
        ));
    }

    /**
     * 修改班组
     */
    public function actionEdit() {
        if (Yii::app()->request->isAjaxRequest) {
            $bz = Bz::model()->findByPk($_GET['id']);
            if (!$bz) {
                WMessage::ajaxInfo("没有找到数据", 0);
            }
            if(Bz::model()->find("name='{$_POST['name']}'")){
                WMessage::ajaxInfo('该班组已存在', 0);
            }
            $bz->attributes = $_POST;
            if ($bz->edit()) {
                WMessage::ajaxInfo();
            } else {
                WMessage::ajaxInfo($bz->error->getErrorMessage(), 0);
            }
        }
        $bz = Bz::model()->findByPk($_GET['id']);
        if (!$bz) {
            WMessage::htmlWarn("没有找到数据");
        }
        $this->setLayoutNone();
        $this->render("bz_form", array(
            "bz" => $bz,
        ));
    }

    /**
     * 删除班组
     * @throws Exception
     */
    public function actionRemove() {
        $bz = Bz::model()->findByPk($_GET['id']);
        if (!$bz) {
            WMessage::ajaxInfo("没有找到数据", 0);
        }
        $transaction = $bz->getDbConnection()->beginTransaction();
        try {
            $bz->delete();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            WMessage::ajaxInfo($e->getMessage(), 0);
        }
        WMessage::ajaxInfo();
    }

}

?>