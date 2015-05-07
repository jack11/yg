<?php
namespace Admin\Controller;
class EmptyController extends BaseController {
	
	public function _empty($name){
		$this->error('',U('/'));
	}
	
}