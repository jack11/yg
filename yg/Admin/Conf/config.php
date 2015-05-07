<?php
return array(
	//'配置项'=>'配置值'

	'TMPL_PARSE_STRING' => array(
		'_IMG_' => __ROOT__.'/Public/Admin/Images',
		'_CSS_' => __ROOT__.'/Public/Admin/Css',
		'_JS_' => __ROOT__.'/Public/Admin/Js',
		'_UPIMG_' => __ROOT__.'/Public/Upload/Images',
		'_UPFILE_' => __ROOT__.'/Public/Upload/File',
		'_TEST_' => realpath(APP_PATH),
	),
	
	'TMPL_ACTION_ERROR' => 'Common:404',
);