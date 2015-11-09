<?php
/**
* 文件缓存实现类
*+----------
* $this->set('name', 'leon');
* $this->set('name', 'jack', 60); //缓存60(second)
* $this->get('name') //获取缓存数据
*/
class Ada_Cache_File extends Ada_Cache {
	
	/**
	* 缓存文件保存目录
	* var String
	*/
	public static $directory = './tmp';
	
	/**
	* 缓存文件名后缀
	× @var String
	*/
	public static $tmpsuffix = 'tmp';


	/**
	* 缓存文件名前缀
	* @var String
	*/
	public static $tmpprefix = 'cache_';

	/*
	* 缓存文件声明
	* @var String
	*/
	private static $tmpscript = '<?php if(!$this instanceOf Cache)exit(0);?>';
	
	/**
	* 设置缓存数据
	*+------------
	* @param String $key
	* @param Mixed $val
	* @param Int $expires
	* return Boolean
	*/
	public function set($key, $val, $expires=0) {
		$name = md5($key);
		$path = self::$directory.DIRECTORY_SEPARATOR.substr($name, 0, 1);
		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}
		$unixtime = '<0>';
		if ($expires > 0) {
			$unixtime = '<'.(int)$expires.'>';
		}
		return file_put_contents($path.DIRECTORY_SEPARATOR.self::$tmpprefix.$name.'.'.self::$tmpsuffix, self::$tmpscript.$unixtime.serialize($val));
	}

	/**
	* 获取缓存数据
	*+------------
	* @param String $key
	* @return Mixed
	*/
	public function get($key) {
		$name = md5($key);
		$path = self::$directory.DIRECTORY_SEPARATOR.substr($name, 0, 1);
		$file = $path.DIRECTORY_SEPARATOR.self::$tmpprefix.$name.'.'.self::$tmpsuffix;
		if (is_file($file)) {
			//剔除缓存声明脚本
			$data = preg_replace('/^'.preg_quote(self::$tmpscript).'/', '', file_get_contents($file));
			//获取数据有效期
			preg_match('/(?<=\<)(?:0|[1-9][0-9]*)(?=\>)/', $data, $matchs);
			if ($matchs[0] == 0 || (time()-filemtime($file) <= $matchs[0])) {
				return unserialize(preg_replace('/\<(?:0|[1-9][0-9]*)\>/', '',$data));
			} else {
				unlink($file); //删除过期缓存文件
			}
		}
		return  NULL;
	}

	/**
	* 清除指定$key缓存数据
	*+--------------------
	* @param String $key
	* @return Boolean
	*/
	public function del($key) {
		$name = md5($key);
		$path = self::$directory.DIRECTORY_SEPARATOR.substr($name, 0, 1);
		$file = $path.DIRECTORY_SEPARATOR.self::$tmpprefix.$name.'.'.self::$tmpsuffix;
		if (is_file($file) && is_writable($file)) {
			return unlink($file);
		}
		return TRUE;
	}
}