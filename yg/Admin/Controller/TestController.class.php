<?php
namespace Admin\Controller;
use Think\Controller;
class TestController  {
	
	public function index(){
		$pa = new \Tools\Fenci\Fenci();
		$teststr = '我们是共产党我们';
		
		$pa->SetSource($teststr);
		
		//设置分词属性
		$pa->resultType = 2;
		$pa->differMax  = true;
		
		$pa->StartAnalysis();
		
		echo '<pre>';
		//获取你想要的结果
		print_r( $pa->GetFinallyIndex());
	}
	
}