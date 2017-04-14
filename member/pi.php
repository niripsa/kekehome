<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '修改资料 - ';

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
  <h3>我的账户 <small> 修改资料</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">我的账户</a></li>
  <li class="active">修改资料</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">修改资料</div>
  <div class="panel-body">


<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#t1" aria-controls="home" role="tab" data-toggle="tab">基本信息</a></li>
    <li role="presentation"><a href="#t2" aria-controls="profile" role="tab" data-toggle="tab">修改一级密码</a></li>
    <li role="presentation"><a href="#t3" aria-controls="messages" role="tab" data-toggle="tab">修改二级密码</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="t1">
    <!--T1-->

<?php
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
/*echo "<pre>";
print_r($rs);*/
?>
<form class="form-horizontal">
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">真实姓名:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x1" placeholder="真实姓名" value="<?php echo $rs['h_fullName'];?>">
    </div>
  </div> 
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">性别:</label>
    <div class="col-sm-10">
      <input  id="x8"  type="radio" name="sex" style="width:30px !important;"   <?php  if($rs['h_sex'] == 1){  echo "checked"; } ?>  >男
      <input  id="x8"  type="radio" name="sex" style="width:30px !important;"   <?php  if($rs['h_sex'] == 0){  echo "checked"; } ?> >女
    </div>
  </div> 
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">手机号:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x9" placeholder="您的手机号" value="<?php echo $rs['h_mobile'];?>">
    </div>
  </div> 
   <div class="form-group">
    <label for="x2" class="col-sm-2 control-label">支付宝账号:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x2" placeholder="您的支付宝账号" value="<?php echo $rs['h_alipayUserName'];?>">
    </div>
  </div> 
    <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">支付宝姓名:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x3" placeholder="您的支付宝账号姓名" value="<?php echo $rs['h_alipayFullName'];?>">
    </div>
  </div> 
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">微信号:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x11" placeholder="您的微信号" value="<?php echo $rs['h_weixin'];?>" >
    </div>
  </div> 
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">百度钱包:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x12" placeholder="您的百度钱包" value="1111111111" >
    </div>
  </div> 
 
    <div class="form-group">
    <label for="x4" class="col-sm-2 control-label">收货地址:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x4" placeholder="您的默认收货地址" value="<?php echo $rs['h_addrAddress'];?>">
    </div>
  </div> 
    <div class="form-group">
    <label for="x5" class="col-sm-2 control-label">邮编:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x5" placeholder="您的邮编地址" value="<?php echo $rs['h_addrPostcode'];?>">
    </div>
  </div> 
    <div class="form-group">
    <label for="x6" class="col-sm-2 control-label">收货人:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x6" placeholder="您的默认收货人" value="<?php echo $rs['h_addrFullName'];?>">
    </div>
  </div> 
     <div class="form-group">
    <label for="x7" class="col-sm-2 control-label">收货人手机:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x7" placeholder="收货人手机" value="<?php echo $rs['h_addrTel'];?>">
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
    <label for="x21" class="col-sm-2 control-label">当前密码:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x21" placeholder="请填写您当前的密码" value="" type="password">
    </div>
  </div> 
  <div class="form-group">
    <label for="x22" class="col-sm-2 control-label">新密码:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x22" placeholder="新的密码" value="" type="password">
    </div>
  </div> 
  <div class="form-group">
    <label for="x23" class="col-sm-2 control-label">确认密码:</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x23" placeholder="确认密码" value="" type="password">
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
		var x7=$("#x7").val();
		var x8=$("#x8").val();
		var x9=$("#x9").val();
		var x10=$("#x10").val();
		var x11=$("#x11").val();
		var x12=$("#x12").val();

		if($("#x1").val()==""){
			tishi4("请填写玩家姓名",'#x1');
			return false;
			}
		if($("#x2").val()==""){
			tishi4("请填写支付宝账号",'#x2');
			return false;
			}
		if($("#x3").val()==""){
			tishi4("请填写支付宝姓名",'#x3');
			return false;
			}
		if($("#x4").val()==""){
			tishi4("请填写收货地址",'#x4');
			return false;
			}
		if($("#x5").val()==""){
			tishi4("请填写邮编",'#x5');
			return false;
			}
		if($("#x6").val()==""){
			tishi4("请填写收货人",'#x6');
			return false;
			}
		if($("#x7").val()==""){
			tishi4("请填写收货人手机",'#x7');
			return false;
			}			
		if(!checkMobile($("#x7").val())){
				tishi4('请填写正确的手机号码','#x7')
				return false;
				}
		tishi2();
		$.get("/member/bin.php?act=pi&fullname="+encodeURI(x1)+"&alipayUserName="+encodeURI(x2)+"&alipayFullName="+encodeURI(x3)+"&addrAddress="+encodeURI(x4)+"&addrPostcode="+encodeURI(x5)+"&addrFullName="+encodeURI(x6)+"&addrTel="+encodeURI(x7)+"&sex="+encodeURI(x8)+"&mobile="+encodeURI(x9)+"&alipay="+encodeURI(x10)+"&weixin="+encodeURI(x11)+"&baidupay="+encodeURI(x12),function(e){
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
		var x2=$("#x22").val();
		var x3=$("#x23").val();
		if(!checkPwd(x1)){
			tishi4('请输入6-30位密码','#x21')
			return false;
			}
		if(!checkPwd(x2)){
			tishi4('请输入6-30位密码','#x22')
			return false;
			}		
		if(!checkPwd(x3)){
			tishi4('请输入6-30位密码','#x23')
			return false;
			}
		if(x2!=x3){
			tishi4('两次密码输入不一致','#x23')
			return false;
			}	
		tishi2();		
		$.get("/member/bin.php?act=pi_pwd&pwd="+encodeURI(x1)+"&pwd2="+encodeURI(x2)+"&pwd3="+encodeURI(x3),function(e){
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