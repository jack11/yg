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
	
}