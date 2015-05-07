<?php
namespace Admin\Controller;

class ListController extends BaseController {
	
	protected function _initialize(){
	}
	
	/*
	 * 具体页面
	 */ 
    public function mul(){
    	$this->assign('temp','综合信息');
		$cate_id = $this->getCateId('综合信息');
		$information = D('Information');
		$ims = $information->where(array('category_id'=>$cate_id))->order('uptime desc')->limit(10)->select();
		$this->assign('ims',$ims);
        $this->display('Common/list');
    }
	
	public function import(){
		$this->assign('temp','重要通知');
        $this->display('Common/list');
	}
	
	public function bran_msg(){
		$this->assign('temp','分行信息');
        $this->display('Common/list');
	}
	
	public function bran_iss(){
		$this->assign('temp','分行发文');
        $this->display('Common/list');
	}
	
	public function sline(){
		$slid = $this->getString("id");
		$temp = '';
		switch ($slid) {
			case '1':
				$temp = '对公条线';
				break;
			case '2':
				$temp = '零售条线';
				break;
			case '3':
				$temp = '运营条线';
				break;
			case '4':
				$temp = '风险条线';
				break;
			default:
				break;
		}
		$this->assign('temp',$temp);
        $this->display('Common/list');
	}
	
	public function depart(){
		$slid = $this->getString("id");
		$temp = '';
		switch ($slid) {
			case '1':
				$temp = '公司业务部';
				break;
			case '2':
				$temp = '零售业务部';
				break;
			case '3':
				$temp = '办公室';
				break;
			case '4':
				$temp = '计划财务部';
				break;
			case '5':
				$temp = '风险管理部';
				break;
			case '6':
				$temp = '营业部';
				break;
			case '7':
				$temp = '业务一部';
				break;
			case '8':
				$temp = '业务二部';
				break;
			default:
				break;
		}
		$this->assign('temp',$temp);
        $this->display('Common/list');
	}
	
	/*
	 * 操作方法
	 * */
	public function add(){
		$type = $this->getString("type");
		$this->assign('op',0);
		$this->assign('item',$type);
        $this->display('Common/detail');
    }
	
	public function update(){
		$type = $this->getString("type");
		$id = $this->getString("id");
		$this->assign('op',1);
		$this->assign('item',$type);
		$information = D("Information");
		$im = $information->where(array("id"=>$id))->find();
		$this->assign('im',$im);
        $this->display('Common/detail');
    }
	
	public function delete(){
		$type = $this->getString("type");
		$this->assign('item',$type);
        $this->display('Common/detail');
    }
	
	public function search(){
		$kw = $this->getString("search_word");
		$this->assign('kw',$kw);
        $this->display('Common/list');
    }
	
	/*
	 * 数据操作
	 * */

	function add_detail(){
		$type = $this->getString("type");
		$title = $this->getString("title");
		$content = $this->getString("content");
		if(empty($title)||empty($content)){
			$this->error('添加'.$type.'失败');
			return;
		}
		$admin = session('admin');
		$admin_id = $admin['id'];
		$time = time();
		$cate_id = $this->getCateId($type);
		
		$inforModel = array(
			"admin_id"=>$admin_id,
			"category_id"=>$cate_id,
			"content"=>$content,
			"count"=>0,
			"title"=>$title,
			"uptime"=>$time,);
		$information = D('Information');
		$iss = $information->add($inforModel);
		if($iss){
			$this->success('添加'.$type.'《'.$title.'》成功');
		}else{
			$this->error('添加'.$type.'失败');
		}
	}
	
	function update_detail(){
		$type = $this->getString("type");
		$title = $this->getString("title");
		$content = $this->getString("content");
		$id = $this->getString("id");
		if(empty($title)||empty($content)){
			$this->error('更新'.$type.'失败');
			return;
		}
		$information = D('Information');
		$im = $information->where(array("id"=>$id))->find();
		$im['title'] = $title;
		$im['content'] = $content;
		$iss = $information->save($im);
		if($iss){
			$this->success('更新'.$type.'《'.$title.'》成功');
		}else{
			$this->error('更新'.$type.'失败');
		}
	}
	
	public function getCateId($cate_name){
		$category = D('Category');
		$cate_id = $category->getIdByName($cate_name);
		return $cate_id;
	}
}
