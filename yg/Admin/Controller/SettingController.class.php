<?php
namespace Admin\Controller;

class SettingController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	$m_setting = D('Setting');
    	if(chkSubmit()){
    		dumps($_FILES);
			
			$update = array();
			$update['site_name']	= $this->getString('post.site_name');
			//$update['site_logo']	= $this->getString('post.site_logo');
			//$update['member_face']	= $this->getString('post.member_face');
			$update['site_seo']	= $this->getString('post.site_seo');
			$update['site_email']	= $this->getString('post.site_email');
			$update['upload_size_limit']	= $this->getInt('post.upload_size_limit')*1024;
			$update['site_phone']	= $this->getString('post.site_phone');
			$update['site_status']	= $this->getString('post.site_status');
			$update['closed_reason']	= $this->getString('post.closed_reasons');
			
			//logo
			if($_FILES){
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->rootPath  =     C('UPIMG_PATH').'/'; // 设置附件上传根目录
			    $upload->savePath  =     ''; // 设置附件上传（子）目录
			    if($_FILES['site_logo']['name']){		//logo
			    	$result =   $upload->uploadOne($_FILES['site_logo']);
					if($result){
						$path = $result['savepath'].$result['savename'];
						$update['site_logo']	= $path;
					}else{
						$this->error($upload->getError());
					}
			    }
				if($_FILES['member_face']['name']){		//member_face
					$result =   $upload->uploadOne($_FILES['member_face']);
					if($result){
						$path = $result['savepath'].$result['savename'];
						$update['member_face']	= $path;
					}else{
						$this->error($upload->getError());
					}
				}
			}


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