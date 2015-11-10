<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 解析循环结构语句
*+--------------------------------------------------------------------------------
* {loop var=$list[0] key=$index}
* {$list[0][$index]/}
* {/loop}
*+--------------------------------------------------------------------------------
* <?php for ($index = 0; $index < count($this->variables["list"][0]); $index++){?>
* <?php echo $this->variables["list"][0][$index];?>
* <?php }?>
*+--------------------------------------------------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2015/02/01
*/
class Ada_Template_Compile_Loop extends Ada_Template_Compile{
	
	/**
	* 解析循环语句
	*+---------------
	* @param Void
	* @return Void
	*/
	public static function compile() {
		self::$contents = preg_replace(self::pattern(self::$start, self::$close), self::replace(), self::$contents);
	}
	
	/**
	* 匹配模式
	*+---------------
	* @param String $start
	* @param String $close
	* @return Void
	*/
	public static function pattern($start, $close) {
		return array(
			sprintf('/%s[\s]*loop[\s]+var[\s]*=[\s]*\$([a-zA-Z][\w]*)(.+)[\s]+key[\s]*=[\s]*(\$[a-zA-z][\w]*)[\s]*%s/', $start, $close),
			sprintf('/%s[\s]*\/loop%s/', $start, $close),
		);
	}
	
	/**
	* 匹配内容
	*+---------------
	* @param Void
	* return Array
	*/
	public static function replace() {
		return array(
			'<?php for (\\3 = 0; \\3 < count($this->variables["\\1"]\\2); \\3++){?>',
			'<?php }?>'
		);
	}
}