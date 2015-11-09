<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Utf8编码字符处理实现类
*+----------------------
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Utf8 extends Ada_Wong {
	
	//ascii字符编码范围
	const ASCII = '[\x00-\x7f]';

	//多字节编码范围
	const MULTI = '(?:[\xC0-\xDF]|[\xE0-\xEF]|[\xF0-\xF7]|[\xF8-\xFB]|[\xFC-\xFD])(?:[\x80-\xBF]{1,5})';
	
	//编码
	const CHARSET = 'UTF-8';
	
	/**
	* 判断字符是否为ASCII字符
	*+-----------------------
	* @param String $string	输入字符
	* @return Boolean
	*/
	public static function isAscii($string) {
		return preg_match('/^(?:'.self::ASCII.')+$/', $string);
	}
	
	/**
	* 判断字符是否为多字节字符
	*+-----------------------
	* @param String $string 输入字符
	* @return Bool
	*/
	public static function isMulti($string) {
		return preg_match('/^(?:'.self::MULTI.')+$/', $string);
	}

	/**
	* 获取子串在输入字符中出现的次数
	*+------------------------------
	* @param String $string 输入字符
	* @parma String $child 子串
	* @reutrn Int
	*/
	public static function count($string, $child) {
		$count = 0;
		if(preg_match_all("/(?:{$child})+?/u", $string, $matchs)) {
			return count($matchs[0]);
		}
		return $count;
	}

	/**
	* 设置子串在输入字符中以指定颜色突出显示
	*+--------------------------------------
	* @param String $string 输入字符
	* @param String $child 子串
	* @return String
	*/
	public static function light($string, $child) {
		return preg_replace_callback("/(?:{$child})/u", function($matchs) {
			return '<font color="red">'.$matchs[0].'</font>';
		}, $string);
	}

	/**
	* 获取字符长度
	*+------------
	* @param String $string 输入字符
	* @return Int
	*/
	public static function strlen($string) {
		if (function_exists('mb_strlen')) {
			return mb_strlen($string, self::CHARSET);
		} else if(function_exists('iconv_strlen')) {
			return iconv_strlen($string, self::CHARSET);
		} else {
			$count = $index = 0;
			$strlen = strlen($string);
			while($index < $strlen) {
				$index+=self::step(substr($string, $index, 1));
				$count++;
			}			
			return $count;
		}	
	}

	/**
	* 字符截取
	* 从输入字符的{$start}位置开始截取{$length}个字符
	*+-----------------------------------------------
	* @param String $string 输入字符
	* @param Int $start 开始位置
	* @param Int $length 截取长度
	* @return String
	*/
	public static function cutstr($string, $start=0, $length=NULL) {
		if ($length == NULL) {
			$length = self::strlen($string);
		}
		if (function_exists('mb_substr')) {
			return mb_substr($string, $start, $length, self::CHARSET);
		} else if(function_exists('iconv_substr')) {
			return iconv_substr($string, $start, $length, self::CHARSET);
		} else {
			$count = $sbyte = $index = 0;
			$strlen = $pstart = $pend = strlen($string);
			while($index < $strlen) {
				if ($count == $start) {
					$pstart = $index;
					$sbyte = $count;
				}
				if ($count-$sbyte >= $length) {
					$pend = $index;
					break;
				}
				$index+=self::step(substr($string, $index, 1));
				$count++;
			}			
			return substr($string, $pstart, $pend-$pstart);
		}
	}

	/**
	* 获取字符字节个数
	*+----------------
	* @param String $string 输入字符
	* @return Int
	*/
	private static function step($string) {
		$ord = ord($string);
		if ($ord < 128) { //1byte
			return 1;
		} else if ($ord >= 192 && $ord <= 223) { //2byte
			return 2;
		} else if ($ord >= 224 && $ord <= 239) { //3byte
			return 3;
		} else if ($ord >= 240 && $ord <= 247) { //4byte
			return 4;
		} else if ($ord >= 248 && $ord <= 251) { //5byte
			return 5;
		} else if ($ord >= 252 && $ord <= 253) { //6byte
			return 6;
		} else {
			throw new Ada_Exception('Unrecognized character encoding');
		}
	}
}