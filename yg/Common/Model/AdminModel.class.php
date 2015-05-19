<?php

namespace Common\Model;

class AdminModel extends BaseModel{
	
	public function getAdminList($condition,$limit='',$page='',$field='*'){
		return $this->where($condition)->field($field)->limit($limit)->page($page)->select();
	}
	
	public function getOne($condition){
		return $this->where($condition)->find();
	}
	
	public function updateAdmin($admin_id,$update){
		return $this->where(array('admin_id'=>$admin_id))->save($update);
	}
	
	

}
