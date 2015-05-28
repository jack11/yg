<?php

namespace Common\Model;

class OrderModel extends BaseModel{
	
	
	/**
     * 返回是否允许某些操作
     * @param unknown $operate
     * @param unknown $order_info
     */
    public function getOrderOperateState($operate,$order_info){

        if (!is_array($order_info) || empty($order_info)) return false;

        switch ($operate) {

            //买家取消订单
        	case 'buyer_cancel':
        	   $state = $order_info['order_state'] == C('order_new') ;
        	   break;


           //平台取消订单
           case 'system_cancel':
               $state = $order_info['order_state'] == C('order_state_new');
               break;

           //平台收款
           case 'system_receive_pay':
               $state = $order_info['order_state'] == C('order_state_new');
               break;

	       //买家投诉
	       case 'complain':
	           $state = (in_array($order_info['order_state'],array(ORDER_STATE_PAY,ORDER_STATE_SEND)) ||
	               intval($order_info['finnshed_time']) > (TIMESTAMP - C('complain_time_limit'))) && $order_info['complain_state']==0;
	           break;

        }
        return $state;

    }
	
	/**
	 * 查询订单详情
	 * condition 查询条件
	 * extend 额外返回的信息 如member会追加返回订单会员信息
	 */
	public function getOrderDetail($condition,$extend=array()){
		$order_info = $this->getOne($condition);
		if(!$order_info){
			return false;
		}
		
		if(in_array('member', $extend)){
			$member_info = D('Member')->getOne(array('member_id'=>$order_info['buyer_id']));
			$order_info['extend_member'] = $member_info?$member_info:array();
		}

		if(in_array('luck', $extend) && $order_info['is_luck']){
			$luck_info = D('Luck')->getOne(array('order_id'=>$order_info['order_id']));
			$order_info['extend_luck'] = $luck_info?$luck_info:array();
		}
		
		if(in_array('log', $extend)){
			$log_list = D('OrderLog')->getList(array('order_id'=>$order_info['order_id']));
			$order_info['extend_log'] = $log_list?$log_list:array();
		}
		
		return $order_info;
	}
	
	/**
	 * 得到订单列表详情
	 */
	public function getOrderList($condition,$extend=array(),$limit='',$page='',$field='*',$order='order_id desc'){
		$order_list = $this->getList($condition,$limit,$page,$field,$order);
		if(empty($order_list)){
			return array();
		}
		if(empty($extend)){
			return $order_list;
		}
		
		foreach($order_list as $k=>$order_info){
			
			if(in_array('member', $extend)){
				$condition = array();
				$condition['member_id'] = $order_info['buyer_id'];
				$member_info = D('Member')->getOne($condition);
				$order_list[$k]['extend_member'] = $member_info;
			}
			
			if(in_array('goods_one', $extend)){
				$condition = array();
				$condition['order_id'] = $order_info['order_id'];
				$goods_info = D('OrderGoods')->getOne($condition);
				$order_list[$k]['extend_goods_info'] = $goods_info;
			}
			
			if(in_array('goods_list', $extend)){
				$condition = array();
				$condition['order_id'] = $order_info['order_id'];
				$goods_list = D('OrderGoods')->getList($condition);
				$order_list[$k]['extend_goods_list'] = $goods_list;
			}
		}
		return $order_list;
	}
}
