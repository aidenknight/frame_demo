<?php
/**
 * Created by PhpStorm.
 * User: huangwenlong
 * Date: 2017/9/8
 * Time: 下午7:28
 */

namespace houdunwang\view;


class Base
{
	//定义一个受保护的属性$data
	//并将其初始化赋值一个空数组
	protected $data=[];

	//定义一个受保护的属性$file
	//主要用于存储文件位置
	protected $file;



	public function with($var){

		$this->data=$var;
		return $this;
	}

	//公共方法make,主要用于显示路径
	//这里我们使用之前boot中定义的常量MODULE等等实行路径字符串的拼接
	//注意其中controller控制类的小写
	public function make(){

		$this->file =  "../app/".MODULE."/view/".strtolower (CONTROLLER)."/".ACTION."." . c('view.suffix');
		return $this;

	}

	//调用系统函数__toString函数
	//这个函数当使用echo 输出一个对象时 会自动被调用
	//其中extract使用数组键名作为变量名，使用数组键值作为变量值
	//将数组data中的变量提取出来
	//并且引入上面我们组成的路径
	public function __toString ()
	{
		// TODO: Implement __toString() method.
		extract ($this->data);
		include $this->file;

		return '';
	}
}