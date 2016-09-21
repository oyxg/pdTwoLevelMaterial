<?php

// 取消下面注释可以定义一个路径别名
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('problem',dirname(dirname(__FILE__)).'\modules\problem');
// 这里是 Web application 主配置，全部可写
// CWebApplication的属性可以在这里配置
return array(
        //基路径
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        //应用名称
        'name'=>'配电待建物资管理系统',
        //目标语言
        //'language'=>"zh_cn",
        //源语言
        'sourceLanguage'=>"zh_cn",
        // 预加载日志组件
        'preload'=>array('log'),

        // 自动载入模型和组件
        'import'=>array(
                'application.models.*',
                'application.components.*',
                'application.vendor.youngsun.*',
                'application.vendor.io.*',
                'application.vendor.util.*',
                'application.vendor.message.*',
                'application.vendor.http.*',
                'application.vendor.message.*',
        ),
       
        'defaultController'=>"index",
        
        //模块列表
        'modules'=>array(
        // 取消下面的注释可以启用 Gii 工具l
        'gii'=>array(
        'class'=>'system.gii.GiiModule',
        'password'=>'123',
        // 如果移除下面的选项，Gii默认只能本机访问
        'ipFilters'=>array('127.0.0.1','::1'),
        ),
        ),
        
        // 应用组件
        'components'=>array(
                //应用选项
                'ao'=>array(
                        'class'=>ApplicationOption,
                        'manageTitle'=>'',
                        'copyTitle'=>'配电待建物资管理系统',
                        'server'=>''
                ),
                //用户组件
                /*
                'user'=>array(
                    // 启用cookie基本认证
                    'allowAutoLogin'=>true,
                ),
                */
                // 取消下面注释将启用 URLs 模式
                'urlManager'=>array(
                        'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'urlSuffix'=>".html",
                        'caseSensitive'=>false,
                ),
                //数据库配置
                'db'=>array(
                        //连接字符串
                        'connectionString' => 'mysql:host=127.0.0.1;dbname=pdTwoLevelMaterial',
                        //是否打开准备模拟。默认为 false， 意味着PDO将准备使用本地预备支持，如果可用。对于某些数据
                        //库 (如 MySQL), 这将需要设置为true 以至于 PDO 能模拟该预备支持 绕过buggy本地预备支持
                        'emulatePrepare' => true,
                        //用户名
                        'username' => 'root',
                        //密码
                        'password' => 'abc112233',
                        //编码
                        'charset' => 'utf8',
                        //是否记录的值绑定到一个准备的SQL语句。 默认为 false。在开发阶段，你应该考虑设置这个属性为true
                        'enableParamLogging'=>false,
                        //正在执行的SQL语句是否启用分析。 默认为 false。这个主要 启用它主要用于开发阶段找出SQL执行的瓶颈。
                        'enableProfiling'=>false
                ),
                //错误处理
                'errorHandler'=>array(
                        // 使用 'site/error' 动作来显示出错信息
                        'errorAction'=>'error/error',
                ),

/*                //日志
                'log'=>array(
                    'class'=>'CLogRouter',
                    'routes'=>array(
                        array(
                            'class'=>'CFileLogRoute',
                            'levels'=>'error, warning',
                        ),
                        // 取消下面的注释将在web页面上显示日志信息

                        array(
                            'class'=>'CWebLogRoute',
                        ),

                    ),
                ),*/

                //RBAC
                'authManager'=>array(
                        'class'=>'CDbAuthManager',
                        'connectionID'=>'db',
                        'defaultRoles'=>array('guest'), //默认角色
                        'itemTable' => 'auth_item', //认证项表名称
                        'itemChildTable' => 'auth_item_child', //认证项父子关系
                        'assignmentTable' => 'auth_assignment', //认证项赋权关系
                ),
                'cache'=>array(
                        'class'=>'system.caching.CDbCache',
                ),
        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params'=>array(
                // this is used in contact page
                'adminEmail'=>'wutong@iyoungsun.com',
        ),
);
