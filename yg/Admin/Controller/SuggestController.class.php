<?php
/**
 * 建议
 */
namespace Admin\Controller;

class SuggestController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$m_suggest = D('Suggest');
		
		$condition = array();
		if($_GET['username']){
			$condition['member_name'] = array('like',"%{$_GET[username]}%");
		}
		if(isset($_GET['state']) && $_GET['state'] !== ''){
			$condition['state'] = intval($_GET['state']);
		}
		
		//分页
		$page_size = 10;
		$page = $m_suggest->getPage($condition,$page_size);
		$this->assign('show_page',$page);

		$suggest_list = $m_suggest->getList($condition,'',intval($_GET['p']).','.$page_size);
		$this->assign('suggest_list',$suggest_list);
		
		$this->assign('state_list',getSuggestStateAndDesc());
		$this->assign('search',$_GET);
		$this->display('html/suggest.index');
	}
	
	public function state(){
		$suggest_id = $this->checkId('suggest_id');
		$state = $_GET['state'] ? intval($_GET['state']) : 1;
		
		$res = D('Suggest')->update(array('suggest_id'=>$suggest_id),array('state'=>$state));
		if(!$res){
			$this->error('更新失败');
		}
		$this->success('更新成功');
	}
}