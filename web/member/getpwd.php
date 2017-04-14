<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>找回密码</title>
    <link rel="stylesheet" href="/ui/css/bootstrap.min.css">
    <link href="/ui/css/css.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="/ui/js/html5shiv.min.js"></script>
      <script src="/ui/js/respond.min.js"></script>
    <![endif]-->
    <style>
    body{ background:#977106; min-width:320px;}
    </style>
</head>
<body>
    <div class="container log">
        <div class="tit"><img src="<?php echo $webInfo['h_webLogoLogin'];?>"></div>
        <div class="xlogin center-block">
        
<?php
switch($type){
	case 'aq':
		switch($step){
			case 3:
				aq_3();
				break;
			case 2:
				aq_2();
				break;
			case 1:
				aq_1();
				break;
			default:
				aq();
				break;
		}
		break;
	case 'qq':
		switch($step){
			case 1:
				qq_1();
				break;
			default:
				qq();
				break;
		}
		break;
	case 'other':
		other();
		break;
	default:
		main();
		break;
}

function aq_3(){
	global $db;
	global $username;
	global $q1,$q2,$q3;
	global $pwd;
	global $webInfo;
	
	if(strlen($username) != 11){
		HintAndBack("玩家编号错误，请检查！",1);
	}
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$username}'");
	if(!$rs){
		HintAndBack("未找到您的玩家编号！",1);
	}
	if(strlen($rs['h_a1']) <= 0 || strlen($rs['h_q1']) <= 0){
		HintAndBack("抱歉，您未填写密保问题，无法使用本方式取回密码！",1);
	}
	
	if(strlen($q1) <= 0){
		HintAndBack("请输入答案1！",1);
	}
	if(strlen($q2) <= 0){
		HintAndBack("请输入答案2！",1);
	}
	if(strlen($q3) <= 0){
		HintAndBack("请输入答案3！",1);
	}

	if($rs['h_q1'] != $q1){
		HintAndBack("抱歉，答案1错误！",1);
	}
	if($rs['h_q2'] != $q2){
		HintAndBack("抱歉，答案2错误！",1);
	}
	if($rs['h_q3'] != $q3){
		HintAndBack("抱歉，答案3错误！",1);
	}
	
	if(strlen($pwd) < 6 || strlen($pwd) > 32){
		HintAndBack("抱歉，登录密码6-32位任意字符，请检查！",1);
	}
	
	$pwd = md5($pwd);
	
	$sql = "update `h_member` set h_passWord = '" . $pwd . "' where h_userName = '" . $username . "'";
	$db->query($sql);
	
	okinfo('/member/login.php','密码修改成功');
}

function aq_2(){
	global $db;
	global $username;
	global $q1,$q2,$q3;
	global $webInfo;
	
	if(strlen($username) != 11){
		HintAndBack("玩家编号错误，请检查！",1);
	}
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$username}'");
	if(!$rs){
		HintAndBack("未找到您的玩家编号！",1);
	}
	if(strlen($rs['h_a1']) <= 0 || strlen($rs['h_q1']) <= 0){
		HintAndBack("抱歉，您未填写密保问题，无法使用本方式取回密码！",1);
	}
	
	if(strlen($q1) <= 0){
		HintAndBack("请输入答案1！",1);
	}
	if(strlen($q2) <= 0){
		HintAndBack("请输入答案2！",1);
	}
	if(strlen($q3) <= 0){
		HintAndBack("请输入答案3！",1);
	}

	if($rs['h_q1'] != $q1){
		HintAndBack("抱歉，答案1错误！",1);
	}
	if($rs['h_q2'] != $q2){
		HintAndBack("抱歉，答案2错误！",1);
	}
	if($rs['h_q3'] != $q3){
		HintAndBack("抱歉，答案3错误！",1);
	}
	?>
 <form action="?type=aq&step=3" method="post">
 <input name="q1" type="hidden" value="<?php echo $q1; ?>">
 <input name="q2" type="hidden" value="<?php echo $q2; ?>">
 <input name="q3" type="hidden" value="<?php echo $q3; ?>">
	<div class="xlogin2 form-horizontal">
		<div class="lo1">使用密保找回密码，第三步</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">玩家编号:</label>
			<div class="col-sm-8">
				<input class="form-control" id="username" name="username" readonly placeholder="您的玩家编号" value="<?php echo $username; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">重置新密码:</label>
			<div class="col-sm-8">
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="6-32位任意字符">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<div class="checkbox">&nbsp;</div>
			</div>    
			<div class="col-sm-4"><button type="submit" class="btn btn-primary form-control denglugo">提交修改</button></div>
		</div>
	</div> 
     </form>
	<?php
}

