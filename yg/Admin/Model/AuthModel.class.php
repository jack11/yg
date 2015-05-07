<?php

namespace Admin\Model;
use Think\Model;

class AuthModel extends Model{
	
	/**
	 * 权限查询
	 * @param int user_id 用户id
	 * @return mixed array or false
	 */
	public function getAuths($user_id){
		$where['admin_id'] = $user_id;
		$fields = array('id'); 
		$res = $this->where($where)->field($fields)->select();
		if(is_array($res)){
			$ids = array();
			foreach ($res as $value) {
				$ids[] = $value['id'];
			}
			return $ids;
		}
		return $res;
	}
}
