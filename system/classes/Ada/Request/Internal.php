<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 内部请求处理类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Request_Internal extends Ada_Wong {
	
	/**
	* controller映射类名称
	*/
	private $controller;

	/**
	* action映射成员方法名称
	*/
	private $action;

	/**
	* 注册动态执行方法成员
	*/
	private $invokes = array('before', 'after');
	
	/**
	* 请求对象实例
	*/
	private $request;

	/**
	* 控制文件存放目录
	*/
	private $directory = 'controller';

	/**
	* action成员方法前缀
	*/
	private $prefix = 'action_';
	
	/**
	* 构造函数
	* @param Request $request
	* @param Arry $routes
	* @return Void
	*/
	public function __construct(Request &$request, Response &$response, $routes) {
		$file = $this->mapPath($routes);
		$rc = new ReflectionClass($this->controller);
		if (!$rc->isAbstract() && $rc->isSubclassOf('Controller')) {
			$controller = new $this->controller($request);
			if (method_exists($controller, $this->action)) {
				ob_start();
				$this->invoke($controller);
				$content = ob_get_contents();
				ob_end_clean();
				$response->body($content);
				$response->status(200);
				return true;
			}
		}
		throw new Ada_Exception('The requested URL was not found on this server');
	}
	
	/**
	* 析构函数
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		unset($this->request);
	}

/**
* 获取控制器类名及类名称映射的文件
* $param Array $routes 路由映射信息
* $return String
*/
private function mapPath($routes) {
	$this->controller = $this->directory.'_';
	if (isset($routes['directory']) && !empty($routes['directory'])) {
		$this->controller.= $routes['directory'].'_';
	}
	$this->controller.= $routes['controller'];
	$this->action = $this->prefix.$routes['action'];
	return str_replace('_', DIRECTORY_SEPARATOR, $this->controller);
}

	/**
	* 动态执行注册的成员方法
	* @param Controller $controller
	* @return Void
	*/
	private function invoke(Controller $controller) {
		array_splice($this->invokes,1,0,$this->action);
		foreach ($this->invokes as $method) {
			$rm = new ReflectionMethod($controller, $method);
			if (method_exists($controller, $method) && $rm->isPublic()) {
					$rm->invoke($controller);
			}
			unset($rm);
		}
	}
}