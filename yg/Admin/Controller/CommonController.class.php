<?php
namespace Admin\Controller;

class CommonController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
	public function pic_upload(){
		
		    $upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     UP_IMAGE; // 设置附件上传根目录
		    $upload->savePath  =     ''; // 设置附件上传（子）目录
		    // 上传文件 
		   // $info   =   $upload->upload();

			if (!empty($_FILES['_pic']['tmp_name'])){
				//$result = $upload->upfile('_pic');
				$result =   $upload->uploadOne($_FILES['_pic']);
				if ($result){
					exit(json_encode(array('status'=>1,'url'=>$result['savepath'].$result['savename'])));
				}else {
					exit(json_encode(array('status'=>0,'msg'=>$upload->getError)));
				}
			}
		
	}
	
	/**
	 * 图片裁剪
	 *
	 */
	public function pic_cut(){
		//import('function.thumb');
		if (chksubmit()){
			$thumb_width = $_POST['x'];
			$x1 = $_POST["x1"];
			$y1 = $_POST["y1"];
			$x2 = $_POST["x2"];
			$y2 = $_POST["y2"];
			$w = $_POST["w"];
			$h = $_POST["h"];
			$scale = $thumb_width/$w;
			$src = str_ireplace(UPLOAD_SITE_URL,BASE_UPLOAD_PATH,$_POST['url']);
			if (!empty($_POST['filename'])){
// 				$save_file2 = BASE_UPLOAD_PATH.'/'.$_POST['filename'];
				$save_file2 = str_ireplace(UPLOAD_SITE_URL,BASE_UPLOAD_PATH,$_POST['filename']);
			}else{
				$save_file2 = str_replace('_small.','_sm.',$src);
			}
			$cropped = resize_thumb($save_file2, $src,$w,$h,$x1,$y1,$scale);
			@unlink($src);
			$pathinfo = pathinfo($save_file2);
			//<<<<<<
			//exit($pathinfo['basename']);		
			//<<<<<<
			//>>>>>>
			$file = $pathinfo['basename'];
			fileServiceConvert($file);
			exit($file);
			//>>>>>>
		}
		$save_file = str_ireplace(UP_IMAGE,BASE_UPLOAD_PATH,$_GET['url']);
		$_GET['resize'] = $_GET['resize'] == '0' ? '0' : '1';
		$this->assign('height',100);
		$this->assign('width',200);
		//Tpl::showpage('common.pic_cut','null_layout');
		$this->display('html/common.pic_cut');
	}

}