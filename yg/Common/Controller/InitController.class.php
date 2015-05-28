<?php

/**
 * 整个网站的父类，用于初始化整个网站的一些配置信息
 */
 
namespace Common\Controller;
use Think\Controller;
 
class InitController extends Controller{
	
	
	public function __construct(){
		parent::__construct();
		
		//获取网站的配置
		$setting_list  = M('Setting')->select();
		$new_setting_list = array();
		foreach($setting_list as $v){
			$new_setting_list[$v['name']] = $v['value'];
		}
		C('setting',$new_setting_list);
		unset($new_setting_list,$setting_list);
		
		
	}
	
	/**
	 * 上传文件
	 */
	protected function uploadImg($name){
		if($_FILES[$name]['name']){
			$upload = new \Think\Upload();// 实例化上传类
		    $upload->rootPath  =     C('UPIMG_PATH').'/'; // 设置附件上传根目录
		    $upload->savePath  =     createImgFolder(); // 设置附件上传（子）目录
		    if($_FILES[$name]['name']){		
		    	$result =   $upload->uploadOne($_FILES[$name]);
				if($result){
					$path = $result['savepath'].$result['savename'];
					return $path;
				}else{
					$this->error($upload->getError());
				}
		    }
		}
		return FALSE;
	}
	
	protected function checkId($id){
		$id = intval(I($id));
		if($id<=0){
			$this->error('非法访问');
		}
		return $id;
	}
	
	/**
	 * ajax返回数据
	 */
	protected function returnAjax($state=true,$data=array(),$message=''){
		$return = array();
		$return['state']	= $state;
		$return['data']		= $data;
		$return['message']	= $message;
		echo json_encode($return);
		exit;
	}
}
