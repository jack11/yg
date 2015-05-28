<?php
namespace Admin\Controller;

class GoodsClassController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
	/**
	 * 分类列表
	 */
    public function index(){
    	$m_goods_class = D('GoodsClass');
		
		
		
		$condition = array();
		$class_list = $m_goods_class->getList($condition);
		
		$new_list = array();
		foreach ($class_list as $key => $value) {
			$new_list[$value['class_id']] = $value;
		}
		$class_list = $new_list;
		
		$new_list = array();
		foreach ($class_list as $key => $value) {
			if($value['parent_id']==0){
				$value['child'] = 0;
				$new_list[$value['class_id']] = $value;
			}
		}
		foreach ($class_list as $key => $value) {
			if(key_exists($value['parent_id'], $new_list)){
				$new_list[$value['parent_id']]['child'] = 1;
			}
		}
		$class_list = $new_list;unset($new_list);
		
		
		$this->assign('class_list',$class_list);
        $this->display('html/goods_class.index');
    }
	
	/**
	 * ajax得到下级分类
	 */
	public function getClassAjax(){
		$class_id = $this->getInt('get.class_id');
		if($class_id<=0){
			echo json_encode(array());
			exit;
		}
		
		$m_goods_class = D('GoodsClass');
		$class_list = $m_goods_class->getList(array());
		
		
		$new_list = array();
		foreach ($class_list as $key => $value) {
			if($value['parent_id']==$class_id){
				$value['child'] = 0;
				$new_list[$value['class_id']] = $value;
			}
		}
		foreach ($class_list as $key => $value) {
			if(key_exists($value['parent_id'], $new_list)){
				$new_list[$value['parent_id']]['child'] = 1;
			}
		}
		$class_list = $new_list;unset($new_list);
		
		
		echo json_encode(array_values($class_list));
		exit;
	}
	
	/**
	 * 编辑
	 */
	public function edit(){
		$class_id = $this->getInt('get.class_id');
		if($class_id<=0){
			$this->error('非法访问');
		}
		$m_goods_class = D('GoodsClass');
		$class_info = $m_goods_class->getClassInfo(array('class_id'=>$class_id));
		if(!$class_info){
			$this->error('分类不存在');
		}
		
		//class_list
		$condition['class_id'] = array('not in',array($class_id));
		$class_list = $m_goods_class->getClassList($condition);
		$class_list = $m_goods_class->getClassTree($class_list);
		$this->assign('class_list',$class_list);
		
		$this->assign('edit_sign',TRUE);
		$this->assign('class',$class_info);
		$this->display('html/goods_class.add');
	}
	
	/**
	 * 新增
	 */
	public function add(){
		$m_class = D('GoodsClass');
		$class_list = $m_class->getList(array());
		$class_list = $m_class->getClassTree($class_list);
		$this->assign('class_list',$class_list);
		//dumps($class_list);
		$this->assign('class',array('class_id'=>$this->getInt('get.gc_parent_id')));
		$this->display('html/goods_class.add');
	}

}