function aq_1(){
	global $db;
	global $username;
	global $webInfo;
	
	if(strlen($username) != 11){
		HintAndBack("玩家编号错误，请检查！",1);
	}
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$username}'");
	if(!$rs){
		HintAndBack("未找到您的玩家编号！",1);
	}
	if(strlen($rs['h_a1']) <= 0 || strlen($rs['h_q1']) <= 0){
		HintAndBack("抱歉，您未填写密保问题，无法使用本方式取回密码！",1);
	}
	?>
 <form action="?type=aq&step=2" method="post">
	<div class="xlogin2 form-horizontal">
		<div class="lo1">使用密保找回密码，第二步</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">玩家编号:</label>
			<div class="col-sm-8">
				<input class="form-control" id="username" name="username" readonly placeholder="您的玩家编号" value="<?php echo $username; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">密保问题1:</label>
			<div class="col-sm-8">
				<input class="form-control" id="a1" name="a1" readonly placeholder="您的密保问题1" value="<?php echo $rs['h_a1']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">答案1:</label>
			<div class="col-sm-8">
				<input class="form-control" id="q1" name="q1" placeholder="请填写您的答案1" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">密保问题2:</label>
			<div class="col-sm-8">
				<input class="form-control" id="a2" name="a2" readonly placeholder="您的密保问题2" value="<?php echo $rs['h_a2']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">答案2:</label>
			<div class="col-sm-8">
				<input class="form-control" id="q2" name="q2" placeholder="请填写您的答案2" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">密保问题3:</label>
			<div class="col-sm-8">
				<input class="form-control" id="a3" name="a3" readonly placeholder="您的密保问题3" value="<?php echo $rs['h_a3']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">答案3:</label>
			<div class="col-sm-8">
				<input class="form-control" id="q3" name="q3" placeholder="请填写您的答案3" value="">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<div class="checkbox">&nbsp;</div>
			</div>    
			<div class="col-sm-4"><button type="submit" class="btn btn-primary form-control denglugo">提交验证</button></div>
		</div>
	</div> 
     </form>
	<?php
}

function aq(){
	?>
    <form action="?type=aq&step=1" method="post">
	<div class="xlogin2 form-horizontal">
		<div class="lo1">使用密保找回密码，第一步</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">玩家编号:</label>
			<div class="col-sm-8">
				<input class="form-control" id="username" name="username" placeholder="请输入您的手机号码" value="">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<div class="checkbox">&nbsp;</div>
			</div>    
			<div class="col-sm-4"><button type="submit" class="btn btn-primary form-control denglugo">下一步</button></div>
		</div>
	</div> 
    </form>
	<?php
}

function qq_1(){
	global $db;
	global $username;
	global $webInfo;
	
	if(strlen($username) != 11){
		HintAndBack("玩家编号错误，请检查！",1);
	}
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$username}'");
	if(!$rs){
		HintAndBack("未找到您的玩家编号！",1);
	}
	$qq = $rs['h_qq'];
	if(strlen($qq) <= 0){
		HintAndBack("抱歉，您未填写QQ号码，无法使用本方式取回密码！",1);
	}
	
	$qq = substr($qq,0,2) . '******' . substr($qq,-2);
	?>
	<div class="xlogin2 form-horizontal">
		<div class="lo1">使用QQ找回密码，第二步</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">玩家编号:</label>
			<div class="col-sm-8">
				<input class="form-control" id="username" placeholder="您的玩家编号" value="<?php echo $username; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">玩家QQ:</label>
			<div class="col-sm-8">
				<input class="form-control" id="username" placeholder="您的QQ号" value="<?php echo $qq; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">提示:</label>
			<div class="col-sm-8">
				请使用上面的QQ号码联系我们客服人员QQ：<?php echo $webInfo['h_serviceQQ']; ?>
			</div>
		</div>
	</div> 
	<?php
}

function qq(){
	?>
    <form action="?type=qq&step=1" method="post">
	<div class="xlogin2 form-horizontal">
		<div class="lo1">使用QQ找回密码，第一步</div>
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">玩家编号:</label>
			<div class="col-sm-8">
				<input class="form-control" id="username" name="username" placeholder="请输入您的手机号码" value="">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<div class="checkbox">&nbsp;</div>
			</div>    
			<div class="col-sm-4"><button type="submit" class="btn btn-primary form-control denglugo">下一步</button></div>
		</div>
	</div> 
    </form>
	<?php
}

function other(){
	global $webInfo;
	?>
	<div class="xlogin2 form-horizontal">
		<div class="lo1">使用其它方式找回密码</div>
		<div class="form-group">
			<div class="col-sm-12">
            	<div style="padding-left:30px;">
				 &nbsp; &nbsp;请您联系我们客服人员QQ：<?php echo $webInfo['h_serviceQQ']; ?>，提供尽量全的资料给我们核对，以帮助我们确认您的身份无误，再帮您重置密码。<br>
                 &nbsp; &nbsp; 请您提供尽量全的资料：您的上家编号、您推广过的下家编号、您购买过的宠物、您的真实姓名等资料。<br>
				 &nbsp; &nbsp; 只有您未填写密保和QQ，我们才会受理本方式的取回密码。
                </div>
			</div>
		</div>
	</div> 
	<?php
}

function main(){
	?>
	<div class="xlogin2 form-horizontal">
		<div class="lo1">请选择找回密码类型</div>
		<div class="form-group" style="padding-left:30px;">
			<div class="col-sm-12"><button type="button" onClick="window.location.href='?type=aq'" class="btn btn-primary form-control">使用回答密保问题的方式找回</button></div>
		</div>
		<div class="form-group" style="padding-left:30px;">
			<div class="col-sm-12"><button type="button" onClick="window.location.href='?type=qq'" class="btn btn-primary form-control">使用QQ找回</button></div>
		</div>
		<div class="form-group" style="padding-left:30px;">
			<div class="col-sm-12"><button type="button" onClick="window.location.href='?type=other'" class="btn btn-primary form-control">其它方式</button></div>
		</div>
	</div> 
	<?php
}
?>

            
            
        </div>    
    </div>
    
    
    
<script src="/ui/js/jquery.min.js"></script>
<script src="/ui/js/bootstrap.min.js"></script>
<script src="/ui/js/jquery.backstretch.min.js"></script>
<script src="/ui/layer/layer.js"></script>
<script src="/ui/js/long.js"></script>
<script>
	 $.backstretch(["/ui/images/dl.jpg"], {
			  fade: 100,
			  duration: 100
		  });
</script>


  </body>
</html>