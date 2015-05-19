<?php
/**
 * 基础model
 */
namespace Common\Model;
use Think\Model;

class BaseModel extends Model {

	public function getPage($condition,$size = 10) {
		$count = $this->where($condition)->count();
		// 查询满足要求的总记录数
		$Page = new \Think\Page();
		//dumps($Page);
		// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page -> getCode($count, $size);
		
		return $show;
	}
	
	public function page($page){
		if(!$page){
			return $this;
		}
		return parent::page($page);
	}
	
	public function limit($limit){
		if(!$limit){
			return $this;
		}
		return parent::limit($limit);
	}
}
