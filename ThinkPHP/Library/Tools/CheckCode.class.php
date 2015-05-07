<?php
namespace Tools;

/*验证码*/
class CheckCode{
	protected $img = null;

	protected $pixel = 200;	//噪点数

	protected $line = 8;	//直线数

	protected $size = 4;	//显示的字数

	protected $width = 150;	//验证码宽

	protected $height = 30;	//验证码高

	protected $model = 0;	//模式 0代表数字 1代表小写字母 2代表大写字母 3代表中文 4代表数字、字母结合

	protected $font ='./ttfs/simfang.ttf';//字体文件

	protected $name = 'checkCode';	//在session 的名称


	public function _construct(){
		$this->font =  LIB_PATH . 'Tools/'.$this->font();
	}

	public function setPixel($pixel){
		$this->pixel = $pixel;
		return $this;
	}

	public function setLine($line){
		$this->line = $line;
		return $this;
	}

	public function setSize($size){
		$this->size = $size;
		return $this;
	}

	public function setWidth($width){
		$this->width = $width;
		return $this;
	}

	public function setHeight($height){
		$this->height = $height;
		return $this;
	}

	public function setModel($model){
		$this->model  = $model;
		return $this;
	}

	public function setFont($filename){
		$this->font = LIB_PATH . 'Tools/'.$filename;
		return $this;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	//输出验证码 sname 代表在session里的名字
	public function getImg($sname = 'code'){
		$this->createImg();
		$this->draw();
		$this->write($sname);
		//imagejpeg($this->img,'1.jpg');//本次测试：火狐显示的图片和保存的图片不一样，ie却一样
		if(function_exists('imagejpeg')){
			header('Content-type:image/jpeg');
			imagejpeg($this->img);
		}else{
			header('Content-type:image/png');
			imagepng($this->img);
		}
		imagedestroy($this->img);
	}
	
	//创建图片
	protected function createImg(){
		if (function_exists('imagecreatetruecolor')) {
           $this->img = imagecreatetruecolor($this->width,$this->height);
		   imagecolorallocate($this->img,122,122,122);
        } else {
            $this->img = imagecreate($this->width,$this->height);
        }
		$r = Array(225, 255, 255, 223);
        $g = Array(225, 236, 237, 255);
        $b = Array(225, 236, 166, 125);
        $key = mt_rand(0, 3);
        $backColor = imagecolorallocate($this->img, $r[$key], $g[$key], $b[$key]);    //背景色（随机）
		imagefill($this->img, 0, 0, $backColor);
		$borderColor = imagecolorallocate($this->img, 100, 100, 100);                    //边框色
		imagerectangle($this->img, 0, 0, $this->width - 1, $this->height - 1, $borderColor);
	}

	//画噪点 直线
	protected function draw(){
		//
		for($i = 0;$i<$this->pixel;$i++){
			$color = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
		}

		//
		for($i = 0;$i<$this->line;$i++){
			$color = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			//imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
			imagearc($this->img, mt_rand(-10, $this->width), mt_rand(-10, $this->height), mt_rand(30, 300), mt_rand(20, 200), 55, 44, $color);
		}
	}
	
	/*
	* 写字符串（数字、英文、汉字）
	*/
	protected function write($sname){
		if(!session_id()){
			session_start();
		}

		//验证码
		$str = '';
		switch($this->model){
			case 0:{
				$string = '0123456789';
				$str = $this->writeString($string);
				break;
			}
			case 1:{
				$string = 'abcdefghijklmnopqrstuvwxyz';
				$str = $this->writeString($string);
				break;
			}
			case 2:{
				$string = 'ABCDEFGHIJKLMNOPRSTUVWXYZ';
				$str = $this->writeString($string);
				break;
			}
			case 3:{
				$string = '请问认同与怕是法国红酒考虑这些差别那么而我们的祖国是什么样子的你说呢不知道就要乱六安天网恋王亮亡灵低于高搞告幻换还幻欢乐列航行务必比较黑暗无聊口语';
				$str = $this->writeChars($string);
				break;
			}
			default:{
				$string = 'ABCDEFGHIJKLMNPRSTUVWXYZabcdefghijklmnpqrstuvwxyz123456789';
				$str = $this->writeString($string);
				break;
			}
		}

		$_SESSION[$this->name] = strtolower($str);
	}

	/*
	* 写英文数字
	*/
	protected function writeString($string){
		$str = '';
		for($i = 0;$i<$this->size;$i++){
			$string = str_shuffle($string);
			$char = substr($string,0,1);
			$str .= $char;
			$color = imagecolorallocate($this->img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));
			imagettftext($this->img, 20, mt_rand(0, 30), 30 * $i +10, mt_rand(20, 25), $color, $this->font, $char);
		}
		return $str;
	}

	/*
	* 写中文
	*/
	protected function writeChars($string){
		$str = '';
		//$string = iconv('UTF-8','gbk',$string);
		for($i = 0;$i<$this->size;$i++){
			$char = substr($string,floor(mt_rand(0,strlen($string)-1)/3)*3,3);
			$str .= $char;
			$color = imagecolorallocate($this->img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));
			imagettftext($this->img, mt_rand(16, 20), mt_rand(0, 30), 30 * $i +10, mt_rand(20, 25), $color, $this->font, $char);
		}
		return $str;
	}


}

/*test
$code = new CheckCode();
$code->setFont('ttfs/2.ttf')->setModel(4)->setWidth(150)->setHeight(30)->setPixel(200)->setLine(8)->setSize(4)->getImg();
*/
	
?>