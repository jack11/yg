<?php
namespace Admin\Controller;

class IndexController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
    public function index(){
        $this->display('Index/index');
    }
	
	/**
	 * 修改密码
	 */
	public function modify(){
		if(chkSubmit()){
			if(!$_POST['old_password'] || !$_POST['password'] || !$_POST['re_password']){
				$this->error('非法访问');
			}
			if($_SESSION['admin_info']['password'] != md5($_POST['old_password'])){
				$this->error('密码错误');
			}
			if(md5($_POST['password']) != md5($_POST['re_password'])){
				$this->error('两次密码不一样');
			}
			
			$condition['admin_id'] = $_SESSION['admin_info']['admin_id'];
			$update['password'] = md5($_POST['password']);
			$res = D('Admin')->update($condition,$update);
			if(!$res){
				$this->error('更新失败');
			}
			unset($_SESSION['is_logined'],$_SESSION['admin_info']);
			$this->success('更新密码成功');
		}
		$this->display('Index/password');
	}
}