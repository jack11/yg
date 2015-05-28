<?php
/**
 * 配置文件
 */
define('ROOT',dirname(APP_PATH));
 
return array(

	//调试模式
	'SHOW_PAGE_TRACE' =>TRUE,
	

	//数据库配置
	'DB_DSN' 		=> 'mysqli://root:@localhost:3306/yg_shop',
	'DB_PREFIX'		=> 'yg_',

	'MODULE_ALLOW_LIST' => array('Home','Admin'),
	'DEFAULT_MODULE'  => 'Home', //默认分组
	
	//url模式 
	'URL_MODEL' => '2',
	'URL_CASE_INSENSITIVE' => true,
	'VAR_CONTROLLER' =>'controller', 

	'URL_HTML_SUFFIX'=>'',
	
	//日志
	'LOG_RECORD' => true,
	'LOG_LEVEL'	=> 'SQL',
	'SHOW_ERROR_MSG'        =>  true,
	
	
	/**
	 * 路径及url及常量的配置
	 */
	'UPIMG_PATH' => realpath(ROOT.'/Public/Upload/Images/'),
	'IMG_URL'	 => '/Public/Images',
	'AMIND_URL'	 => '/admin.php',
	'HOME_URL'	 => '/index.php',
	
	//订单状态
	'order_state_new'		=> 10,
	'order_state_cancle'	=> 0,
	'order_state_pay'		=> 20,
	'order_state_finnish'	=> 99,
	
	//商品状态
	'goods_state_cancle'	=> 0,
	'goods_state_new'		=> 1,
	'goods_state_finnish'	=> 2,
	
);

