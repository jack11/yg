<?php

namespace Common\Model;

class GoodsModel extends BaseModel{
	
	public function getGoodsList($condition,$limit='',$page='',$field='*'){
		return $this->where($condition)->field($field)->limit($limit)->page($page)->select();
	}
	
	
	
	 public function getOnlineGoodsList($condition,$limit='',$page='',$field='*',$order=''){
	 	$condition['state'] = C('goods_state_new');
		return $this->getList($condition,$limit,$page,$field);
	 }
}
