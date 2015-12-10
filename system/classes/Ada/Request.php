<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 请求处理实现类
*+--------------
* @package	Core
* @category	Base
* @author	zjie 2015/11/10
*/
abstract class Ada_Request {
	
	/**
	* 请求url
	* @var String
	*/
	private	$url = '';

	/**
	* 请求方法
	* @var String
	*/
	private $method = 'GET';
	
	/*
	* 请求参数
	* @var Array
	*/
	private $params = array();

	/**
	* 响应对象
	* @var Object
	*/
	private $response = NULL;
	
	/**
	* 请求协议
	* @var String
	*/
	protected $protocol = 'http';

	/**
	* 允许请求的方法
	* @var String
	*/
	protected $allowMethods = array('GET', 'POST');

	/**
	* 构造方法
	*+----------------------------
	* @param String $url 请求的url
	*/
	public function __construct($url=NULL) {
		$this->url = $url ? $url : Uri::path();
		$this->response = new Response();
	}

	/**
	* 设置请求方法
	*+------------------------------
	* @param String $method 请求方式
	* @return Ref
	*/				
	public function method($method='get') {
		$method = strtoupper($method);
		if (!in_array($method, $this->allowMethods)) {
			throw new Ada_Exception('Request method error');
		}
		$this->method = $method;
		return $this;
	}

	/**
	* 执行请求
	*+--------------------
	* @param Void
	* @return Response实例
	*/
	public function execute() {
		if (preg_match('`^'.$this->protocol.'`i', $this->getUrl())) {
			$this->external(); //外部请求
		} else {
			$this->internal(); //内部请求
		}
		return $this->response;
	}

	/**
	* 执行内部请求
	*+------------
	* @param Void
	* @return Void
	*/
	private function internal() {
		new	Ada_Request_Internal($this, $this->response, Route::factory($this)->parser()->execute());
	}

	/**
	* 执行外部请求
	*+-------------
	* @param Void
	* @return Void
	*/
	private function external() {
		new	Ada_Request_External($this, $this->response, $this->method);
	}
	
	/**
	* 设置请求参数
	*+------------------------------
	* @param Mixed $key 请求参数名称
	* @param Mixed $val 参数值
	* @return Self
	*/
	public function setParam($key, $val=NULL) {
		if (is_array($key)) {
			$this->params = array_merge($key, $this->params);
		} else {
			$this->params[$key] = $val;
		}
		return $this;
	}

	/**
	* 获取请求的url
	*+--------------
	* @param Void
	* @return String
	*/
	public function getUrl() {
		return $this->url;
	}
	
	/**
	* 获取请求参数
	*+-------------------------------
	* @param String $key 请求参数名称
	* @param Mixed $default 默认值
	* @return Mixed
	*/
	public function getParam($key=NULL, $default=NULL) {
		if (is_null($key)) {
			return $this->params;
		} else {
			if (isset($this->params[$key])) {
				return $this->params[$key];
			}
		}
		return $default;
	}

	/**
	* 获取$_POST数据
	*+----------------------------
	* @param String $key  变量名称
	* @param Mixed $default 默认值
	* @return Mixed
	*/
	public function post($key=NULL, $default=NULL) {
		if ($key == NULL && $default == NULL) {
			return $_POST;
		} else if($_POST[$key]) {
			return $_POST[$key];
		} else {
			return $default;
		}
	}

	/**
	* 获取$_GET数据
	*+---------------------------
	* @param String $key  变量名称
	* @param Mixed $default 默认值
	* @return Mixed
	*/
	public function get($key, $default=NULL) {
		return isset($_GET[$key]) ? $_GET[$key] : $default;
	}

	/**
	* 判断客户端是否Ajax请求
	*+---------------
	* @param Void
	* @return Boolean
	*/
	public function isajax() {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			return TRUE;
		}
		return FALSE;
	}
}