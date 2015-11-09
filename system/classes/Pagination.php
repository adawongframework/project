<?php
class Pagination extends Ada_Wong {
	
	//当前页码
	public $currpage = 1;

	//分页总记录数
	public	$totalRows = 0;
	
	//分页标签内容
	private $body = '';

	//分页大小
	private $pageSize = 20;

	//分页总页数
	private $pageRows = 0;

	public function __construct($pageSize=20) {
		$this->pageSize = $pageSize;
	}
	

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