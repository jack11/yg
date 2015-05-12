<?php

namespace Home\Model;

class goodsModel extends MyModel{
	
	public function getGoodsList($condition,$field='*',$page='',$limit='',$order=''){
		return $this->select($condition);
	}

}
