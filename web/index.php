<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';
echo isflowerfairy2('123456');
if(!$webInfo['h_open']){
	echo "
	<script>
	window.location.href='/close.php';
	</script>
	";
	}
function checkSubstrs($list, $str) {
        $flag = false;
        for ($i = 0; $i < count($list); $i++) {
            if (strpos($str, $list[$i]) > 0) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }
function check_wap() {
        if (isset($_SERVER['HTTP_VIA'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_X_NOKIA_CONNECTION_MODE'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID'])) {
            return true;
        }
        if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            // Check whether the browser/gateway says it accepts WML.  
            $br = "WML";
        } else {
            $browser = isset($_SERVER['HTTP_USER_AGENT']) ? trim($_SERVER['HTTP_USER_AGENT']) : '';
            if (empty($browser)) {
                return true;
            }
            $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');
 
            $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');
 
            $found_mobile = checkSubstrs($mobile_os_list, $browser) || checkSubstrs($mobile_token_list, $browser);
            if ($found_mobile) {
                $br = "WML";
            } else {
                $br = "WWW";
            }
        }
        if ($br == "WML") {
            return true;
        } else {
            return false;
        }
    }
	if(check_wap()){ ?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    
    <title>可可家园，一款惊奇的游戏！</title>
    <link href="mod/mlogin.css" rel="stylesheet" type="text/css">
       <link rel="shortcut icon" href="http://bo.pergame.vip/images/logo_icon.ico?id=2" type="image/x-icon">
    <script type="text/javascript" src="mod/jquery-1.8.2.min.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0,user-scalable=true">
</head>
<body>

<div class="form-div">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="tZQgxVlvbj+Ct3DZdHzKELBgQ4QarpWADNXqzdfvjse2UshLS+/DNNmi7poYpqY7sIzPqXvdREp4U9wtK+93zg8D9rfxQucvBPPw31FZ+Ok=">
</div>

<div>

	<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="64A35033">
	<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="3bwd714Nw0oZvzjCwR/tfcjMp3sbKn6GFYYSVbjrukoZobX4ceirSkmS4El4vBcWI4U9SZcb9ioVew6hF77vqFp/+IOTmchxlYKOcOQUnIOuGhbkmIfVwZ9xjD6/WQno82q5HuIKv7Ta1W1Xzd9HBNyYwl1Q5dLf3L/iitbfseaa2bz/lbiVYSL3j4rB3B08">
</div>
         
        <img src="mod/sologan.png" style="width: 70%;margin-top: 70px; margin-left: 15%">
        <input name="txtUserId" type="text" id="username" value = "<?php echo $_COOKIE['m_username']; ?>" class="text" placeholder="用户名">
        <input name="txtPassword" type="password" id="pwd" class="text" placeholder="密码">
		<input style="display:none;" type="checkbox" id="remember" value="1" checked='CHECKED'>
        <div style="width: 60%; margin-top: 10px; margin-left: 20%;">
            <input name="txtVerifyCode" type="text" id="x3" class="text-v" placeholder="验证码">
            <img id="img" src="../include/getCode.php" onclick="reImg();" style="float: right; background: url(/images/mlogin_en/l_textbox_v.png) no-repeat; background-size: 100% 100%; width: 40%; height: 30px; padding-left: 10px;">
        </div>
        <input type="submit" name="btnSave" value="" id="btnSave" class="btn denglugo">
        
        <div style=" margin-top: 10px;margin-left: auto;margin-right: auto;text-align: center;">

                <a href="mobile/getpwd.php" style="font-size:14px;">忘记密码</a>
                
             
        </div>
</div>
    

    <script type="text/javascript">
        function reImg() {
            var img = document.getElementById("img");
            img.src = "../include/getCode.php?" + Math.random();
        }
        function pwd() {
            //window.location.href = "GetPassword.aspx";
        }
    </script>
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
			var x3=$("#x3").val();
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
			if(x3==""){
				tishi4('请输入验证码','#x3')
				return false;
				}
				
			var url="/member/bin.php?act=login&username="+encodeURI(username)+"&pwd="+encodeURI(pwd)+"&verify="+encodeURI(x3)+"&remember="+encodeURI(remember.toString());
			tishi2();
			$.ajax({ type : "get", async:true,  url : url, dataType : "json",
				success: function(json){
					tishi2close();
					if(json.state == true){
						//layer.alert(json.msg,function(){
							//跳转
							window.location.href = '/mobile/';
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
    </script>
  

</body></html>
	<?php }else{ ?>
	<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    
    <title>可可家园，一款惊奇的游戏！</title>
    

    <link href="mod/style.css" rel="stylesheet" type="text/css">

    <script src="mod/jquery.js"></script>
    

    
    
    
    
    
    
    
    
    <style>
        .btn-login {
            background: url(/images/login/btn.png) no-repeat;
            margin-top: 26px;
            font-size: 30px;
            color: #ffffff;
            margin-left: 200px;
        }

        input::-webkit-input-placeholder {
            color: #442204;
            font-size: 14px;
            border: none;
        }

        .btn-text {
            background: url(/images/login/l_login_t_b.png) no-repeat;
            width: 350px;
            height: 40px;
            margin-left: 120px;
            padding-left: 30px;
            outline: none;
        }

        .v-b-s {
            background: url(/images/login/v_b.png) no-repeat;
            padding-left: 30px;
            outline: none;
        }

        body {
            width: 100%;
            height: 100%;
        }
        .box_relative {
            position: absolute;
            right: 200px;
            top: 20px;
            font-size:20px;
            color:#a30707;
            font-weight:bold;
            
            
            }
    </style>

</head>
<!--
<body style="position: relative; background-size: 100% 100%; background: url(/images/l_b.jpg); background-repeat: no-repeat; background-position: center top; overflow: hidden;">
-->
<body>
    
    
    
    <input readonly="true" style="background: url(/images/login/l_l_t.png) no-repeat; width: 700px; height: 100px; font-size: 30px; color: #ffffff; padding-left: 120px; padding-top: 5px;" value="可可家园，一款惊奇的游戏！">
    <form name="ctl00" method="post" action="http://bo.pergame.vip/Login.aspx" id="ctl00" style="width: 100%; height: 100%;">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="FfJkkKYuqKMPVGJZ+8jPAxBxitE8jT6BOkP+AusNZNxdJ7bcadhg93wHLdgSqieKLIIxYfveHkbWHnZvonWYcLboCmK+UzYHrrM4xKryL81GDPcAB4uz8BnUWp1nX5f0MadT/PvKwbQziP16s5agCvnt4nZzBwUyUvTdSrutqYAc+U6Fugqjrj+96DGX9toTfGU8RCTjmpeSPDMvgctZt0knmlkYN6xr8X9seACT5aY=">
</div>

<div>

	<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="C2EE9ABB">
	<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="i4OPunwygdxrNKk9mzcOp8XOC0CxmrlhUeZmF5AC31PkqFnQaxPkBuxPJLWql4gIm++qj95qEzhcjx8m2B8kvKgwUDXnk/ADizc0k2Pws7d/uzRpZ1Fs5cdc/DoVkDlEpmIGqtbBB28JO9md8h3Qis7rHVNn8E87g5hxw/ZSmkbXuli78WXLbtDolhxoREA0">
</div>
          
          <div style="background: url(/images/login/l_login_b.png) no-repeat; width: 600px; height: 430px; margin-top: 50px; margin-left: 350px; position: relative;">
         <input name="UserId" type="text" id="username" value="<?php echo $_COOKIE['m_username']; ?>" class="btn-text" placeholder="用户名" onclick=" JavaScript: this.value = &#39;&#39;; " style="border-width:0px;margin-top: 140px">
            <input name="PassWord" type="password" id="pwd" class="btn-text" placeholder="密码" onclick=" JavaScript: this.value = &#39;&#39;; " style="margin-top: 25px;">
            <div style="margin-top: 25px; width: 320px; height: 40px; margin-left: 120px;">
                <input name="vcode" type="text" id="x3" class="v-b-s" placeholder="验证码" style="height:40px;width:180px;">
                <img id="img" onClick="this.src=this.src+'?'+Math.random();" style="position: absolute; width: 140px; height: 50px; padding-left: 15px; padding-top: 0px" src="../include/getCode.php">
            </div>
            <div>
                <input type="submit" name="btnSave" value="登录" id="btnSave" class="btn-login" style="height:65px;width:214px;">

                <input style="display:none;" type="checkbox" id="remember" value="1" checked='CHECKED'><a href="/member/getpwd.php" style="font-size:14px;">忘记密码</a>
                
            </div>
        </div>
    </form>
	    <script src="/ui/js/jquery.min.js"></script>
    <script src="/ui/js/bootstrap.min.js"></script>
    <script src="/ui/js/jquery.backstretch.min.js"></script>
    <script src="/ui/layer/layer.js"></script>
    <script src="/ui/js/long.js"></script>
    
    <script>
		
    	$(".btn-login").click(function () {
			denglu_go();
			return false;
		});	
		function denglu_go(){
			
			var username=$("#username").val();
			var pwd=$("#pwd").val();
			var x3=$("#x3").val();
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
			if(x3==""){
				tishi4('请输入验证码','#x3')
				return false;
				}
				
			var url="/member/bin.php?act=login&username="+encodeURI(username)+"&pwd="+encodeURI(pwd)+"&verify="+encodeURI(x3)+"&remember="+encodeURI(remember.toString());
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
   
    


</body></html>
<?php } ?>