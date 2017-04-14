<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
if(!$_GET['type'] || $_GET['type'] <= 0 || $_GET['type'] > 3)die;
$t = array();
$t[1] = '个人资料';
$t[2] = '修改登录密码';
$t[3] = '修改安全密码';

$pageTitle = $t[$_GET['type']];

require_once 'inc_header.php';
require_once 't.php';
if($_GET['type'] == 1){
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
/*echo "<pre>";
print_r($rs);*/
?>
<form class="form-horizontal">
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">真实姓名</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_fullName'];?>" id="x1" class="personal-info-line personal-info-input" placeholder="" />
        </div>
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">性别</span>
            <label class="personal-info-line-split">:</label>
           <input  id="x8"  type="radio" name="sex" value = "1" style="width:30px !important;"   <?php  if($rs['h_sex'] == 1){  echo "checked"; } ?>  >男
      <input  id="x8"  type="radio" name="sex" value = "0"  style="width:30px !important;"   <?php  if($rs['h_sex'] == 0){  echo "checked"; } ?> >女
        </div>
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">手机号</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_mobile'];?>"  id="x9" class="personal-info-line personal-info-input" placeholder="" />
        </div>
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">支付宝账号</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_alipayUserName'];?>"  id="x2" class="personal-info-line personal-info-input" placeholder="您的支付宝账号" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">支付宝姓名</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_alipayFullName'];?>"  id="x3" class="personal-info-line personal-info-input" placeholder="您的支付宝账号姓名" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">微信号</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_weixin'];?>"  id="x11" class="personal-info-line personal-info-input" placeholder="您的微信号" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">百度钱包</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="1111111111"  id="x12" class="personal-info-line personal-info-input" placeholder="您的百度钱包" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">收货地址</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_addrAddress'];?>"  id="x4" class="personal-info-line personal-info-input" placeholder="您的默认收货地址" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">邮编</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_addrPostcode'];?>"  id="x5" class="personal-info-line personal-info-input" placeholder="您的邮编地址" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">收货人</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_addrFullName'];?>"  id="x6" class="personal-info-line personal-info-input" placeholder="您的默认收货人" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">收货人手机</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_addrTel'];?>"  id="x7" class="personal-info-line personal-info-input" placeholder="收货人手机" />
        </div>
		<input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub xiugai1_go" />

</form>

<?php }elseif($_GET['type'] == 2){ ?>
<form class="form-horizontal">
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">当前密码</span>
            <label class="personal-info-line-split">:</label>
            <input placeholder="请填写您当前的密码" type="password" value=""  id="x21" class="personal-info-line personal-info-input">
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">新密码</span>
            <label class="personal-info-line-split">:</label>
            <input placeholder="新的密码" type="password" value=""  id="x22" class="personal-info-line personal-info-input">
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">确认新密码</span>
            <label class="personal-info-line-split">:</label>
            <input placeholder="确认新的密码" type="password" value=""  id="x23" class="personal-info-line personal-info-input">
        </div>
    <input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub xiugai2_go" />
</form>

<?php }elseif($_GET['type'] == 3){ ?>
<form class="form-horizontal">
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">当前安全密码</span>
            <label class="personal-info-line-split">:</label>
            <input placeholder="请填写您当前的安全密码" type="password" value=""  id="x31" class="personal-info-line personal-info-input">
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">新安全密码</span>
            <label class="personal-info-line-split">:</label>
            <input placeholder="新的安全密码" type="password" value=""  id="x32" class="personal-info-line personal-info-input">
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">确认新密码</span>
            <label class="personal-info-line-split">:</label>
            <input placeholder="确认新的安全密码" type="password" value=""  id="x33" class="personal-info-line personal-info-input">
        </div>
    <input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub xiugai3_go" />
</form>
<?php } ?>

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
require_once 'f.php';
require_once 'inc_footer.php';
?>