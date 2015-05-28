<?php
namespace Home\Controller;
class IndexController extends BaseController {
	

    public function index(){
    	
		$m_goods = D('Goods');
		//最新5个推荐商品
		$g_image_list = $m_goods->getOnlineGoodsList(array('is_commend'=>1),5);
		$this->assign('t_commend_list',$g_image_list);
		
		//2个新品
		$g_new_list = $m_goods->getOnlineGoodsList(array('is_new'=>1),2);
		$this->assign('t_new_list',$g_new_list);
		
		//公告
		$m_notice = D('Notice');
		$notice_list = $m_notice->getList(array(),3,'','*','add_time desc');
		$this->assign('t_notice_list',$notice_list);
		
		//揭晓的总数
		$count = $m_goods->getCount(array('state'=>C('goods_state_finnish')));
		$this->assign('finnish_count',$count);
		
		//最新准备揭晓的4个商品
		$condition = array();
		$condition['end_time'] 	= array('egt',TIMESTAMP);
		$end_goods_list = $m_goods->getOnlineGoodsList($condition,4,'','','end_time desc');
		$this->assign('t2_goods_list',$end_goods_list);
		
		//中奖4个用户
		$m_luck = D('Luck');
		$luck_list = $m_luck->getList(array(),4);
		$this->assign('luck_list',$luck_list);
		
		//8个推荐商品
		$commend_list = $m_goods->getOnlineGoodsList(array('is_commend'=>1),8);
		$this->assign('commend_list',$commend_list);
		
		//最新购买11个用户
		$m_order = D('Order');
		$order_list = $m_order->getOrderList(array(),array('member','goods_one'),11);//$m_order->getList(array(),8,'','*','order_id desc');
		$this->assign('order_list',$order_list);
		
		//12个新品
		$new_list = $m_goods->getOnlineGoodsList(array('is_new'=>1),12);
		$this->assign('new_list',$new_list);
		
		//晒单
		
		
		$this->display('Index/index');
    }
	
	

}