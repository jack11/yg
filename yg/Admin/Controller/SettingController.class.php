<?php
namespace Admin\Controller;

class SettingController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	$m_setting = D('Setting');
    	if(chkSubmit()){
    		
			
			$update = array();
			$update['site_name']	= $this->getString('post.site_name');
			$update['site_logo']	= $this->getString('post.site_logo');
			$update['member_face']	= $this->getString('post.member_face');
			$update['site_seo']	= $this->getString('post.site_seo');
			$update['site_email']	= $this->getString('post.site_email');
			$update['upload_size_limit']	= $this->getString('post.upload_size_limit');
			$update['site_phone']	= $this->getString('post.site_phone');
			$update['site_status']	= $this->getString('post.site_status');
			$update['closed_reason']	= $this->getString('post.closed_reasons');
			
			$res = $m_setting->updateAll($update);
			if($res){
				$this->success('更新成功');
			}else{
				$this->error('更新失败');
			}
    	}
		
		$setting_list = $m_setting->getSettingList(array());
		$this->assign('setting',$setting_list);
		
        $this->display('html/setting');
    }
	
	public function first_index()
	{
		$this->assign('temp','综合信息');
		$this->display('Common/list');
	}
}