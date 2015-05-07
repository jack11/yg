<?php
namespace Admin\Controller;

class CulturalController extends BaseController {
	
	protected function _initialize(){
	}
	
	public function whfc(){
		$this->assign('temp','文化风采');
        $this->display('Cultural/cultural_list');
	}
	
	/*
	 * 操作方法
	 * */
	public function add(){
		$type = $this->getString("type");
		// $this->assign('op',0);
		$this->assign('item',$type);
        $this->display('Cultural/cul_detail');
    }
	
	public function update(){
		$type = $this->getString("type");
		$this->assign('op',1);
		$this->assign('item',$type);
		$this->assign('title',"这是标题");
		// $this->assign('imgpath',"/guangda/ThinkPHP/Public/upload/images/docx_win.png");
		$this->assign('content',"这是内容");
        $this->display('Cultural/cul_detail');
    }
	
	public function delete(){
		$type = $this->getString("type");
		$this->assign('item',$type);
        $this->display('Cultural/detail');
    }
	
	public function search(){
		$kw = $this->getString("search_word");
		$this->assign('kw',$kw);
        $this->display('Cultural/cultural_list');
    }
}