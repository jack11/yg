<?php

namespace Home\Model;

class InformationModel extends MyModel{
	
	/**
	 * 得到分页信息
	 * @param int cate_id 栏目id
	 * @param int page 当前页数  
	 * @return array(array list,int count)
	 */
	public function getList($cate_id,$page,$size){
		$where['category_id'] = $cate_id;
		$data['list'] = $this->where($where)->order('uptime')->page($page.','.$size)->select();
		$data['count']  = $this->where($where)->count();
		return $data;
	}
	
	/**
	 * 得到具体的页面内容
	 * @param int cate_id
	 * @param int id
	 * @return mixed 
	 */
	public function getContent($cate_id,$id){
		$where['id'] = $id;
		$where['category_id'] = $cate_id;
		return $this->where($where)->find();
	}
	
	/**
	 * 根据关键字找文章
	 * @param mixed word array or string 关键字
	 * @return mixed array or false
	 */
	public function getArticleByWord($words){
		if(!is_array($words)){
			$like['title'] = array('like',"%{$words}%");
			$like['content'] = array('like',"%{$words}%");
		}else{
			$arr = array();
			foreach($words as $word){
				$arr[] = "%{$word}%";
			}
			$like['title'] = array('like',$arr,'or');
			$like['content'] = array('like',$arr,'or');
		}
		$like['_logic'] = 'OR';
		$data['list'] = $this->where($like)->select();
		$data['count'] = $this->where($like)->count();
		return $data;
	}
	
	/**
	 * 根据找文章
	 * @param mixed word array or string 关键字
	 * @return mixed array or false
	 */
	 public function getArticleByParams($words,$time,$type,$order){
		$arr = array();
		foreach($words as $word=>$count){
			$arr[] = "%{$word}%";
		}
		$tmp = array('like',$arr,'or');

		switch ($type) {
			case 1:
				$like['title'] = $tmp;
				break;
			case 2:
				$like['content'] = $tmp;
				break;
			default:
				$like['title'] = $tmp;
				$like['content'] = $tmp;
				$like['_logic'] = 'or';
				break;
		}
		$where['_complex'] = $like;
		if($time!=0){
			$where['uptime'] = array('gt',time()-$time);
		}
		$order = "uptime {$order}";
		$data['list'] = $this->where($where)->order($order)->select();
		$data['count'] = $this->where($where)->count();
		return $data;
	}

}
