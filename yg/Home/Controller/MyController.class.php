<?php
namespace Home\Controller;
use Think\Controller;
class MyController extends Controller {
	protected $first_titles = array();
	
	
	public function __construct(){
		parent::__construct();
		$this->first_titles = array(
			array('name'=>'首页','class'=>''),
			array('name'=>'行内通知','class'=>''),
			array('name'=>'分行信息','class'=>''),
			array('name'=>'下载专区','class'=>''),
			array('name'=>'通讯录','class'=>''),
			array('name'=>'文化风采','class'=>''),
			array('name'=>'公共文件夹','class'=>'')
			);
	}
	
	protected function findCurrTitle($title){
		foreach ($this->first_titles as $key => $value) {
			if($value['name'] == $title){
				$this->first_titles[$key]['class'] = 'active';
			}
		}
	}
}