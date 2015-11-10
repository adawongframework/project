<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 解析顺序结构语句
*+--------template----------------------------------------------------------------
* {time()/}
* {date('Y-m-d H:i:s')/}
* {test(1,2,3,4)/}
* {$user[0]['name']/}
* {test($user[0]['sex'])/}
* {test($name)/}
*+--------compile-----------------------------------------------------------------
* <?php echo time();?>
* <?php echo date('Y-m-d H:i:s');?>
* <?php echo test(1,2,3,4);?>
* <?php echo $this->variables["user"][0]['name'];?>
* <?php echo test($this->variables["user"][0]['sex']);?>
* <?php echo test($this->variables["name"]);?>
*+--------------------------------------------------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2015/02/01
*/
class Ada_Template_Compile_Syntax extends Ada_Template_Compile {
	
	/**
	* 解析顺序结构语句
	*+-----------------------
	* @param Void
	* @return Void
	*/
	public static function compile() {
		self::$contents = preg_replace(self::pattern(self::$start, self::$close), self::replace(), self::$contents);
	}
	
	/**
	* 匹配模式
	*+--------
	* @param String $start
	* @param String $close
	* return Array
	*/
	public static function pattern($start, $close) {
		return array(
			sprintf('/%s[\s]*([a-zA-z][\w]*)::(.*)[\s]*\/[\s]*%s/', $start, $close), //静态方法调用
			sprintf('/%s[\s]*\$([a-zA-z][\w]*)(.*)[\s]*\/[\s]*%s/', $start, $close), //打印变量
			sprintf('/%s[\s]*([a-zA-z][\w]*)(\(.*\))[\s]*\/[\s]*%s/', $start, $close), //调用函数
			'/\<\?php([\s]echo[\s])([a-zA-z][\w]*\([\s]*)\$([a-zA-z][\w]*)(.*)[\s]*(\));\?\>/', //函数调用变量
			
		);
	}
	
	/**
	* 匹配内容
	*+--------
	* @param Void
	* @return Array
	*/
	public static function replace() {
		return array(
			'<?php echo \\1::\\2;?>',
			'<?php echo \$this->variables["\\1"]\\2;?>',
			'<?php echo \\1\\2;?>',
			'<?php\\1\\2\$this->variables["\\3"]\\4\\5;?>',
		);
	}
}