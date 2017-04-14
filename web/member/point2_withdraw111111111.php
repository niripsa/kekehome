<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '申请提现 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>交易系统 <small> 申请提现</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">账户管理</a></li>
  <li class="active">申请提现</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">申请提现</div>
   

  <div class="panel-body">
  <p>注:提现将收取<?php echo $webInfo['h_withdrawFee'] * 100; ?>%手续费</p>
  
<?php
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>
   
   <!--主-->
   <form class="form-horizontal">

  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">您的金币余额</label>
    <div class="col-sm-10">
      <input disabled="disabled" class="form-control form-long-w1" id="x1" placeholder="您的金币余额" value="<?php echo $rs['h_point2'];?>">
    </div>
  </div> 

  <div class="form-group">
    <label for="x2" class="col-sm-2 control-label">提现金额</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x2" placeholder="提现金额" value="" maxlength="10">
    </div>
  </div>
  
  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">支付宝账号</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x3" placeholder="收款的支付宝账号" value="<?php echo $rs['h_alipayUserName'];?>">
    </div>
  </div>
  
   <div class="form-group">
    <label for="x4" class="col-sm-2 control-label">支付宝姓名</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x4" placeholder="收款的支付宝账号姓名" value="<?php echo $rs['h_alipayFullName'];?>">
    </div>
  </div>
  <!--
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label><input type="checkbox" checked="checked" id="x5"> 设置该支付宝账号为默认收款账号</label>
      </div>
    </div>
  </div>  
  -->
  
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10" id="x4-cos"></div>
  </div> 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning goumai_go">申请提现</button>
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
	mgo(43);
	var zhituis=<?php echo $rs['comMembers'];?>;
	$(".goumai_go").click(function () {
			goumai_go();
			//layer.msg("本功能12月10号开发,尽请期待!");
			return false;
		});	
	function goumai_go(){
		if(zhituis < <?php echo $webInfo['h_withdrawMinCom']; ?>){
			//alert(zhituis);
			tishi4("您的账号至少要直推<?php echo $webInfo['h_withdrawMinCom']; ?>个人才能提现",'#x1');
			return false;
			}
		if($("#x2").val()==""){
			tishi4("请输入填写提现金额",'#x2');
			return false;
			}

		if(!checkNum($("#x2").val()) || $("#x2").val()<<?php echo $webInfo['h_withdrawMinMoney']; ?>){
			tishi4("提现金额<?php echo $webInfo['h_withdrawMinMoney']; ?>元起,请输入<?php echo $webInfo['h_withdrawMinMoney']; ?>以上的整数",'#x2');
			return false;
			}
		
		if($("#x3").val()==""){
			tishi4("请输入您收款用的支付宝账号",'#x3');
			return false;
			}
		if($("#x4").val()==""){
			tishi4("请输入您收款用的支付宝账号姓名",'#x4');
			return false;
			}		
		
		layer.msg("共计提现"+$("#x2").val()+"元,确认无误请点击申请提现",{time: 20000, btn: ['确定提现', '我点错了'],btn1: function(){goumai_go2()}});

		}
	function goumai_go2(){
		tishi2();
		//+"&x4="+encodeURI($("#x5").prop('checked'))
		$.get("/member/bin.php?act=point2_withdraw&num="+encodeURI($("#x2").val())+"&alipayUserName="+encodeURI($("#x3").val())+"&alipayFullName="+encodeURI($("#x4").val()),function(e){
			tishi2close();
			if(e!=""){
				$("#x4-cos").html(unescape(e));
				if($("#x4-cos").text().substr(0,6)=="申请提现成功"){
					layer.msg("申请提现成功",{end:function(){location.reload();}});
					}
				}	
			},'html'
			);
		}	
		
	
    </script>
    
<?php
require_once 'inc_footer.php';
?>