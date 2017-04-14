<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = 'KK拍卖';

require_once 'inc_header.php';
require_once 't.php';
?>
<style>
body{
	font-size:14px
}
</style>
<strong><span style="color:#F00">警告:</span></strong><br>
<span style="color:#F00">如果不购买，请勿抢购，否则会扣除您相应的KK作为惩罚！</span><br>
<strong>注意:</strong><br>
为了减少服务器资源,只显示前3名挂单的,没显示的后面依次排队挂单。抢购成功后平台将向卖家收取<font color="red">20%</font>的<font color="red">手续费</font>！<br>
挂单前请先完善您的支付宝信息!<br>
 <button type="submit"  value="我要挂单"  class="friend-new-sub guadan_go">我要挂单</button>
<br />
拍卖流程：<br />
1、<span style="color:#ff0000">卖家</span>挂单拍卖KK（点击“我要挂单”，填写收款支付宝信息和拍卖多少KK）；<br />
2、<span style="color:#0000ff">买家</span>抢购KK（点击“我要抢购”）；<br />
3、<span style="color:#0000ff">买家</span>打款给卖家（30分钟内未付款 则视为恶意交易，系统将扣除买家的违约金）；<br />
4、<span style="color:#0000ff">买家</span>确认已打款（手工付款后，点击“我已付款”）；<br />
5、<span style="color:#ff0000">卖家</span>确认已收款（点击“确认收款”，KK由系统自动确认给买家，同时平台扣取20%KK拍卖手续费用。卖家超过12小时不确认收款，公司将没收卖家本次交易KK）
</div>
<div id="xinxi">

</div>



</div>
</div>
<!--MAN End-->
</div></div>

<?php
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>

<div class="shouhuodizhi" id="shouhuodizhi" style="display:none;">
<div style="padding:20px 50px;">
<form class="form-horizontal">
   <div class="form-group">
    <label class="col-sm-3 control-label" for="x1">可挂KK:</label>
    <div class="col-sm-9"><input class="form-control" id="x1" placeholder="您的KK余额" value="<?php echo $rs['h_point2'];?>" disabled='disabled'></div> 
  </div>
    <div class="form-group">
    <label class="col-sm-3 control-label" for="x2">收款支付宝账号:</label>
    <div class="col-sm-9"><input class="form-control" id="x2" placeholder="请填写您的支付宝账号" value="<?php echo $rs['h_alipayUserName'];?>"></div> 
  </div>
    <div class="form-group">
    <label class="col-sm-3 control-label" for="x3">收款支付宝姓名:</label>
    <div class="col-sm-9"><input class="form-control" id="x3" placeholder="请填写您支付宝对应姓名" value="<?php echo $rs['h_alipayFullName'];?>"></div> 
  </div>
 <div class="form-group">
    <label class="col-sm-3 control-label" for="x5">微信号码:</label>
    <div class="col-sm-9"><input class="form-control" id="x5" placeholder="请输入您的微信号码,方便联系" value="<?php echo $rs['h_weixin'];?>"></div> 
  </div>
 <div class="form-group">
    <label class="col-sm-3 control-label" for="x6">手机号码:</label>
    <div class="col-sm-9"><input class="form-control" id="x6" placeholder="请输入您的手机号码,方便联系" value="<?php echo $rs['h_addrTel'];?>"></div> 
  </div>  
    <div class="form-group">
    <label class="col-sm-3 control-label" for="x4">挂单金额:</label>
    <div class="col-sm-9"><input class="form-control" id="x4" placeholder="您准备卖出多少KK"></div> 
  </div>   

  <div class="form-group"></div>
   <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-primary btn-block" onClick="guajinbi(this);return false;">马上挂售</button>
    </div>
  </div> 
</form>
</div>
</div>

 <script>
	mgo(41);
	var indexdd;
	
	$(".guadan_go").click(function(e) {
		
<?php
if(strlen($rs['h_alipayUserName']) <= 0 || strlen($rs['h_alipayFullName']) <= 0){
    echo 'layer.alert("请先修改您的支付宝信息，如果有玩家购买，会把人民币打入您的支付宝账号",function(){window.location.href="/mobile/pi.php";});';
    echo 'return false;';
}
?>


if(browserWidth<800){
    indexdd=layer.open({type: 1,title:'KK挂单',skin: 'layui-layer-rim',content: $("#shouhuodizhi").html()});
}else{
	indexdd=layer.open({type: 1,title:'KK挂单',area: '750px',skin: 'layui-layer-rim',content: $("#shouhuodizhi").html()});
}

	
	
	
    });
	
function guajinbi(t){
	var top=$(t).parent().parent().parent();
	var x1=top.find("#x1").val();
	var x2=top.find("#x2").val();
	var x3=top.find("#x3").val();
	var x4=top.find("#x4").val();
	var x5=top.find("#x5").val();
	var x6=top.find("#x6").val();


	if (x2==''){
			tishi4('请填写您的收款支付宝',top.find("#x2"))
			return false;
		}

	if (x3==''){
			tishi4('请填写您的收款支付宝姓名',top.find("#x3"))
			return false;
		}
		
	if (x5==''){
			tishi4('请填写您的微信号码,方便互相联系',top.find("#x5"))
			return false;
		}
		
	if (x6!=''){
		if(!checkMobile(x6)){
				tishi4('请填写正确的手机号码',top.find("#x6"))
				return false;
			}
		}

	if (x4==''){
			tishi4('请填写要挂多少KK',top.find("#x4"))
			return false;
		}
	if (!checkNum(x4) || parseFloat(x4)<10){
			tishi4('至少挂10KK,而且是整数',top.find("#x4"))
			return false;
		}
	if (parseFloat(x4)>parseFloat(x1)){
			tishi4('您的余额不足',top.find("#x4"))
			return false;
		}
	
		
	tishi2();		
	$.get("/mobile/bin.php?act=point2_sell_post&num="+encodeURI(x4)+"&alipayUserName="+encodeURI(x2)+"&alipayFullName="+encodeURI(x3)+"&weixin="+encodeURI(x5)+"&mobile="+encodeURI(x6),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='挂单成功'){
						layer.close(indexdd);
						layer.msg('挂单成功,3秒后跳转到卖出记录',function(){window.location.href="/mobile/point2_sell_log.php";});
					}else{
						layer.msg(unescape(e))
					}
				
				}
			},'html');		
		
		

	}
	function jinbi_qianggou(rid){
	layer.msg("确认要拍下这单吗?如果拍下后不付款,系统会对您相应的处罚",{time: 20000, btn: ['确定拍下', '我点错了'],btn1: function(){	
		tishi2();
		$.get("/mobile/bin.php?act=point2_buy&id="+encodeURI(rid),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='抢购成功'){
					layer.close(indexdd);
					layer.msg('抢购成功,3秒后跳转到购买记录',function(){window.location.href="/mobile/point2_buy_log.php";});
					}else{
					layer.msg(unescape(e))
					}
				
				}
			},'html');
		}});	
		}
$(document).ready(function(e){
	getgdlist();
	setInterval('getgdlist()',10000);
});

function getgdlist(){
	//choujianglist
	$.get("/mobile/bin.php?act=point2_sell_list&t="+Math.random().toString(),function(e){
		$('#xinxi').html(e)
		},'html')
	}
   </script>
    
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>