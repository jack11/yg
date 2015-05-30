<?php
namespace Home\Controller;
class LoginController extends BaseController {
	


	public function index(){
		$this->display('login/login');
	}
	
	/**
	 * 验证码
	 */
	public function getCode() {
		$code = new \Tools\CheckCode();
		$code->setFont('ttfs/2.ttf')->setModel(4)->setWidth(94)->setHeight(25)->setPixel(1000)->setLine(2)->setSize(4)->setFontSize(17)->setSpace(20)->getImg();
	}
	
	public function login(){
		
		$code = new \Tools\CheckCode();
		if(!$code->check($_POST['code'])){
			$this->returnAjax(FALSE,'','验证码错误');
		}
		$username = $_POST['username'].'';
		$password = md5($_POST['password']);
		
		$m_member = D('Member');
		$member_info = $m_member->getOne(array('username'=>$username,'password'=>$password));
		if(!$member_info){
			$this->returnAjax(FALSE,'','用户名密码错误');
		}
		
		$update_member = array();
		$update_member['login_time']	= TIMESTAMP;
		$update_member['login_ip']		= $_SERVER['REMOTE_ADDR'];
		$update_member['last_time']		= $member_info['login_time'];
		$update_member['last_ip']		= $member_info['login_ip'];
		$update_member['login_times']	= $member_info['login_times']+1;
		$m_member->update(array('member_id'=>$member_info['member_id']),$update_member);
		
		//记录已经登陆
		$_SESSION['is_logined'] = 1;
		$_SESSION['member_info']		= $member_info;
		$this->returnAjax(TRUE,'','登陆成功');
	}

	/**
	 * 注册
	 */
	public function regist(){
		
		
		$this->display('login/regist');
	}
	
	/**
	 * 注册提交
	 */
	public function registAct(){
		
	}

}