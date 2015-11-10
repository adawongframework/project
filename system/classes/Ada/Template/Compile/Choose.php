<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 解析选择结构语句
*+-----------------------------------------------------------------------------------------------------
* {if $count == 1 && $test >= $count}
* {elseif $count == 2}
* {else}
* {/if}
*+-----------------------------------------------------------------------------------------------------
* <?php if ($this->variables["count"] == 1 && $this->variables["test"] >= $this->variables["count"]){?>
* <?php else if ($this->variables["count"] == 2){?>
* <?php }else{ ?>
* <?php }?>
+------------------------------------------------------------------------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2015/02/01
*/
class Ada_Template_Compile_Choose extends Ada_Template_Compile{
	
	public static function compile() {
		self::$contents = preg_replace(self::pattern(self::$start, self::$close), self::replace(), self::$contents);
		preg_match_all('/\<\?php (if|else if) .+\?\>/', self::$contents, $matchs);
		if ($matchs[0]) {
			foreach ($matchs[0] as $v) {
				$tmp = preg_replace('/\$([a-zA-Z][\w]*)([^=><!])?/', '$this->variables["\\1"]\\2', $v);
				self::$contents = preg_replace('/'.preg_quote($v).'/', $tmp, self::$contents);
			}
		}
	}
	
	/**
	* 匹配模式
	* @param String $start
	* @param String $close
	* @return Array
	*/
	public static function pattern($start, $close) {
		return array(
			sprintf('/%s[\s]*if[\s]+(.+)%s/', $start, $close),
			sprintf('/%s[\s]*elseif[\s]+(.+)%s/', $start, $close),
			sprintf('/%s[\s]*else[\s]*%s/', $start, $close),
			sprintf('/%s[\s]*\/if[\s]*%s/', $start, $close)

		);
	}
	
	/**
	* 匹配内容
	*+------------------
	* @param Void
	* @return Void
	* @return Array
	*/
	public static function replace() {
		return array(
			'<?php if (\\1){?>',
			'<?php else if (\\1){?>',
			'<?php }else{ ?>',
			'<?php }?>'
		);
	}
}