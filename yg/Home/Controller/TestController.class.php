<?php

namespace Home\Controller;
class TestController extends BaseController {
	
	public function index(){
		echo I('get.id','','string');
	}
	
}