<?php
/**
 * Created by PhpStorm.
 * User: huangwenlong
 * Date: 2017/9/8
 * Time: 下午7:57
 */

namespace houdunwang\model;
use PDO;
use PDOException;
use Exception;

class Base
{
	//私有静态属性pdo,并且给其赋值为null
	//这个属性主要是用于实例化系统类pdo的
	private static $pdo=null;

	//私有属性$table 这个属性主要是接收数据表
	private $table;

	//构造函数,主要用于初始化pdo类的初始化操作
	//该方法会传入一个参数$class 暂时不知道
	public function __construct ($class)
	{
		if (is_null (self::$pdo)){
			self::connect();
		}
		//通过传入的参数$class可以获得我们的需要的表名
		//只要通过\来进行截取并且首字母小写就可以获得表名

		$info=strtolower (ltrim (strrchr ($class,'\\'),'\\'));

		//将截取好的info赋值给表名
		$this->table=$info;
	}


	//私有方法connect
	//主要用于数据库的链接初始化工作,比如dsn常量 字符串设置  抛出异常类
	//
	private function connect(){

		try {
			//这个c函数是在helper助手函数中写的
			//具体详情可以参考helper.php
			dd (c ('database.driver'));
			//分别定义dsn  用户名  密码   这些参数都可以在配置项config中动态的设置
			$dsn      = c('database.driver').":host=".c('database.host').";dbname=".c('database.dbname');
			$user     = c('database.user');
			$password = c('database.password');
			//self静态调用pdo属性,实例化pdo对象

			self::$pdo      = new PDO( $dsn , $user , $password );
			//设置字符集
			self::$pdo->query ('set names utf8');
			//设置错误属性
			self::$pdo->setAttribute (PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		} catch ( PDOException $e ) {
			//注意,throw是抛出错误的意思
			throw new Exception($e->getMessage ());
		}
	}


	//公共方法find ,有一个参数$id
	//主要用于获取数据表中的id字段是什么
	public function find ($id)
	{
		//先获取主键，获取当前操作的数据表的主键到底是谁
		//这个getpk方法在下面
		$pk = $this->getPk();
		//dd($this->table);
		//拼接字符串,完成查询语句并将其赋值给sql
		$sql = "select * from {$this->table} where {$pk} = {$id}";
		//dd($sql);
		//执行查询
		//调用系统的query方法,将查询结果赋值给$data
		$data = $this->query ($sql);
		//dd($data);
		//$data是一个数组,其中有我们不需要的键名,使用current函数去除键值
		return current ($data);
	}

	/**
	 * 获取表主键到底是id还是aid还是cid
	 * 这个方法在上面有过调用
	 */
	private function getPk(){
		//查看表结构
		//使用desc链接数据表,并赋值给sql
		$sql = "desc " . $this->table;
		//执行系统函数query可以查看表结构,并且将结果赋值给data
		$data  = $this->query ($sql);
		//dd($data);
		//首先给pk一个空字符串
		$pk = '';
		//获取的结果有多条
		//需要使用foreach循环找到我们需要的主键
		foreach($data as $v){
			//主键的key值一定会有pri的标记
			if($v['Key'] == 'PRI'){
			//获取数组中Filed,这个是数据库的id值
				$pk = $v['Field'];
				break;
			}
		}
		return $pk;
	}
	/**
	 * 执行有结果集的查询
	 * 这个查询是我们之前写过的
	 * 这里不做注释了
	 */
	public function query($sql){
		try{
			$res = self::$pdo->query($sql);
			//去除结果集
			return $row = $res->fetchAll(PDO::FETCH_ASSOC);
		}catch (PDOException $e){
			throw new Exception($e->getMessage ());
		}
	}

}