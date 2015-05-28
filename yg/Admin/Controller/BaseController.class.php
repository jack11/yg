<?php
namespace Admin\Controller;
use Common\Controller\InitController;

class BaseController extends InitController {
	
	public function __construct(){
		parent::__construct();
		$this->checkLogin();

		$this->_showMenu();
		
	}

	protected function checkLogin(){
		if(!$_SESSION['is_logined']){
			redirect(ADMIN_URL.'login/index');
		}
	}
	
	/**
	 * 成功
	 */
	 protected function success($message = '', $jumpUrl = '', $ajax = false){
	 	parent::success($message,$jumpUrl,$ajax);
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
				'name'	=> '网站管理',
				'link'	=> 'setting',
				'child'	=> array(
					array(
						'name' => '欢迎',
						'link' => 'welcome',
					),
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
					array(
						'name' => '建议管理',
						'link' => 'suggest',
					),
				),
			),
			'2'	=> array(
				'name'	=> '订单',
				'link'	=> 'order',
				'child'	=> array(
					array(
						'name' => '订单管理',
						'link' => 'order',
					),
				),
			),
			'3'	=> array(
				'name'	=> '会员',
				'link'	=> 'member',
				'child'	=> array(
					array(
						'name' => '会员管理',
						'link' => 'member',
					),
				),
			),
		);
		$this->assign('top_menus_list',$menus_list) ;
	}
}
	