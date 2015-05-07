<?php
return array(
	//'配置项'=>'配置值'

	'TMPL_PARSE_STRING' => array(
		'_IMG_' => __ROOT__.'/Public/Home/images',
		'_CSS_' => __ROOT__.'/Public/Home/css',
		'_JS_' => __ROOT__.'/Public/Home/js',
		'_UPIMG_' => __ROOT__.'/Public/upload/images',
		'_UPFILE_' => __ROOT__.'/Public/upload/file',
		'_TEST_' => realpath(APP_PATH),
	),
	
	'TMPL_ACTION_ERROR' => 'Common:404',

);