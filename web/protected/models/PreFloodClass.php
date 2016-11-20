<?php

/**
 * 功能：班组
 * 作者：陈天宇
 * 日期：2016-06-29
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class PreFloodClass extends ActiveRecord {

    public $id;
    public $name;
    private $_pk = 'id';

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
        return 'mod_preflood_class';
    }

    /**
     * 验证规则
     * @see CModel::rules()
     */
    public function rules() {
        return array(
            array(
                'name',
                'required'
            )
        );
    }

    /**
     * 属性标签
     * @return multitype:string
     */
    public function attributeLabels() {
        return array(
            'id' => '主键',
            'name' => '分类名称'
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
        return self::model()->findByPk($id)->name;
    }


}
