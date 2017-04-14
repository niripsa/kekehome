<?php
#php 
#1.接收数据 ①$_GET/$_POST(form提交 | AJAX请求)  ②.cookie
#2.对数据进行处理---和mysql进行交互(增删改查) 得到一些结果
#3.把结果返回(html | json(app)) 
#html/css/js:美化一个界面 APP本身就能进行美化,故返回json数据

session_start();	//本质是去接收cookie中的数据
$LoginEdUserName = $_COOKIE['h_userName'];
//是服务器去获取浏览器上传的cookie数据
$LoginEdPassWord = $_COOKIE['h_passWord'];
//验证是否登录
if($LoginEdUserName != "" && $LoginEdPassWord != "")
{
	$sql = "select * from `h_admin` where h_userName = '{$LoginEdUserName}' LIMIT 1";
	$rsAdmin = $db->get_one($sql);
}
else
{
	# 直接返回html
	echo '<html><head><title>登录提示</title><meta http-equiv="content-type" content="text/html; charset=utf-8"></head><body>';
	#跳转1.header php服务器调用的跳转
	#2.js自己的跳转 location.href=
	HintAndTurnTopFrame("您未登录或登录超时，请您重新登录！\\n\\n安全起见，您若20分钟未操作后台，将自动超时！","login.php");
	echo '</body></html>';
	exit();
}

$qxArr = array(
	'网站配置'=>array(
		'基本配置'=>'config.php',
		'网站Logo'=>'logo.php',
		'拆分率设置'=>'setsplitrate.php',
		'推荐会员提成配置'=>'config_com.php',
		/*'直荐升级配置'=>'config_level_up.php',*/
		/*'激活会员配置'=>'config_point1.php',*/
		'出售配置'=>'config_point2_sell.php',
		'提现配置'=>'config_withdraw.php',
		'抽奖配置'=>'config_lottery.php',
		'庄园植物设置'=>'farm.php',
		'玩家公告'=>'news.php?location=' . urlencode('网站主栏目') . '&mid=108',
	),
	'会员管理'=>array(
		'会员列表'=>'member.php',
		/*'会员宠物列表'=>'cw.php',*/
		'推荐结构'=>'rr.php',
		'KK拍卖列表'=>'pm.php',
		/*'提现记录'=>'tk.php',*/

		/*'商城商品管理'=>'goods.php',
		'商城订单列表'=>'order.php',*/
		'会员登录记录'=>'log1.php',
	),
	'资金流水'=>array(
		'加减种子'=>'point1add.php',
		'种子流水明细'=>'log2.php',
		'加减KK'=>'point2add.php',
		'KK流水明细'=>'log3.php',
	),
	'消息管理'=>array(
		'会员消息列表'=>'log4.php',
		'发送消息给会员'=>'msg_send.php',
		'收到的会员消息'=>'log4.php?stype=' . urlencode('管理员收件'),
	),
	'工具'=>array(
		'清空数据'=>'tool_clear.php',
		/*'调整时间'=>'tool_time.php',*/
		/*'结算KK'=>'settle.php',*/
	),
	'管理员帐号'=>array(
		'帐号管理'=>'admin.php',
	),
);