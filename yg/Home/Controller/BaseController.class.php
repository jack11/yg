<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {

	public function __construct(){
		
		parent::__construct();
		$this->setHeader();
		
		$m_goods_class = M('goods_class');
		
		//分类
		$class_list = $m_goods_class->getClassList(array());
		$class_list = $this->getClassTree($class_list);
	}
	
	protected function _initialize(){
		
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
	
	/**
	 * 设置头
	 */
	protected function setHeader(){
		header('Content-type:text/html;charset=utf-8');
	}
	
	/**
	 * 得到树形class
	 */
	 protected function getClassTree($class,$deep='2'){
	 	if(!empty_array($class)){
	 		return array();
	 	}
		
	 	$tree = array();	//返回数组
	 	for ($i=0; $i < $deep; $i++) { 
			 
		 }
	 }
	
	
	
	
}