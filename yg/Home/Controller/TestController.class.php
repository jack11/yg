<?php

namespace Home\Controller;
class TestController extends BaseController {
	
	public function index(){
		echo D('goods')->getGoodsList(array());
	}
	
}