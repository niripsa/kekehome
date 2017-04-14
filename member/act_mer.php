<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
$pageTitle = '开通新玩家 - ';
require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>账户管理 <small> 开通新玩家</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">账户管理</a></li>
  <li class="active">开通新玩家</li>
</ol>
</div>

<?php

$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);

?>
<div class="panel panel-default">
  <div class="panel-heading">开通新玩家</div>
  <div class="panel-body">  
   <!--主-->


   <form  class="form-horizontal">
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label"><font color="red"> * </font>推荐人账号</label>
    <div class="col-sm-10">
      <input  class="form-control form-long-w1" id="comMember" placeholder="您的玩家编号" value="<?php echo $rs['h_userName'];?>">
    </div>
  </div>
  

  <div class="form-group">
    <label for="x2" class="col-sm-2 control-label">您的KK余额</label>
    <div class="col-sm-10">
      <input disabled="disabled" class="form-control form-long-w1" id="x2" placeholder="您的KK余额" value="<?php echo $rs['h_point2'];?>">
    </div>
  </div>  

  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">消耗KK</label>
    <div class="col-sm-10">
      <input disabled="disabled" class="form-control form-long-w1" id="x3" placeholder="消耗KK" value="<?php echo $webInfo['h_point2ComRegAct']; ?>">
    </div>
  </div> 
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label"><font color="red"> * </font>新庄园账号:</label>
    <div class="col-sm-8">
      <input class="form-control" id="username" placeholder="只能使用玩家的手机号码">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label"><font color="red"> * </font>真实姓名:</label>
    <div class="col-sm-8">
      <input class="form-control" id="fullname" placeholder="只能使用玩家的真实姓名">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label"><font color="red"> * </font>性别:</label>
    <div class="col-sm-8">
      <input  id="sex" name="sex" type="radio" value="1" checked>男
      <input  id="sex" name="sex" type="radio" value="0">女

    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label"><font color="red"> * </font>一级密码:</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="pwd" placeholder="6-32位任意字符">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label"><font color="red"> * </font>确认一级密码:</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="pwd2" placeholder="6-32位任意字符">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label"><font color="red"> * </font>二级密码:</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="pwdII" placeholder="6-32位任意字符">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label"><font color="red"> * </font>确认二级密码:</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="pwdII2" placeholder="6-32位任意字符">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">支付宝:</label>
    <div class="col-sm-8">
      <input class="form-control" id="alipay" placeholder="输入玩家支付宝">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">微信:</label>
    <div class="col-sm-8">
      <input class="form-control" id="weixin" placeholder="输入玩家微信">
    </div>
  </div>
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">百度钱包:</label>
    <div class="col-sm-8">
      <input  class="form-control" id="baidupay" value="1111111" placeholder="输入玩家百度钱包">
    </div>
  </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10" id="point1UserName-cos"></div>
  </div> 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="button" id="reg" class="btn btn-warning ">开通新会员</button>
    </div>
  </div>
</form>

    <!--End-->
  </div>
   


</div>
</div>
<!--MAN End-->
</div></div>

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
							window.location.href = '/member/act_mer.php';
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
 





<?php
require_once 'inc_footer.php';
?>