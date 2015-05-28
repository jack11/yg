<?php

namespace Think;

class Page {

	protected $pageSize = 5;
	//页数

	protected $sign = 'p';
	//页码标志

	protected $error = '';

	/*
	 * @param
	 * */
	public function __construct() {

	}

	/*
	 * @param int total 总数
	 * @param size size 每页显示的数量
	 * return 页码html代码
	 * */
	public function getCode($total, $size) {
		if ($total <= 0) {
			$total = $size;
		}
		if (empty($size)) {
			$this -> error = '每页数不能小于等于0!';
			return FALSE;
		}

		//当前页码
		if (!isset($_GET[$this -> sign]) || $_GET[$this -> sign]<=0) {
			$now = 1;
		} else {
			$now = $_GET[$this -> sign]+0;
		}

		//总页
		$sum = ceil($total / $size);

		//设置url
		$url = $this -> builtURL();
		/*
		 * <ul>
		 <li><a title="首页" href="#">&lt;&lt;</a></li>
		 <li><a title="上一页" href="#">&lt;</a></li>
		 <li><a href="#">1</a></li>
		 <li><a href="#">2</a></li>
		 <li><a href="#" class="active">3</a></li>
		 <li><a href="#">4</a></li>
		 <li><a href="#">5</a></li>
		 <li><a href="#">6</a></li>
		 <li><a href="#">7</a></li>
		 <li><a href="#">8</a></li>
		 <li><a title="下一页" href="#">&gt;</a></li>
		 <li><a title="尾页" href="#">&gt;&gt;</a></li>
		 </ul>
		 * */
		//拼接完整的代码
		$i = 1;
		$code = "<li><span class=\"currentpage\">{$now}</span></li>";
		$last = $now - 1;
		$next = $now + 1;

		while ($i < $this -> pageSize && $i < $sum) {
			if ($last >= 1) {
				$code = "<li><a href=\"{$url}{$last}\"><span>{$last}</span></a></li>" . $code;
				$last--;
				$i++;
			}
			if ($next <= $sum) {
				$code = $code . "<li><a href=\"{$url}{$next}\"><span>{$next}</span></a></li>";
				$next++;
				$i++;
			}
		}
		if ($now != 1) {
			$code = "<li><a title=\"上一页\" href=\"{$url}".($now-1)."\"><span>上一页</span></a></li>".$code;
		}
		if ($now < $sum) {
			$code = $code."<li><a title=\"下一页\" href=\"{$url}".($now+1)."\"><span>下一页</span></a></li>";
		}
		if ($this -> error) {
			//return FALSE;
		}
		$code = "<ul><li class=\"all_page\"><span>共 {$sum} 页</span></li>"
			."<li><a title=\"首页\" href=\"{$url}1\"><span>&lt;&lt;</span></a></li>"
			.$code
			."<li><a title=\"尾页\" href=\"{$url}{$sum}\"><span>&gt;&gt;</span></a></li></ul>";
		return $code;
	}

	/*
	 * @param string url 原网页url
	 * return string url 处理后的url
	 * */
	protected function builtURL() {
		$base = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].__ACTION__;

		if (array_key_exists($this -> sign,$_GET)) {
			//unset($_GET[$this -> sign]);
		}
		$paramString = '';
		foreach ($_GET as $k => $v) {
			if($k != $this->sign){
				$paramString .= $k . '/' . $v . '/';
			}
		}
		$url = $base . '/' . $paramString;
		if (stripos($url, 'Home/')) {
			$url = str_ireplace('Home/', '', $url);
		}
		return $url.$this->sign.'/';
	}

	/*
	 * @param int size显示多少页（不是多小条） 默认5页
	 * */
	public function setPageSize($size) {
		$this -> pageSize = $size;
		return $this;
	}

	/*
	 * @param string sign 页码标志
	 * */
	public function setSign($sign) {
		$this -> sign = $sign;
		return $this;
	}

	public function getError() {
		return $this -> error;
	}

}
