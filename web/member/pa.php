<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '密码保护 - ';

require_once 'inc_header.php';
?>


<style>
body{background:#3D3D3D;}
.tab-content{ border:#DDDDDD solid 1px; border-top:0;}
.tab-pane{ padding:30px 10px 10px 10px;}
</style>
  
<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>我的账户 <small> 密码保护</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">我的账户</a></li>
  <li class="active">密码保护</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">密码保护</div>
  <div class="panel-body">


<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#t1" aria-controls="home" role="tab" data-toggle="tab">密保问题保护</a></li>
    <li role="presentation"><a href="#t2" aria-controls="profile" role="tab" data-toggle="tab">QQ保护</a></li>
    <!--
    <li role="presentation"><a href="#t3" aria-controls="messages" role="tab" data-toggle="tab">修改安全密码</a></li>
    -->
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="t1">
    <!--T1-->

<?php
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>
<form class="form-horizontal">
  <div class="form-group">
    <label for="x22" class="col-sm-2 control-label">提示:</label>
    <div class="col-sm-10"><div style="padding-top:7px;">当您忘记密码时，可以通过回答以下密保问题而重置密码。</div></div>
  </div> 
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">密保问题1:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x1" placeholder="如：小学学校名称是？" value="<?php echo $rs['h_a1'];?>">
    </div>
  </div> 
  <div class="form-group">
    <label for="x2" class="col-sm-2 control-label">答案1:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x2" placeholder="输入密保问题1的答案" value="<?php echo $rs['h_q1'];?>">
    </div>
  </div> 
    <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">密保问题2:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x3" placeholder="如：您母亲的姓名是？" value="<?php echo $rs['h_a2'];?>">
    </div>
  </div> 
    <div class="form-group">
    <label for="x4" class="col-sm-2 control-label">答案2:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x4" placeholder="输入密保问题2的答案" value="<?php echo $rs['h_q2'];?>">
    </div>
  </div> 
    <div class="form-group">
    <label for="x5" class="col-sm-2 control-label">密保问题3:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x5" placeholder="如：您父亲的生日是？" value="<?php echo $rs['h_a3'];?>">
    </div>
  </div> 
    <div class="form-group">
    <label for="x6" class="col-sm-2 control-label">答案3:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x6" placeholder="输入密保问题3的答案" value="<?php echo $rs['h_q3'];?>">
    </div>
  </div> 
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning xiugai1_go">马上修改</button>
    </div>
  </div>
</form>

    <!--T1 End-->
    </div>
    <div role="tabpanel" class="tab-pane" id="t2">
    <!--T2-->
    <form class="form-horizontal">
  <div class="form-group">
    <label for="x22" class="col-sm-2 control-label">提示:</label>
    <div class="col-sm-10"><div style="padding-top:7px;">当您忘记密码时，您可以使用该QQ联系我们的客服人员，由我们客服人员为您重置密码。</div></div>
  </div> 
  <div class="form-group">
    <label for="x21" class="col-sm-2 control-label">您的QQ号:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x21" placeholder="填写您的QQ号码" value="<?php echo $rs['h_qq']; ?>" type="text">
    </div>
  </div> 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning xiugai2_go">马上修改</button>
    </div>
  </div>
</form>
    <!--T2 End-->
    </div>
    <div role="tabpanel" class="tab-pane" id="t3">
        <!--T2-->
    <form class="form-horizontal">
  <div class="form-group">
    <label for="x31" class="col-sm-2 control-label">当前安全密码:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x31" placeholder="请填写您当前的密码" value="" type="password">
    </div>
  </div> 
  <div class="form-group">
    <label for="x32" class="col-sm-2 control-label">新安全密码:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x32" placeholder="新的密码" value="" type="password">
    </div>
  </div> 
  <div class="form-group">
    <label for="x33" class="col-sm-2 control-label">确认密码:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x33" placeholder="确认密码" value="" type="password">
    </div>
  </div> 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning xiugai3_go">马上修改</button>
    </div>
  </div>
</form>
    <!--T2 End-->
    </div>
  </div>

</div>


  </div>
</div>
</div>
<!--MAN End-->
</div></div>

<script>
	$("#mlindex").addClass("btn-long16");
	

	$(".xiugai1_go").click(function () {
			xiugai1_go();
			return false;
		});	
	function xiugai1_go(){
		var x1=$("#x1").val();
		var x2=$("#x2").val();
		var x3=$("#x3").val();
		var x4=$("#x4").val();
		var x5=$("#x5").val();
		var x6=$("#x6").val();

		if($("#x1").val()==""){
			tishi4("请填写密保问题1",'#x1');
			return false;
			}
		if($("#x2").val()==""){
			tishi4("请填写答案1",'#x2');
			return false;
			}
		if($("#x3").val()==""){
			tishi4("请填写密保问题2",'#x3');
			return false;
			}
		if($("#x4").val()==""){
			tishi4("请填写答案2",'#x4');
			return false;
			}
		if($("#x5").val()==""){
			tishi4("请填写密保问题3",'#x5');
			return false;
			}
		if($("#x6").val()==""){
			tishi4("请填写答案3",'#x6');
			return false;
			}
		tishi2();
		$.get("/member/bin.php?act=pa&a1="+encodeURI(x1)+"&q1="+encodeURI(x2)+"&a2="+encodeURI(x3)+"&q2="+encodeURI(x4)+"&a3="+encodeURI(x5)+"&q3="+encodeURI(x6),function(e){
			tishi2close();
			if(e!=""){
				layer.msg(unescape(e));
				}	
			},'html');					
		}
		
	$(".xiugai2_go").click(function () {
			xiugai2_go();
			return false;
		});		
		
	function xiugai2_go(){
		var x1=$("#x21").val();
		if(x1.length <= 0){
			tishi4('填写您的QQ号码','#x21')
			return false;
			}
		tishi2();		
		$.get("/member/bin.php?act=pa_qq&qq="+encodeURI(x1),function(e){
			tishi2close();
			if(e!=""){
				e4 = e.substr(0,4);
				if(e4 == '更新成功'){
					/*
					layer.msg(unescape(e),function(){
						window.location.reload();
					});*/
					layer.msg(unescape(e));
				}else{
					layer.msg(unescape(e));
				}
				}	
			},'html');				
			
		}
	$(".xiugai3_go").click(function () {
			xiugai3_go();
			return false;
		});		
		
	function xiugai3_go(){
		var x1=$("#x31").val();
		var x2=$("#x32").val();
		var x3=$("#x33").val();
		if(!checkPwd(x1)){
			tishi4('请输入6-30位密码','#x31')
			return false;
			}
		if(!checkPwd(x2)){
			tishi4('请输入6-30位密码','#x32')
			return false;
			}		
		if(!checkPwd(x3)){
			tishi4('请输入6-30位密码','#x33')
			return false;
			}
		if(x2!=x3){
			tishi4('两次密码输入不一致','#x33')
			return false;
			}	
		tishi2();		
		$.get("/member/bin.php?act=pi_pwdII&pwd="+encodeURI(x1)+"&pwd2="+encodeURI(x2)+"&pwd3="+encodeURI(x3),function(e){
			tishi2close();
			if(e!=""){
				e4 = e.substr(0,4);
				if(e4 == '更新成功'){
					layer.msg(unescape(e),function(){
						window.location.reload();
					});
				}else{
					layer.msg(unescape(e));
				}
				}	
			},'html');				
			
		}
    </script>
    
<?php
require_once 'inc_footer.php';
?>