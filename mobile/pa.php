<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
if(!$_GET['type'] || $_GET['type'] <= 0 || $_GET['type'] > 2)die;
$t = array();
$t[1] = '密保问题保护';
$t[2] = '密保QQ保护';
$pageTitle = $t[$_GET['type']];
require_once 'inc_header.php';
require_once 't.php';
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
if($_GET['type'] == 1){
?>
<form class="form-horizontal">
<div style="font-size: 16px; margin: 10px 0">忘记密码时，可以通过回答密保问题而重置密码。</div>
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">密保问题1</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_a1'];?>" id="x1" class="personal-info-line personal-info-input" placeholder="如：小学学校名称是？" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">答案1</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_q1'];?>" id="x2" class="personal-info-line personal-info-input" placeholder="输入密保问题1的答案" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">密保问题2</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_a2'];?>" id="x3" class="personal-info-line personal-info-input" placeholder="如：您母亲的姓名是？" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">答案2</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_q2'];?>" id="x4" class="personal-info-line personal-info-input" placeholder="输入密保问题2的答案" />
        </div>
        <div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">密保问题3</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_a2'];?>" id="x5" class="personal-info-line personal-info-input" placeholder="如：您父亲的生日是？" />
        </div>
		<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">答案3</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_q2'];?>" id="x6" class="personal-info-line personal-info-input" placeholder="输入密保问题3的答案" />
        </div>
        <input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub xiugai1_go" />
</form>
<? }elseif($_GET['type'] == 2){ ?>
<div style="font-size: 16px; margin: 10px 0">忘记密码时，使用该QQ联系客服重置密码。</div>
<div class="personal-info-item">
            <span id="ctl00_body_Label1" class="personal-info-line personal-info-label">您的QQ号</span>
            <label class="personal-info-line-split">:</label>
            <input name="ctl00$body$TextBox1" type="text" value="<?php echo $rs['h_qq']; ?>" id="x21" class="personal-info-line personal-info-input" placeholder="输入您的QQ号" />
        </div>
 <input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub xiugai2_go" />
<? } ?>
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
require_once 'f.php';
require_once 'inc_footer.php';
?>