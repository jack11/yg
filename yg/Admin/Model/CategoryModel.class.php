<?php

namespace Admin\Model;
use Think\Model;

class CategoryModel extends Model{
	
	/**
	 * 得到某栏目的所有子栏目
	 * @param int parent_id 栏目id
	 * @return mixed array or false
	 */
	public function getCateChild($parent_id){
		$where['parent_id'] = $parent_id;
		return $this->where($where)->select();
	}
	
	public function getIdByName($cate_name){
		$where['name'] = $cate_name;
		return $this->where($where)->getField('id');
	}
	
	
}
