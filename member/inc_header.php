<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';
//echo $memberLogged_userName . '|' . $memberLogged_passWord;exit;
if(!$webInfo['h_open']){
	echo "
	<script>
	window.location.href='/close.php';
	</script>
	";
	exit;
	}

//统计代码
echo '<div style="display:none;"><script src="http://s11.cnzz.com/z_stat.php?id=1261296775&web_id=1261296775" language="JavaScript" type="text/javascript">
    </script>
    </div>';

function php_self(){

    $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);

    return $php_self;

    }
if(!$memberLogged){
	redirect('/index.php');
}else{
	$sql = "select * from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
	$rs = $db->get_one($sql);

	if(false&&(!$rs['pwd1_check'] || !$rs['pwd2_check'])){
	$self = php_self();
	if($self != "index.php" && $self != "pi.php" && $self != "logout.php"){
	echo "
	<script>
	alert('首次登陆请先修改登录密码与安全密码');
	window.location.href = 'pi.php';
	</script>
	";
	exit;
		}
	}
	session_start();
	if($_SESSION['pwd2'] == "" || $_SESSION['pwd2'] < strtotime('now')){
	$self = php_self();
	if($self != "index.php" && $self != "pi.php" && $self != "logout.php" && $self != "pwd2.php"){
	echo "
	<script>
	window.location.href = 'pwd2.php?go={$self}';
	</script>
	";
	exit;
		}
	}
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/pager.php';
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<title><?php echo $pageTitle . $webInfo['h_webName'] . ' - ' . $webInfo['h_webKeyword']; ?></title>
<meta name="keywords" content="<?php echo $webInfo['h_keyword']; ?>" />
<meta name="description" content="<?php echo $webInfo['h_description']; ?>" />
<link rel="stylesheet" href="/ui/css/bootstrap.min.css">
<link href="/ui/css/css.css" rel="stylesheet">
<link rel="stylesheet" href="/zzsc/graph.css">
<script type="text/javascript" src="/ui/js/jquery.min.js"></script>
<script type="text/javascript" src="/ui/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/ui/layer/layer.js"></script>
<script type="text/javascript" src="/ui/js/long.js"></script>
<script type="text/javascript" src="/zzsc/jquery.min.js"></script>
<script type="text/javascript" src="/zzsc/jquery.flot.min.js"></script>
<!--[if lt IE 9]>
<script src="/ui/js/html5shiv.min.js"></script>
<script src="/ui/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
var browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
</script>
</head>
<style type="text/css">body{background:#3D3D3D;}</style>
<body>

<div class="top container-fluid clearfix">
    <div class="row clearfix">
        <div class="logo"><img src="<?php echo '/ui/images/pc_logo2.png'; ?>"/></div>
        <div class="an">
            <div class="btn-group" role="group">
                <div class="btn-group clearfix">
                    <a href="/member/news.php" class="btn btn-default btn-long btn-long2 dropdown-toggle btn-lg"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> 玩家公告</a>
                </div>
                <div class="btn-group clearfix">
                    <a href="/member/msg.php" class="btn btn-default btn-long btn-long2 dropdown-toggle btn-lg"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> 站内信<!-- <span class="badge biaoqian1"></span> --></a>
                </div>
                <div class="btn-group clearfix">
                    <button type="button" class="btn btn-default btn-long dropdown-toggle btn-lg" style="height:46px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $memberLogged_userName;?> <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right clearfix user-menu"> 	
                        <li><a href="/member/pi.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> 修改资料</a></li>
                        <li><a href="/member/pa.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> 密码保护</a></li>
                        <li><a href="/member/log_login.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> 登录日志</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/member/logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> 退出登录</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main clearfix">
<!--LEFT -->
    <div class="left pull-left">    
    <!-- <div class="btn-group-vertical choujiang"><a href="/member/lottery.php" target="_blank"><img src="/ui/images/cj.gif" /></a></div> -->
        <div class="btn-group-vertical">
            <ul>
                <li>
                    <a class="btn btn-long" href="/member/index.php" id="mlindex"><span class="glyphicon glyphicon-home llong0" aria-hidden="true"></span><span class="llong2">玩家首页</span></a>
                </li>    
                <li>
                    <a class="btn btn-long" href="#" role="button"><span class="glyphicon glyphicon-piggy-bank llong0" aria-hidden="true"></span><span class="llong2">庄园管理</span><span class="glyphicon glyphicon-menu-left llong1"></span></a>
                    <ul class="sub-menu">
                        <li><a class="btn btn-long8" href="/member/my_farm.php" id="m11">我的庄园</a></li>
                        <li><a class="btn btn-long8" href="/member/com_list.php" id="m22">好友庄园(一级)</a></li>
                        <li><a class="btn btn-long8" href="/member/com_list_second.php" id="m24">好友庄园(二级)</a></li>
                        <li><a class="btn btn-long8" href="/member/act_mer.php" id="m23">开发新庄园</a></li>
                         <!--<li><a class="btn btn-long8" href="/member/my_farm_detailed.php" id="m13">我的可可(种子)</a></li>
                        <li><a class="btn btn-long8" href="/member/farm_shop.php" id="m12">可可商店</a></li>-->
                         <!-- <li><a class="btn btn-long8" href="/member/lottery.php"  id="m12">玩家抽奖</a></li>
                       <li><a class="btn btn-long8" href="/member/lotterylog.php"  id="m13">抽奖记录</a></li>-->
                    </ul>
                </li>
                <li>
                    <a class="btn btn-long" href="#" role="button"><span class="glyphicon glyphicon-user llong0" aria-hidden="true"></span><span class="llong2">账户管理</span><span class="glyphicon glyphicon-menu-left llong1"></span></a>
                    <ul class="sub-menu">
                        <li><a class="btn btn-long8" href="/member/rr.php" id="m21">推荐结构</a></li>
                        <li><a class="btn btn-long8" href="/member/act_mer_log.php" id="m26">激活记录</a></li>
                    </ul>    
                </li> 
                <li>
                    <a class="btn btn-long" href="#" role="button"><span class="glyphicon glyphicon-usd llong0" aria-hidden="true"></span><span class="llong2">收支明细</span><span class="glyphicon glyphicon-menu-left llong1"></span></a>
                    <ul class="sub-menu">
                       
                       <!-- <li><a class="btn btn-long8" href="/member/point2_log_in.php" id="m31">总收入</a></li>
                        <li><a class="btn btn-long8" href="/member/point2_log_out.php" id="m32">总支出</a></li> -->
                        <li><a class="btn btn-long8" href="/member/point1_log_in.php" id="m33">种子奖励记录</a></li>
                        <li><a class="btn btn-long8" href="/member/wizard.php" id="m34">丘比特奖励记录</a></li>
                        <li><a class="btn btn-long8" href="/member/flowerfairy.php" id="m35">花仙子奖励记录</a></li>
                         <li><a class="btn btn-long8" href="/member/fertilizelogs.php" id="m37">施肥记录</a></li>
                        <li><a class="btn btn-long8" href="/member/seedlogs.php" id="m38">播种记录</a></li>
                        <li><a class="btn btn-long8" href="/member/shuohuolog.php" id="m39">收获记录</a></li>
                    </ul>
                </li>    
                <li>
                    <a class="btn btn-long" href="#" role="button"><span class="glyphicon glyphicon-retweet llong0" aria-hidden="true"></span><span class="llong2">交易系统</span><span class="glyphicon glyphicon-menu-left llong1"></span></a>
                    <ul class="sub-menu">  
                        <li><a class="btn btn-long8" href="/member/point2_transfer.php" id="m46">KK转账</a></li>  
                         <li><a class="btn btn-long8" href="/member/point2_sell_list.php" id="m41">委托交易</a></li>
                        <li><a class="btn btn-long8" href="/member/point2_buy_log.php" id="m42">委托购买记录</a></li>
                        <li><a class="btn btn-long8" href="/member/point2_sell_log.php" id="m43">委托出售记录</a></li>
                        <li><a class="btn btn-long8" href="/member/point1_to_flower.php" id="m44">种子转KK</a></li>
                        <li><a class="btn btn-long8" href="/member/point1_flower_list.php" id="m45">种子转换记录</a></li>
                       <!-- <li><a class="btn btn-long8" href="/member/shangcheng.php" id="m47">商城转账</a></li> -->
                        
                        <!-- <li><a class="btn btn-long8" href="/member/point2_withdraw.php" id="m47">申请提现</a></li> -->
                        <!-- <li><a class="btn btn-long8" href="/member/shangcheng_log.php" id="m48">商城转账记录</a> -->
						<li><a class="btn btn-long8" href="/member/UseBeeLogs.php" id="m49">采蜜记录</a>
                        <!-- <li><a class="btn btn-long8" href="/member/point2_withdraw_log.php" id="m48">提现记录</a></li> -->
                    </ul>
                </li>
                 <li>
                    <a class="btn btn-long" href="#" role="button"><span class="glyphicon glyphicon-shopping-cart llong0" aria-hidden="true"></span><span class="llong2">资料修改</span><span class="glyphicon glyphicon-menu-left llong1"></span></a>
                    <ul class="sub-menu">
                        <li><a class="btn btn-long8" href="/member/pi.php" id="m51"> 修改资料</a></li>
                        <li><a class="btn btn-long8" href="/member/pa.php" id="m52">密码保护</a></li>
                        <li><a class="btn btn-long8" href="/member/log_login.php" id="m53">登录日志</a></li>
                    </ul>
                </li>    
                <!-- <li>
                    <a class="btn btn-long" href="#" role="button"><span class="glyphicon glyphicon-shopping-cart llong0" aria-hidden="true"></span><span class="llong2">购买商品</span><span class="glyphicon glyphicon-menu-left llong1"></span></a>
                    <ul class="sub-menu">
                        <li><a class="btn btn-long8" href="/member/point2_shop.php" id="m51">商城购物</a></li>
                        <li><a class="btn btn-long8" href="/member/point2_shop_order.php" id="m52">我的订单</a></li>
                    </ul>
                </li> -->    
            </ul> 
        </div>
    </div>
	<script>
    //$(selector).toggle(speed,callback);
    </script>
    <!--LEFT End-->
