<?php

namespace Common\Model;

class GoodsModel extends BaseModel{
	
	public function getGoodsList($condition,$limit='',$page='',$field='*'){
		return $this->where($condition)->field($field)->limit($limit)->page($page)->select();
	}
	
	

}
