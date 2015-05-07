<?php

namespace Admin\Model;
use Think\Model;

class UserModel extends Model{
	protected $tableName = 'admin';
	
	/**
	 * 登录
	 * @param string name 用户名
	 * @param string password 密码
	 * @return mixed  return array or false
	 */
	public function login($name,$password){
		$where['user'] = $name;
		$where['password'] = md5($password);
		return $this->where($where)->find();
	}
}
