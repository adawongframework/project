<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 应用控制器
* @package	App
* @category	Controller
* @author	zjie 2014/01/02
*/
class Controller_Welcome extends Controller {
	
	
	/**
	* Action之前调用
	*+--------------
	*/
	public function before() {
		echo __FUNCTION__."\r\n";
	}
	
	/**
	* Action之后调用
	*+---------------
	*/
	public function after() {
		echo __FUNCTION__."\r\n";
	}
	/**
	* 首页
	*+----------------------------
	* http://yourdomain/index.php/
	*/
	public function action_index() {
		echo "hello world\r\n";
	}
	
	/**
	* 详情页
	*+-------------------------------------------
	* http://yourdomain/index.php/details-11.html
	*/
	public function action_details() {
		//获取参数id
		var_dump($this->request->getparam('id')); //11
	}

	/**
	* 模板引擎
	*+--------
	*/
	public function action_template() {
		$template = new Template();
		$template->bindvar(array(
			'var'=>'hello wolrd',
			'total'=>10,
			'array'=>array(1,2,3,4,5,6)
		))->display('index.tpl');
	}

	/**
	* 缓存
	*+----
	*/
	public function action_cache() {
		$cache = Cache::factory('file'); //获取一个文件缓存实例
		//$cache->set('name', 'adawong', 60); //设置有效期60s
		echo $cache->get('name');
	}
}