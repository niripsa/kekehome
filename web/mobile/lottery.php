<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';
//echo $memberLogged_userName . '|' . $memberLogged_passWord;exit;
if(!$memberLogged){
	redirect('/member/login.php');
}

$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>大转盘抽奖</title>
<meta name="viewport" content="width=320, maximum-scale=1, user-scalable=no">
<meta content="telephone=no" name="format-detection" />
<meta content="email=no" name="format-detection" />
<meta name="apple-touch-fullscreen" content="NO">
<link href="/images/lottery/wap_Lottery2.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="wrapper">
    <div id="container">
        <div id="main">
        	<div class="lotteryTitle"><?php echo $webInfo['h_webName']; ?>抽奖活动</div>
            <div class="lotteryTitle2">玩家:<?php echo $rs['h_userName'];?> KK:<span id="jinb"><?php echo $rs['h_point2'];?></span></div>
            <div id="lottery">
            	<div class="lotBg">
            		<div class="lotLight lotLight-animation2">
                    	<li class="lotLight1"><i></i></li>
                    	<li class="lotLight2"><i></i></li>
                    	<li class="lotLight3"><i></i></li>
                    	<li class="lotLight4"><i></i></li>
                    	<li class="lotLight5"><i></i></li>
                    	<li class="lotLight6"><i></i></li>
                    	<li class="lotLight7"><i></i></li>
                    	<li class="lotLight8"><i></i></li>
                    	<li class="lotLight9"><i></i></li>
                    	<li class="lotLight10"><i></i></li>
                    	<li class="lotLight11"><i></i></li>
                    	<li class="lotLight12"><i></i></li>
                    	<li class="lotLight13"><i></i></li>
                    	<li class="lotLight14"><i></i></li>
                    	<li class="lotLight15"><i></i></li>
                    	<li class="lotLight16"><i></i></li>
                    	<li class="lotLight17"><i></i></li>
                    	<li class="lotLight18"><i></i></li>
                    	<li class="lotLight19"><i></i></li>
                    	<li class="lotLight20"><i></i></li>
                    	<li class="lotLight21"><i></i></li>
                    	<li class="lotLight22"><i></i></li>
                    	<li class="lotLight23"><i></i></li>
                    	<li class="lotLight24"><i></i></li>
                    	<li class="lotLight25"><i></i></li>
                    	<li class="lotLight26"><i></i></li>
                    	<li class="lotLight27"><i></i></li>
                    	<li class="lotLight28"><i></i></li>
                    	<li class="lotLight29"><i></i></li>
                    	<li class="lotLight30"><i></i></li>
                    	<li class="lotLight31"><i></i></li>
                    	<li class="lotLight32"><i></i></li>
                    	<li class="lotLight33"><i></i></li>
                    	<li class="lotLight34"><i></i></li>
                    	<li class="lotLight35"><i></i></li>
                    	<li class="lotLight36"><i></i></li>
                    </div>
                    <div class="lotCon">
                    	<div class="prize prize1"><div class="prizebg"></div></div>
                    	<div class="prize prize2"><div class="prizebg"></div></div>
                    	<div class="prize prize3"><div class="prizebg"></div></div>
                    	<div class="prize prize4"><div class="prizebg"></div></div>
                    	<div class="prize prize5"><div class="prizebg"></div></div>
                    	<div class="prize prize6"><div class="prizebg"></div></div>
                    </div>
                    <div class="lotTxt">
                    	<p class="txt1"><span>iphone6 plus</span></p>
                    	<p class="txt2"><span>200KK</span></p>
                    	<p class="txt3"><span>50KK</span></p>
                    	<p class="txt4"><span>20KK</span></p>
                    	<p class="txt5"><span>8KK</span></p>
                    	<p class="txt6"><span>谢谢参与</span></p>
                    </div>
                    <div class="lotImg">
                    	<p class="img1"><img src="/images/lottery/1.png" /></p>
                    	<p class="img2"><img src="/images/lottery/2.png" /></p>
                    	<p class="img3"><img src="/images/lottery/3.png" /></p>
                    	<p class="img4"><img src="/images/lottery/4.png" /></p>
                    	<p class="img5"><img src="/images/lottery/5.png" /></p>
                    	<p class="img6"><img src="/images/lottery/6.png" /></p>
                    </div>
                    <div class="lotCenter">
                    	<i></i>
                        <a href="javascript:void(0)"><span>开始<br />抽奖</span></a>
                    </div>
                </div>
            </div>
            <!--这里填写说明-->
            <div class="shuomingb" style="display:none;">
                    	<p class="txtb1"><span>恭喜您抽中一等奖 iphone6 plus 手机一部,系统已自动填写订单,请到您的商城订单里查看</span></p>
                    	<p class="txtb2"><span>恭喜您抽中二等奖 200KK,系统已经转入您的账户中</span></p>
                    	<p class="txtb3"><span>恭喜您抽中三等奖 50KK,系统已经转入您的账户中</span></p>
                    	<p class="txtb4"><span>恭喜您抽中四等奖 20KK,系统已经转入您的账户中</span></p>
                    	<p class="txtb5"><span>恭喜您抽中五等奖 8KK,系统已经转入您的账户中</span></p>
                    	<p class="txtb6"><span>再接再厉,大奖等着你</span></p>
            </div>
