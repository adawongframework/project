<?php
/**
* 数据库配置文件
*+-----------------------------------------------------------------
* cp ./system/config/Database.php ./application/config/Database.php
*+-----------------------------------------------------------------
*/
return array(
	//默认配置
	'default'=>array(
		'driver' => 'mysql',		//数据库驱动扩展
		'hostname'=>'10.10.2.118',	//数据库服务器地址
		'username'=>'root',			//数据库用户
		'password'=>'',				//数据库密码
		'database'=>'test',			//数据库名称
		'charset'=>'utf8',			//数据库编码
	),
	//备库配置
	'backup'=>array(
		'driver' => 'mysql',		//数据库驱动扩展
		'hostname'=>'10.10.2.118',	//数据库服务器地址
		'username'=>'root',			//数据库用户
		'password'=>'',				//数据库密码
		'database'=>'test',			//数据库名称
		'charset'=>'utf8',			//数据库编码
	),
);