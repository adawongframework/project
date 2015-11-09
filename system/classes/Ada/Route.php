<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ·�ɴ�����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Route extends Ada_Wong {
	
	/**
	* request����ʵ��
	*/
	private	$request = NULL;

	/**
	* ·�ɹ����
	*/
	private $routes = array();
	
	/**
	* ����·��ƥ����Ϣ
	*/
	private $matchs = array();

	/**
	* ���浱ǰ·�ɹ�������
	*/
	private $active = NULL;
	
	/**
	* ���캯��
	* @param Request $request
	*/
	public function __construct(Request &$request) {
		$this->request = $request;
		$this->routes = Config::load('Route', TRUE); //����·�ɹ��������ļ�
	}
	
	/**
	* ִ��·�ɲ���
	* @param Void
	* @return Array
	*/
	public function execute() {
		if ($this->matchs) {
			foreach ($this->matchs as $key=>$val) {
				if (preg_match('`^[a-z]+$`', $key)) {
					if (!preg_match('`^(directory|controller|action|)$`', $key)) {
						$this->request->setparam($key, $val); //����request�����������
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
		throw new Ada_Exception('The requ'); //����uriû��ƥ��·�ɱ����κ�һ������
	}
	
	/**
	* ����·�ɹ����
	* @param Void
	* @return Self
	*/
	public function parser() {
		$url = $this->request->getUrl();
		if ($url) {
			//���$uri��Ϊ��,����·�ɹ����,��$uri��ÿ��������������ƥ��,ֱ���ҵ���ƥ��Ĺ�����Ϣ;�����׳��쳣
			foreach ($this->routes as $key=>$route) {
				if (empty($route)) continue;
				if (preg_match($this->matchs($route), $url, $this->matchs)) {
					$this->active = $key;
					break;
				}
			}
		} else { //��ȡĬ��·�ɹ���,·�ɱ����һ��
			$route = $this->routes[count($this->routes)-1];
			if (isset($route[2])) {
				$this->matchs = $route[2];
			}
		}
		return $this;
	}
	
	/*
	* ����·�ɹ������ɶ�Ӧ������ʽ
	* @param Array $route
	* @return Boolean
	*/
	private function matchs($route) {
		//��������������ʽ
		$pattern = preg_replace('`(?<=[)])`', '?', $route[0]);
		$pattern = preg_replace('`(?<=[(])(?=.)`','?:',$pattern); //���?:�������()�����в���
		$pattern = $uri = preg_replace('`(<[a-z]+>)`','(?\\1)', $pattern); //���岶������
		$pattern = preg_replace('`(?<=[>])(?=[)])`', '[\w]+', $pattern); //����ÿ���ַ���Χ,Ĭ��[\w]
		//�����Զ���������ʽ
		if (isset($route[1]) && is_array($route[1])) {
			foreach ($route[1] as $key=>$rule) {
				$pattern = preg_replace('`(?<=[<]'.$key.'[>])\[\\\w\]\+(?=[)])`U', $rule, $pattern);
			}
		}
		return '`^'.$pattern.'$`';
	}

	/**
	* ��������
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		unset($this->matchs, $this->routes, $this->request);
	}
}