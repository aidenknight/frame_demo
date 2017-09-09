<?php
//加载之前生成vendor目录的autoload.php
//为了实现自动加载,之前使用的__autoload的魔术方法会有许多的限制
//使用composer可以实现自动的git归档,git拉取等等功能

//我们使用require_once引入autoload.php文件
//require是必须的意思，找不到文件时，会报fatal error （致命错误），程序停止往下执行
//　加once后，系统会进行判断，如果已经包含，则不会再包含第二次
require_once "../vendor/autoload.php";

//调用静态化的方法run
//需要注意其命名空间的位置
//我们只需要保持命名空间与文件目录一致
//静态化方法的好处就是不用实例化类,直接::调用
\houdunwang\core\Boot::run ();

