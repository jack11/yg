<?php
/**
 * 品牌
 */
namespace Admin\Controller;

class BrandController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
	/**
	 * 分类列表
	 */
    public function index(){
		$m_brand = D('Brand');
		if (chksubmit()){
			if (!empty($_POST['del_brand_id'])){
				//删除图片
				if (is_array($_POST['del_brand_id'])){
					foreach ($_POST['del_brand_id'] as $k => $v){
						$v = intval($v);
						$brand_array = $m_brand->getOne(array('brand_id'=>$v));
						if (!empty($brand_array['brand_pic'])){
							@unlink($brand_array['brand_pic']);
						}
						//删除分类
						$m_brand->delete($v);
						unset($brand_array);
					}
				}
				$this->success('删除成功');
			}else {
				$this->success('删除失败');
			}
		}
		/**
		 * 检索条件
		 */
		$condition = array();
		if (!empty($_GET['search_brand_name'])){
			$condition['brand_name'] = array('like',"%{$_GET['search_brand_name']}%");
		}
		if (!empty($_GET['search_brand_class'])){
			$condition['brand_class'] = array('like',"%{$_GET['search_brand_class']}%");
		}
		
		//分页
		$page_size = 10;
		$page = $m_brand->getPage($condition,$page_size);
		$this->assign('show_page',$page);

		$brand_list = $m_brand->getBrandList($condition,'',intval($_GET['p']).','.$page_size);
		$this->assign('brand_list',$brand_list);

		$this->assign('search',$_GET);
		$this->display('html/brand.index');
	}

	/**
	 * 增加
	 */
	public function add(){
		$m_class = D('GoodsClass');
		
		if(chkSubmit()){
			if(!$_POST['brand_name'] || !$_POST['class_id']){
				$this->error('非法访问');
			}
			
			$insert = array();
			$insert['brand_name']	= $_POST['brand_name'];
			$insert['class_id']		= intval($_POST['class_id']);
			
			$class_info = D('GoodsClass')->getClassInfo(array('class_id'=>intval($_POST['class_id'])));
			$insert['class_name']	= $class_info['class_name'];
			
			$insert['is_recommend'] = intval($_POST['brand_recommend']);
			$insert['sort']			= intval($_POST['brand_sort']);
			//$insert['brand_pic'] 	= trim($_POST['brand_pic']);
			
			$path = $this->uploadImg('brand_pic');
			if($path){
				$insert['brand_pic'] = $path;
			}
			
			$res = D('Brand')->add($insert);
			if(!$res){
				$this->error('添加失败');
			}
			$this->success('添加成功');
		}
		
		$class_list = $m_class->getList(array());
		$class_list = $m_class->getClassTree($class_list);
		$this->assign('class_list',$class_list);
		$this->display('html/brand.add');
	}

	public function checkBrandName(){
		echo  'true';
	}
	
	public function edit(){
		$m_brand = D('Brand');
		if(chksubmit()){
			
		}
		
		$brand_id = $this->getInt('get.brand_id');
		if($brand_id<=0){
			$this->error('非法访问');
		}
		$brand_info = $m_brand->getOne(array('brand_id'=>$brand_id));
		if(!$brand_info){
			$this->error('不存在改品牌');
		}
		$this->assign('brand_info',$brand_info);
		$this->display('html/brand.edit');
	}
}