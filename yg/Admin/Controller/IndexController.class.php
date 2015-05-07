<?php
namespace Admin\Controller;

class IndexController extends BaseController {
	
	protected function _initialize(){
	}
	
    public function index(){
        $this->display('Index/index');
    }
	
	public function first_index()
	{
		$this->assign('temp','综合信息');
		$this->display('Common/list');
	}
}