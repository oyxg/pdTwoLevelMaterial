/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : pdTwoLevelMaterial

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2016-09-24 11:08:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('Admin', '1', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('Admin', '25', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Admin', '26', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Admin', '34', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Group', '12', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Group', '13', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Group', '14', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Group', '18', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Group', '28', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Group', '30', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Inventory', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('Major', '10', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Major', '11', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Major', '31', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Material', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('Materialer', '32', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Materialer', '4', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Materialer', '9', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('MaterialList', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('PreFloodMaterial', '4', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('PreFloodMaterialInfo', '4', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('PreFloodMaterialList', '4', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('PreFloodMaterialNeed', '4', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('ReceiveMaterialList', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('ReturnMaterialList', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('Storer', '24', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Storer', '27', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Storer', '29', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Storer', '33', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Storer', '5', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Storer', '6', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('TreatedReceiveMF', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('TreatedReturnMF', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('UseMaterial', '39', '', 's:0:\"\";');
INSERT INTO `auth_assignment` VALUES ('Visitor', '38', null, 'N;');
INSERT INTO `auth_assignment` VALUES ('Visitor', '39', null, 'N;');

-- ----------------------------
-- Table structure for `auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('Admin', '2', '管理员', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Auth', '1', '权限设置', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Bz', '0', '班组', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Group', '2', '班组', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('InForm', '0', '填写入库单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('InFormList', '0', '入库单列表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Inventory', '0', '盘点', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Major', '2', '专职', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Material', '1', '物资管理', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Materialer', '2', '材料管理员', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('MaterialList', '0', '物资列表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('MoveForm', '0', '填写移库单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('MoveFormList', '0', '移库单列表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('MyReceiveMF', '0', '我提交的领料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('MyReturnMF', '0', '我提交的退料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('MyScrapForm', '0', '我提交的报废表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('MyTaskBook', '0', '我提交的任务书', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('PreFloodMaterial', '1', '防汛物资管理', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('PreFloodMaterialInfo', '0', '防汛物资信息', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('PreFloodMaterialList', '0', '防汛物资列表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('PreFloodMaterialNeed', '0', '防汛各班需求', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('ReceiveMaterialList', '0', '领料物资记录', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('ReceiveMF', '0', '填写领料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('ReturnMaterialList', '0', '退料物资记录', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('ReturnMF', '0', '填写退料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Scrap', '1', '报废管理', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('ScrapForm', '0', '填写报废表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Setting', '1', '系统设置', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Store', '1', '仓库', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('StoreAdd', '0', '仓库（添加）', null, 'N;');
INSERT INTO `auth_item` VALUES ('StoreDelete', '0', '仓库（刪除）', null, 'N;');
INSERT INTO `auth_item` VALUES ('StoreEdit', '0', '仓库（修改）', null, 'N;');
INSERT INTO `auth_item` VALUES ('StoreList', '0', '仓库（列表）', null, 'N;');
INSERT INTO `auth_item` VALUES ('Storer', '2', '仓库管理员', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Task', '1', '任务书', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('TaskBook', '0', '填写任务书', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('TreatedReceiveMF', '0', '已处理的领料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('TreatedReturnMF', '0', '已处理的退料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('TreatedScrapForm', '0', '已处理的报废表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('TreatedTaskBook', '0', '已处理的任务书', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('UntreatedReceiveMF', '0', '待处理的领料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('UntreatedReturnMF', '0', '待处理的退料单', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('UntreatedScrapForm', '0', '待处理的报废表', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('UntreatedTaskBook', '0', '待处理的任务书', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('UseMaterial', '1', '领退料管理', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('User', '1', '用户', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('UserAdd', '0', '用户（添加）', null, 'N;');
INSERT INTO `auth_item` VALUES ('UserDelete', '0', '用户（刪除）', null, 'N;');
INSERT INTO `auth_item` VALUES ('UserEdit', '0', '用户（修改）', null, 'N;');
INSERT INTO `auth_item` VALUES ('UserList', '0', '用户（列表）', null, 'N;');
INSERT INTO `auth_item` VALUES ('UserStore', '0', '用户仓库（设置）', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Visitor', '2', '游客', '', 's:0:\"\";');
INSERT INTO `auth_item` VALUES ('Warning', '0', '物资（预警）', '', 's:0:\"\";');

-- ----------------------------
-- Table structure for `auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('Admin', 'Auth');
INSERT INTO `auth_item_child` VALUES ('Setting', 'Auth');
INSERT INTO `auth_item_child` VALUES ('Setting', 'Bz');
INSERT INTO `auth_item_child` VALUES ('Material', 'InForm');
INSERT INTO `auth_item_child` VALUES ('Material', 'InFormList');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'Inventory');
INSERT INTO `auth_item_child` VALUES ('Storer', 'Inventory');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'Material');
INSERT INTO `auth_item_child` VALUES ('Storer', 'Material');
INSERT INTO `auth_item_child` VALUES ('Material', 'MaterialList');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'MoveForm');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'MoveFormList');
INSERT INTO `auth_item_child` VALUES ('Group', 'MyReceiveMF');
INSERT INTO `auth_item_child` VALUES ('Group', 'MyReturnMF');
INSERT INTO `auth_item_child` VALUES ('Group', 'MyScrapForm');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'MyScrapForm');
INSERT INTO `auth_item_child` VALUES ('Group', 'MyTaskBook');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'ReceiveMaterialList');
INSERT INTO `auth_item_child` VALUES ('Group', 'ReceiveMF');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'ReturnMaterialList');
INSERT INTO `auth_item_child` VALUES ('Group', 'ReturnMF');
INSERT INTO `auth_item_child` VALUES ('Group', 'Scrap');
INSERT INTO `auth_item_child` VALUES ('Major', 'Scrap');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'Scrap');
INSERT INTO `auth_item_child` VALUES ('Group', 'ScrapForm');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'ScrapForm');
INSERT INTO `auth_item_child` VALUES ('Admin', 'Setting');
INSERT INTO `auth_item_child` VALUES ('Admin', 'Store');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'Store');
INSERT INTO `auth_item_child` VALUES ('Admin', 'StoreAdd');
INSERT INTO `auth_item_child` VALUES ('Store', 'StoreAdd');
INSERT INTO `auth_item_child` VALUES ('Admin', 'StoreDelete');
INSERT INTO `auth_item_child` VALUES ('Store', 'StoreDelete');
INSERT INTO `auth_item_child` VALUES ('Admin', 'StoreEdit');
INSERT INTO `auth_item_child` VALUES ('Store', 'StoreEdit');
INSERT INTO `auth_item_child` VALUES ('Admin', 'StoreList');
INSERT INTO `auth_item_child` VALUES ('Store', 'StoreList');
INSERT INTO `auth_item_child` VALUES ('Group', 'Task');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'Task');
INSERT INTO `auth_item_child` VALUES ('Group', 'TaskBook');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'TreatedReceiveMF');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'TreatedReturnMF');
INSERT INTO `auth_item_child` VALUES ('Major', 'TreatedScrapForm');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'TreatedScrapForm');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'TreatedTaskBook');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'UntreatedReceiveMF');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'UntreatedReturnMF');
INSERT INTO `auth_item_child` VALUES ('Major', 'UntreatedScrapForm');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'UntreatedScrapForm');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'UntreatedTaskBook');
INSERT INTO `auth_item_child` VALUES ('Group', 'UseMaterial');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'UseMaterial');
INSERT INTO `auth_item_child` VALUES ('Admin', 'User');
INSERT INTO `auth_item_child` VALUES ('Materialer', 'User');
INSERT INTO `auth_item_child` VALUES ('Setting', 'User');
INSERT INTO `auth_item_child` VALUES ('Admin', 'UserAdd');
INSERT INTO `auth_item_child` VALUES ('Setting', 'UserAdd');
INSERT INTO `auth_item_child` VALUES ('User', 'UserAdd');
INSERT INTO `auth_item_child` VALUES ('Admin', 'UserDelete');
INSERT INTO `auth_item_child` VALUES ('Setting', 'UserDelete');
INSERT INTO `auth_item_child` VALUES ('User', 'UserDelete');
INSERT INTO `auth_item_child` VALUES ('Admin', 'UserEdit');
INSERT INTO `auth_item_child` VALUES ('Setting', 'UserEdit');
INSERT INTO `auth_item_child` VALUES ('User', 'UserEdit');
INSERT INTO `auth_item_child` VALUES ('Admin', 'UserList');
INSERT INTO `auth_item_child` VALUES ('Setting', 'UserList');
INSERT INTO `auth_item_child` VALUES ('User', 'UserList');
INSERT INTO `auth_item_child` VALUES ('Admin', 'UserStore');
INSERT INTO `auth_item_child` VALUES ('Setting', 'UserStore');
INSERT INTO `auth_item_child` VALUES ('User', 'UserStore');
INSERT INTO `auth_item_child` VALUES ('Admin', 'Warning');
INSERT INTO `auth_item_child` VALUES ('Storer', 'Warning');

-- ----------------------------
-- Table structure for `mod_bz`
-- ----------------------------
DROP TABLE IF EXISTS `mod_bz`;
CREATE TABLE `mod_bz` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '班组名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_bz
-- ----------------------------
INSERT INTO `mod_bz` VALUES ('1', '一班');
INSERT INTO `mod_bz` VALUES ('2', '二班');
INSERT INTO `mod_bz` VALUES ('3', '三班');

