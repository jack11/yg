<?php
namespace Home\Controller;
class IndexController extends BaseController {
	

    public function index(){
    	
		$m_goods = D('goods');
		//最新5个推荐商品
		$g_image_list = $m_goods->getOnlineGoodsList(array('is_commend'=>1),'*','',5);
		$this->assign('t_commend_list',$g_image_list);
		
		//2个新品
		$g_new_list = $m_goods->getOnlineGoodsList(array('is_new'=>1),'*','',2);
		$this->assign('t_new_list',$g_new_list);
		
		//公告
		$m_notice = D('Notice');
		$notice_list = $m_notice->getNoticeList(array(),'*','',3);
		$this->assign('t_notice_list',$notice_list);
		
		//最新揭晓的4个商品
		$condition = array();
		$condition['end_time'] 	= array('egt',TIMESTMP);
		$end_goods_list = $m_goods->getOnlineGoodsList($condition,'*','',4,'end_time desc');
		
		//中奖4个用户
		$m_luck = D('Luck');
		$luck_list = $m_luck->getLuckList(array(),4);
		$this->assign('luck_list',$luck_list);
		
		//8个推荐商品
		$commend_list = $m_goods->getOnlineGoodsList(array('is_commend'=>1),'*','',8);
		$this->assign('commend_list',$commend_list);
		
		//最新购买8个用户
		$m_order = D('Order');
		$order_list = $m_order->getOrderList(array('order_state'=>ORDER_NEW),8);
		$this->assign('order_list',$order_list);
		
		//10个新品
		$new_list = $m_goods->getOnlineGoodsList(array('is_new'=>1),'*','',10);
		$this->assign('new_list',$new_list);
		
		//晒单
		
		
		$this->display('Index/index');
    }
	
	

}