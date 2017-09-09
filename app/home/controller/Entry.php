<?php
//命名空间之前不能加任何东西
//所以把注释加载在这里
//命名空间按照惯例以文件目录命名
namespace app\home\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Article;

/**
 * Class Entry
 *entry是入口的意思
 * 也是现在许多框架采用的入口文件类
 * 这里今天没有多写,只是使用了测试打印功能2017年09月07日 20:48:41
 * @package app\home\controller
 */
class Entry extends Controller {

	/**
	 *公共方法index,主要用于在用户第一次进入
	 * 程序时默认加载该方法,预计在后期将会引入
	 * 主页html文件 2017年09月07日 20:50:17
	 */
	public  function index(){

		//include "a";

		//测试数据库模型是否成功
		$data = Article::find(1);
		dd($data);

		//测试页面是否成功加载
		return View::with(compact ('test'))->make();

	}

	/**
	 *公共方法add,暂时(2017年09月07日 20:50:39)
	 * 只用于测试打印,测试boot类中appRun方法是否成功
	 * 暂时不知道将来的打算2017年09月07日 20:51:54
	 */
	public  function add(){
		//测试Controller.php中setRedirect和message方法
		//$this->setRedirect ()接收到setRedirect()返回的$this
		//测试提示信息是否成功加载

		$this->setRedirect ()->message ( '添加成功' );

	}
}