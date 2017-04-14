<?php
# 文件名称:conn.php 2009-11-1 16:03:03
# 网站相关的设置及配置信息
header("Content-type: text/html;charset=utf-8");
//error_reporting(E_ERROR | E_PARSE);	//开发时注释掉，正式运营时，开启
//@ini_set("display_errors", "Off");
//热配置↑
//函数可以无限期执行↓
@set_time_limit(0);
//为什么函数前面会有个@？加@的函数将不会报错

//版本相关设置，防不同版本而出错
PHP_VERSION >= '5.1' && date_default_timezone_set('Asia/Shanghai');
session_cache_limiter('private, must-revalidate'); 
@ini_set('session.auto_start',0); 
//SESSION auto_start :自动开启 设置为0是关 较消耗系统资源，不推荐
//session_start() 手动开启 较常用

# &:一荣俱荣，一损俱损
if(PHP_VERSION < '4.1.0') {
	$_GET         = &$HTTP_GET_VARS;
	$_POST        = &$HTTP_POST_VARS;
	$_COOKIE      = &$HTTP_COOKIE_VARS;
	$_SERVER      = &$HTTP_SERVER_VARS;
	$_ENV         = &$HTTP_ENV_VARS;
	$_FILES       = &$HTTP_POST_FILES;
}

//系统通用函数库 及 防注入等非法操作
//MAGIC_QUOTES_GPC = off = 0，需要手工转义

//echo __FILE__;
//exit;
//魔术常量__FILE__:即文件目录D:\phpstudy\WWW\include\conn.php
//dirname 代表取出文件所在的文件夹目录
//substr(地址,数字a,数字b)函数 取一个字符串的子串 js当中叫slice
//前闭后开 包括第a个，不包括第b个
//$_REQUEST ~array_merge($_GET,$_POST)
//array_merge()合并数组


//substr(__DIR__,0,-7);
define('ROOTPATH', substr(dirname(__FILE__), 0, -7));
//↓与转义有关
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
//↓防止攻击GLOBALS变量
isset($_REQUEST['GLOBALS']) && exit('Access Error');
require_once 'function.php';
#$_REQUEST= array_merge($_GET,$_POST);

//了解$$
/*$a="gaoxugang";
$$a="27";
//$$a也可以写成${$a}
echo $gaoxugang;exit;	27*/
//$$a会先执行后面的$a,值为gaoxugang，
//然后相当于定义了变量$gaoxugang


//php当中的foreach循环
//
/*$a = "gaoxugang";
echo $a{0};	//g(第一个字母)
echo $a{strlen($a)-1};	//	g(最后一个字母)
exit;*/

/*$a="gaoxugang";
$a==="gaoxugang" && $b ="yes";
//↑若$a为"gaoxugang"，则$b = "yes"
echo $b;
exit;*/


//$act来自于下面遍历中产生的$$_key
foreach(array('_COOKIE', '_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		//下面的代码是为了安全，简单进行了过滤
		//daddslashes(x)=x，里面的值不变
		$_key{0} != '_' && $$_key = daddslashes($_value);
		//↑若key第一个字母不是_,那么
		//首先把上面循环里面所有的key定义为变量,
		//然后值为对应的value
	}
}
#↑循环1 $_REQUEST ='_COOKIE'
#$$_REQUEST = $_COOKIE #用户上传来的cookie的key-value数组
#若$_COOKIE['username'] = 'gaoxugang';
#$$key即$username="gaoxugang"

//$_FILES也是系统提供的函数,用来存文件
//http以前用的版本是1.0，现在用的是1.1，以后会火的是2.0 默认端口：80
(!MAGIC_QUOTES_GPC) && $_FILES = daddslashes($_FILES);
$REQUEST_URI  = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//页面压缩
function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') :ob_start();


//用户IP
//设置优先级
if($_SERVER['HTTP_X_FORWARDED_FOR']){
	$m_user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif($_SERVER['HTTP_CLIENT_IP']){
	$m_user_ip = $_SERVER['HTTP_CLIENT_IP'];
} else{
	$m_user_ip = $_SERVER['REMOTE_ADDR'];
}
$m_user_ip  = preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$m_user_ip) ? $m_user_ip : 'Unknown';
#正则表达式和问号表达式↑
//preg_match()相当于js当中的exec()	用于匹配正则表达式


//进行访问频率控制
if(extension_loaded('redis')){
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	if(isset($_SERVER['REQUEST_URI'])){
		//对访问的接口进行频率控制
		$sKey = str_replace('/', '#', $_SERVER['REQUEST_URI']);
		$iNow = $redis->incr($sKey);
		if($iNow == 1){
			$redis->expire($sKey, 3);
		}else{
			writeLog("{$sKey} faces frequency attack!");
			exit;
		}
	}
}


//导入conn.php的原因：存了数据库变量

//parse_ini_file()专门用来解析ini文件	将解析成数组
/*aPhpIni=parse_ini_file("D:\phpstudy\php\php-5.4.45\php.ini");
var_dump($aPhpIni);*/
//建立数据库连接
//dbConfig.php没有加目录，说明和当前文件是一个目录，相当于./
$db_settings = parse_ini_file('dbConfig.php');
//var_dump($db_settings);exit;
@extract($db_settings);
/*var_dump($config_db);
exit;*/
//extract(数组)	能将数组的key变成变量，value变成相应变量的值
//将ini文件转换成变量：parse_ini_file()		extract()

/*$arr = array("gaoxugang"=>17,"wangzhe"=>19);
extract($arr);
echo $gaoxugang;
echo "<br>";
echo $wangzhe;
exit;*/	//17 19

//mysql 	mysqli
require_once 'mysql.php';
//说明dbmysql是个类，getInstanse是个静态方法,后面的4个变量是之前extract()生成的
//#Linux Nginx-Apache
$db =dbmysql::getInstance($con_db_host,$con_db_id,$con_db_pass,$con_db_name);
//对象调用方法  对象名->方法名
//类调用静态方法 类名::方法名

/*class A{
	public function query(){
		echo "you are query!";
	}
}
class B extends A{}
$b = new B();
$b->query();*/	//可以调用父类中的方法

//$rs query还不是最终的数据，还需要mysqli_fetch_array()搬下来
//->为通过对象去调用对象的方法
$rs = $db->query('select * from h_member');

/*function gaoxugang(){
	echo "gaoxugang";
}
执行函数的方法
1.gaoxugang()
2.$a="gaoxugang";
$a();
*/

$ckeditor_mc_id = '';
$ckeditor_mc_val = '';
$ckeditor_mc_lang = "zh-cn";
$ckeditor_mc_toolbar = "Default";
$ckeditor_mc_height = "400";

define('CC_FARM_CN', 618100);

//操作密码
define('CC_ACT_PWD', 'lalav5_#@!_19999999');

