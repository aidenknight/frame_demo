<?php
/**
 * Created by PhpStorm.
 * User: huangwenlong
 * Date: 2017/9/8
 * Time: 下午7:48
 */

namespace houdunwang\view;


class View
{
	/**
	 * 当调用不存在的方法时候会触发__call函数
	 * 传入不存在的方法名称$name
	 * 这里的方法体中返回自调用的parseAction函数
	 * @param $name			不存在方法名称
	 * @param $arguments	方法参数
	 *
	 * @return mixed
	 */
	public function __call ( $name , $arguments )
	{

		return self::parseAction ($name,$arguments);
	}
	/**
	 * 当调用不存在的静态方法时候会触发__callStatic函数
	 * 传入不存在的方法名称$name
	 * 这里的方法体中返回自调用的parseAction函数
	 * @param $name			不存在方法名称
	 * @param $arguments	方法参数
	 *
	 * @return mixed
	 */
	public static function __callStatic ( $name , $arguments )
	{
		return self::parseAction ($name,$arguments);
	}


	/**
	 * 公共方法parseAction,主要用于实例化base类,并且调用$name传入的方法
	 * 同样将其return出去
	 * @param $name
	 * @param $arguments
	 *
	 * @return mixed
	 */
	public static function parseAction( $name, $arguments){
		return call_user_func_array ([new Base,$name],$arguments);
	}
}