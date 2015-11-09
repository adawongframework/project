<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Uri处理实现类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Uri extends Ada_Wong {
	
	/**
	* 获取pathinfo
	* @param Void
	* @return String
	*/
	public static function getinfo() {
		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === FALSE) {
			$uri.= basename($_SERVER['SCRIPT_NAME']);
		}
		$url = preg_replace('#'.$_SERVER['SCRIPT_NAME'].'#', '', $uri);
		if (!empty($url)) {
			$url = trim($url, '\/');
			if (strpos($url, '?') !== FALSE) {
				return preg_replace(array('#(?<=[?]).+#', '#[?]#'), '', $url);
			} else {
				return $url;
			}
		}
		return '';
	}

	/**
	* 获取baseurl
	* @param Void
	* @return String
	*/
	public static function baseurl() {
		$config = Config::load('config', TRUE);
		return $config['baseurl'];
	}
	
	/**
	* 设置uri
	* @param String $url 如果参数为空,返回pathinfo
	* @return String
	*/
	public static function siteurl($uri=NULL) {
		$config = Config::load('config', TRUE);
		$indexfile = '';
		if (isset($config['indexfile'])) {
			$indexfile = $config['indexfile'];
		}
		return self::baseurl().$indexfile.'/'.$uri;
	}
}