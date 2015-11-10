<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 分页处理类
*+---------------
* @package	Core
* @category	Base
* @author	zjie 2014/02/20
*/
class Pagination extends Ada_Wong {
	
	/**
	* 当前页码
	* @var Int
	*/
	public $currpage = 1;

	/**
	* 总记录数
	* @var Int
	*/
	public	$totalRows = 0;
	
	/**
	* 分页内容
	* @var String
	*/
	private $body = '';

	/**
	* 每页大小
	* @var Int
	*/
	private $pageSize = 20;

	/**
	* 总页码数
	* @var Int
	*/
	private $pageRows = 0;
	
	/**
	* 构造函数
	*+--------------------
	* @param Int $pageSize
	*/
	public function __construct($pageSize=20) {
		$this->pageSize = $pageSize;
	}
	
	/**
	* 生成分页标签
	*+------------------
	* @parma String $url
	* @return String
	*/
	public function execute($url='') {
		$this->body = 'totals:'.$this->totalRows;
		$this->pageRows = ceil($this->totalRows/$this->pageSize);
		if ($this->pageRows == 1) {
			return $this->body;
		}
		for($i=1; $i <= $this->pageRows; $i++) {
			$attr = '';
			if ($i == $this->currpage) {
				$attr .= 'class="current"';
			} else {
				$attr = 'href="'.(str_replace('{pagination}', $i, $url)).'"';
			}
			$this->body.='<a '.$attr.'>'.$i.'</a>';
		}
		return $this->body;
	}
}