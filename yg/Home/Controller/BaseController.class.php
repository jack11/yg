<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {

	
	
	public function __construct(){
		
		parent::__construct();
	}
	
	protected function _initialize(){
		
	}
	
	
	protected function findCurrTitle($title){
		foreach ($this->first_titles as $key => $value) {
			if($value['name'] == $title){
				$this->first_titles[$key]['class'] = 'active';
			}
		}
	}
	
	protected function error($message='',$jumpUrl='',$ajax=false){
		if(''===$message){
			$message = '你所访问的页面不存在';
		}
		parent::error($message,$jumpUrl,$ajax);
	}
	
	protected function getString($name,$default=''){
		return I($name,$default,'string');
	}
	
	protected function getInt($name,$default=0){
		return I($name,$default,'int');
	}
	protected function getArray($name,$default=array()){
		$res = I($name,$default);
		if(!is_array($res)){
			return array();
		}
		return $res;
	}
	
	protected function _empty($name){
		$this->error();
	}
	
	
	
	
}