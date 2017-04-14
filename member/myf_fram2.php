<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
$pageTitle = '我的庄园 - ';
require_once 'inc_header.php';
$myfuserName = $_GET['username'];
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>庄园管理 <small> 我的庄园</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">庄园管理</a></li>
  <li class="active">我的庄园</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">我的庄园</div>

   <div class="panel-body">
<!--====================-->


<div class="row">

<frame>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script language="javascript" src="/js/jquery-1.8.2.min.js"></script> 
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="javascript" >
var imgsrc="imsges";
var imgt=".png";
</script>
<script language="javascript" src="/js/jss.js"></script>
 
<!--[if IE 6]>
 <script language="javascript" >
 window.location.href="ie6.asp";
 </script>
<![endif]-->
</head>
<body id="body" >
 <?php

$query = "select * from h_member where h_userName = '{$myfuserName}'";
$result = $db->query($query);
$list = $db->fetch_array($result);
$dog = $list['dog'];
$bogy = $list['bogy'];

/*总生长*/
$query = "select sum(h_price) as total from h_log_point2 where h_userName = '{$myfuserName}' and h_type_id=4";
$rs = $db->get_one($query);
if($rs){
	$growth_total = $rs['total'];
}else{
	$growth_total = 0;
}


 list_1();
function list_1(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $myfuserName,$userfullname,$rs,$rs1;
	global $rs2,$rs3,$rs4,$rs5,$money_now,$land1,$land2,$add,$harvest1,$harvest2,$farm_money,$land_now;
	
	$money_now = 0;
	$land_now = 0;
	$query = "select * from h_member where h_userName = '{$myfuserName}'";
	$result = $db->query($query);
	$list = $db->fetch_array($result);
	$userfullname = $list['h_fullName'];
	
	$sql = "select *";
    $sql .= ",(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers";
    $sql .= ",(select sum(h_price) from `h_log_point2` where h_userName = a.h_userName and h_price > 0) as point2sum";
    $sql .= " from `h_member` a where h_userName = '{$myfuserName}' LIMIT 1";
    $rs = $db->get_one($sql);
	
	/*$rs1 = $db->get_one("select sum(h_price) as sumP from `h_log_point2` where h_userName = '{$myfuserName}' and h_type = '宠物产币'");
	if(strlen($rs1['sumP']) <= 0){
		$rs1['sumP'] = 0;
	}*/
	
	/*$rs3 = $db->get_one("select sum(h_price) as sumP from `h_log_point2` where h_userName = '{$myfuserName}' and h_type = '购买宠物'");
	if(strlen($rs3['sumP']) <= 0){
		$rs3['sumP'] = 0;
	}*/
	
	$query = "select * from `h_member_farm` where h_userName = '{$myfuserName}' and h_isEnd = 0";
	$result = $db->query($query);
	
	while($list = $db->fetch_array($result))
	{
		$rs3[]=$list;
	}
	if(count($rs3) > 0)
	{
		foreach ($rs3 as $key=>$val)
		{
		  if($val['h_pid'] == "112")
		  {
			$h_harvest = explode(",",$val['h_harvest']);
			
			  for($a = 0; $a < count($h_harvest); $a++)
			  {
			    $land_now = $land_now + intval($h_harvest[$a]);
			  }
		  }
		  else
		  {
			$h_harvest = explode(",",$val['h_harvest']);
			  
		    for($a = 0; $a < count($h_harvest); $a++)
			{
			  $land_now = $land_now + intval($h_harvest[$a]);
			}
		  }
		}
	}
	
	/*$rs4 = $db->get_one("select sum(h_price) as sumP from `h_log_point2` where h_userName = '{$myfuserName}' and h_type = '种植KK'");
	
	$rs5 = $db->get_one("select sum(h_price) as sumP from `h_log_point2` where h_userName = '{$myfuserName}' and h_type = '收获产币'");
	if(strlen($rs5['sumP']) <= 0){
		$rs5['sumP'] = 0;
	}*/
	
	$farm_money = $land_now;
	
	$land1;
	$land2;
	$time1;
	$time2;
	$harvest1;
	$harvest2;
	$query = "select * from `h_member_farm` where h_userName = '{$myfuserName}' and h_isEnd = 0";
	$result = $db->query($query);

	while($list = $db->fetch_array($result))
	{
		$rs2[]=$list;
	}
	if(count($rs2) > 0)
	{
		foreach ($rs2 as $key=>$val)
		{		  
		  if($val['h_pid'] == '112')
		  {
		    $land1 = explode(",",$val['h_land']);
			$harvest1 = explode(",",$val['h_harvest']);
			$time1 = explode("|",$val['h_h_time']);
			
			for($a = 0; $a < count($land1); $a++)
			{
			  if($land1[$a] == "1")
			  {
			    $zero1=strtotime(date("y-m-d h:i:s")); //当前时间
		        $zero2=strtotime($time1[$a]);
		        $days=floor(($zero1 - $zero2)/86400);
			    $money_now = floor($money_now + $val['h_point2Day'] * $days * ($harvest1[$a] / 300));
			  }
			}
		  }
		  else
		  {
		    $land2 = explode(",",$val['h_land']);
			$harvest2 = explode(",",$val['h_harvest']);
			$time2 = explode("|",$val['h_h_time']);

			for($a = 0; $a < count($land2); $a++)
			{
			  if($land2[$a] == "1")
			  {
			    $zero1=strtotime(date("y-m-d h:i:s")); //当前时间
		        $zero2=strtotime($time2[$a]);
		        $days=floor(($zero1 - $zero2)/86400);
				
			   $money_now = floor($money_now + $val['h_point2Day'] * $days * ($harvest2[$a] / 3000));
			    /*echo "<br>";*/
			  }
			}
		  }
		}
    }
	
	
}
 ?>
 <div id="load" style=" position:absolute; z-index:400; top:300px; width:800px; text-align:center;"><img  src="imsges/load.gif" /></div>

