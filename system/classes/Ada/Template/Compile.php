<?php
class Ada_Template_Compile extends Ada_Template{
	
	/**
	* 开始定界符
	* @var String
	*/
	protected static $start = '{';
	
	/**
	* 结束定界符
	* @var String
	*/
	protected static $close = '}';

	/**
	* 模板内容
	* @var Stirng
	*/
	protected static $contents = '';

	public static function execute($tplfile, $tmpfile) {
		self::$start = preg_quote(self::$delimiter[0]);
		self::$close = preg_quote(self::$delimiter[1]);
		self::$contents = file_get_contents($tplfile);
		Ada_Template_Compile_Include::incfile(self::$start, self::$close);
		Ada_Template_Compile_Syntax::compile();
		Ada_Template_Compile_Include::compile();
		Ada_Template_Compile_Loop::compile();
		Ada_Template_Compile_Choose::compile();
		file_put_contents($tmpfile, self::$tplscript.self::$contents);
	}
}