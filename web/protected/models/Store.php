<?php

class Store extends ActiveRecord {

    /**
     * storeID
     */
    public $storeID;

    /**
     * 父仓库ID
     */
    public $parentID;

    /**
     * 仓库名称
     */
    public $storeName;
    private $_pk = 'storeID';

    /**
     * 获取模型实例
     * @return Store
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 表名
     * @see CActiveRecord::tableName()
     */
    public function tableName() {

        return 'mod_store';
    }

    static function getCategoryList() {
        $store = new Store();
        return (array) $store->findAll();
    }

    /**
     * 验证规则
     * @see CModel::rules()
     */
    public function rules() {
        return array(
            array(
                'parentID,storeName,',
                'required'
            ),
            array(
                'storeID',
                'numerical',
                'on' => self::SCENES_EDIT
            )
        );
    }

    /**
     * 属性标签
     * @return multitype:string
     */
    public function attributeLabels() {
        return array(
            'storeID' => 'storeID',
            'parentID' => '父仓库ID',
            'storeName' => '仓库名称'
        );
    }

    /**
     * 是否存在指定ID
     * @return bool
     */
    public static function hasOne($id) {
        return parent::hasOne($id, __CLASS__);
    }

    /**
     * 获取列表
     * @return array
     */
    public static function getList() {
        return parent::getList(__CLASS__);
    }

    /**
     * 获取名称
     * @param int $id
     * @return string
     */
    public static function getName($id) {
        $id = explode(",",$id);
        $storeName = array();
        foreach($id as $v){
            $storeName[] = self::model()->findByPk($v)->storeName;
        }
        $storeName = implode(",",$storeName);
        return $storeName;
    }
}
