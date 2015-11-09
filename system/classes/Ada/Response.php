<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http��Ӧ����ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Response extends Ada_Wong {

	/**
	* ��Ӧ����
	*/
	private $body = '';

	/**
	* ��Ӧ״̬��
	*/
	private $code = 404;
	
	/**
	* ��ȡ��������Ӧ����
	* @param String ��Ӧ����
	* @return String
	*/
	public function body() {
		if(func_num_args() > 0) {
			$this->body = func_get_arg(0);
		}
		return $this->body;
	}
	
	/**
	* ��ȡ������Ӧ״̬��
	* @param Void
	* @return Int
	*/
	public function status() {
		if(func_num_args() > 0) {
			$this->code = func_get_arg(0);
		}
		return $this->code;
	}
	
	/**
	* ������Ӧ��Ϣ
	* @param Void
	* @retrun String
	*/
	public function __toString() {
		return $this->body;
	}
	
	/**
	* ��������
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		$this->body = '';
	}
}