<?php
namespace Admin\Controller;

class GoodsController extends BaseController {
	
	public  function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	
		//一级分类
		$m_goods_class = D('GoodsClass');
		$goods_class_list = $m_goods_class->getClassList(array('parent_id'=>0));
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
			$insert['class_id']		= $this->getInt('post.class_id')+1;
			$insert['goods_name'] 	= $this->getString('post.goods_name');
			$insert['goods_jingle']	= $this->getString('post.goods_jingle');
			$insert['shop_price']	= $this->getString('post.shop_price');
			$insert['start_time']	= $this->getString('post.start_time');
			$insert['end_time']		= $this->getString('post.end_time');
			$insert['attribute']	= $this->getString('post.attribute');
			$insert['view_count']	= $this->getInt('post.view_count');
			$insert['content']		= $this->getString('post.content');
			$insert['is_new']		= $this->getInt('post.view_count');
			$insert['is_commend']	= $this->getInt('post.iscommend');
			
			//每份价格
			$insert['per_price']	= 1;
			//多少份
			$insert['goods_number']	= ceil($insert['shop_price']/$insert['per_price']);
			//状态
			$insert['state']		= 1;
			
			if($m_goods->add($insert)){
				$this->success('添加商品成功','/admin.php/goods/add');
			}else{
				$this->error('发布失败');
			}
		}
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

}