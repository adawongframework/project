<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 文件缓存实现类
*+------------------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/02/01
*+------------------------------------------------
* $this->set('name', 'leon');
* $this->set('name', 'jack', 60); //60second
* $this->get('name') //get data
* $this->del('name') //del key
*/
class Ada_Cache_File extends Ada_Cache {
	
	/**
	* 缓存文件保存目录
	* @var String
	*/
	public static $directory = './tmp';
	
	/**
	* 缓存文件名后缀
	* @var String
	*/
	public static $tmpsuffix = 'tmp';


	/**
	* 缓存文件名前缀
	* @var String
	*/
	public static $tmpprefix = 'cache_';

	/*
	* 缓存文件声明脚本
	* @var String
	*/
	private static $tmpscript = '<?php if(!$this instanceOf Cache)exit(0);?>';
	
	/**
	* 设置缓存数据
	*+---------------------------
	* @param String $key 缓存key
	* @param Mixed $val 缓存数据
	* @param Int $expires 有效时间 单位秒
	* return Boolean
	*/
	public function set($key, $val, $expires=0) {
		$file = $this->checked($key);
		$path = dirname($file);
		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}
		$unixtime = '<0>';
		if ($expires > 0) { //大于0表示设置有效时间
			$unixtime = '<'.(int)$expires.'>';
		}
		return file_put_contents($file, self::$tmpscript.$unixtime.serialize($val));
	}

	/**
	* 获取缓存数据
	*+------------
	* @param String $key 缓存键名
	* @return Mixed
	*/
	public function get($key) {
		$file = $this->checked($key);
		if (is_file($file)) {
			//剔除缓存声明脚本
			$data = preg_replace('/^'.preg_quote(self::$tmpscript).'/', '', file_get_contents($file));
			//获取数据有效期
			preg_match('/(?<=\<)(?:0|[1-9][0-9]*)(?=\>)/', $data, $matchs);
			if (isset($matchs[0]) && ($matchs[0] == 0 || (time()-filemtime($file) <= $matchs[0]))) {
				return unserialize(preg_replace('/\<'.$matchs[0].'\>/', '',$data));
			} else {
				unlink($file); //删除过期缓存文件
			}
		}
		return  NULL;
	}

	/**
	* 清除指定$key缓存数据
	*+--------------------
	* @param String $key 缓存键名
	* @return Boolean
	*/
	public function del($key) {
		$file = $this->checked($key);
		if (is_file($file) && is_writable($file)) {
			return unlink($file);
		}
		return TRUE;
	}

	/**
	* 检测缓存key是否合法 缓存目录是否可读写
	*+--------------------------------------
	* @param String $key 缓存key
	* @return String
	*/
	private function checked($key) {
		if (!is_string($key)) {
			throw Ada_Exception('Key Must Be String Type');
		}
		if (!is_readable(self::$directory)) {
			throw Ada_Exception('Directory does not have read permission');
		}
		if (!is_writable(self::$directory)) {
			throw Ada_Exception('Directory does not have write permission');
		}
		$name = md5($key);
		return self::$directory.DIRECTORY_SEPARATOR.substr($name, 0, 1).DIRECTORY_SEPARATOR.self::$tmpprefix.$name.'.'.self::$tmpsuffix;
	}
}
//End file ./system/classes/Ada/Cache/File.php