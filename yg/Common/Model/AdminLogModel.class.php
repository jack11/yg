<?php

namespace Common\Model;

class AdminLogModel extends BaseModel{
	
	public function getLogList($condition,$limit='',$page='',$field='*'){
		return $this->where($condition)->field($field)->limit($limit)->page($page)->select();
	}
	
	public function getOne($condition){
		return $this->where($condition)->find();
	}
	
	public function loginLog($arr){
		return $this->add($arr);
	}
	
	

}
