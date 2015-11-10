<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 应用控制器
* @package	App
* @category	Controller
* @author	zjie 2014/01/02
*/
class Controller_Welcome extends Controller {
	
	/**
	* 首页
	* http://yourdomain/index.php/
	*/
	public function action_index() {
		echo 'hello world';
	}
	
	/**
	* 详情页
	* http://yourdomain/index.php/details-11.html
	*/
	public function action_details() {
		var_dump($this->request->getparam('id')); //获取id
	}
}