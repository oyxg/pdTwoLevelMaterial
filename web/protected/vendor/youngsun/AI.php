<?php
class AI{

	//物资管理
	const C_InForm="InForm";//物资（入库）
	const C_MaterialDelete="MaterialDelete";//物资（刪除）
	const C_MaterialEdit="MaterialEdit";//物资（修改）
	const C_MaterialList="MaterialList";//物资（列表）
	const C_InFormList="InFormList";//入库单列表
	const C_MoveForm="MoveForm";//填写移库单
	const C_MoveFormList="MoveFormList";//移库单列表
	const C_Inventory="Inventory";//物资盘点

//	const C_IOGlobal="IOGlobal";//出入库（全仓记录）
//	const C_IOReportNormal="IOReportNormal";//出入库一般报表
//	const C_IOSelf="IOSelf";//出入库（本仓记录）

	//仓库
	const C_StoreAdd="StoreAdd";//仓库（添加）
	const C_StoreDelete="StoreDelete";//仓库（刪除）
	const C_StoreEdit="StoreEdit";//仓库（修改）
	const C_StoreList="StoreList";//仓库（列表）

	//用户
	const C_UserAdd="UserAdd";//用户（添加）
	const C_UserDelete="UserDelete";//用户（刪除）
	const C_UserEdit="UserEdit";//用户（修改）
	const C_UserList="UserList";//用户（列表）
	const C_UserStore="UserStore";//用户仓库（设置）

	//物资报废管理
	const C_ScrapForm="ScrapForm";//填写报废表
	const C_MyScrapForm="MyScrapForm";//我提交的报废表
	const C_UntreatedScrapForm="UntreatedScrapForm";//待处理的报废表
	const C_TreatedScrapForm="TreatedScrapForm";//已处理的报废表

	//领退料管理
	const C_ReceiveMF="ReceiveMF";//填写领料单
	const C_ReturnMF="ReturnMF";//填写退料单
	const C_MyReceiveMF="MyReceiveMF";//我提交的领料单
	const C_MyReturnMF="MyReturnMF";//我提交的退料单
	const C_UntreatedReceiveMF="UntreatedReceiveMF";//待处理的领料单
	const C_TreatedReceiveMF="TreatedReceiveMF";//已处理的领料单
	const C_UntreatedReturnMF="UntreatedReturnMF";//待处理的退料单
	const C_TreatedReturnMF="TreatedReturnMF";//已处理的退料单
    const C_ReceiveMaterialList="ReceiveMaterialList";//领料物资记录
    const C_ReturnMaterialList="ReturnMaterialList";//退料物资记录

	//配电任务书管理
	const C_TaskBook="TaskBook";//填写任务书
	const C_MyTaskBook="MyTaskBook";//我提交的任务书
	const C_UntreatedTaskBook="UntreatedTaskBook";//待处理的任务书
	const C_TreatedTaskBook="TreatedTaskBook";//已处理的任务书

	const C_Bz="Bz";//班组

	const C_PreFloodMaterialList="PreFloodMaterialList";//防汛物资列表
	const C_PreFloodMaterialInfo="PreFloodMaterialInfo";//防汛物资台账
	const C_PreFloodMaterialIn="PreFloodMaterialIn";//防汛物资入库

	/************************************任务分割线*****************************************/

	const T_Material="Material";//物资管理
	const T_Scrap="Scrap";//物资报废管理
	const T_Task="Task";//配电任务书管理
	const T_UseMaterial="UseMaterial";//领退料管理
	const T_Auth="Auth";//权限设置
	const T_Setting="Setting";//系统设置
	const T_Store="Store";//仓库
	const T_User="User";//用户
	const T_PreFloodMaterial="PreFloodMaterial";//防汛物资管理

	/************************************角色分割线*****************************************/

	const R_Admin="Admin";//管理员
	const R_Group="Group";//班组
	const R_Storer="Storer";//仓库管理员
	const R_Materialer="Materialer";//材料管理员
	const R_Major="Major";//专职
	const R_Visitor="Visitor";//游客
}