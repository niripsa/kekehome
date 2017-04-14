<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mobile/logged_data.php';
//echo $memberLogged_userName . '|' . $memberLogged_passWord;exit;

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
	window.location.href = 'index.php?t=4';
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
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
<title><?php echo $pageTitle . $webInfo['h_webName'] . ' - ' . $webInfo['h_webKeyword']; ?></title>
<meta name="keywords" content="<?php echo $webInfo['h_keyword']; ?>" />
<meta name="description" content="<?php echo $webInfo['h_description']; ?>" />
<link href="/mod/MobileStyle.css" rel="stylesheet">
<script type="text/javascript" src="/ui/js/jquery.min.js"></script>
<script src="/mod/jquery.validate.min.js"></script>
<script src="/mod/messages_zh.js"></script>
<script src="/mod/moment.min.js"></script>
<script src="/mod/underscore-min.js"></script>
<script src="/mod/WdatePicker.js"></script>
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
<body>
