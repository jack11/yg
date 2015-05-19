<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
	
	public function __construct(){
		parent::__construct();
		
		$this->_showMenu();
	}
	
	protected function _initialize(){
		if(!$this->isLogined()){
			//$this->redirect('User/login');
		}
	}
	
	protected function isLogined(){
		return !empty($this->getArray('session.admin'));
	}
	
	/**
	 * 成功
	 */
	 protected function success($message = '', $jumpUrl = '', $ajax = false){
	 	parent::success($message);
		exit;
	 }
	
	/**
	 * 错误信息
	 */
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
	
	protected function _showMenu(){
		$menus_list = array(
			'0'	=> array(
				'name'	=> '设置',
				'link'	=> 'setting',
				'child'	=> array(
					array(
						'name'	=> '站点设置',
						'link'	=> 'setting',
					),
				),
			),
			'1'	=> array(
				'name'	=> '商品',
				'link'	=> 'goods',
				'child'	=> array(
					array(
						'name'	=> '商品管理',
						'link'	=> 'goods',
					),
					array(
						'name'	=> '分类管理',
						'link'	=> 'goods_class',
					),
					array(
						'name'	=> '品牌管理',
						'link'	=> 'brand',
					),
				),
			),
			'2'	=> array(
				'name'	=> '订单',
				'link'	=> 'order',
				'child'	=> array(),
			),
			'3'	=> array(
				'name'	=> '会员',
				'link'	=> 'member',
				'child'	=> array(),
			),
			'4'	=> array(
				'name'	=> '网站',
				'link'	=> 'article',
				'child'	=> array(),
			),
		);
		$this->assign('top_menus_list',$menus_list) ;
		
	}
}
	