<?php
/**
 * 欢迎页面
 */
namespace Admin\Controller;

class WelcomeController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->display('html/welcome');
	}
}