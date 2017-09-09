<?php
/**
 * Created by PhpStorm.
 * User: huangwenlong
 * Date: 2017/9/8
 * Time: 下午8:27
 */

namespace houdunwang\model;



//该m中的model与v中的model一样,我们看v的注释就好
class Model
{
	public function __call ( $name , $arguments )
	{
		return self::parseAction ( $name , $arguments );
	}

	public static function __callStatic ( $name , $arguments )
	{
		return self::parseAction ( $name , $arguments );
	}

	public static function parseAction ( $name , $argument )
	{
		//dd(get_called_class ());//返回当前调用的类名
		$class = get_called_class ();
		return call_user_func_array ( [ new Base($class) , $name ] , $argument );
	}

}