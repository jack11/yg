<?php
/**
 * 任务处理
 */
namespace Admin\Controller;

class CrontabController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
	public function index(){
		
	}
	
	/**
	 * 商品处理
	 */
	public function goods(){
		
		$m_order = D('Order');
		$m_goods = D('Goods');
		
		$size = 500;
		for ($i=0; ; $i+=$size) {
			$limit = $i.','.$size; 
			
			$condition = array();
			$condition['end_time'] 	= array('lt',TIMESTAMP);
			$condition['state']		= C('goods_state_new');
			
			$goods_list = $m_goods->getList($condition,$limit,'','*','goods_id desc');
			if(empty($goods_list)){
				break;
			}
			
			$cancel_list = array();	//取消
			$luck_list	 = array();	//中奖的
			foreach($goods_list as $goods_info){
				if($goods_info['goods_number'] > $goods_info['seller_number']){
					$cancel_list[] = $goods_info;
				}else{
					$luck_list[] = $goods_info;
				}
			}
			$this->_cancel_goods($cancel_list);
			$this->_luck_goods($luck_list);
		}
		
		echo 'Success';
	}
	
	/**
	 * 取消的商品处理
	 */
	public function _cancel_goods($goods_list){
		$m_order = D('Order');
		$m_order_goods = D('OrderGoods');
		foreach ($goods_list as $key => $goods_info) {
			$seller_number = ceil($goods_info['seller_number']);
			$numbers = array();
			for ($i=0; $i < $seller_number; $i++) { 
				$numbers[] = $i;
			}
			$numbers = array_values(shuffle(shuffle($numbers)));	//打乱数组
			$luck_number = ceil(mt_rand(0, $goods_info['seller_number']));
			$luck_number = $numbers[$luck_number];
			
			$order_goods_list = $m_order_goods->getList(array('goods_id'=>$goods_info['goods_id'],'goods_state'=>1));
			$num = 0;
			$luck_order_goods_info = array();	//中的商品信息
			
			foreach ($order_goods_list as $key => $value) {
				$num  += $value['goods_number'];
				if($num>=$luck_number ){
					$luck_order_goods_info = $value;
					break;
				}
			}
			
			//更新所有订单商品表
			$m_order_goods->update(array('goods_id'=>$goods_info['goods_id'],'goods_state'=>1),array('goods_state'=>2));
			$m_order_goods->update(array('order_goods_id'=>$luck_order_goods_info['order_goods_id']),array('goods_state'=>3));
		}
	}
	
	/**
	 * 开奖商品处理
	 */
	public function _luck_goods($goods_list){
		
	}
}