<div class="lotterynum" style="line-height:20px;" id="chongjianglist">     

</div>  
<div class="lotterynum" style="line-height:20px;">     
 活动说明：<br>
（1）每次抽奖消耗10KK<br>
（2）抽中KK的,系统会自动把KK汇入您的账户<br>
（3）抽中实物的,系统会自动下单,请在抽奖前在个人资料里完善您的物流信息!<br>
（4）本活动解释权归公司所有<br></div> 

      </div>
    </div>
</div>
<section style="display: none;" class="fullHtml loadingBox" id="loadingBox"><i></i><span>加载中...</span></section>
<script type="text/javascript" src="/images/lottery/jquery-2.1.1.min.js"></script>
<script src="/ui/layer/layer.js"></script>
<script>


var cj=true;

function getzjlist(){
	//choujianglist
	$.get("/member/bin.php?act=lottery_win_list&t="+Math.random().toString(),function(e){
		$('#chongjianglist').html(unescape(e))
		},'html')
	}

function zhuanpan(cid){
		var Pnum=$(".prize").length;
		var classid=cid;
		if(Pnum<classid){alert("奖品不存在")}
		$(".lotCenter").addClass("lotCenter-animation"+Pnum+"-"+classid);
		$(".lotLight").removeClass("lotLight-animation2").addClass("lotLight-animation1");
		setTimeout(function(){
			layer.msg($(".shuomingb .txtb"+cid).html(),{time:0,btn: ['确定'],end:function(){
				$(".lotCenter").removeClass("lotCenter-animation"+Pnum+"-"+classid);
				$(".lotLight").removeClass("lotLight-animation1").addClass("lotLight-animation2");
				cj=true;
				}});
			},6000);
	}

function cjgo(a,b){
	//if(b==0 && a==0){
	if(b<=0){
		$('#jinb').html(a);
		layer.msg("您的余额不足");
		return false;
	}
		
	$('#jinb').html(a);
	zhuanpan(b);	
}

$(document).ready(function(e){
	getzjlist();
	setInterval('getzjlist()',30000);
	$(".lotCenter").click(function(){
	if(cj){
			cj=false;
			var url="/member/bin.php?act=lottery_click&t="+Math.random().toString();
			$.ajax({ type : "get", async:true,  url : url, dataType : "jsonp"});
		}
	});

	var Pnum=$(".prize").length;
	var deg=360/Pnum;
	for(var i=1;i<=Pnum;i++){
		var numdeg=deg*i-deg;
		if(Pnum==6){var pdeg1=i*deg+deg;};
		if(Pnum==5){
			var pdeg1=i*deg+54;
			$(".prize1 .prizebg").css("background","#fcb600");
			$(".prize2 .prizebg").css("background","#f28501");
			$(".prize3 .prizebg").css("background","#f9a700");
			$(".prize4 .prizebg").css("background","#f69601");
			$(".prize5 .prizebg").css("background","#fec000");
		};
		if(Pnum==4){var pdeg1=i*deg+45;};
		if(Pnum==3){
			var pdeg1=i*deg+deg+30;
			$(".prize1 .prizebg").css("background","#fcb600");
			$(".prize2 .prizebg").css("background","#f28501");
			$(".prize3 .prizebg").css("background","#f9a700");		
		};
		if(Pnum==2){var pdeg1=i*deg+deg;};
		var pdeg2=90-deg;
		$(".img"+i).css("transform","rotate("+numdeg+"deg)");
		$(".txt"+i).css("transform","rotate("+numdeg+"deg)");
		$(".prize"+i).css("transform","rotate("+pdeg1+"deg)");
		$(".prizebg").css("transform","rotate("+pdeg2+"deg)");
	}
	//页面大小
	initialise();
}); 

$(window).resize(function(e) {
	initialise();
});

function initialise(){
	var windowwidth=$(window).width();
	if(windowwidth>640){windowwidth=640;}
	var scale=windowwidth/320;
	$("#main").css("padding-top",scale*40);
	$(".lotterynum").css({"margin-left":scale*30,"margin-right":scale*30});
}

</script>
</body>
</html>
</div>