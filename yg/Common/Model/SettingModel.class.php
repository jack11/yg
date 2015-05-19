<?php

namespace Common\Model;
use Think\Model;


class SettingModel extends Model{
	
	public function updateAll($update){
		if(empty($update)){
			return FALSE;
		}
		foreach ($update as $k=>$v) {
			$res = $this->where(array('name'=>$k))->save(array('value'=>$v));
			if($res===FALSE){
				return FALSE;
			}
		}
		return TRUE;
	}
	
	public function getSettingList($condition,$field='*'){
		$list = $this->where($condition)->field($field)->select();
		//装化成以name为下表的数组
		$new_list = array();
		foreach ($list as $key => $value) {
			$new_list[$value['name']] = $value['value'];
		}
		return $new_list;
	}
	
	

}
