<?php

namespace Common\Model;

class GoodsClassModel extends BaseModel{
	

	
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
				$new_class = $this->getClassTree($class_list,$class['class_id'],$level+1);
				if($new_class){
					$tree[$key]['has_child'] = 1;
				}else{
					$tree[$key]['has_child'] = 0;
				}
				$tree = array_merge($tree,$new_class);
			 }
		 }
		return $tree;
	 }
	 
	
	

}
