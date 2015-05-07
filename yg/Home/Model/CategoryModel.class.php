<?php

namespace Home\Model;

class CategoryModel extends MyModel{
	
	/**
	 * 通过本栏目找到所有兄弟栏目父及其栏目 或者顶栏目和它的子栏目
	 * @param int id 栏目id
	 * @return array(string father,array children)
	 */
	 public function getCateList(&$id){
	 	$fields = array('id','name','parent_id');
	 	$tree = array();
	 	$cate = $this->Field($fields)->find($id);
		if(!$cate){
			return FALSE;
		}
		if($cate['parent_id'] == 0){
			$tid = $this->where('parent_id='.$cate['id'])->getField('id');
			if($tid<=0){
				$tree[] = $cate;
				return $tree;
			}
			$id = $tid;
			$cate = $this->Field($fields)->find($id);
		}
		$tree[] = $this->Field($fields)->find($cate['parent_id']);
		$tree[] = $this->where(array('parent_id'=>$cate['parent_id']))->Field($fields)->select();
		foreach($tree[1] as $k=>$v){
			if($v['id'] == $cate['id']){
				$tree[1][$k]['curr'] = 'curr_title';
			}else{
				$tree[1][$k]['curr'] = '';
			}
		}
		return $tree;
	 }
	 
	 /**
	  * 面包屑导航条
	  * @param int id
	  * @return array
	  */
	  public function getPosition($id){
	  	$nav = array();
	  	while (TRUE) {
			$row = $this->field('id,name,parent_id')->find($id);
			if($row){
				$nav[] = $row;
				if($row['parent_id'] != 0){
					$id = $row['parent_id'];
				}else{
					break;
				}
			}else{
				break;
			}
		  }
		return array_reverse($nav);
	  }
	  
	  /**
	   * 根据id得到名字
	   * @param array ids
	   * @return mixed array or false
	   */
	 public function getNameByIds($ids){
		$ids = array_unique($ids);
		$where['id'] = array('in',$ids);
		$fields = array('name','id');
		return $this->where($where)->field($fields)->select();
	 }
}
