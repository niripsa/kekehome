<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = 'KK转账 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>交易管理 <small> KK转账</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">交易管理</a></li>
  <li class="active">KK转账</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">KK转账</div>
   

  <div class="panel-body">
   <!--主-->
   <form class="form-horizontal">

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <span style="color:#F00">
 
<?php
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>
      
  您好! <strong><?php echo $rs['h_fullName']; ?></strong> (<?php echo $rs['h_userName']; ?>). 您的可转出KK为:<span id="mejihuobi"><?php echo $rs['h_point1']; ?></span>
  
  
      </span>
    </div>
  </div>

  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">转出金额</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x1" placeholder="请输入要转出的金额" value="" maxlength="11">
    </div>
  </div>

  <div class="form-group">
    <label for="x2" class="col-sm-2 control-label">用户编号</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x2" placeholder="输入您要转给的用户" value="">
    </div>
  </div> 


  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10" id="x4-cos"></div>
  </div> 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning zhuanjihuobi_go">马上转账</button>
    </div>
  </div>
</form>
    <!--End-->
  </div>
   


</div>
</div>
<!--MAN End-->
</div></div>

<script src="/ui/layer/extend/layer.ext.js"></script>
    <script>
	mgo(41);
	
	
	$('#x2').bind('input propertychange', function() { 
		if($(this)){
			tishi2();
			$.get("/member/bin.php?act=chkun&username="+$(this).val(),function(e){
			tishi2close();
			if(e!=""){
				$("#x4-cos").html(unescape(e));
				}
			},'html');
				
			}else{
				$("#x4-cos").html('');
			}
		});	

	$(".zhuanjihuobi_go").click(function () {
			zhuanjihuobi_go();
			return false;
		});	
	function zhuanjihuobi_go(){
		if($("#x1").val()==""){
			tishi4("请输入填写你充值KK的金额",'#x1');
			return false;
			}
			
		if(!checkNum($("#x1").val())){
			tishi4("请输入正确的金额 至少转1KK",'#x1');
			return false;
			}
		if(parseFloat($("#x1").val())>parseFloat($("#mejihuobi").text())){
			tishi4("你的KK余额不足",'#x1');
			return false;			
			}
		//if(!checkMobile($("#x2").val())){
		//	tishi4("请输入正确的玩家编号",'#x2');
		//	return false;
		//	}
						
		x4=$("#x4-cos").text().substr(0,5);
		if(x4!="玩家姓名："){
			tishi4($("#x4-cos").text(),'#x2');
			return false;
			}
		var lcindex_ = layer.prompt({title: '请输入安全密码，并确认转账',formType: 1}, function(pass){
			if(pass==""){
				layer.msg("请输入您的密码")
				return false;
				}
			tishi2();
			$.get("/member/bin.php?act=point1_transfer&num="+$("#x1").val()+"&username="+$("#x2").val()+"&pwdII="+pass,function(e){
			tishi2close();
			layer.close(lcindex_);
			if(e!=""){
				//$("#x4-cos").html(unescape(e));
				if(unescape(e)=="转账成功"){
					layer.msg("转账成功,2秒后返回",{time: 2000, btn: ['确定'],end:function(){
							location.reload(); 
						}});
					}else{
						layer.alert(unescape(e));
					}
				}
			},'html');
			});
		}	
    </script>
    
<?php
require_once 'inc_footer.php';
?>