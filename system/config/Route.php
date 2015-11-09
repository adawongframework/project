<?php
return	array(
	array( //文章详情
		'<action>-<id>.html',
		array(
			'action'=>'archive',
			'id'=>'[1-9][0-9]*',
		),
		array(
			'controller'=>'welcome',
			'action'=>'archive'
		)
	),
	array( //后台管理
		'<directory>-<controller>-<action>.html',
		array(
		),
		array(
			'controller'=>'index',
			'action'=>'index',
		)
	),
	array( //分类列表
		'<action>(-<id>(-<page>(-<keyword>))).html',//<controller>(/<action>(/<id>))
		array(
			'action'=>'category',
			'id'=>'[1-5]+',
			'page'=>'[\d]+',
			'keyword'=>'.*',
		),
		array(
			'controller'=>'welcome',
			'action'=>'category'
		)
	)
);