<div class="bg">
  
    <?php  if($dog>=1){  ?>
	  <div id="gou1"><img src="imsges/dog.png" border="0" /></div>
	<?php } ?>
	<?php if($dog>=2){  ?>
	  <div id="gou2"><img src="imsges/dog.png" border="0" /></div>
	<?php } ?>
	  
	<?php  if($bogy>=1){  ?>
	   <div id="daocaoren"><img src="imsges/dcr2.png" border="0" /></div>
	<?php } ?>
	<?php if($bogy>=2){  ?>
	   <div id="daocaoren2"><img src="imsges/dcr1.png" border="0" /></div>
	<?php } ?>
	<?php if($bogy>=3){  ?>
	   <div id="daocaoren3"><img src="imsges/dcr3.png" border="0" /></div>
	<?php } ?>
	<?php if($bogy>=4){  ?>
	   <div id="daocaoren4"><img src="imsges/dcr4.png" border="0" /></div>
	<?php } ?>



  <div class="didiv">
    <ul class="diul">
      <?php
      /*echo "<pre>";
      print_r($land1);
      print_r($land2);
      exit;*/

	  if($land1[0] == 1)
	  {
	  ?>
      <li class="di" id="di1" style="top:15px; left:295px;  background:url(imsges/dibg01.png) top left no-repeat;">
	    <img src='imsges/shu1.png' />

		<div class='diinfo'><?php echo $harvest1[0] ?>枚</div>
		<div class="zeng" style="display:none"></div>
      </li>
	  <?php
	  }
	  else
	  {
	  ?>
	  <li class="di" id="di1" style="top:15px; left:295px;  background:url(imsges/dibg00.png) top left no-repeat;">
		<div class="zeng" style="display:none"></div>
      </li>
	  <?php
	  }
	  if($land1[1] == 1)
	  {
	  ?>
      <li class="di" id="di2" style="top:49px; left:380px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	  
		<div class='diinfo'><?php echo $harvest1[1] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  else
	  {
	  ?>
	  <li class="di" id="di2" style="top:49px; left:380px;  background:url(imsges/dibg00.png) top left no-repeat;">
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  if($land1[2] == 1)
	  {
	  ?>
	  <li class="di" id="di3" style="top:83px; left:465px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	  
		<div class='diinfo'><?php echo $harvest1[2] ?>枚</div>
	    <div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di3" style="top:83px; left:465px;  background:url(imsges/dibg00.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land1[3] == 1)
	  {
	  ?>
	  <li class="di" id="di4" style="top:117px; left:550px;  background:url(imsges/dibg01.png) top left no-repeat;">
	    

	    <img src='imsges/shu1.png' />
	    <div class='diinfo'><?php echo $harvest1[3] ?>枚</div>
	    <div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di4" style="top:117px; left:550px;  background:url(imsges/dibg00.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land1[4] == 1)
	  {
	  ?>
	  <li class="di" id="di5" style="top:151px; left:635px;  background:url(imsges/dibg01.png) top left no-repeat;">
	    <div class='diinfo'><?php echo $harvest1[4] ?>枚</div>

	    <img src='imsges/shu1.png' />
	  
	    <div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di5" style="top:151px; left:635px;  background:url(imsges/dibg00.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
	  <!-- 第18 -->
	  <?php
	  }
	  if($land1[5] == 1)
	  {
	  ?>
	  <li class="di" id="di6" style="top:185px; left:720px;  background:url(imsges/dibg01.png) top left no-repeat;">
	    <div class='diinfo'><?php echo $harvest1[4] ?>枚</div>

	    <img src='imsges/shu1.png' />
	  
		<div class='diinfo'><?php echo $harvest1[5] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di6" style="top:185px; left:720px;   background:url(imsges/dibg00.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land1[6] == 1)
	  {
	  ?>
      <li class="di" id="di7" style="top:59px; left:195px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	  
		<div class='diinfo'><?php echo $harvest1[6] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
	  <li class="di" id="di7" style="top:59px; left:195px;  background:url(imsges/dibg00.png) top left no-repeat;">
		<div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land1[7] == 1)
	  {
	  ?>
      <li class="di" id="di8" style="top:93px; left:280px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	 
		<div class='diinfo'><?php echo $harvest1[7] ?>枚</div>
		<div class="zeng" style="display:none"></div>
      </li>
	  <?php
	  }
	  else
	  {
	  ?>
	  <li class="di" id="di8" style="top:93px; left:280px;  background:url(imsges/dibg00.png) top left no-repeat;">
		<div class="zeng" style="display:none"></div>
      </li>
      <?php
	  }
	  if($land1[8] == 1)
	  {
	  ?>
      <li class="di" id="di9" style="top:127px; left:365px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	 
		<div class='diinfo'><?php echo $harvest1[8] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
	  <li class="di" id="di9" style="top:127px; left:365px;  background:url(imsges/dibg00.png) top left no-repeat;">
		<div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land1[9] == 1)
	  {
	  ?>
	  <li class="di" id="di10" style="top:161px; left:450px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	 
		<div class='diinfo'><?php echo $harvest1[9] ?>枚</div>
	    <div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di10" style="top:161px; left:450px;  background:url(imsges/dibg00.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
	  <!-- 第十块 -->
      <?php
	  }
	  if($land1[10] == 1)
	  {
	  ?>
	  <li class="di" id="di11" style="top:195px; left:535px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	  
		<div class='diinfo'><?php echo $harvest1[10] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di11" style="top:195px; left:535px;  background:url(imsges/dibg00.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
	  <!-- 第十yi块 -->
      <?php
	  }
	  if($land1[11] == 1)
	  {
	  ?>
	  <li class="di" id="di12" style="top:229px; left:620px;  background:url(imsges/dibg01.png) top left no-repeat;">

	    <img src='imsges/shu1.png' />
	 
		<div class='diinfo'><?php echo $harvest1[11] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di12" style="top:229px; left:620px;  background:url(imsges/dibg00.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>

      <?php
	  }
	  if($land2[0] == 1)
	  {
	  ?>
	  <li class="di" id="di13" style="top:103px; left:95px;  background:url(imsges/dibg11.png) top left no-repeat;">

	    <img src='imsges/shu5.png' />
	  
		<div class='diinfo'><?php echo $harvest2[0] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di13" style="top:103px; left:95px;  background:url(imsges/dibg10.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land2[1] == 1)
	  {
	  ?>
	  <li class="di" id="di14" style="top:137px; left:180px;  background:url(imsges/dibg11.png) top left no-repeat;">

	    <img src='imsges/shu5.png' />
	 
		<div class='diinfo'><?php echo $harvest2[1] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di14" style="top:137px; left:180px;  background:url(imsges/dibg10.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land2[2] == 1)
	  {
	  ?>
	  <li class="di" id="di15" style="top:171px; left:265px;  background:url(imsges/dibg11.png) top left no-repeat;">

	    <img src='imsges/shu5.png' />
	 
		<div class='diinfo'><?php echo $harvest2[2] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di15" style="top:171px; left:265px;  background:url(imsges/dibg10.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land2[3] == 1)
	  {
	  ?>
	  <li class="di" id="di16" style="top:205px; left:350px;  background:url(imsges/dibg11.png) top left no-repeat;">

	    <img src='imsges/shu5.png' />
	 
		<div class='diinfo'><?php echo $harvest2[3] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di16" style="top:205px; left:350px;  background:url(imsges/dibg10.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  if($land2[4] == 1)
	  {
	  ?>
	  <li class="di" id="di17" style="top:239px; left:435px;  background:url(imsges/dibg11.png) top left no-repeat;">

	    <img src='imsges/shu5.png' />
	  
		<div class='diinfo'><?php echo $harvest2[4] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di17" style="top:239px; left:435px;  background:url(imsges/dibg10.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  ?>
	  <!-- 第十六块 -->

	  <?php
	  if($land2[5] == 1)
	  {
	  ?>
	  <li class="di" id="di18" style="top:273px; left:520px;  background:url(imsges/dibg11.png) top left no-repeat;">

	    <img src='imsges/shu5.png' />
	 
		<div class='diinfo'><?php echo $harvest2[5] ?>枚</div>
		<div class="zeng" style="display:none"></div>
	  </li>
	  <?php
	  }
	  else
	  {
	  ?>
      <li class="di" id="di18" style="top:273px; left:520px; background:url(imsges/dibg10.png) top left no-repeat;">
	    <div class="zeng" style="display:none"></div>
	  </li>
      <?php
	  }
	  ?>

    </ul>
  </div>
  
  <div class="info">&nbsp;&nbsp;<span id="unumber">用户：<?=$memberLogged_userName?></span>&nbsp;&nbsp;&nbsp;&nbsp;总量：<span class="red" id="zong"><?php echo ($rs['h_point2']+$farm_money);?></span>&nbsp;&nbsp;仓库：<span class="red" id="stock"><?php echo $rs['h_point2'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;播种：<span class="red" id="zmei"><?php echo $farm_money?></span>&nbsp;&nbsp;肥料：<span class="red" id="fei"><?php echo $money_now;?></span>&nbsp;&nbsp;花仙子：<span class="red" id="dog"><?php echo $dog;?></span>&nbsp;&nbsp;丘比特：<span class="red" id="bogy"><?php echo $bogy;?></span>&nbsp;&nbsp;总生长：<span class="red" id="growth_total"><?php echo $growth_total;?></span></div>
  
  <div class="tooldiv">
    <div id="kaiico"><img src="imsges/kaiico2.png" alt="开垦新地" /></div>
	<div id="jiaico"><img src="imsges/jiaico2.png"  alt="增加播种" /></div>
    <div id="hfico"><img src="imsges/hfico2.png"    alt="撒施化肥"  /></div>
    <div id="caiico"><img src="imsges/caiico2.png"  alt="采摘KK" /></div>
    <div id="caiico"><img src="imsges/mf1.png" onClick="mico('caimi')" alt="采蜜" /></div>
	<div id="sxico"><img src="imsges/shuaxin.png" onClick="location.reload();" alt="刷新" /></div>
	<input id="money_now" value="<?php echo $rs['h_point2'];?>" style="display:none;" />
  </div>
  <div id="shuom"><a href="my_farm_info.php"><img src="imsges/sm.png" border="0" /></a></div>
  <div id="shifei" style="display:none"><img style="width:0px;" src="imsges/huafei.png" /></div>
</div>
<div class="clear"></div>
<div class="gaidiv" style="display:none"></div>
<div  id="aform"  style="display:none"> <div id="closes">取消</div> 请输入播种KK的数量<br />
    <input name="dousum" type="text" id="dousum" size="12" maxlength="20" />&nbsp;<button id="adbtn">播种</button> <br />
	最大输入<span class="red" id="max_add">0</span>枚</div>

<div id="shuidiv" style="display:none" ><img src="imsges/gongxi.gif" /><br />恭喜您浇水获得奖励<span id="jshui" class="red">9.73</span>枚KK</div>

<div style=" position:absolute; z-index:400; top:550px; width:800px; text-align: right; display:none;"><a href="ie6.asp?unumber=">如果游戏显示不正常请点击这里转到兼容模式</a></div>

<!--<div id="shop" ><a href="/SHOP"  target="_blank"><img src="imsges/shop.gif" border="0" /></a></div>-->
 
</body>
</html>﻿
</frame>
</div>


<!--====================-->

  </div>


    
  
</div>
</div>
<!--MAN End-->
</div></div>

    <script>
	$(function(){
		mgo(22);
	});
    </script>

