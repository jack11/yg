<?php
namespace Admin\Controller;

class CommunicationController extends BaseController {
	
	protected function _initialize(){
	}
	
	public function txl(){
		$this->assign('temp','通讯录');
		$this->display('Communication/tongxunlu');
	}
	
}