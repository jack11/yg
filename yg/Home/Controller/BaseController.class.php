<?php
namespace Home\Controller;
use Common\Controller\InitController;

class BaseController extends InitController {

	public function __construct(){
		
		parent::__construct();
		$this->defineVar();
		$this->setHeader();
		
		$m_goods_class = D('GoodsClass');
		
		//分类
		$class_list = $m_goods_class->getList(array());
		$this->assign('class_list',$class_list);
		//$class_list = $this->getClassTree($class_list);
		
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
	 * 得到树形class 2级
	 */
	 protected function getClassTree($class,$parent_id = 0,$deep=1){
	 	if(!empty_array($class)){
	 		return array();
	 	}
		
	 	$tree = array();	//返回数组
	 	foreach ($class as $key => $value) {
			 if($value['parent_id'] == $parent_id);
		 }
	 }
	
	/**
	 * 定义常量
	 */
	private final function defineVar(){
		//运行时间
		define('TIMESTAMP', time());
	
		//订单状态 0取消 10新增 20已支付 30完成
		define('ORDER_CANCLE', 0);
		define('ORDER_NEW',10);
		define('ORDER_PAY', 20);
		define('ORDER_FINISH', 30);
		
	}
	
	
}