<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 解析包含文件语句
*+-----------------------------
* {template test.html/}
*+-----------------------------
* <?php include "test.html";?>
*+-----------------------------
* @package	Core
* @category	Base
* @author	zjie 2015/02/01
*/
class Ada_Template_Compile_Include extends Ada_Template_Compile {
	
	/**
	* 定义匹配模式
	* var Array
	*/
	private static $pattern = array(
		'file' => '((?:[.a-zA-Z0-9]+\/)*(?:[a-zA-z0-9][\w]*))',
	);

	/**
	* 执行编译模板操作
	*+----------------
	* @param Void
	* @return Void
	*/
	public static function compile() {
		self::$contents = preg_replace(self::pattern(self::$start, self::$close), self::replace(), self::$contents);
	}
	
	/**
	* 返回匹配模式
	*+------------
	* @param Void
	* @return Array
	*/
	public static function pattern($start, $close) {
		return array(
			sprintf('/%s[\s]*template (.+)[\s]*\/[\s]*%s/', $start, $close)
		);
	}
	
	/**
	* 返回匹配内容
	*+------------
	* @param Void
	* @return Array
	*/
	public static function replace() {
		return array(
			'<?php include "\\1";?>'
		);
	}
	
	/**
	* 查找和替换被包含的文件
	* 没有实现深度包含文件
	*+----------------------
	* @param Void
	* @return Void
	*/
	public static function incfile($stat, $close) {
		$pattern = '/(?:'.self::$start.'[\s]*template[\s]+%s[\s]*\/[\s]*'.$close.')+/U';
		preg_match_all(sprintf($pattern, self::$pattern['file'].'\.'.self::$tplsuffix), self::$contents, $matchs);
		$files = array();
		//获取被包含的文件内容
		if ($matchs[1]) {
			foreach ($matchs[1] as $file) {
				$file.= '.'.self::$tplsuffix;
				if (!is_file($file)) {
					throw new Ada_Exception('tpl '.$file.' file Not Found');
				}
				$files[$file] = file_get_contents($file);
			}
		}
		//获取包含文件内容替换到包含位置
		foreach ($files  as $file => $text) {
			self::$contents = preg_replace(sprintf($pattern, $file), $text, self::$contents);
		}
		unset($matchs, $files);
	}
}