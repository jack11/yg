<?php

namespace Admin\Model;
use Think\Model;

class InformationModel extends Model{
	
	public function getList($cate_id,$page,$size){
		$where['category_id'] = $cate_id;
		$data['list'] = $this->where($where)->order('uptime')->page($page.','.$size)->select();
		$data['count']  = $this->where($where)->count();
		return $data;
	}
}
