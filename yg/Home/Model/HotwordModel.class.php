<?php

namespace Home\Model;

class HotwordModel extends MyModel{
	
	/**
	 * 得到最多的热点词
	 */
	 public function getHotWord($limit){
		return $this->limit($limit)->order('count desc')->select();
	 }
	 
	 /**
	  * 热点词的更新
	  */
	  public function updateWord($words){
	  	foreach($words as $word=>$count){
		  	$where['word'] = $word;
			if(($count = $this->where($where)->getField('count'))>0){
				$data['count'] = $count+1;
				$this->where($where)->save($data);
			}else{
				$data['word'] = $word;
				$data['count'] = 1;
				$this->add($data);
			}
		}
	  }
}
