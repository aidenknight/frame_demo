<?php

namespace houdunwang\core;
//命名空间之前不能加任何东西
//所以把注释加载在这里
//命名空间按照惯例以文件目录命名

/**
 * Class Boot
 *创建boot类,该类为启动类
 * 主要执行数据初始化操作 init方法
 * 路由控制(执行应用)        runApp方法
 * 框架的单一入口文件会调用该类的方法 run
 *
 * @package houdunwang\core
 * 该类中使用的所有方法都为static方法
 *static方法是类中的一个成员方法,属于整个类,即使不用创建任何对象也可以直接调用!
 * 静态方法效率上要比实例化高,会常驻在内存中
 */
class Boot
{
	//定义静态方法
	public static function run ()
	{
		self::handelr();
		//测试在index页面有没有正确的打印
		//成功打印1才能进行下面的步骤
		//echo 1;
		//静态化调用init方法,初始化环境
		self::init ();
		//静态化调用appRun方法,路由控制
		self::appRun ();

	}

	private static function handelr()
	{
		$whoops = new \Whoops\Run;
		$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$whoops->register();
	}

	/**
	 *静态方法appRun,主要用于路由控制
	 * 在写这个方法之前,我们定义一个参数s,并默认s=home/entry/index
	 * 这是当前主流框架的get参数的命名方式,相比之前的
	 * c=xx&a=xx的get参数相比更短,更加便捷
	 *使用'/' 分割符来分割模块,控制器和方法,只需要使用explode函数就可以方便的分离
	 */
	public static function appRun ()
	{
		//使用if else 判断$_get是否设置
		//如果设置了该参数说明用户已经产生操作,按照用户的操作进行寻找路径

		if ( isset( $_GET[ 's' ] ) ) {
			//使用explode函数分离字符串,第一个参数/ 是用/作为分离的标记
			//后一个参数是待分离的字符串
			//该函数是会返回一个数组的,然后将其复制给$info

			$info = explode ( '/' , $_GET[ 's' ] );

			//因为我们所有的业务逻辑都使用app目录下的文件夹
			//所以结合get参数拼接我们要实例化的类名称
			//其中需要注意info数组的第0号是模型,第1号是控制器,第2号是调用的方法
			//我们将控制器中的类名大写命名,这里需要使用ucfirst函数转大写
			$class = "\app\\{$info[0]}\controller\\" . ucfirst ( $info[ 1 ] );
			//调用的方法是info数组的第二号
			$action = $info[ '2' ];
			//dd($class);
			//定义常量
			define ( 'MODULE' , $info[ 0 ] );
			define ( 'CONTROLLER' , $info[ 1 ] );
			define ( 'ACTION' , $info[ 2 ] );


			//如果没有参数证明用户刚刚登陆,需要返回给s一个默认值,使用户看到首页
		} else {
			//赋值给class变量一个字符串
			//该字符串是入口类文件没有.php的路径
			//主要是下面实例化类使用
			$class = "\app\home\controller\Entry";
			//赋值给action变量一个字符串
			//该字符串是入口类文件中的方法名
			//主要是下面实例化类调用对象
			$action = "index";

			//定义三个常量,下一步用就不注释了

			define ( 'MODULE' , 'home' );
			define ( 'CONTROLLER' , 'entry' );
			define ( 'ACTION' , 'index' );

		}

		//call_user_func_array   同等于new 类()
		//但是当前的主流框架都这么使用,我们一样要这么使用
		//其中有两个参数,第一个是new 类  , 方法   第二个参数是要传入方法的参数
		//至于前面为什么要使用echo后面会讲
		echo call_user_func_array ( [ new $class , $action ] , [] );
		//(new  $class)->$action();


	}


	/**
	 *静态化方法init
	 * 主要用于初始化框架环境
	 * 包括头部文件的设置,时区的设置,session的开启
	 */
	public static function init ()
	{
		//声明头部文件,设置编码格式为utf8
		//如果不设置会导致浏览器页面乱码
		//虽然有些浏览器可以自动转码,但是为了所有用户的体验必须写
		header ( 'Content-type:text/html;charset=utf8' );

		//设置时区为中华人民共和国,即东八区
		//不设置市区可能会导致时间显示错误
		date_default_timezone_set ( 'PRC' );

		//开启session
		//想要使用登陆等功能必须开启session,最好在程序开始时开启session
		//下面的 || 表示 或者 的意思,只有开启过session才有session_id,如果没有id
		//再开启session
		session_id () || session_start ();
	}


}
