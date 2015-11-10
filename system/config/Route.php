<?php
/**
* 路由配置文件
*+-----------------------------------------------------------
* 路由类将最后一条当做默认路由规则
* cp ./system/config/Route.php ./application/config/Route.php
*+-----------------------------------------------------------
*/
return	array(
	
	//文章详情路由 details-11.html <==> controler:welcome action:details id:11
	array(
		'<action>-<id>.html',
		array(
			'action'=>'details',
			'id'=>'[1-9][0-9]*'
		),
		array(
			'controller'=>'welcome',
		),
	),
	//默认路由
	array(
		//匹配模式
		'<controller>-<action>.html',	//Controller-action.html 
		//字符范围
		array(
			'controller'=>'[\w]+',		//Controller允许的字符范围
			'action'=>'[\w]+'			//action允许的字符范围
		),
		//默认控制器、方法
		array(
			'controller'=>'welcome',
			'action'=>'index'
		)
	)
);