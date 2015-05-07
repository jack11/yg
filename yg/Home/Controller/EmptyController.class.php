<?php
namespace Home\Controller;
class EmptyController extends BaseController {
	protected $allow_category_id = TRUE;
	
	public function _empty($name){
		$this->error('',U('/'));
	}
}