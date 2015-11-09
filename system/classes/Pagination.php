<?php
class Pagination extends Ada_Wong {
	
	//��ǰҳ��
	public $currpage = 1;

	//��ҳ�ܼ�¼��
	public	$totalRows = 0;
	
	//��ҳ��ǩ����
	private $body = '';

	//��ҳ��С
	private $pageSize = 20;

	//��ҳ��ҳ��
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