<?php

/**
 * 发送邮件
 */
namespace Tools\mail;
class Mail{
	private $phpmailer = null;
	private static $instance = null;
	
	protected function __construct(){
		require_once __DIR__.'/PHPMailer/class.phpmailer.php';
		$this->phpmailer = new \PHPMailer();
		//连接
		$this->phpmailer->Host = 'smtp.163.com';	//主机
		$this->phpmailer->SMTPAuth = true;		//是否需要登录
		$this->phpmailer->Username = 'php0620@163.com';
		$this->phpmailer->Password = '12345gy';	
		
		//邮件配置
		$this->phpmailer->CharSet = 'utf-8';	//语言
		$this->phpmailer->From = 'php0620@163.com';	//发件人地址
		$this->phpmailer->FromName = 'php';	//发件人姓名
		$this->phpmailer->Mailer = 'smtp';	//方式
		//$this->phpmailer->Port = 25;
		$this->phpmailer->AddAddress('531612615@qq.com');		//接受者
		//$this->phpmailer->AddCC('824144294@qq.com');	//抄送
		
	}
	
	public static function getInstance(){
		if( self::$instance instanceof self && self::instance){
			return self::instance;
		}
		return new self();
	}
	
	public function __set($name,$value){
		$this->phpmailer->$name = $value;
	}
	
	public function __get($name){
		return $this->phpmailer->$name;
	}
	
	/**
	 * 发送邮件
	 * @param subject 主题
	 * @param body 
	 */
	public function send($subject,$body,$from,$fromname,$to){
		$this->phpmailer->Subject	= $subject;
		$this->phpmailer->Body		= $body;
		$this->phpmailer->From 		= $from;
		$this->phpmailer->FromName	= $fromname;
		$this->phpmailer->AddAddress($to);
		
		return $this->phpmailer->send();
	}
}
