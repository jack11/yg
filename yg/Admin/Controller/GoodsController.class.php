<?php
namespace Admin\Controller;

class GoodsController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	
		//一级分类
		$m_goods_class = D('GoodsClass');
		$goods_class_list = $m_goods_class->getList(array('parent_id'=>0));
		$this->assign('goods_class_list',$goods_class_list);
		
		//品牌
		$m_brand = D('Brand');
		$brand_list = $m_brand->getBrandList();
		$this->assign('brand_list',$brand_list);
		
		//状态
		$state_list = array(
			array('name'=>'正常','value'=>'1'),
		);
		$this->assign('state_list',$state_list);
		
		//商品筛选
		$condition = array();
		if($this->getString('get.goods_name')){
			$condition['goods_name'] = $this->getString('get.goods_name');
		}
		if($this->getInt('get.goods_class')){
			$condition['goods_class'] = $this->getInt('get.goods_class');
		}
		if($this->getInt('get.brand')){
			$condition['brand'] = $this->getInt('get.brand');
		}
		if($this->getInt('get.state')){
			$condition['state'] = $this->getInt('get.state');
		}
		$m_goods = D('Goods');
		$page_size = 10;
		$page = $m_goods->getPage($condition,$page_size);
		$this->assign('show_page',$page);
		
		$goods_list = $m_goods->getGoodsList($condition,'',intval($_GET['p']).','.$page_size);
		$this->assign('goods_list',$goods_list);
		
        $this->display('html/goods.index');
    }

	public function add(){
		$m_goods = D('Goods');
		if(chkSubmit()){
			$this->assign('tmp',$_POST);
			
			$insert = array();
			
			//分类
			$insert['goods_class']	= $this->getInt('post.goods_class');
			$class_info = D('GoodsClass')->getOne(array('class_id'=>$insert['goods_class']));
			$insert['class_name']	= $class_info['class_name'];
			
			//品牌
			$insert['brand_id']		= $this->getInt('post.brand_id');
			$brand_info	= D('Brand')->getOne(array('brand_id'=>$insert['brand_id']));
			$insert['brand_name']	= $brand_info['brand_name'];
			
			$insert['goods_name'] 	= $this->getString('post.goods_name');
			$insert['goods_jingle']	= $this->getString('post.goods_jingle');
			$insert['shop_price']	= $this->getString('post.shop_price');
			$insert['attribute']	= $this->getString('post.attribute');
			$insert['view_count']	= $this->getInt('post.view_count');
			$insert['content']		= $_POST['content'];
			$insert['is_new']		= $this->getInt('post.is_new');
			$insert['is_commend']	= $this->getInt('post.is_commend');
			
			//商品图片
			$path = $this->uploadImg('goods_images');
			$insert['goods_image']	= $path;
			
			//每份价格
			$insert['per_price']	= 1;
			//多少份
			$insert['goods_number']	= ceil($insert['shop_price']/$insert['per_price']);
			//状态
			$insert['state']		= 1;
			
			//时间
			$start_time = strtotime($this->getString('post.start_time'));
			$end_time 	= strtotime($this->getString('post.end_time'));
			$start_time	= $start_time ? $start_time : TIMESTAMP;
			$end_time	= $end_time ? $end_time : (TIMESTAMP+7*24*3600);
			$insert['start_time']	= $start_time;
			$insert['end_time']		= $end_time;
			
			if($m_goods->add($insert)){
				$this->success('添加商品成功','/admin.php/goods/add');
			}else{
				$this->error('发布失败');
			}
		}


		//分类
		$m_goods_class = D('GoodsClass');
		$class_list = $m_goods_class->getList(array());
		$class_list = $m_goods_class->getClassTree($class_list);
		foreach($class_list as $key=>$class){
			if($class['has_child']){
				unset($class_list[$key]);
			}
		}
		$this->assign('class_list',$class_list);
		
		//商品品牌
		
		
		//每份价格
		$this->assign('per_price',C('setting.goods_per_price'));
		
		
		$this->display('html/goods.add');
	}

	public function setting(){
		$m_setting = D('Setting');
		if(chkSubmit()){
			$update = array();
			$update['can_edit_per_goods_price'] = $this->getInt('post.can_edit_per_goods_price');
			$update['goods_per_price']			= $this->getString('post.goods_per_price');
			
			$res = $m_setting->updateAll($update);
			if($res){
				$this->success('更新成功');
			}else{
				$this->error('更新失败');
			}
		}
		
		$setting = $m_setting->getSettingList(array('name'=>array('in',array('can_edit_per_goods_price','goods_per_price'))));
		$this->assign('setting',$setting);
		
		$this->display('html/goods.setting');
	}
	
	/**
	 * 获取品牌
	 */
	public function getBrandAjax(){
		$class_id = $this->getInt('get.class_id');
		if($class_id<=0){
			die(json_encode(array('state'=>FALSE)));
		}
		$brand_list = D('Brand')->getList(array('class_id'=>$class_id));
		$this->returnAjax(TRUE,$brand_list);
	}
	
	/**
	 * 编辑商品
	 */
	public function edit(){
		$goods_id = $this->checkId('goods_id');
		
		$m_goods = D('Goods');
		$goods_info = $m_goods->getOne(array('goods_id'=>$goods_id));
		
		$this->assign('goods_info',$goods_info);
		$this->display('html/goods.edit');
		
	}
}