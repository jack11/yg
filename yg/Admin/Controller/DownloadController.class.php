<?php
namespace Admin\Controller;

class DownloadController extends BaseController {
	
	protected function _initialize(){
	}
	
	
	public function xz_word(){
		$this->assign('temp','资料下载');
		$this->display('Download/dl_list');
	}
	
	public function xz_soft(){
		$this->assign('temp','软件下载');
		$this->display('Download/dl_list');
	}
	
	
	/*
	 * 操作方法
	 * */
	public function add(){
		$type = $this->getString("type");
		// $this->assign('op',0);
		$this->assign('item',$type);
        $this->display('Download/download');
    }
	
	public function update(){
		$type = $this->getString("type");
		$this->assign('op',1);
		$this->assign('item',$type);
		$this->assign('title',"这是标题");
		$this->assign('imgpath',"/guangda/ThinkPHP/Public/upload/images/docx_win.png");
		$this->assign('content',"这是内容");
        $this->display('Download/download');
    }
	
	public function delete(){
		$type = $this->getString("type");
		$this->assign('item',$type);
        $this->display('Common/detail');
    }
	
	public function search(){
		$kw = $this->getString("search_word");
		$this->assign('kw',$kw);
        $this->display('Download/dl_list');
    }
}