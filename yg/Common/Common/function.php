<?php

/**
 * test dump
 */
function dumps($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	exit;
}

/**
 * 判断是否是不为空数组
 */
function empty_array($array){
	if(empty($array) || !is_array($array)){
		return TRUE;
	}
	return FALSE;
}


function chkSubmit(){
	if(isset($_POST['form_submit']) && $_POST['form_submit']=='ok'){
		return TRUE;
	}
	return FALSE;
}

/**
 *  创建图片上传的路径
 */
function createImgFolder(){
	$folder_string = '';
	for($i=0;$i<3;$i++){
		$folder_string .= intval(mt_rand(1, 9)).'/';
	}
	mkdir(C('UPIMG_PATH').'/'.$folder_string,0777,TRUE);
	return $folder_string;
}

/**
 * 订单状态说明
 */
function getOrderStateAndDesc(){
	return  array('0'=>'已取消','10'=>'未付款','20'=>'已支付','99'=>'已完成');
}

/**
 * 建议状态说明
 */
function getSuggestStateAndDesc(){
	return  array('0'=>'已拒绝','1'=>'新增','2'=>'已采用');
}

/**
 * 商品地址
 */
function getGoodsUrl($goods_id){
	if($goods_id<=0){
		return '#';
	}
	return getUrl('goods/index',array('goods_id'=>$goods_id));
}

/**
 * 文章地址
 */
function getArticleUrl($art_id){
	if($art_id<=0){
		return '#';
	}
	return getUrl('article/index',array('article_id'=>$art_id));
} 

/**
 * 得到url
 */
function getUrl($url,$params=array(),$ext=''){
	return U($url,$params,$ext);
}

/**
 * 截取字符串
 */
function strCut($string,$length=null,$start=0,$encoding='UTF-8'){
	$string = trim($string);
	$new_string = mb_substr($string, $start,$length,$encoding);
	if($new_string != $string){
		$new_string .= '...';
	}
	return $new_string;
}

/**
 * 计算已经完成的百分比
 */
function getPercent($child,$parent){
	if($parent<=0){
		return 0;
	}
	$percent = ($child*100.00/$parent);
	if($percent>100){
		$percent = 100;
	}
	return sprintf('%.2f',$percent);
}


 