-- ----------------------------
-- Table structure for `mod_in_form`
-- ----------------------------
DROP TABLE IF EXISTS `mod_in_form`;
CREATE TABLE `mod_in_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '入库单ID',
  `informCode` varchar(20) NOT NULL COMMENT '入库单号',
  `date` date NOT NULL COMMENT '入库日期',
  `glProCode` varchar(20) DEFAULT NULL COMMENT '关联大修项目编号',
  `glPro` varchar(255) DEFAULT NULL COMMENT '关联大修项目',
  `contact` varchar(50) DEFAULT NULL COMMENT '联系人',
  `tel` varchar(100) DEFAULT NULL COMMENT '联系人电话',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `del` enum('1','0') NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_in_form
-- ----------------------------
INSERT INTO `mod_in_form` VALUES ('1', '20160603001', '2016-06-03', '20160603dd', '车祸', '小鹿', '555555555', '修修修', '0');
INSERT INTO `mod_in_form` VALUES ('2', '20160604001', '2016-06-04', '201605002', '东区911', '忐忑', '88888888', '啦啦啦', '0');
INSERT INTO `mod_in_form` VALUES ('5', '20160604002', '2016-06-04', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('6', '20160604003', '2016-06-04', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('7', '20160613001', '2016-06-13', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('8', '20160613002', '2016-06-13', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('23', '20160613003', '2016-06-13', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('24', '20160613004', '2016-06-13', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('25', '20160614001', '2016-06-14', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('28', '20160615001', '2016-06-15', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('33', '20160615002', '2016-06-15', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('34', '20160615003', '2016-06-15', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('35', '20160615004', '2016-06-15', '15', '15', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('36', '20160615005', '2016-06-15', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('39', '20160615006', '2016-06-15', '156', '156', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('40', '20160615007', '2016-06-15', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('41', '20160615008', '2016-06-15', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('42', '20160615009', '2016-06-15', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('43', '20160615010', '2016-06-15', '123', '123', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('44', '20160617001', '2016-06-17', 't151515', '天津事变', '蒋欣', '15151515151515', '事变', '0');
INSERT INTO `mod_in_form` VALUES ('45', '20160622001', '2016-06-22', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('46', '20160622002', '2016-06-22', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('47', '20160622003', '2016-06-22', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('48', '20160801001', '2016-08-01', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('52', '20160802001', '2016-08-02', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('53', '20160809001', '2016-08-09', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('54', '20160809002', '2016-08-09', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('55', '20160809003', '2016-08-09', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('56', '20160810001', '2016-08-10', '', '', '', '', '', '0');
INSERT INTO `mod_in_form` VALUES ('64', '20160810002', '2016-08-10', '', '', '', '', '', '0');

-- ----------------------------
-- Table structure for `mod_material`
-- ----------------------------
DROP TABLE IF EXISTS `mod_material`;
CREATE TABLE `mod_material` (
  `materialID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `storeID` tinyint(4) unsigned NOT NULL COMMENT '仓库ID',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号',
  `goodsCode` varchar(20) NOT NULL COMMENT '物料编码',
  `extendCode` varchar(20) DEFAULT NULL COMMENT '扩展编码',
  `goodsName` varchar(255) DEFAULT NULL COMMENT '物资名称',
  `workCode` varchar(50) DEFAULT NULL COMMENT '工单号',
  `erpLL` varchar(50) DEFAULT NULL COMMENT 'ERP领料单',
  `erpCK` varchar(50) DEFAULT NULL COMMENT 'ERP出库单',
  `factory` varchar(50) DEFAULT NULL COMMENT '厂家',
  `factory_contact` varchar(100) DEFAULT NULL COMMENT '厂家联系人',
  `factory_tel` varchar(100) DEFAULT NULL COMMENT '厂家联系电话',
  `standard` varchar(255) DEFAULT NULL COMMENT '规格',
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `price` double(20,2) DEFAULT NULL COMMENT '单价',
  `validityDate` date DEFAULT NULL COMMENT '有效期',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `accessory` varchar(20) DEFAULT NULL COMMENT '附件',
  `minCount` double(20,3) DEFAULT NULL COMMENT '最低库存，预警值',
  `currCount` double(10,3) NOT NULL COMMENT '当前库存',
  `applyNum` double(10,3) DEFAULT NULL COMMENT '可供申请数，由于审批需要时间。防止同一物资被申请报废两次。设置该值',
  `del` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`materialID`),
  KEY `storeID` (`storeID`),
  KEY `goodsID` (`goodsCode`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='物资表';

-- ----------------------------
-- Records of mod_material
-- ----------------------------
INSERT INTO `mod_material` VALUES ('1', '9', '8890', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '-0.257', '10.000', '0');
INSERT INTO `mod_material` VALUES ('2', '10', '3366', 'wz20001', '3366', '物资2', '9908', '1515151515', '4545454545', 'youngsun', '天天', '12343223454', '红、绿', '台', '500.00', '2018-06-30', '补不补', null, '50.000', '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('3', '10', 'G9002', 'ck00001', '2-208', '物资3', '9001', 'ERP002', 'ERP002-c', '晟能', '李梅', '15645678945', '大号', '个', '678.00', '2018-06-22', '辣辣', null, '100.000', '540.000', '540.000', '0');
INSERT INTO `mod_material` VALUES ('4', '10', 'G9002', 'ck00002', '*iji', '物资4', '9002', 'LL2016-05', 'LL2016', '京东', 'Jack', '15855834860', '橡胶', '米', '1909.00', '0000-00-00', 'oooooo', null, '200.000', '741.000', '741.000', '0');
INSERT INTO `mod_material` VALUES ('5', '9', 'WZ1606RK00001', 'bug0001', '', 'BUG2920', '', '', '', '', '', '', '', '', null, null, '', null, null, '99.000', '99.000', '0');
INSERT INTO `mod_material` VALUES ('6', '9', 'WZ1606RK00002', '1', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('7', '10', 'WZ1606RK00003', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '15.000', '15.000', '0');
INSERT INTO `mod_material` VALUES ('8', '9', '8890', 'dl001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '18.000', '16.869', '0');
INSERT INTO `mod_material` VALUES ('9', '9', '8891', 'dl002', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '6.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('10', '9', '8893', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '5.515', '0.000', '0');
INSERT INTO `mod_material` VALUES ('11', '9', '8894', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '8.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('12', '11', 'G9002', 'ck00002', '*iji', '物资4', '9002', 'LL2016-05', 'LL2016', '京东', 'Jack', '15855834860', '橡胶', '米', '1909.00', '0000-00-00', 'oooooo', null, '200.000', '50.000', '50.000', '0');
INSERT INTO `mod_material` VALUES ('13', '11', '8891', 'dl002', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '1.639', '2.000', '0');
INSERT INTO `mod_material` VALUES ('14', '10', 'HP001', '777777', '', 'CCCCC', '9901', '', '', '', '', '', 'lanse', '米', '160.00', null, '', null, '90.689', '124.977', '126.977', '0');
INSERT INTO `mod_material` VALUES ('15', '10', 'WZ1606RK000034', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('16', '10', 'WZ1606RK00056', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '10.000', '10.000', '0');
INSERT INTO `mod_material` VALUES ('17', '10', 'WZ1606RK00005', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('18', '10', 'WZ1606RK00006', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('19', '10', 'WZ1606RK00007', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '15.000', '15.000', '0');
INSERT INTO `mod_material` VALUES ('20', '10', 'WZ1606RK00009', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '10.000', '10.000', '0');
INSERT INTO `mod_material` VALUES ('21', '10', 'WZ1606RK00010', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('22', '10', 'WZ1606RK000012', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('23', '10', 'WZ1606RK00013', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('24', '10', 'WZ1606RK00014', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('25', '9', 'WZ1606RK00014', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '45.000', '4.000', '0');
INSERT INTO `mod_material` VALUES ('29', '11', 'WZ1606RK00005', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '15.000', '15.000', '0');
INSERT INTO `mod_material` VALUES ('30', '9', 'WZ1606RK000012', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '11.000', '16.000', '0');
INSERT INTO `mod_material` VALUES ('31', '9', 'WZ1606RK00010', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '1.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('32', '9', 'WZ1606RK00009', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '5.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('33', '9', 'WZ1606RK00007', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('34', '9', 'PC-20160010', '0010', '890312', 'CTY', 'BH-0016', '7781230', '1230988', '中国', '系大大', '1239090909', 'blue', '个', '18.90', '2019-06-26', '入库，移库', null, '100.000', '145.000', '145.000', '0');
INSERT INTO `mod_material` VALUES ('35', '10', '8894', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '16.000', '16.000', '0');
INSERT INTO `mod_material` VALUES ('36', '11', '3366', 'wz20001', '3366', '物资2', '9908', '1515151515', '4545454545', 'youngsun', '天天', '12343223454', '红、绿', '台', '500.00', '2018-06-30', '补不补', null, '50.000', '5.000', '5.000', '0');
INSERT INTO `mod_material` VALUES ('37', '9', 'WZ1606RK00020', '622', '', '622', '', '', '', '', '', '', '', '', null, null, '', null, null, '1000.000', '1000.000', '0');
INSERT INTO `mod_material` VALUES ('38', '10', 'WZ1606RK00020', '622', '', '622', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('39', '9', 'G9002', 'ck00001', '2-208', '物资3', '9001', 'ERP002', 'ERP002-c', '晟能', '李梅', '15645678945', '大号', '个', '678.00', '2018-06-22', '辣辣', null, '100.000', '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('40', '9', '3366', 'wz20001', '3366', '物资2', '9908', '1515151515', '4545454545', 'youngsun', '天天', '12343223454', '红、绿', '台', '500.00', '2018-06-30', '补不补', null, '50.000', '75.000', '70.000', '0');
INSERT INTO `mod_material` VALUES ('41', '10', 'WZ1606RK00022', '911', '', 'IIIIIIIII', '', '', '', '', '', '', '', '', null, null, '', null, '50.000', '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('42', '11', 'WZ1606RK00022', '911', '', 'IIIIIIIII', '', '', '', '', '', '', '', '', null, null, '', null, '50.000', '100.000', '100.000', '0');
INSERT INTO `mod_material` VALUES ('43', '9', 'G9002', 'ck00002', '*iji', '物资4', '9002', 'LL2016-05', 'LL2016', '京东', 'Jack', '15855834860', '橡胶', '米', '1909.00', '0000-00-00', 'oooooo', null, '200.000', '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('44', '10', 'WZ1606RK00024', '110', '', 'OOOO', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('45', '11', 'WZ1606RK00024', '110', '', 'OOOO', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('46', '9', 'WZ1606RK00024', '110', '', 'OOOO', '', '', '', '', '', '', '', '', null, null, '', null, null, '10.000', '10.000', '0');
INSERT INTO `mod_material` VALUES ('47', '11', 'WZ1606RK000034', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '15.000', '15.000', '0');
INSERT INTO `mod_material` VALUES ('48', '10', '8890', 'dl001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '3.000', '3.000', '0');
INSERT INTO `mod_material` VALUES ('49', '9', 'WZ1606RK00056', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, null, '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('50', '11', 'PC-20160010', '0010', '890312', 'CTY', 'BH-0016', '7781230', '1230988', '中国', '系大大', '1239090909', 'blue', '个', '18.90', '2019-06-26', '入库，移库', null, '100.000', '5.000', '5.000', '0');
INSERT INTO `mod_material` VALUES ('51', '10', '5555', 'wz20001', '3366', '物资2', '4444', '6666', '7777', 'youngsun', '天天', '12343223454', '红、绿', '台', '500.00', '2018-06-30', '补不补', null, '50.000', '0.000', '0.000', '0');
INSERT INTO `mod_material` VALUES ('52', '10', 'G9003', 'ck00001', '2-208', '物资3', '9001', 'ERP002', 'ERP002-c', '晟能', '李梅', '15645678945', '大号', '个', '678.00', '2018-06-22', '辣辣', null, '100.000', '540.000', '540.000', '0');
INSERT INTO `mod_material` VALUES ('53', '9', '1234', 'asdfasdf', '', '物资1', '', '', '', '', '', '', '', '', null, null, '', null, null, '100.000', '100.000', '0');
INSERT INTO `mod_material` VALUES ('54', '9', '88933', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', null, '10.000', '12.000', '12.000', '0');
INSERT INTO `mod_material` VALUES ('55', '9', 'WZ1608RK00001', '112', '', '123123', '', '', '', '', '', '', '', '', null, null, '', null, null, '12.000', '12.000', '0');
INSERT INTO `mod_material` VALUES ('56', '9', 'WZ1608RK00002', '112', '', '121313123', '', '', '', '', '', '', '', '', null, null, '', null, null, '10.000', '10.000', '0');
INSERT INTO `mod_material` VALUES ('57', '9', '201608', '123', '', 'HHHHasdf', '', '', '', '', '', '', '', '', null, null, '', null, null, '27.000', '27.000', '0');
INSERT INTO `mod_material` VALUES ('58', '10', '201608', '321', '', '312asdf', '', '', '', '', '', '', '', '', null, null, '', null, null, '10.000', '10.000', '0');
INSERT INTO `mod_material` VALUES ('59', '11', '201608', '123', '', 'HHHHasdf', '', '', '', '', '', '', '', '', null, null, '', null, null, '22.000', '22.000', '0');

-- ----------------------------
-- Table structure for `mod_material_in`
-- ----------------------------
DROP TABLE IF EXISTS `mod_material_in`;
CREATE TABLE `mod_material_in` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `materialID` int(10) unsigned NOT NULL COMMENT '物资编号',
  `storeID` tinyint(4) unsigned NOT NULL COMMENT '仓库ID',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号',
  `goodsCode` varchar(20) NOT NULL COMMENT '物料编码',
  `extendCode` varchar(20) DEFAULT NULL COMMENT '扩展编码',
  `goodsName` varchar(255) DEFAULT NULL COMMENT '物资描述',
  `workCode` varchar(50) DEFAULT NULL COMMENT '工单号',
  `erpLL` varchar(50) DEFAULT NULL COMMENT 'ERP领料单',
  `erpCK` varchar(50) DEFAULT NULL COMMENT 'ERP出库单',
  `factory` varchar(50) DEFAULT NULL COMMENT '厂家',
  `factory_contact` varchar(100) DEFAULT NULL COMMENT '厂家联系人',
  `factory_tel` varchar(100) DEFAULT NULL COMMENT '厂家联系电话',
  `standard` varchar(255) DEFAULT NULL COMMENT '规格',
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `price` double(20,2) DEFAULT NULL COMMENT '单价',
  `validityDate` date DEFAULT NULL COMMENT '有效期',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `minCount` double(20,3) DEFAULT NULL COMMENT '最低库存，预警值',
  `currCount` double(10,3) NOT NULL COMMENT '当前库存',
  `informID` varchar(20) NOT NULL COMMENT '入库单ID-关联【入库单】',
  PRIMARY KEY (`id`),
  KEY `storeID` (`storeID`),
  KEY `goodsID` (`goodsCode`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='物资表';

-- ----------------------------
-- Records of mod_material_in
-- ----------------------------
INSERT INTO `mod_material_in` VALUES ('1', '1', '9', '8890', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', '10.000', '18.000', '20160603001');
INSERT INTO `mod_material_in` VALUES ('2', '2', '10', '3366', 'wz20001', '3366', '物资2', '9908', '1515151515', '4545454545', 'youngsun', '天天', '12343223454', '红、绿', '台', '500.00', '2018-06-30', '补不补', '50.000', '80.000', '20160603001');
INSERT INTO `mod_material_in` VALUES ('3', '3', '10', 'G9002', 'ck00001', '2-208', '物资3', '9001', 'ERP002', 'ERP002-c', '晟能', '李梅', '15645678945', '大号', '个', '678.00', '2017-06-08', '辣辣', '100.000', '540.000', '20160604001');
INSERT INTO `mod_material_in` VALUES ('4', '4', '10', 'G9002', 'ck00002', '*iji', '物资4', '9002', 'LL2016-05', 'LL2016', '京东', 'Jack', '15855834860', '橡胶', '米', '1909.00', '2017-06-24', 'oooooo', '200.000', '791.000', '20160604001');
INSERT INTO `mod_material_in` VALUES ('5', '5', '9', 'WZ1606RK00001', 'bug0001', '', 'BUG2920', '', '', '', '', '', '', '', '', null, null, '', null, '123.000', '20160604002');
INSERT INTO `mod_material_in` VALUES ('6', '6', '9', 'WZ1606RK00002', '1', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '1.000', '20160604003');
INSERT INTO `mod_material_in` VALUES ('7', '7', '10', 'WZ1606RK00003', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160604003');
INSERT INTO `mod_material_in` VALUES ('8', '8', '9', '8890', 'dl001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', '10.000', '19.000', '20160613001');
INSERT INTO `mod_material_in` VALUES ('9', '9', '9', '8891', 'dl002', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', '10.000', '20.639', '20160613002');
INSERT INTO `mod_material_in` VALUES ('10', '10', '9', '8893', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', '10.000', '18.000', '20160613003');
INSERT INTO `mod_material_in` VALUES ('11', '11', '9', '8894', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', '10.000', '50.000', '20160613004');
INSERT INTO `mod_material_in` VALUES ('12', '14', '10', 'HP001', '777777', '', 'CCCCC', '9901', '', '', '', '', '', 'lanse', '米', '160.00', null, '', '91.000', '100.977', '20160614001');
INSERT INTO `mod_material_in` VALUES ('13', '15', '10', 'WZ1606RK000034', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615001');
INSERT INTO `mod_material_in` VALUES ('14', '16', '10', 'WZ1606RK00056', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615002');
INSERT INTO `mod_material_in` VALUES ('15', '17', '10', 'WZ1606RK00005', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615003');
INSERT INTO `mod_material_in` VALUES ('16', '18', '9', 'WZ1606RK00006', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615004');
INSERT INTO `mod_material_in` VALUES ('17', '19', '10', 'WZ1606RK00007', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615005');
INSERT INTO `mod_material_in` VALUES ('18', '20', '10', 'WZ1606RK00009', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615006');
INSERT INTO `mod_material_in` VALUES ('19', '21', '10', 'WZ1606RK00010', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615007');
INSERT INTO `mod_material_in` VALUES ('20', '22', '10', 'WZ1606RK000012', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615008');
INSERT INTO `mod_material_in` VALUES ('21', '23', '10', 'WZ1606RK00013', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615009');
INSERT INTO `mod_material_in` VALUES ('22', '24', '10', 'WZ1606RK00014', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615010');
INSERT INTO `mod_material_in` VALUES ('23', '17', '11', 'WZ1606RK00005', '11111', '', '111', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160615003');
INSERT INTO `mod_material_in` VALUES ('24', '34', '9', 'PC-20160010', '0010', '890312', 'CTY', 'BH-0016', '7781230', '1230988', '中国', '系大大', '1239090909', 'blue', '个', '19.00', '2019-06-26', '入库，移库', '100.000', '150.000', '20160617001');
INSERT INTO `mod_material_in` VALUES ('25', '37', '9', 'WZ1606RK00020', '622', '', '622', '', '', '', '', '', '', '', '', null, null, '', null, '1000.000', '20160622001');
INSERT INTO `mod_material_in` VALUES ('26', '41', '10', 'WZ1606RK00022', '911', '', 'IIIIIIIII', '', '', '', '', '', '', '', '', null, null, '', '50.000', '100.000', '20160622002');
INSERT INTO `mod_material_in` VALUES ('27', '44', '10', 'WZ1606RK00024', '110', '', 'OOOO', '', '', '', '', '', '', '', '', null, null, '', null, '10.000', '20160622003');
INSERT INTO `mod_material_in` VALUES ('28', '51', '10', '5555', 'wz20001', '3366', '物资2', '4444', '6666', '7777', 'youngsun', '天天', '12343223454', '红、绿', '台', '500.00', '2018-06-30', '补不补', '50.000', '0.000', '20160801001');
INSERT INTO `mod_material_in` VALUES ('29', '52', '10', 'G9003', 'ck00001', '2-208', '物资3', '9001', 'ERP002', 'ERP002-c', '晟能', '李梅', '15645678945', '大号', '个', '678.00', '2018-06-22', '辣辣', '100.000', '540.000', '20160802001');
INSERT INTO `mod_material_in` VALUES ('30', '53', '9', '1234', 'asdfasdf', '', '物资1', '', '', '', '', '', '', '', '', null, null, '', null, '100.000', '20160809001');
INSERT INTO `mod_material_in` VALUES ('31', '54', '9', '88933', 'wz10001', '3366', '物资1', '9001', '898989', '989898', 'toyo', '惠芬', '153456789123', '19*16*10', '个', '70.00', '2018-06-27', '啦啦啦啦', '10.000', '12.000', '20160809002');
INSERT INTO `mod_material_in` VALUES ('32', '55', '9', 'WZ1608RK00001', '112', '', '123123', '', '', '', '', '', '', '', '', null, null, '', null, '12.000', '20160809003');
INSERT INTO `mod_material_in` VALUES ('33', '56', '9', 'WZ1608RK00002', '112', '', '121313123', '', '', '', '', '', '', '', '', null, null, '', null, '10.000', '20160809003');
INSERT INTO `mod_material_in` VALUES ('34', '57', '9', '201608', '123', '', 'HHHHasdf', '', '', '', '', '', '', '', '', null, null, '', null, '12.000', '20160810001');
INSERT INTO `mod_material_in` VALUES ('35', '58', '10', '201608', '321', '', '312asdf', '', '', '', '', '', '', '', '', null, null, '', null, '10.000', '20160810001');
INSERT INTO `mod_material_in` VALUES ('36', '57', '9', null, '123', '', 'HHHHasdf', '', '', '', '', '', '', '', '', null, null, '', null, '15.000', '20160810002');
INSERT INTO `mod_material_in` VALUES ('37', '59', '11', '201608', '123', '', 'HHHHasdf', '', '', '', '', '', '', '', '', null, null, '', null, '22.000', '20160810002');

-- ----------------------------
-- Table structure for `mod_material_move`
-- ----------------------------
DROP TABLE IF EXISTS `mod_material_move`;
CREATE TABLE `mod_material_move` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `materialID` int(11) NOT NULL COMMENT '关联物资ID',
  `storeID` int(10) NOT NULL COMMENT '目标仓库',
  `comeStoreID` int(10) DEFAULT NULL COMMENT '来源仓库',
  `comeMaterialID` int(10) DEFAULT NULL COMMENT '来源物资ID',
  `moveformID` int(11) NOT NULL COMMENT '移库ID',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号',
  `goodsCode` varchar(20) NOT NULL COMMENT '移库时的物资编号',
  `extendCode` varchar(20) DEFAULT NULL COMMENT '扩展码',
  `goodsName` varchar(255) DEFAULT NULL COMMENT '物资描述',
  `factory` varchar(50) DEFAULT NULL COMMENT '厂家',
  `standard` varchar(255) DEFAULT NULL COMMENT '规格',
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `price` double(20,2) DEFAULT NULL COMMENT '单价',
  `number` double(11,3) NOT NULL COMMENT '移库数量',
  `minCount` double(20,3) DEFAULT NULL COMMENT '移库时的预警值',
  `validityDate` date DEFAULT NULL COMMENT '有效期',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `workCode` varchar(50) DEFAULT NULL,
  `erpLL` varchar(50) DEFAULT NULL,
  `erpCK` varchar(50) DEFAULT NULL,
  `factory_contact` varchar(100) DEFAULT NULL,
  `factory_tel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_material_move
-- ----------------------------
INSERT INTO `mod_material_move` VALUES ('1', '4', '11', null, null, '1', 'G9002', 'ck00002', '*iji', '物资4', '京东', '橡胶', '米', '1909.00', '50.000', '200.000', '0000-00-00', 'oooooo', '9002', 'LL2016-05', 'LL2016', 'Jack', '15855834860');
INSERT INTO `mod_material_move` VALUES ('2', '9', '11', null, null, '1', '8891', 'dl002', '3366', '物资1', 'toyo', '19*16*10', '个', '70.00', '1.639', '10.000', '2018-06-27', '啦啦啦啦', '9001', '898989', '989898', '惠芬', '153456789123');
INSERT INTO `mod_material_move` VALUES ('3', '24', '9', null, null, '2', 'WZ1606RK00014', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('7', '17', '11', null, null, '6', 'WZ1606RK00005', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('8', '18', '9', null, null, '7', 'WZ1606RK00006', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('9', '23', '9', null, null, '8', 'WZ1606RK00013', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('10', '30', '9', null, null, '9', 'WZ1606RK000012', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('11', '31', '9', null, null, '10', 'WZ1606RK00010', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('12', '32', '9', null, null, '11', 'WZ1606RK00009', '11111', '', '111', '', '', '', null, '5.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('13', '33', '9', null, null, '12', 'WZ1606RK00007', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('14', '33', '10', null, null, '14', 'WZ1606RK00007', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('15', '35', '10', null, null, '15', '8894', 'wz10001', '3366', '物资1', 'toyo', '19*16*10', '个', '70.00', '6.000', '10.000', '2018-06-27', '啦啦啦啦', '9001', '898989', '989898', '惠芬', '153456789123');
INSERT INTO `mod_material_move` VALUES ('16', '11', '10', '9', null, '16', '8894', 'wz10001', '3366', '物资1', 'toyo', '19*16*10', '个', '70.00', '5.000', '10.000', '2018-06-27', '啦啦啦啦', '9001', '898989', '989898', '惠芬', '153456789123');
INSERT INTO `mod_material_move` VALUES ('17', '36', '11', '10', null, '17', '3366', 'wz20001', '3366', '物资2', 'youngsun', '红、绿', '台', '500.00', '10.000', '50.000', '2018-06-30', '补不补', '9908', '1515151515', '4545454545', '天天', '12343223454');
INSERT INTO `mod_material_move` VALUES ('18', '36', '10', '11', null, '18', '3366', 'wz20001', '3366', '物资2', 'youngsun', '红、绿', '台', '500.00', '5.000', '50.000', '2018-06-30', '补不补', '9908', '1515151515', '4545454545', '天天', '12343223454');
INSERT INTO `mod_material_move` VALUES ('19', '38', '10', '9', null, '19', 'WZ1606RK00020', '622', '', '622', '', '', '', null, '500.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('20', '38', '9', '10', null, '20', 'WZ1606RK00020', '622', '', '622', '', '', '', null, '500.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('21', '39', '9', '10', null, '21', 'G9002', 'ck00001', '2-208', '物资3', '晟能', '大号', '个', '678.00', '540.000', '100.000', '2018-06-22', '辣辣', '9001', 'ERP002', 'ERP002-c', '李梅', '15645678945');
INSERT INTO `mod_material_move` VALUES ('22', '39', '10', '9', null, '22', 'G9002', 'ck00001', '2-208', '物资3', '晟能', '大号', '个', '678.00', '540.000', '100.000', '2018-06-22', '辣辣', '9001', 'ERP002', 'ERP002-c', '李梅', '15645678945');
INSERT INTO `mod_material_move` VALUES ('23', '40', '9', '10', '2', '23', '3366', 'wz20001', '3366', '物资2', 'youngsun', '红、绿', '台', '500.00', '75.000', '50.000', '2018-06-30', '补不补', '9908', '1515151515', '4545454545', '天天', '12343223454');
INSERT INTO `mod_material_move` VALUES ('24', '42', '11', '10', '41', '24', 'WZ1606RK00022', '911', '', 'IIIIIIIII', '', '', '', null, '100.000', '50.000', null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('25', '42', '10', '11', '42', '25', 'WZ1606RK00022', '911', '', 'IIIIIIIII', '', '', '', null, '100.000', '50.000', null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('26', '43', '9', '10', '4', '26', 'G9002', 'ck00002', '*iji', '物资4', '京东', '橡胶', '米', '1909.00', '741.000', '200.000', '0000-00-00', 'oooooo', '9002', 'LL2016-05', 'LL2016', 'Jack', '15855834860');
INSERT INTO `mod_material_move` VALUES ('27', '4', '10', '9', '43', '27', 'G9002', 'ck00002', '*iji', '物资4', '京东', '橡胶', '米', '1909.00', '741.000', '200.000', '0000-00-00', 'oooooo', '9002', 'LL2016-05', 'LL2016', 'Jack', '15855834860');
INSERT INTO `mod_material_move` VALUES ('28', '41', '11', '10', '41', '28', 'WZ1606RK00022', '911', '', 'IIIIIIIII', '', '', '', null, '100.000', '50.000', null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('29', '45', '11', '10', '44', '29', 'WZ1606RK00024', '110', '', 'OOOO', '', '', '', null, '10.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('30', '45', '10', '11', '45', '30', 'WZ1606RK00024', '110', '', 'OOOO', '', '', '', null, '10.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('31', '46', '9', '10', '44', '31', 'WZ1606RK00024', '110', '', 'OOOO', '', '', '', null, '10.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('32', '47', '11', '10', '15', '32', 'WZ1606RK000034', '11111', '', '111', '', '', '', null, '15.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('33', '48', '10', '9', '8', '33', '8890', 'dl001', '3366', '物资1', 'toyo', '19*16*10', '个', '70.00', '3.000', '10.000', '2018-06-27', '啦啦啦啦', '9001', '898989', '989898', '惠芬', '153456789123');
INSERT INTO `mod_material_move` VALUES ('34', '49', '9', '10', '16', '34', 'WZ1606RK00056', '11111', '', '111', '', '', '', null, '5.000', null, null, '', '', '', '', '', '');
INSERT INTO `mod_material_move` VALUES ('35', '11', '10', '9', '11', '35', '8894', 'wz10001', '3366', '物资1', 'toyo', '19*16*10', '个', '70.00', '5.000', '10.000', '2018-06-27', '啦啦啦啦', '9001', '898989', '989898', '惠芬', '153456789123');
INSERT INTO `mod_material_move` VALUES ('36', '50', '11', '9', '34', '36', 'PC-20160010', '0010', '890312', 'CTY', '中国', 'blue', '个', '18.90', '5.000', '100.000', '2019-06-26', '入库，移库', 'BH-0016', '7781230', '1230988', '系大大', '1239090909');

-- ----------------------------
-- Table structure for `mod_move_form`
-- ----------------------------
DROP TABLE IF EXISTS `mod_move_form`;
CREATE TABLE `mod_move_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storeID` tinyint(4) NOT NULL,
  `moveFormCode` varchar(20) NOT NULL COMMENT '移库单号',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次编号',
  `date` date NOT NULL COMMENT '移库时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `del` enum('1','0') NOT NULL DEFAULT '0' COMMENT '0:未删，1：已删',
  `glPro` varchar(50) DEFAULT NULL,
  `glProCode` varchar(50) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL COMMENT '附件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_move_form
-- ----------------------------
INSERT INTO `mod_move_form` VALUES ('1', '11', '20160614001', '', '2016-06-14', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('2', '9', '20160615001', '', '2016-06-15', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('6', '11', '20160615002', '', '2016-06-15', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('7', '9', '20160615003', '', '2016-06-15', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('8', '9', '20160616001', '', '2016-06-16', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('9', '9', '20160616002', '', '2016-06-16', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('10', '9', '20160616003', '', '2016-06-16', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('11', '9', '20160616004', '', '2016-06-16', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('12', '9', '20160617001', '', '2016-06-17', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('14', '10', '20160617002', '', '2016-06-17', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('15', '10', '20160622001', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('16', '10', '20160622002', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('17', '11', '20160622003', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('18', '10', '20160622004', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('19', '10', '20160622005', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('20', '9', '20160622006', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('21', '9', '20160622007', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('22', '10', '20160622008', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('23', '9', '20160622009', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('24', '11', '20160622010', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('25', '10', '20160622011', '', '2016-06-22', '', '0', null, null, ',upload/move_from_pic/25_1.jpg');
INSERT INTO `mod_move_form` VALUES ('26', '9', '20160622012', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('27', '10', '20160622013', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('28', '11', '20160622014', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('29', '11', '20160622015', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('30', '10', '20160622016', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('31', '9', '20160622017', '', '2016-06-22', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('32', '11', '20160624001', '', '2016-06-24', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('33', '10', '20160628001', '', '2016-06-28', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('34', '9', '20160628002', '', '2016-06-28', '', '0', null, null, null);
INSERT INTO `mod_move_form` VALUES ('35', '10', '20160628003', '', '2016-06-28', '', '0', null, null, ',upload/move_from_pic/35_1.jpg');
INSERT INTO `mod_move_form` VALUES ('36', '11', '20160628004', '', '2016-06-28', '', '0', null, null, ',upload/move_from_pic/36_1.jpg,upload/move_from_pic/36_3.jpg,upload/move_from_pic/36_8.jpg,upload/move_from_pic/36_9.jpg');

-- ----------------------------
-- Table structure for `mod_preflood_in`
-- ----------------------------
DROP TABLE IF EXISTS `mod_preflood_in`;
CREATE TABLE `mod_preflood_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mID` int(11) NOT NULL COMMENT '防汛物资ID',
  `bzID` int(11) NOT NULL COMMENT '班组ID',
  `num` int(11) DEFAULT NULL COMMENT '入库数量',
  `projectCode` varchar(100) DEFAULT NULL COMMENT '项目编号',
  `projectName` varchar(255) DEFAULT NULL COMMENT '项目名称',
  `workCode` varchar(50) DEFAULT NULL COMMENT '工单号',
  `erpLL` varchar(50) DEFAULT NULL COMMENT 'ERP领料单',
  `file` longtext COMMENT '附件',
  `state` enum('scrap','send','normal') NOT NULL DEFAULT 'normal' COMMENT '状态：scrap报废，send送修，normal正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_preflood_in
-- ----------------------------
INSERT INTO `mod_preflood_in` VALUES ('1', '1', '1', '10', '20160921001', '抢修沿塘变', '0001', '1515', 'xxxx', 'normal');
INSERT INTO `mod_preflood_in` VALUES ('2', '1', '2', '5', '20160921002', '抢修沿塘变', '0002', '1515', 'xxxx', 'normal');
INSERT INTO `mod_preflood_in` VALUES ('3', '1', '1', '8', '20160921002', '抢修锡山变', '0003', '1615', 'xxxx', 'normal');
INSERT INTO `mod_preflood_in` VALUES ('4', '1', '3', '2', '20160921003', '抢修濒湖变', '0009', '2015', 'xxx', 'normal');

-- ----------------------------
-- Table structure for `mod_preflood_info`
-- ----------------------------
DROP TABLE IF EXISTS `mod_preflood_info`;
CREATE TABLE `mod_preflood_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) NOT NULL COMMENT '分类名称',
  `name` varchar(255) NOT NULL COMMENT '物资名称',
  `price` double(10,2) DEFAULT NULL COMMENT '单价',
  `unit` varchar(20) DEFAULT NULL COMMENT '单位',
  `standard` varchar(100) DEFAULT NULL COMMENT '规格型号',
  `jsgf` varchar(255) DEFAULT NULL COMMENT '技术规范',
  `pzlevel` varchar(100) DEFAULT NULL COMMENT '配置级别',
  `configure` varchar(255) DEFAULT NULL COMMENT '配置标准',
  `factory` varchar(255) DEFAULT NULL COMMENT '厂家',
  `bh` varchar(50) DEFAULT NULL COMMENT '出厂编号',
  `contact` varchar(100) DEFAULT NULL COMMENT '联系人',
  `tel` varchar(100) DEFAULT NULL COMMENT '联系方式',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_preflood_info
-- ----------------------------
INSERT INTO `mod_preflood_info` VALUES ('1', '个人防护用品', '雨靴', '20.00', '双', 'xxxxx', 'xxxxx', '工区', '1件/人', 'asdfasdf', '110201', '王', '11111', '输变配通用');

-- ----------------------------
-- Table structure for `mod_preflood_need`
-- ----------------------------
DROP TABLE IF EXISTS `mod_preflood_need`;
CREATE TABLE `mod_preflood_need` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mID` int(11) NOT NULL COMMENT '防汛物资id',
  `bzID` int(11) NOT NULL COMMENT '班组ID',
  `needNum` int(11) NOT NULL COMMENT '需求数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_preflood_need
-- ----------------------------
INSERT INTO `mod_preflood_need` VALUES ('1', '1', '1', '12');
INSERT INTO `mod_preflood_need` VALUES ('2', '1', '2', '4');
INSERT INTO `mod_preflood_need` VALUES ('3', '1', '3', '6');
INSERT INTO `mod_preflood_need` VALUES ('4', '1', '4', '2');

-- ----------------------------
-- Table structure for `mod_receive_form`
-- ----------------------------
DROP TABLE IF EXISTS `mod_receive_form`;
CREATE TABLE `mod_receive_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storeID` int(10) NOT NULL COMMENT '仓库ID',
  `userID` int(10) NOT NULL,
  `formCode` varchar(20) NOT NULL COMMENT '领料单号',
  `nature` enum('qx','dx') NOT NULL COMMENT 'qx:抢修；dx:大修',
  `outTime` date DEFAULT NULL COMMENT '发料时间',
  `glPro` varchar(50) DEFAULT NULL COMMENT '项目名称',
  `glProCode` varchar(20) DEFAULT NULL COMMENT '项目编号',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号（该字段已作废）',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `pic` longtext COMMENT '附件存放地址(预算封面，领料单照片)',
  `state` enum('tg','zf','sh') NOT NULL DEFAULT 'sh' COMMENT 'sh:审核;zf:作废;tg:通过;',
  `opinion` varchar(255) DEFAULT NULL COMMENT '作废原因',
  `date` date NOT NULL,
  `bz` varchar(100) DEFAULT NULL COMMENT '领料人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_receive_form
-- ----------------------------
INSERT INTO `mod_receive_form` VALUES ('1', '9', '12', '20160613001', 'qx', null, '59595', '', '', '', null, 'tg', null, '2016-06-13', null);
INSERT INTO `mod_receive_form` VALUES ('2', '9', '12', '20160613002', 'qx', null, '654581', '', null, '', null, 'tg', null, '2016-06-13', null);
INSERT INTO `mod_receive_form` VALUES ('3', '9', '13', '20160614001', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('4', '9', '13', '20160614002', 'qx', null, '', '', null, 'banzu2', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('5', '9', '12', '20160614003', 'qx', null, '', '', null, '111', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('6', '9', '12', '20160614004', 'qx', null, '', '', null, '11111', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('7', '9', '12', '20160614005', 'qx', null, '', '', null, 'tuiliao', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('8', '9', '12', '20160614006', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('9', '10', '14', '20160614007', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('10', '10', '14', '20160614008', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('11', '10', '14', '20160614009', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('12', '10', '14', '20160614010', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('13', '10', '14', '20160614011', 'dx', null, '', '', null, '', null, 'tg', null, '2016-06-14', null);
INSERT INTO `mod_receive_form` VALUES ('14', '9', '12', '20160615001', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-15', null);
INSERT INTO `mod_receive_form` VALUES ('15', '9', '12', '20160621001', 'qx', null, '', '', null, '', null, 'sh', null, '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('16', '9', '12', '20160621002', 'dx', null, '', '', null, '', null, 'sh', null, '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('17', '9', '12', '20160621003', 'qx', null, '', '', null, '', null, 'zf', 'sadfas5d5a1sdf', '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('18', '9', '12', '20160621004', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('19', '9', '12', '20160621005', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('20', '9', '12', '20160621006', 'qx', null, '', '', null, '', null, 'zf', '', '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('21', '9', '12', '20160621007', 'qx', null, '', '', null, '', null, 'tg', null, '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('22', '9', '12', '20160621008', 'qx', null, '', '', null, '', null, 'zf', '', '2016-06-21', null);
INSERT INTO `mod_receive_form` VALUES ('23', '9', '12', '20160628001', 'dx', null, '', '', null, '', null, 'zf', '', '2016-06-28', '333');
INSERT INTO `mod_receive_form` VALUES ('24', '9', '12', '20160628002', 'qx', null, '', '', null, '', ',upload/receive_pic/24_2.jpg,upload/receive_pic/24_3.jpg', 'tg', null, '2016-06-28', '4564');
INSERT INTO `mod_receive_form` VALUES ('25', '9', '12', '20160628003', 'qx', null, '', '', null, '', ',upload/receive_pic/25_2.jpg,upload/receive_pic/25_3.jpg,upload/receive_pic/25_4.jpg', 'tg', null, '2016-06-28', '');
INSERT INTO `mod_receive_form` VALUES ('26', '9', '12', '20160629001', 'qx', null, '', '', null, '', null, 'zf', '', '2016-06-29', '二班');
INSERT INTO `mod_receive_form` VALUES ('27', '9', '12', '20160829001', 'qx', null, '', '', null, '', null, 'zf', '', '2016-08-29', '一班');
INSERT INTO `mod_receive_form` VALUES ('28', '9', '12', '20160829002', 'qx', null, '', '', null, '', null, 'zf', '', '2016-08-29', '二班');
INSERT INTO `mod_receive_form` VALUES ('29', '9', '12', '20160906001', 'qx', null, '', '', null, '', null, 'zf', '', '2016-09-06', '三班');
INSERT INTO `mod_receive_form` VALUES ('30', '9', '12', '20160906002', 'qx', null, '', '', null, '', null, 'sh', null, '2016-09-06', 'bz1');
INSERT INTO `mod_receive_form` VALUES ('31', '9', '12', '20160906003', 'dx', '2016-09-06', '', '', null, '', ',upload/receive_pic/31_1.jpg,upload/receive_pic/31_2.jpg,upload/receive_pic/31_3.jpg,upload/receive_pic/31_4.xls', 'sh', null, '2016-09-06', 'bz1');

-- ----------------------------
-- Table structure for `mod_receive_form_material`
-- ----------------------------
DROP TABLE IF EXISTS `mod_receive_form_material`;
CREATE TABLE `mod_receive_form_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formID` int(11) DEFAULT NULL COMMENT '关联领料单ID',
  `materialID` int(11) DEFAULT NULL COMMENT '物资ID',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号',
  `goodsCode` varchar(20) NOT NULL COMMENT '物料编码',
  `goodsName` varchar(255) NOT NULL COMMENT '物料描述',
  `factory` varchar(50) DEFAULT NULL COMMENT '厂家',
  `extendCode` varchar(20) DEFAULT NULL COMMENT '扩展编码',
  `number` double(10,3) NOT NULL COMMENT '领用数量（请领数）',
  `sfnumber` double(10,3) DEFAULT NULL COMMENT '实发数',
  `applyNum` double(10,3) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `price` double(20,2) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_receive_form_material
-- ----------------------------
INSERT INTO `mod_receive_form_material` VALUES ('1', '1', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '2.000', null, '0.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('2', '1', '1', '8890', 'wz10001', '物资1', 'toyo', '3366', '2.000', null, '0.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('3', '2', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '2.000', null, '0.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('4', '2', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '2.000', null, '0.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('5', '3', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '5.000', null, '5.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('7', '4', '10', '8893', 'wz10001', '物资1', 'toyo', '3366', '6.000', null, '3.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('8', '5', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '2.000', null, '0.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('9', '5', '9', '8891', 'dl002', '物资1', 'toyo', '3366', '2.000', null, '0.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('10', '6', '9', '8891', 'dl002', '物资1', 'toyo', '3366', '3.000', null, '0.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('11', '6', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '2.000', null, '2.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('12', '7', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '10.000', null, '8.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('13', '8', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '5.000', null, '0.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('14', '9', '14', 'HP001', '777777', 'CCCCC', '', '', '10.000', null, '0.000', '米', '160.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('15', '10', '14', 'HP001', '777777', 'CCCCC', '', '', '10.000', null, '0.000', '米', '160.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('16', '11', '14', 'HP001', '777777', 'CCCCC', '', '', '2.000', null, '0.000', '米', '160.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('17', '12', '14', 'HP001', '777777', 'CCCCC', '', '', '2.000', null, '0.000', '米', '160.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('18', '13', '14', 'HP001', '777777', 'CCCCC', '', '', '2.000', null, '0.000', '米', '160.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('19', '14', '9', '8891', 'dl002', '物资1', 'toyo', '3366', '21.000', null, '19.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('20', '15', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '1.000', null, '1.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('21', '16', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '4.000', null, '4.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('24', '16', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '1.000', null, '1.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('25', '17', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '1.000', null, '1.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('26', '18', '10', '8893', 'wz10001', '物资1', 'toyo', '3366', '2.257', null, '2.515', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('27', '19', '30', 'WZ1606RK000012', '11111', '111', '', '', '10.000', null, '3.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('28', '20', '25', 'WZ1606RK00014', '11111', '111', '', '', '5.000', null, '4.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('29', '21', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '10.000', null, '5.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('30', '22', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '5.000', null, '5.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('31', '23', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '2.000', null, '2.000', '个', '70.00', '给到2个，以后再给');
INSERT INTO `mod_receive_form_material` VALUES ('32', '24', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '7.000', '7.000', '7.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('33', '25', '10', '8893', 'wz10001', '物资1', 'toyo', '3366', '12.485', null, '12.485', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('34', '25', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '15.000', null, '15.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('35', '25', '31', 'WZ1606RK00010', '11111', '111', '', '', '14.000', null, '14.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('36', '25', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '22.000', null, '22.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('37', '25', '1', '8890', 'wz10001', '物资1', 'toyo', '3366', '12.000', null, '12.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('38', '26', '30', 'WZ1606RK000012', '11111', '111', '', '', '16.000', '16.000', '16.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('39', '27', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '2.744', '2.744', '2.744', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('40', '28', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '1.125', '1.125', '1.125', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('41', '29', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '2.000', '2.000', '2.000', '', null, null);
INSERT INTO `mod_receive_form_material` VALUES ('42', '30', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '2.000', '2.000', '2.000', '个', '70.00', null);
INSERT INTO `mod_receive_form_material` VALUES ('43', '31', '25', 'WZ1606RK00014', '11111', '111', '', '', '1.000', '1.000', '1.000', '', null, null);

-- ----------------------------
-- Table structure for `mod_return_form`
-- ----------------------------
DROP TABLE IF EXISTS `mod_return_form`;
CREATE TABLE `mod_return_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storeID` int(10) NOT NULL COMMENT '仓库ID',
  `userID` int(10) NOT NULL,
  `formCode` varchar(20) NOT NULL COMMENT '领料单号',
  `nature` enum('qx','dx') NOT NULL COMMENT 'qx:抢修；dx:大修',
  `outTime` time DEFAULT NULL COMMENT '发料时间',
  `glPro` varchar(50) DEFAULT NULL COMMENT '项目名称',
  `glProCode` varchar(20) DEFAULT NULL COMMENT '项目编号',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `pic` longtext COMMENT '附件存放地址(预算封面，领料单照片)',
  `state` enum('tg','zf','sh') NOT NULL DEFAULT 'sh' COMMENT 'sh:审核;zf:作废;tg:通过;',
  `opinion` varchar(255) DEFAULT NULL COMMENT '作废原因',
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_return_form
-- ----------------------------
INSERT INTO `mod_return_form` VALUES ('1', '9', '12', '20160613001', 'qx', null, 'asdfrtgy6798', '', 'TL160600001', '', null, 'tg', null, '2016-06-13');
INSERT INTO `mod_return_form` VALUES ('2', '9', '12', '20160614001', 'dx', null, '', '', 'TL160600002', '', null, 'tg', 'asdfasdf', '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('3', '9', '13', '20160614002', 'qx', null, '', '', 'TL160600003', '', null, 'tg', '151515', '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('4', '9', '12', '20160614003', 'dx', null, '', '', 'TL160600004', '', null, 'zf', 'zuofei', '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('5', '9', '12', '20160614004', 'qx', null, '', '', 'TL160600005', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('6', '9', '12', '20160614005', 'qx', null, '', '', 'TL160600006', 'dfdf', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('7', '9', '12', '20160614006', 'qx', null, '', '', 'TL160600007', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('8', '10', '14', '20160614007', 'dx', null, '', '', 'TL160600008', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('9', '10', '14', '20160614008', 'qx', null, '', '', 'TL160600009', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('10', '10', '14', '20160614009', 'qx', null, '', '', 'TL160600010', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('11', '10', '14', '20160614010', 'dx', null, '', '', 'TL160600011', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('12', '10', '14', '20160614011', 'dx', null, '', '', 'TL160600012', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('13', '10', '14', '20160614012', 'dx', null, '', '', 'TL160600013', '', null, 'tg', null, '2016-06-14');
INSERT INTO `mod_return_form` VALUES ('14', '9', '12', '20160621001', 'qx', null, '', '', 'TL160600014', '', null, 'zf', '', '2016-06-21');
INSERT INTO `mod_return_form` VALUES ('15', '9', '12', '20160621002', 'qx', null, '', '', 'TL160600015', '', null, 'tg', null, '2016-06-21');
INSERT INTO `mod_return_form` VALUES ('16', '9', '12', '20160621003', 'qx', null, '', '', 'TL160600016', '', null, 'zf', '', '2016-06-21');
INSERT INTO `mod_return_form` VALUES ('17', '9', '12', '20160628001', 'qx', null, '', '', 'TL160600017', '', ',upload/return_pic/17_5.jpg,upload/return_pic/17_6.jpg', 'zf', 'asdfasdf', '2016-06-28');
INSERT INTO `mod_return_form` VALUES ('18', '9', '12', '20160628002', 'qx', null, '', '', 'TL160600018', '', null, 'sh', null, '2016-06-28');

-- ----------------------------
-- Table structure for `mod_return_form_material`
-- ----------------------------
DROP TABLE IF EXISTS `mod_return_form_material`;
CREATE TABLE `mod_return_form_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formID` int(11) DEFAULT NULL COMMENT '关联领料单ID',
  `materialID` int(11) DEFAULT NULL COMMENT '物资ID',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号',
  `goodsCode` varchar(20) NOT NULL COMMENT '物料编码',
  `goodsName` varchar(255) NOT NULL COMMENT '物料描述',
  `factory` varchar(50) DEFAULT NULL COMMENT '厂家',
  `extendCode` varchar(20) DEFAULT NULL COMMENT '扩展编码',
  `number` double(10,3) NOT NULL COMMENT '领用数量',
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `price` double(20,2) DEFAULT NULL,
  `receiveFormCode` varchar(20) DEFAULT NULL COMMENT '关联领料单编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_return_form_material
-- ----------------------------
INSERT INTO `mod_return_form_material` VALUES ('1', '1', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '2.000', '', null, null);
INSERT INTO `mod_return_form_material` VALUES ('2', '1', '1', '8890', 'wz10001', '物资1', 'toyo', '3366', '2.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('3', '1', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '2.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('4', '2', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '1.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('5', '3', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '1.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('6', '4', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '2.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('7', '5', '8', '8890', 'dl001', '物资1', 'toyo', '3366', '2.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('8', '5', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '5.000', '', null, null);
INSERT INTO `mod_return_form_material` VALUES ('9', '6', '9', '8891', 'dl002', '物资1', 'toyo', '3366', '2.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('10', '6', '9', '8891', 'dl002', '物资1', 'toyo', '3366', '3.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('11', '7', '11', '8894', 'wz10001', '物资1', 'toyo', '3366', '2.000', '个', '70.00', null);
INSERT INTO `mod_return_form_material` VALUES ('12', '8', '14', 'HP001', '777777', 'CCCCC', '', '', '10.000', '米', '160.00', null);
INSERT INTO `mod_return_form_material` VALUES ('13', '9', '14', 'HP001', '777777', 'CCCCC', '', '', '10.000', '米', '160.00', null);
INSERT INTO `mod_return_form_material` VALUES ('14', '10', '14', 'HP001', '777777', 'CCCCC', '', '', '2.000', '米', '160.00', null);
INSERT INTO `mod_return_form_material` VALUES ('15', '11', '14', 'HP001', '777777', 'CCCCC', '', '', '2.000', '米', '160.00', null);
INSERT INTO `mod_return_form_material` VALUES ('16', '12', '14', 'HP001', '777777', 'CCCCC', '', '', '2.000', '米', '160.00', null);
INSERT INTO `mod_return_form_material` VALUES ('17', '13', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '2.000', '', null, null);
INSERT INTO `mod_return_form_material` VALUES ('18', '14', '30', 'WZ1606RK000012', '11111', '111', '', '', '2.000', '', null, null);
INSERT INTO `mod_return_form_material` VALUES ('19', '15', '30', 'WZ1606RK000012', '11111', '111', '', '', '2.000', '', null, '20160621005');
INSERT INTO `mod_return_form_material` VALUES ('20', '16', '5', 'WZ1606RK00001', 'bug0001', 'BUG2920', '', '', '2.000', '', null, '20160614005');
INSERT INTO `mod_return_form_material` VALUES ('21', '17', '9', '8891', 'dl002', '物资1', 'toyo', '3366', '1.000', '个', '70.00', '20160615001');
INSERT INTO `mod_return_form_material` VALUES ('22', '18', '9', '8891', 'dl002', '物资1', 'toyo', '3366', '2.000', '个', '70.00', '20160615001');

-- ----------------------------
-- Table structure for `mod_scrap_form`
-- ----------------------------
DROP TABLE IF EXISTS `mod_scrap_form`;
CREATE TABLE `mod_scrap_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storeID` int(11) NOT NULL COMMENT '仓库ID',
  `formCode` varchar(20) NOT NULL COMMENT '表单编号',
  `bID` int(11) NOT NULL COMMENT '班组ID,记录谁提交的',
  `zID` int(11) NOT NULL COMMENT '专职ID,记录交给哪个专职处理',
  `projectCode` varchar(50) NOT NULL COMMENT '工程编号',
  `projectName` varchar(255) NOT NULL COMMENT '工程名称',
  `opinion` varchar(255) DEFAULT NULL COMMENT '技术鉴定意见',
  `date` date NOT NULL COMMENT '提交日期',
  `state` enum('2','1','0') NOT NULL DEFAULT '0' COMMENT '状态：0：审批；1：退回；2:通过；',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_scrap_form
-- ----------------------------
INSERT INTO `mod_scrap_form` VALUES ('1', '9', '20160614001', '4', '10', '9090', '8090', '', '2016-06-14', '2');
INSERT INTO `mod_scrap_form` VALUES ('2', '9', '20160614002', '4', '10', '9098', '890--aodfj9', 'bujige', '2016-06-14', '1');
INSERT INTO `mod_scrap_form` VALUES ('3', '9', '20160715001', '4', '4', '111', '报废', '', '2016-07-15', '2');

-- ----------------------------
-- Table structure for `mod_scrap_form_material`
-- ----------------------------
DROP TABLE IF EXISTS `mod_scrap_form_material`;
CREATE TABLE `mod_scrap_form_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formID` int(11) NOT NULL COMMENT '关联报废表ID',
  `goodsCode` varchar(20) NOT NULL COMMENT '物资编号',
  `goodsName` varchar(255) NOT NULL COMMENT '物资名称',
  `standard` varchar(255) DEFAULT NULL COMMENT '规格型号',
  `unit` varchar(10) DEFAULT NULL COMMENT '计量单位',
  `designNum` double(10,3) DEFAULT NULL COMMENT '设计折旧数量',
  `number` double(10,3) NOT NULL COMMENT '实退数量',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_scrap_form_material
-- ----------------------------
INSERT INTO `mod_scrap_form_material` VALUES ('1', '1', '151515', '7777', '', '', null, '15.000', '');
INSERT INTO `mod_scrap_form_material` VALUES ('2', '1', '66666', '66666', '', '', null, '66.000', '');
INSERT INTO `mod_scrap_form_material` VALUES ('3', '2', '118282', 'bububu', '', '', null, '8.000', '');
INSERT INTO `mod_scrap_form_material` VALUES ('4', '2', '787878', 'hHHh', '', '', null, '20.000', '');
INSERT INTO `mod_scrap_form_material` VALUES ('5', '3', 'bf001', '报废1', '123-1', '个', '100.000', '100.000', '报废');

-- ----------------------------
-- Table structure for `mod_store`
-- ----------------------------
DROP TABLE IF EXISTS `mod_store`;
CREATE TABLE `mod_store` (
  `storeID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentID` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父仓库ID',
  `storeName` varchar(50) NOT NULL COMMENT '仓库名称',
  PRIMARY KEY (`storeID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='仓库';

-- ----------------------------
-- Records of mod_store
-- ----------------------------
INSERT INTO `mod_store` VALUES ('9', '0', '配电工区仓库');
INSERT INTO `mod_store` VALUES ('10', '9', '测试网点仓库1');
INSERT INTO `mod_store` VALUES ('11', '9', '测试网点仓库2');

-- ----------------------------
-- Table structure for `mod_task_book`
-- ----------------------------
DROP TABLE IF EXISTS `mod_task_book`;
CREATE TABLE `mod_task_book` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bookCode` varchar(20) NOT NULL COMMENT '任务书编号',
  `date` date DEFAULT NULL COMMENT '施工日期',
  `zrdw` varchar(50) DEFAULT NULL COMMENT '责任单位',
  `zrbz` varchar(50) DEFAULT NULL COMMENT '责任班组',
  `phdw` varchar(50) DEFAULT NULL COMMENT '配合单位',
  `line` varchar(100) DEFAULT NULL COMMENT '线路及设备名称',
  `content` longtext COMMENT '消缺内容',
  `state` enum('adopt','back','examine','edit') NOT NULL COMMENT '状态：通过，退回，审核，编辑',
  `uID` int(11) NOT NULL COMMENT '用户ID',
  `opinion` varchar(255) DEFAULT NULL COMMENT '原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_task_book
-- ----------------------------
INSERT INTO `mod_task_book` VALUES ('1', '20160623001', '2016-06-15', 'asdfasdf', '二班', '架空高架线', '515151', '1.909090\n2.1234023948', 'back', '12', 'duihui ');
INSERT INTO `mod_task_book` VALUES ('2', '20160624001', '2016-06-08', '三班', '四班', '五班', '堰塘边', '1.dfadsf\n2.asdfasdf', 'adopt', '12', null);
INSERT INTO `mod_task_book` VALUES ('3', '20160704001', '2016-07-13', '二班', '三班', '四班', '架空', 'asdfadfsfd', 'back', '14', 'keneng');
INSERT INTO `mod_task_book` VALUES ('9', '20160705001', '2016-07-28', '一班', '二班', '三板', '架空高价线路', 'asdfasfd\nasf anisdn0823', 'adopt', '12', null);
INSERT INTO `mod_task_book` VALUES ('10', '20160705002', '2016-07-28', '', '', '', '', '', 'back', '12', null);
INSERT INTO `mod_task_book` VALUES ('11', '20160705003', '2016-07-05', '一班', '二班', '三班', 'asdfasdf', '1.asdfasdf\n2.asdfasdfasdf', 'adopt', '12', null);
INSERT INTO `mod_task_book` VALUES ('12', '20160705004', '2016-07-05', '1', '2', '3', 'asdf', 'asdf', 'adopt', '12', null);
INSERT INTO `mod_task_book` VALUES ('13', '20160705005', '2016-07-06', '', '', '', '', '', 'back', '12', null);
INSERT INTO `mod_task_book` VALUES ('14', '20160705006', '2016-07-28', '', '', '', '', '', 'adopt', '12', null);
INSERT INTO `mod_task_book` VALUES ('15', '20160705007', '2016-07-29', '', '', '', '', '', 'back', '12', null);
INSERT INTO `mod_task_book` VALUES ('16', '20160706001', '2016-07-26', '', '', '', '', '', 'back', '12', null);

-- ----------------------------
-- Table structure for `mod_task_book_material`
-- ----------------------------
DROP TABLE IF EXISTS `mod_task_book_material`;
CREATE TABLE `mod_task_book_material` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bookCode` varchar(20) NOT NULL COMMENT '关联任务书表',
  `batchCode` varchar(20) DEFAULT NULL COMMENT '批次号',
  `materialID` int(10) DEFAULT NULL COMMENT '物资id',
  `goodsCode` varchar(20) DEFAULT NULL COMMENT '物料编码',
  `goodsName` varchar(50) DEFAULT NULL COMMENT '物资名称',
  `standard` varchar(255) DEFAULT NULL COMMENT '规格',
  `unit` varchar(20) DEFAULT NULL COMMENT '单位',
  `price` double(20,2) DEFAULT NULL COMMENT '单价',
  `number` double(20,3) DEFAULT NULL COMMENT '数量',
  `sfnumber` double(20,3) DEFAULT NULL,
  `applyNum` double(20,3) DEFAULT NULL COMMENT '可供申请数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_task_book_material
-- ----------------------------
INSERT INTO `mod_task_book_material` VALUES ('1', '20160623001', null, null, null, '111', '111', '个', '12.99', '15.900', null, null);
INSERT INTO `mod_task_book_material` VALUES ('3', '20160624001', null, null, null, 'bububu', '', '台', '23.50', '15.000', null, null);
INSERT INTO `mod_task_book_material` VALUES ('4', '20160624001', null, null, null, 'asdf', 'bubu', '台', '78.12', '1.901', null, null);
INSERT INTO `mod_task_book_material` VALUES ('5', '20160704001', null, null, null, '802134', 'asdf', '', null, '18.000', null, null);
INSERT INTO `mod_task_book_material` VALUES ('6', '20160704001', null, null, null, 'asdbufb', 'sdfa', '', null, '41.000', null, null);
INSERT INTO `mod_task_book_material` VALUES ('7', '20160623001', null, null, null, '22', '', '', null, '13.000', null, null);
INSERT INTO `mod_task_book_material` VALUES ('8', '20160705001', '8891', '9', 'dl002', '物资1', '19*16*10', '个', '70.00', '3.000', '3.000', '3.000');
INSERT INTO `mod_task_book_material` VALUES ('9', '20160705002', 'WZ1606RK00014', '25', '11111', '111', '', '', null, '10.000', '10.000', '10.000');
INSERT INTO `mod_task_book_material` VALUES ('10', '20160705003', 'WZ1606RK00009', '32', '11111', '111', '', '', null, '5.000', '5.000', '5.000');
INSERT INTO `mod_task_book_material` VALUES ('11', '20160705003', '3366', '40', 'wz20001', '物资2', '红、绿', '台', '500.00', '5.000', '5.000', '5.000');
INSERT INTO `mod_task_book_material` VALUES ('12', '20160705004', 'WZ1606RK00056', '49', '11111', '111', '', '', null, '5.000', '5.000', '5.000');
INSERT INTO `mod_task_book_material` VALUES ('13', '20160705005', 'WZ1606RK00024', '46', '110', 'OOOO', '', '', null, '10.000', '10.000', '10.000');
INSERT INTO `mod_task_book_material` VALUES ('14', '20160705006', 'WZ1606RK00002', '6', '1', '111', '', '', null, '1.000', '1.000', '1.000');
INSERT INTO `mod_task_book_material` VALUES ('15', '20160705007', '8890', '1', 'wz10001', '物资1', '19*16*10', '个', '70.00', '10.000', '10.000', '10.000');
INSERT INTO `mod_task_book_material` VALUES ('16', '20160706001', 'WZ1606RK00024', '46', '110', 'OOOO', '', '', null, '10.000', '10.000', '10.000');

-- ----------------------------
-- Table structure for `mod_user`
-- ----------------------------
DROP TABLE IF EXISTS `mod_user`;
CREATE TABLE `mod_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loginName` varchar(16) NOT NULL COMMENT '登录名',
  `loginPassword` varchar(32) NOT NULL COMMENT '登录密码',
  `userName` varchar(20) NOT NULL COMMENT '用户姓名',
  `englishName` varchar(20) NOT NULL DEFAULT '' COMMENT '英文姓名',
  `nickName` varchar(20) NOT NULL COMMENT '昵称',
  `loginCount` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastLogin` datetime DEFAULT NULL COMMENT '最后一次登录',
  `disabled` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否禁用',
  `email` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='用户模块';

-- ----------------------------
-- Records of mod_user
-- ----------------------------
INSERT INTO `mod_user` VALUES ('1', 'admin', '123', '超级管理员', '', '1', '170', '2016-09-24 09:50:33', '', '');
INSERT INTO `mod_user` VALUES ('4', 'gqcl', '123', '工区材料管理员', '', '', '237', '2016-09-24 09:50:38', '', '');
INSERT INTO `mod_user` VALUES ('5', 'cs1', '123', '测试网点1仓管', '', '', '16', '2016-09-22 19:10:41', '', '');
INSERT INTO `mod_user` VALUES ('6', 'cs2', '123', '测试网点2仓管', '', '', '1', '2016-09-22 19:11:09', '', '');
INSERT INTO `mod_user` VALUES ('9', 'cty', '123', 'cty', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('10', 'zz1', '123', 'zz1', '', '', '14', '2016-06-14 12:57:28', '', '');
INSERT INTO `mod_user` VALUES ('11', 'zz2', '123', 'zz2', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('12', 'bz1', '123', 'bz1', '', '', '140', '2016-09-06 12:38:56', '', '');
INSERT INTO `mod_user` VALUES ('13', 'bz2', '123', 'bz2', '', '', '9', '2016-06-14 14:02:20', '', '');
INSERT INTO `mod_user` VALUES ('14', 'bz11', '123', 'bz11', '', '', '8', '2016-07-04 09:17:48', '', '');
INSERT INTO `mod_user` VALUES ('29', 's1', '123', 's1', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('30', 'v1', '123', 'v1', '', '', '1', '2016-09-22 19:11:39', '', '');
INSERT INTO `mod_user` VALUES ('31', 'v2', '123', 'v2', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('32', 'v3', '123', 'v3', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('33', 'v4', '123', 'v4', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('34', 'v5', '123', 'v5', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('36', 'v6', '123', '浏览', '', '', '4', '2016-07-25 11:05:51', '', '');
INSERT INTO `mod_user` VALUES ('38', 'v7', '123', 'yk', '', '', '0', null, '', '');
INSERT INTO `mod_user` VALUES ('39', 'll', '123', '浏览', '', '', '7', '2016-07-25 14:04:07', '', '');

-- ----------------------------
-- Table structure for `mod_user_store`
-- ----------------------------
DROP TABLE IF EXISTS `mod_user_store`;
CREATE TABLE `mod_user_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL COMMENT '用户ID',
  `storeID` varchar(20) NOT NULL COMMENT '仓库ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_user_store
-- ----------------------------
INSERT INTO `mod_user_store` VALUES ('1', '4', '9');
INSERT INTO `mod_user_store` VALUES ('2', '5', '10');
INSERT INTO `mod_user_store` VALUES ('3', '6', '11');
INSERT INTO `mod_user_store` VALUES ('4', '9', '9');
INSERT INTO `mod_user_store` VALUES ('5', '10', '9');
INSERT INTO `mod_user_store` VALUES ('6', '11', '9');
INSERT INTO `mod_user_store` VALUES ('7', '12', '9');
INSERT INTO `mod_user_store` VALUES ('8', '13', '9');
INSERT INTO `mod_user_store` VALUES ('9', '14', '10,11');
INSERT INTO `mod_user_store` VALUES ('10', '18', '10');
INSERT INTO `mod_user_store` VALUES ('14', '29', '10,11');
INSERT INTO `mod_user_store` VALUES ('15', '30', '10,11');
INSERT INTO `mod_user_store` VALUES ('16', '31', '10');
INSERT INTO `mod_user_store` VALUES ('17', '32', '11');
INSERT INTO `mod_user_store` VALUES ('18', '33', '10,11');
INSERT INTO `mod_user_store` VALUES ('19', '39', '9,10,11');

-- ----------------------------
-- View structure for `view_preflood_list`
-- ----------------------------
DROP VIEW IF EXISTS `view_preflood_list`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_preflood_list` AS select `need`.`mID` AS `mID`,`need`.`bzID` AS `bzID`,`need`.`needNum` AS `needNum`,sum(`in`.`num`) AS `nowNum` from ((`mod_preflood_need` `need` left join `mod_preflood_info` `info` on((`info`.`id` = `need`.`id`))) left join `mod_preflood_in` `in` on(((`need`.`mID` = `in`.`mID`) and (`need`.`bzID` = `in`.`bzID`)))) group by `need`.`mID`,`need`.`bzID`,`need`.`needNum`,`info`.`className`,`info`.`name` ;
