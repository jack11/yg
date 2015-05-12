<?php
namespace Home\Controller;
class GoodsController extends BaseController {
	
	
    public function index(){
    	$this->display('html/goods');
    }
	
	public function goods_list(){
		$this->display('html/goods_list');
	}
}