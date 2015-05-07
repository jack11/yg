<?php
namespace Home\Controller;
class CartController extends BaseController {
	
	protected $allow_category_id = array(0);
	
	
    public function index(){
    	$this->display('html/cart');
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