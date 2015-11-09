<?php
return	array(
	array( //分类列表
		'<controller>-<action>.html',//<controller>(/<action>(/<id>))
		array(
			'controller'=>'[\w]+',
			'action'=>'[\w]+'
		),
		array(
			'controller'=>'welcome',
			'action'=>'index'
		)
	)
);