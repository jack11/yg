<?php
/**
 * 品牌model
 */
namespace Common\Model;


class BrandModel extends BaseModel{
	
	public function getBrandList($condition,$limit='',$page=null,$field='*'){
		return $this->where($condition)->field($field)->limit($limit)->page($page)->select();
	}
	
	public function getOne($condition){
		return $this->where($condition)->find();
	}
	
	

}
