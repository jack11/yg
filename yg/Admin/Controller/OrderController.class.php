<?php
namespace Admin\Controller;
use Common\Controller\InitController;

class BaseController extends InitController {
	
	public function __construct(){
		parent::__construct();
		
	}

	public function index(){
		
		$condition = array();
		if($_GET['order_sn']){
			$condition['order_sn'] = $_GET['order_sn'];
		}
		if(isset($_GET['order_state']) && $_GET['order_state']!==''){
			$condition['order_state'] = $_GET['order_state'];
		}
		if($_GET['buyer_name']){
			$condition['buyer_name'] = array('like','%'.$_GET['buyer_name'].'%');
		}
		if($_GET['payment_code']) {
            $condition['payment_code'] = intval($_GET['payment_code']);
        }
		if(isset($_GET['is_luck']) && $_GET['is_luck'] !== ''){
			$condition['is_luck'] = $_GET['is_luck'];
		}
		$if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_time']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_time']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_time']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_time']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('between',array($start_unixtime,$end_unixtime));
        }
		
		$m_order = D('Order');
		$page_size = 15;
		$page = $m_order->getPage($condition,$page_size);
		$this->assign('show_page',$page);
		
		$order_list = $m_order->getList($condition,'',intval($_GET['p']).','.$page_size);
		foreach ($order_list as $k=>$v) {
			$order_list[$k]['if_cancle'] = $m_order->getOrderOperateState('system_cancel',$v);
			$order_list[$k]['if_receive'] = $m_order->getOrderOperateState('system_receive_pay',$v);
		}
		$this->assign('order_list',$order_list);
		
		//订单状态
		$state_list = array('0'=>'取消','10'=>'未付款','20'=>'已支付','99'=>'已完成');
		$this->assign('state_list',$state_list);
		
		//付款方式
		$payment_list = D('Payment')->getList(array());
		$this->assign('payment_list',$payment_list);
		
		$this->display('html/order.index');
	}

	public function detail(){
		$order_id = intval($_GET['order_id']);
		if($order_id<=0){
			$this->error('非法操作');
		}
		$m_order = D('Order');
		$order_info = $m_order->getOrderDetail(array('order_id'=>$order_id),array('luck'));
		if(!$order_info){
			$this->error('不存在该订单');
		}
		$this->assign('order_info',$order_info);
		
		$state_list = getOrderStateAndDesc();
		$this->assign('state_list',$state_list);
		
		$this->display('html/order.detail');
		
	}
	
	public function cancle(){
		$order_id = intval($_GET['order_id']);
		$this->checkId($order_id);
		
		$m_order = D('Order');
		$order_info = $m_order->getOne(array('order_id'=>$order_id));
		if(!$m_order->getOrderOperateState('system_cancel',$order_info)){
			$this->error('不可操作');
		}
		$res = $m_order->update(array('order_id'=>$order_id),array('order_state'=>C('order_state_cancle')));
		if($res){
			$insert = array();
			$insert['order_id'] = $order_id;
			$insert['log_msg']	= '管理员取消订单：'.$_GET['message'];
			$insert['log_time']	= TIMESTAMP;
			$insert['log_role']	= '管理员';
			$insert['log_user'] = $_SESSION['admin_info']['username'];
			$insert['log_orderstate'] = $order_info['order_state'];
			D('OrderLog')->add($insert);
			$this->success('取消成功');
			exit;
		}
		$this->error('取消失败');
		
	}
}
	