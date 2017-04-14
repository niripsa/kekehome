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
    <title>登录到系统</title>
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
<div class="xlogin2 form-horizontal">
	<div class="lo1">用户登录</div>
   <div class="form-group">
    <label for="username" class="col-sm-4 control-label">玩家编号:</label>
    <div class="col-sm-8">
      <input class="form-control" id="username" placeholder="请输入您的手机号码" value="<?php echo $_COOKIE['m_username']; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="pwd" class="col-sm-4 control-label">登录密码:</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="pwd" placeholder="请输入您的密码">
    </div>
  </div>

<!--  <div class="form-group">
    <label for="x3" class="col-sm-4 control-label">验 证 码:</label>
    <div class="col-sm-4">
      <input class="form-control" id="x3" placeholder="验证码">
    </div>
    <div class="col-sm-4">
      <img src="" width="70" height="34" id="yzmpic" class="loimg" onclick="sxyzm();"/>
    </div>     
  </div> --> 
  
  <div class="form-group">
  <label for="pwd" class="col-sm-4 control-label"><input style="display:none;" type="checkbox" id="remember" value="1" checked='CHECKED'> <a href="getpwd.php" tppabs="http://luoleng.net/member/getpwd.php" target="_blank">忘记密码</a> </label>
    <!-- <div class="col-sm-4"><input  onclick="javascript:window.open('reg.php'/*tpa=http://luoleng.net/member/reg.php*/)" type="button" class="btn btn-primary form-control" value='注册'></input></div> -->
  <div class="col-sm-4"><button type="submit" class="btn btn-primary form-control denglugo">登录</button></div>
  </div> 
 <div class="lo4"></div>
 <br/>
 <!--<div class="form-group">
  <label for="pwd" class="col-sm-4 control-label">登录方式</label>
  <div class="col-sm-4"><img onclick="javascript:window.open('http://www.yundabao.com/download.aspx?id=49071')" src="/ui/images/qq_login.png"></div>
  <div class="col-sm-4"><img onclick="javascript:window.open('http://www.yundabao.com/download.aspx?id=49071')" src="/ui/images/wechat_login.png"></div>
  </div>  --> 

</div> 
</div>   
    
</div>   
    
</div>
    
</div>


    <script src="/ui/js/jquery.min.js"></script>
    <script src="/ui/js/bootstrap.min.js"></script>
    <script src="/ui/js/jquery.backstretch.min.js"></script>
    <script src="/ui/layer/layer.js"></script>
    <script src="/ui/js/long.js"></script>
    
    <script>
		
    	$(".denglugo").click(function () {
			denglu_go();
			return false;
		});	
		function denglu_go(){
			
			var username=$("#username").val();
			var pwd=$("#pwd").val();
			//var x3=$("#x3").val();
			var remember=$("#remember").prop('checked');
			if(username==""){
				tishi4('请输入您的玩家编号','#username')
				return false;
				}
			//if(!checkMobile(username)){
			//	tishi4('玩家编号应该是手机号码形式的11位数字','#username')
			//	return false;
			//	}
			
			if(pwd==""){
				tishi4('请输入您的密码','#pwd')
				return false;
				}
/*			if(x3==""){
				tishi4('请输入验证码','#x3')
				return false;
				}*/
				
			var url="/member/bin.php?act=login&username="+encodeURI(username)+"&pwd="+encodeURI(pwd)+"&remember="+encodeURI(remember.toString());
			tishi2();
			$.ajax({ type : "get", async:true,  url : url, dataType : "json",
				success: function(json){
					tishi2close();
					if(json.state == true){
						//layer.alert(json.msg,function(){
							//跳转
							window.location.href = '/member/';
						//});
						
					} else {
						layer.alert(json.msg);
					}
				},
				error:function(json){
					tishi2close();
					layer.alert('网络错误，请重新提交');
				}
			});
		}
		
		 $.backstretch(["/ui/images/dl.jpg"], {
		          fade: 100,
		          duration: 100
		      });
    </script>
  </body>
</html>