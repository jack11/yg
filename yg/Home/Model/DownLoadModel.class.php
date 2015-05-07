<?php

namespace Home\Model;

class DownLoadModel extends MyModel{
	protected $tableName = 'download';
	
	/**
	 * 得到分页信息
	 * @param int cate_id 栏目id
	 * @param int page 当前页数  
	 * @return array(array list,int count)
	 */
	public function getList($cate_id,$page,$size){
		$where['category_id'] = $cate_id;
		$data['list'] = $this->where($where)->order('uptime')->page($page.','.$size)->select();
		$data['count']  = $this->where($where)->count();
		return $data;
	}
}
