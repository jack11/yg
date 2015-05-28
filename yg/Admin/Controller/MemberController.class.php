<?php
/**
 * 会员
 */
namespace Admin\Controller;

class MemberController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
	/**
	 * 分类列表
	 */
    public function index(){
		$m_member = D('Member');
		/**
		 * 检索条件
		 */
		$condition = array();
		if ($_GET['text_type'] && $_GET['text_value']){
			switch ($_GET['text_type']) {
				case 'username': $name = 'username' ; break;
				default : $name = 'username' ; break;
			}
			$condition[$name] = array('like',"%{$_GET['text_value']}%");
		}
		if(isset($_GET['state']) && $_GET['state'] !== ''){
			$condition['state'] = intval($_GET['state']);
		}
		
		//分页
		$page_size = 10;
		$page = $m_member->getPage($condition,$page_size);
		$this->assign('show_page',$page);

		$member_list = $m_member->getList($condition,'',intval($_GET['p']).','.$page_size);
		$this->assign('member_list',$member_list);

		$this->assign('search',$_GET);
		$this->display('html/member.index');
	}
	
	/**
	 * 更改访问权限
	 */
	public function state(){
		$member_id = $this->checkId('member_id');
		
		$state = intval($_GET['state']) ? 1 : 0;
		
		$m_member = D('Member');
		$res = $m_member -> update(array('member_id'=>$member_id),array('state'=>$state));
		if($res){
			$this->success('编辑成功');
			exit;
		}
		$this->error('编辑失败');
	}
}