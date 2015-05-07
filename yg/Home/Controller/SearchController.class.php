<?php

namespace Home\Controller;
class SearchController extends BaseController {
	
	public function result(){
		//是否是按搜索提交的
		$is_submit = $this->getString('get.submit');
		if(IS_POST){
			$is_submit = TRUE;
		}else{
			$is_submit = FALSE;
		}
		$data['keyword'] = $keyword = trim($this->getString('keyword'),'');
		//$keyword = explode(' ', $keyword);
		if(empty($keyword)){
			$this->error('请输入关键字');
		}
		//分词
		$pa = new \Tools\Fenci\Fenci();
		$pa->SetSource($keyword);	
		//设置分词属性
		$pa->resultType = 2;
		$pa->differMax  = true;
		$pa->StartAnalysis();
		$keyword = $pa->GetFinallyIndex();
		
		$data['time'] = $time = $this->getInt('get.time');
		if($time<=0){
			$time = 0;
		}
		$time = $time * 3600 * 24;
		
		$data['type'] = $type = trim($this->getInt('get.type'));
		$type = ($type<=0 || $type>2)?0:$type;
		
		$data['order'] = $order = trim($this->getInt('get.order'));
		$order = $order==0?'desc':'asc';
		
		$info = D('Information');
		$list = $info->getArticleByParams($keyword,$time,$type,$order);
		$data['count'] = $list['count'];
		$list = $list['list'];
		if($list){
			$cate_ids = array();
			foreach ($list as  $value) {
				if(!in_array($value['category_id'], $cate_ids)){
					$cate_ids[] = $value['category_id'];
				}
			}
			$cate = D('Category');
			$names = $cate->getNameByIds($cate_ids);
			foreach ($list as $key => $value) {
				foreach ($names as  $v) {
					if($value['category_id'] == $v['id']){
						$list[$key]['category_name'] = $v['name'];
					}
				}
			}
			
			$p = new \Think\Page();
			$size = 10;
			$pageCode = $p->setPageSize(8)->setSign('p')->getCode($data['count'], $size);
			$this->assign('pageCode',$pageCode);
		}
		
		//热点词
		$hotword = D('Hotword');
		$is_submit?$hotword->updateWord($keyword):'';
		$data['hotword'] = $hotword->getHotWord(7);
		
		//查询条件生成
		$data['no_time'] = $this->noSomethingUrl('time');
		$data['no_type'] = $this->noSomethingUrl('type');
		$data['no_order'] = $this->noSomethingUrl('order');

		//cookie的生成		
		$cookie =  json_decode(cookie('word'),true);
		if(empty($cookie)) $cookie=array();
		if($is_submit){
			$data['history'][0]['keyword'] = $data['keyword'];
			$data['history'][0]['url'] = $this->noSomethingUrl('');
			$i=1;
			$flag = false;
			foreach ($cookie as $value) {
				if(++$i>10){
					break;
				}
				$value = $value;
				if($data['keyword']==$value['keyword']){
					$flag = true;
					continue;
				}
				$data['history'][$i] = $value;
			}
			cookie('word',json_encode($data['history']),3600*24*30);
		}else{
			$data['history'] = $cookie;
		}
		
		$this->assign('first_title',$this->first_titles);
		$this->assign('list',$list);
		$this->assign('data',$data);
		$this->display('Search/result');
	}

	protected function noSomethingUrl($something){
		$params = $this->getArray('get.');
		$string = rtrim(U('search/result'),'/').'?';
		foreach ($params as $key => $value) {
			if($key != $something){
				$string .= $key.'='.$value.'&';
			}
		}
		return rtrim($string,'&');
		
	}
	
	protected function jsonToArray($json){
		$json = json_decode($json);
		$json = (array)$json;
		foreach ($json as $key => $value) {
			if(is_object($value)){
				$json[$key] = $this->jsonToArray($value);
			}
		}
		return $json;
	}
	
}