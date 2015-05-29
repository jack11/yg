<?php

namespace Home\Controller;
class TestController extends BaseController {
	
	public function index(){
		//echo D('goods')->getGoodsList(array());
		/*
		$mail =  \Tools\mail\Mail::getInstance();
				//$mail = vendor('phpmail');
				//$mail = new \PHPMailer();
				
				$mail->send(1,2,'php0620@163.com','3','531612615@qq.com');*/
		
	}
	
	public function email(){
		$mail =  \Tools\mail\Mail::getInstance();
		$res = $mail->send(1,2,'531612615@qq.com','php0620@163.com','3');
		if($res){
			echo '发送成功';
		}else{
			echo '发送失败';
		}
	}
	
	public function fenci(){
		$fenci = new \Tools\Fenci\Fenci();
		$teststr = '我们是共产党我们';

		$fenci->SetSource($teststr);
		
		//设置分词属性
		$fenci -> resultType = 2;
		$fenci -> differMax = true;
	
		$fenci -> StartAnalysis();
	
		echo '<pre>';
		//获取你想要的结果
		print_r($fenci -> GetFinallyIndex());
	}

}
