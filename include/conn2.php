<?php
# 文件名称:conn.php 2009-11-1 16:03:03
# 网站相关的设置及配置信息
header("Content-type: text/html;charset=utf-8");
//error_reporting(E_ERROR | E_PARSE);	//开发时注释掉，正式运营时，开启
//@ini_set("display_errors", "Off");
@set_time_limit(0);

//版本相关设置，防不同版本而出错
PHP_VERSION >= '5.1' && date_default_timezone_set('Asia/Shanghai');
session_cache_limiter('private, must-revalidate'); 
@ini_set('session.auto_start',0); 
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
define('ROOTPATH', substr(dirname(__FILE__), 0, -7));
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
isset($_REQUEST['GLOBALS']) && exit('Access Error');
require_once 'function.php';
foreach(array('_COOKIE', '_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		$_key{0} != '_' && $$_key = daddslashes($_value);
	}
}
(!MAGIC_QUOTES_GPC) && $_FILES = daddslashes($_FILES);
$REQUEST_URI  = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//页面压缩
function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') :ob_start();

//用户IP
if($_SERVER['HTTP_X_FORWARDED_FOR']){
	$m_user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif($_SERVER['HTTP_CLIENT_IP']){
	$m_user_ip = $_SERVER['HTTP_CLIENT_IP'];
} else{
	$m_user_ip = $_SERVER['REMOTE_ADDR'];
}
$m_user_ip  = preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$m_user_ip) ? $m_user_ip : 'Unknown';

//建立数据库连接
$db_settings = parse_ini_file('dbConfig.php');
@extract($db_settings);
require_once 'mysql.php';
$db =dbmysql::getInstance($con_db_host,$con_db_id,$con_db_pass,$con_db_name);
$rs = $db->query('select *　from   h_member');
var_dump($rs);
exit;


$ckeditor_mc_id = '';
$ckeditor_mc_val = '';
$ckeditor_mc_lang = "zh-cn";
$ckeditor_mc_toolbar = "Default";
$ckeditor_mc_height = "400";

define('CC_FARM_CN', 618100);

//操作密码
define('CC_ACT_PWD', 'lalav5_#@!_19999999');

