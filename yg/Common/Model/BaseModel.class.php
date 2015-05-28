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
	
	public function page($page,$listRows = NULL){
		if(!$page){
			return $this;
		}
		return parent::page($page,$listRows);
	}
	
	public function limit($limit, $length = NULL){
		if(!$limit){
			return $this;
		}
		return parent::limit($limit,$length);
	}
	
	/**
	 * 得到一个
	 */
	public function getOne($condition,$field='*'){
		return $this->where($condition)->limit(1)->find();
	}
	
	/**
	 * 得到list
	 */
	public function getList($condition,$limit='',$page='',$field='*',$order=''){
		return $this->where($condition)->field($field)->limit($limit)->page($page)->order($order)->select();
	}
	
	/**
	 * 更新
	 */
	public function update($condition,$update){
		return $this->where($condition)->save($update);
	}
	
	/**
	 * 得到总数
	 */
	public function getCount($condition){
		return $this->where($condition)->count();
	}
}
