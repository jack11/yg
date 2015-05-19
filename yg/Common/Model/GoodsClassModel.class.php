<?php

namespace Common\Model;
use Think\Model;


class GoodsClassModel extends Model{
	
	public function getClassList($condition,$field='*'){
		return $this->where($condition)->field($field)->select();
	}
	
	public function getClassInfo($condition){
		return $this->where($condition)->find();
	}
	
	/**
	 * 得到树形class
	 */
	 public function getClassTree($class_list,$parent_id=0,$level=0){
	 	if(empty($class_list)){
	 		return array();
	 	}
		
	 	$tree = array();
	 	foreach ($class_list as $key=>$class) {
			 if($class['parent_id'] == $parent_id){
			 	$class['level'] = $level;
			 	$tree[$key] = $class;
				$tree = array_merge($tree,$this->getClassTree($class_list,$class['class_id'],$level+1));
			 }
		 }
		return $tree;
	 }
	
	

}
