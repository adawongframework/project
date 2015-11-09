<?php
class Image extends Ada_Wong{
	
	//图片
	private $file = NULL;

	//图片后缀
	private $suffix = '';
	
	//图片格式
	private $format = 'gif|png|jp[e]?g';

	//图片宽度
	private $width = 0;

	//图片高度
	private $height = 0;
	
	//图片对象
	private $resource = NULL;
	
	/**
	* 设置要处理的图片
	* 如果文件不存在或者不是图片文件将抛出错误
	* @param String $image 完整图片名称
	*/
	public function __construct($file) {
		if (preg_match('#^.+\.(?<suffix>'.$this->format.')$#i', $file, $matchs) && is_file($file)) {
			$this->file = $file;
			$this->suffix = $matchs['suffix'];
			list($this->width, $this->height) = getimagesize($this->file);
			$func = str_replace('jpg', 'jpeg', 'imagecreatefrom'.$this->suffix);
			$this->resource = $func($this->file);
		} else {
			throw new Exception('file '.$this->file.' not found');
		}
	}
	
	/**
	* 设置图片大小
	* @param $width Int 目标图片宽度
	* @param $height Int 目标图片高度
	* @return Self
	*/
	public function resize($width=100, $height=100) {
		$src = $this->resource;
		//unset($this->resource);
		$this->resource = imagecreatetruecolor($width, $height);
		if(imagecopyresampled($this->resource, $src, 0,0,0,0,$width,$height,$this->width,$this->height)) {
			imagedestroy($src);
			return $this;
		}
		throw new Exception('resize file '.$this->file.' failed');
	}

	/**
	* 输出图片
	* @return Void
	*/
	public function output() {
		header('content-type:image/'.$this->suffix);
		imagejpeg($this->resource);
	}

	/**
	* 对图片进行过滤处理
	* @return Self
	*/
	public function filter() {
		imagefilter($this->resource, IMG_FILTER_GRAYSCALE);
		return $this;
	}

	/**
	* 保存文件
	* 如果保存文件失败将抛出异常
	* @param String $name 新文件名称
	* @param String $path 保存目录
	*/
	public function save($name=NULL, $directory=NULL) {
		var_dump($this->resource);
		if (!is_resource($this->resource)) {
			throw new Exception('could not save file');
		}
		if ($name) {
			if ($directory) {
				$path = $directory;
				if (!is_dir($path)) {
					mkdir($path, 0777, true);
				}
			} else {
				$path = realpath(dirname($this->file));
			}
			$file = trim($path, DIRECTORY_SEPARATOR.'.').DIRECTORY_SEPARATOR.$name.'.'.$this->suffix;
		} else {
			$file = $this->file;
		}
		$func = str_replace('jpg', 'jpeg', 'image'.$this->suffix);
		$func($this->resource, $file);
	}

	public function __destruct() {
		if (is_resource($this->resource)) {
			imagedestroy($this->resource);
			$this->resource = NULL;
		}
	}
}