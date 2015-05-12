<?php
namespace Home\Controller;
class ArticleController extends BaseController {
	

	public function index(){
		$this->new_help();
	}
	
	
    public function new_help(){
    	$this->display('html/zhinan');
    }
	
	public function help(){
		$this->display('html/help');
	}
	

}