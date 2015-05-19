<?php
namespace Admin\Controller;

class IndexController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
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