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
		if(!$this->check_verify($_POST['code'])){
			$this->error('验证码错误');
		}
		$username = $_POST['user_name'].'';
		$password = md5($_POST['password']);
		
		$m_admin = D('Admin');
		$admin_info = $m_admin->getOne();
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
		$config = array(
			'fontSize' => 13, // 验证码字体大小
			'length' => 4, // 验证码位数
			'useNoise' => false, // 关闭验证码杂点
			'imageH'=>0,
			'imageW'=>90,
		);
		$Verify = new \Think\Verify($config);
		$Verify -> entry();
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
