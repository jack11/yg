<?php
namespace Home\Controller;
class IndexController extends BaseController {
	
	protected $allow_category_id = array(0);
	
	
    public function index(){
    	$this->assign('left_nav',$tree);
		$this->assign('right_nav',$nav);
		$this->display('Index/index');
    }
	
	/**
	 * 综合信息
	 */
	protected function multiple(){
		
	}
	
	/**
	 *  重要信息 
	 */
	protected function important(){
		
	}
	
	/**
	 * 条线信息
	 */
	 protected function line(){
	 	
	 }
	 
	 /**
	  * 部门信息
	  */
	  protected function department(){
	  	
	  }
	  
	  /**
	   * 产品
	   */
}