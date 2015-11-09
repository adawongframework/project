<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 加密解密具体实现类,使用异或运算
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Encrypt_Xor{
	
	/**
	* 对明文进行加密
	* @param	String	$encode	输入字符
	* @param	String	$secret	加密秘钥
	* @return	String	返回加密之后的密文
	*/
	public static function encode($string, $secret) {
		$text = '';
		$index = $i = 0;
		$count = array();
		$chars = md5($secret);
		$count[] = strlen($chars);
		$count[] = strlen($string);
		while ($i < $count[1]) {
			if ($index == strlen($count[0])) $index = 0;
			$text.= $chars[$index].($string[$i] ^ $chars[$index++]);
			$i++;
		}
		return	base64_encode(self::secret($text, $secret));
	}
	
	/**
	* 对密文进行解密
	* @param	String	$encode	输入字符
	* @param	String	$secret	加密秘钥
	* @return	String	返回解密之后的明文
	*/
	public static function decode($string, $secret) {
		$text = '';
		$index = 0;
		$string = self::secret(base64_decode($string), $secret);
		$count = strlen($string);
		while ($index < $count) {
			$code = $string[$index];
			$text.= $string[++$index] ^ $code;
			$index++;
		}
		return	$text;
	}
	
	/**
	* 对密文和秘钥进行加密解密
	* @param	String	$string	密文
	* @param	String	$secret	秘钥
	* @return	String	返回加密的密文
	*/
	private static function	secret($string, $secret) {
		$text = '';
		$index = $i = 0;
		$count = array();
		$chars = md5($secret);
		$count[] = strlen($chars);
		$count[] = strlen($string);
		while ($i < $count[1]) {
			if ($index == strlen($count[0])) $index = 0;
			$text.= $string[$i] ^ $chars[$index++];
			$i++;
		}
		return	$text;
	}
}