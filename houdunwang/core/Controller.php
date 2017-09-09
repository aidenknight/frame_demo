<?php
/**
 * Created by PhpStorm.
 * User: huangwenlong
 * Date: 2017/9/8
 * Time: 下午3:46
 */

namespace houdunwang\core;


class Controller
{
	//定义私有属性$url
	//主要用于地址的跳转
	private $url="windows.history.back()";

	//定义公共方法message,主要用于显示我们的提示信息
	//该方法传入一个参数message,主要用于在界面上显示我们想要传入的信息
	public function message($message){

		include "./view/message.php"; die();

	}


	/**
	 * 公共方法setRedirect主要用于页面的跳转
	 * 使用url属性和location等方法来实现跳转
	 * @param string $url
	 *返回一个$this  这是一个对象,在下一步的链式操作跳转能够实例化对象
	 * @return $this
	 */
	public function setRedirect( $url=''){
		if (empty($url)){
			$this->url="window.history.back()";
		}else{
			$this->url="location.href='$url'";
		}
		return $this;
	}

}