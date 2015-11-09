<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 路由处理类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Route extends Ada_Wong {
	
	/**
	* request对象实例
	*/
	private	$request = NULL;

	/**
	* 路由规则表
	*/
	private $routes = array();
	
	/**
	* 保存路由匹配信息
	*/
	private $matchs = array();

	/**
	* 保存当前路由规则名称
	*/
	private $active = NULL;
	
	/**
	* 构造函数
	* @param Request $request
	*/
	public function __construct(Request &$request) {
		$this->request = $request;
		$this->routes = Config::load('Route', TRUE); //载入路由规则配置文件
	}
	
	/**
	* 执行路由操作
	* @param Void
	* @return Array
	*/
	public function execute() {
		if ($this->matchs) {
			foreach ($this->matchs as $key=>$val) {
				if (preg_match('`^[a-z]+$`', $key)) {
					if (!preg_match('`^(directory|controller|action|)$`', $key)) {
						$this->request->setparam($key, $val); //设置request对象请求参数
						unset($this->matchs[$key]);
					}
				} else {
					unset($this->matchs[$key]);
				}
			}
			if (isset($this->routes[$this->active][2])) {
				$this->matchs = array_merge($this->routes[$this->active][2], $this->matchs);
			}
			if (isset($this->matchs['controller'], $this->matchs['action'])) {
				return $this->matchs;
			}
		}
		throw new Ada_Exception('The requ'); //请求uri没有匹配路由表中任何一条规则
	}
	
	/**
	* 解析路由规则表
	* @param Void
	* @return Self
	*/
	public function parser() {
		$url = $this->request->getUrl();
		if ($url) {
			//如果$uri不为空,遍历路由规则表,将$uri与每条规则表进行正则匹配,直到找到相匹配的规则信息;否则抛出异常
			foreach ($this->routes as $key=>$route) {
				if (empty($route)) continue;
				if (preg_match($this->matchs($route), $url, $this->matchs)) {
					$this->active = $key;
					break;
				}
			}
		} else { //获取默认路由规则,路由表最后一个
			$route = $this->routes[count($this->routes)-1];
			if (isset($route[2])) {
				$this->matchs = $route[2];
			}
		}
		return $this;
	}
	
	/*
	* 根据路由规则生成对应正则表达式
	* @param Array $route
	* @return Boolean
	*/
	private function matchs($route) {
		//构建基础正则表达式
		$pattern = preg_replace('`(?<=[)])`', '?', $route[0]);
		$pattern = preg_replace('`(?<=[(])(?=.)`','?:',$pattern); //添加?:对最外层()不进行捕获
		$pattern = $uri = preg_replace('`(<[a-z]+>)`','(?\\1)', $pattern); //定义捕获组名
		$pattern = preg_replace('`(?<=[>])(?=[)])`', '[\w]+', $pattern); //定义每组字符范围,默认[\w]
		//构建自定义正则表达式
		if (isset($route[1]) && is_array($route[1])) {
			foreach ($route[1] as $key=>$rule) {
				$pattern = preg_replace('`(?<=[<]'.$key.'[>])\[\\\w\]\+(?=[)])`U', $rule, $pattern);
			}
		}
		return '`^'.$pattern.'$`';
	}

	/**
	* 析构函数
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		unset($this->matchs, $this->routes, $this->request);
	}
}