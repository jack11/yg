<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this -> display('html/login');
	}
	
	public function login(){
		
		$code = new \Tools\CheckCode();
		if(!$code->check($_POST['code'])){
			$this->error('验证码错误');
		}
		$username = $_POST['user_name'].'';
		$password = md5($_POST['password']);
		
		$m_admin = D('Admin');
		$admin_info = $m_admin->getOne(array('username'=>$username,'password'=>$password));
		if(!$admin_info){
			$this->error('用户名密码错误');
		}
		
		//更新相关登陆信息
		$m_admin_log = D('AdminLog');
		$log_array = array();
		$log_array['admin_id'] = $admin_info['admin_id'];
		$log_array['login_time']	= TIMESTAMP;
		$log_array['login_ip']		= $_SERVER['REMOTE_ADDR'];
		$log_array['state']			= 1;
		$m_admin_log->loginLog($log_array);
		
		$update_admin = array();
		$update_admin['login_time']	= TIMESTAMP;
		$update_admin['login_ip']	= $_SERVER['REMOTE_ADDR'];
		$update_admin['last_time']	= $admin_info['login_time'];
		$update_admin['last_ip']	= $admin_info['login_ip'];
		$update_admin['login_times']= $admin_info['login_times']+1;
		$m_admin->updateAdmin($admin_info['admin_id'],$update_admin);
		
		//记录已经登陆
		$_SESSION['is_logined'] = 1;
		$_SESSION['admin_info']	= $admin_info;
		redirect(ADMIN_URL.'/index/index');
	}

	/**
	 * 验证码
	 */
	public function getCode() {
		$code = new \Tools\CheckCode();
		$code->setFont('ttfs/2.ttf')->setModel(4)->setWidth(94)->setHeight(25)->setPixel(1000)->setLine(2)->setSize(4)->setFontSize(17)->setSpace(20)->getImg();
	}
	
	protected function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}
	
	/**
	 * 退出
	 */
	public function loginOut(){
		unset($_SESSION['is_logined']);
		unset($_SESSION['admin_info']);
		$this->success('退出成功');
	}

}
