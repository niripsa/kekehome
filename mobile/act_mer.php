<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
$pageTitle = '开通新玩家';
require_once 'inc_header.php';
?>



<?php

$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
require_once 't.php';
?>
   <form  class="form-horizontal">
   <div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label">推荐人</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" value="<?php echo $rs['h_userName'];?>" id="comMember" class="friend-new-line friend-new-line-input" placeholder="推荐人">
            </div>
  <div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label">您的KK余额</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" value="<?php echo $rs['h_point2'];?>" id="x2" disabled="disabled" class="friend-new-line friend-new-line-input">
            </div>
  <div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label">消耗KK</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" value="<?php echo $webInfo['h_point2ComRegAct']; ?>" id="x3" disabled="disabled" class="friend-new-line friend-new-line-input">
            </div>
  <div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>新庄园账号</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" placeholder="只能使用玩家的手机号码" value="" id="username" class="friend-new-line friend-new-line-input">
            </div>
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>真实姓名</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" placeholder="只能使用玩家的真实姓名" value="" id="fullname" class="friend-new-line friend-new-line-input">
            </div>	
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>性别</span>
                <label class="friend-new-line-split">:</label>
				&nbsp&nbsp
        <input  id="sex" name="sex" type="radio" value="1" checked>男&nbsp&nbsp&nbsp
      <input  id="sex" name="sex" type="radio" value="0">女
            </div>	
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>一级密码</span>
                <label class="friend-new-line-split">:</label>
        <input  type="password" placeholder="6-32位任意字符" value="" id="pwd" class="friend-new-line friend-new-line-input">
            </div>	
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>确认一级密码</span>
                <label class="friend-new-line-split">:</label>
        <input  type="password" placeholder="6-32位任意字符" value="" id="pwd2" class="friend-new-line friend-new-line-input">
            </div>	
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>二级密码</span>
                <label class="friend-new-line-split">:</label>
        <input  type="password" placeholder="6-32位任意字符" value="" id="pwdII" class="friend-new-line friend-new-line-input">
            </div>	
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>确认二级密码</span>
                <label class="friend-new-line-split">:</label>
        <input  type="password" placeholder="6-32位任意字符" value="" id="pwdII2" class="friend-new-line friend-new-line-input">
            </div>
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>支付宝</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" placeholder="输入玩家支付宝" value="" id="alipay" class="friend-new-line friend-new-line-input">
            </div>				
<div class="friend-new-item">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>微信</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" placeholder="输入玩家微信" value="" id="weixin" class="friend-new-line friend-new-line-input">
            </div>	
<div class="friend-new-item" style = "display:none">
                <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label"><font color="red"> * </font>百度钱包</span>
                <label class="friend-new-line-split">:</label>
        <input  type="text" placeholder="输入玩家百度钱包" value="111111111" id="baidupay" class="friend-new-line friend-new-line-input">
            </div>	

<button type="button" id="reg" class="friend-new-sub">开通新会员</button>

</form>


<script>
		mgo(23);	
</script>

    <script>
		
    	$("#reg").click(function () {
			denglu_go();
			return false;
		});	
		function denglu_go(){
			
			var comMember=$("#comMember").val();
			var username=$("#username").val();

			var fullname=$("#fullname").val();
			var sex=$("#sex").val();
			var mobile=$("#mobile").val();

			var pwd=$("#pwd").val();
			var pwdII=$("#pwdII").val();
      var pwd2=$("#pwd2").val();
      var pwdII2=$("#pwdII2").val();

			
			var alipay=$("#alipay").val();
			var weixin=$("#weixin").val();
			var baidupay=$("#baidupay").val();

			if(comMember==""){
				tishi4('请输入直推人编号','#comMember')
				return false;
			}

			if(username==""){
				tishi4('请填写新会员的编号','#username')
				return false;
			}	

      if(!/^\d{7,11}$/.test(username)){
        tishi4('请填写正确的手机号码','#username')
        return false;
      }

			if(fullname==""){
				tishi4('请填写新会员的真实姓名','#fullname')
				return false;
			}		

			if(!checkPwd(pwd)){
				tishi4('请输入6-30位一级密码','#pwd')
				return false;
			}

      if(!checkPwd(pwd2)){
        tishi4('请输入6-30位确认一级密码','#pwd2')
        return false;
      }

      if(pwd!=pwd2){
          tishi4('一级密码和确认一级密码不一致！','#pwd2')
          return false;
      }

				
			if(!checkPwd(pwdII)){
				tishi4('请输入6-30位的二级密码','#pwdII')
				return false;
			}

      if(!checkPwd(pwdII2)){
        tishi4('请输入6-30位的确认二级密码','#pwdII2')
        return false;
      }

       if(pwdII!=pwdII2){
          tishi4('二级密码和确认二级密码不一致！','#pwdII2')
          return false;
      }

      $("#reg").attr({"disabled":"disabled"});
			var url="/member/bin.php?act=reg2&comMember="+encodeURI(comMember)+"&username="+encodeURI(username)+"&pwd="+encodeURI(pwd)+"&pwdII="+encodeURI(pwdII)+"&fullname="+encodeURI(fullname)+"&sex="+encodeURI(sex)+"&mobile="+encodeURI(mobile)+"&alipay="+encodeURI(alipay)+"&weixin="+encodeURI(weixin)+"&baidupay="+encodeURI(baidupay);
			tishi2();
			$.ajax({ type : "get", async:true,  url : url, dataType : "json",
				success: function(json){
					tishi2close();
					if(json.state == true){
						layer.alert(json.msg,function(){
							//跳转
							window.location.href = '/mobile/act_mer.php';
						});
						
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
 
<? require_once 'f.php'; ?>




<?php
require_once 'inc_footer.php';
?>