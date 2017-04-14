<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';

$farmid = "";
$land_money = "";
$land_money_now = 0;
$pid = "";
$harvest = "";
$h_harvest;
$harvest_time = "";
$rstr = "ok";
$farmid = $_POST["kid"];
$admun = $_POST["addou"];
$money_now = $_POST["now"];
$land = "";
$land_str = "";
$num = 0;
$num_now = 0;
$time;
$time_str;
$rs2;
global $memberLogged_userName;

if($admun < 0 || $admun == null)
{
  echo("请输入正确的数量！");exit;
}

if($admun > $money_now)
{
  echo("您没有这么多KK了！快去充值吧~~！");exit;
}

if($_POST["adtype"] == "ad")
{
	$query = "select * from `h_member_farm` where h_userName = '{$memberLogged_userName}' and h_isEnd = 0";
	$result = $db->query($query);
	
	while($list = $db->fetch_array($result))
	{
		$rs2[]=$list;
	}
	if(count($rs2) > 0)
	{
		foreach ($rs2 as $key=>$val)
		{
		  if($val['h_pid'] == "112")
		  {
			if(intval($farmid) < 11)
			{
			  $h_harvest = explode(",",$val['h_harvest']);
			  $land_money = $h_harvest[intval($farmid)-1];
			  $pid = "112";
			  
			}
		  }
		  else
		  {
			if(intval($farmid) == 11 || intval($farmid) > 11)
			{
			  $h_harvest = explode(",",$val['h_harvest']);
			  $land_money = $h_harvest[intval($farmid)-11];
			  $pid = "113";
			  
			}
		  }
		}
	}
	else
	{
	  $rstr = "wrong";
	}
	
	$land_money_now = $land_money + $admun;
	
	if(intval($farmid) < 11)
	{
	  if($land_money_now > 3000)
	  { 
	    echo("您种植的数量超出了最大限度！");exit;
	  }
	  $h_harvest[intval($farmid)-1] = $land_money_now;
	}
	else
	{
	  if($land_money_now > 30000)
	  { 
	    echo("您种植的数量超出了最大限度！");exit;
	  }
	  $h_harvest[intval($farmid)-11] = $land_money_now;
	}
	
	for($i = 0; $i < count($h_harvest); $i++)
	{
	  if($i == 0)
	  {
		$harvest = $h_harvest[$i];
	  }
	  else
	  {
		$harvest = $harvest. "," .$h_harvest[$i];
	  }
	}
	
	
	$query = "update `h_member_farm` set h_harvest = '". $harvest ."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";
	$db->query($query);
	
	$query = "update `h_member` set h_point2 = h_point2 - ". $admun ." where h_userName = '{$memberLogged_userName}'";
	$db->query($query);
	
	$query = "insert into `h_log_point2` set h_userName = '{$memberLogged_userName}' , h_price = -". $admun .", h_about = '庄园种植". $admun ."KK', h_addTime = now(), h_actIP = '". getUserIP() ."' , h_type = '种植KK'";
	$db->query($query);
  
  echo("result:".$rstr."-". $land_money_now);
}
elseif($_POST["adtype"] == "new")
{
    $query = "select * from `h_member_farm` where h_userName = '{$memberLogged_userName}' and h_isEnd = 0";
	$result = $db->query($query);
	
	while($list = $db->fetch_array($result))
	{
		$rs2[]=$list;
	}
	if(count($rs2) > 0)
	{
		foreach ($rs2 as $key=>$val)
		{
		  if($val['h_pid'] == "112")
		  {
			if(intval($farmid) < 11)
			{
			  $h_harvest = explode(",",$val['h_harvest']);
			  $land_money = $h_harvest[intval($farmid)-1];
			  $land = explode(",",$val['h_land']);
			  $time = explode("|",$val['h_h_time']);
			  $time[intval($farmid)-1] = date('Y-m-d')." 00:00:00";
			  
			  $pid = "112";
			  $num = intval($val['h_num']);
			  $i = 0;
			  for($a = 0; $a < count($land); $a++)
			  {
			    if($land[$a] == "1")
			    {
			      $i++;
			    }
			  }
			  $num_now = $i;
			}
		  }
		  else
		  {
			if(intval($farmid) == 11 || intval($farmid) > 11)
			{
			  $h_harvest = explode(",",$val['h_harvest']);
			  $land_money = $h_harvest[intval($farmid)-11];
			  $land =  explode(",",$val['h_land']);
			  $time = explode("|",$val['h_h_time']);
			  $time[intval($farmid)-11] = date('Y-m-d')." 00:00:00";
			  
			  $pid = "113";
			  $num = intval($val['h_num']);
			  $i = 0;
			  for($a = 0; $a < count($land); $a++)
			  {
			    if($land[$a] == "1")
			    {
			      $i++;
			    }
			  }
			  $num_now = $i;
			}
		  }
		}
	}
	else
	{
	  $rstr = "wrong";
	}
	
	if(intval($farmid) < 11)
	{
	  $land_money_now = 300 + $admun;
	  if($land_money_now > 3000)
	  { 
	    echo("您种植的数量超出了最大限度！");exit;
	  }
	  $h_harvest[intval($farmid)-1] = $land_money_now;
	  $land[intval($farmid)-1] = "1";
	}
	else
	{
	  $land_money_now = 3000 + $admun;
	  if($land_money_now > 30000)
	  { 
	    echo("您种植的数量超出了最大限度！");exit;
	  }
	  $h_harvest[intval($farmid)-11] = $land_money_now;
	  $land[intval($farmid)-11] = "1";
	}
	
	if($num - $num_now > 0)
	{
	  
	}
	else
	{
	  echo("您的种子不够，快到可可商店进行购买吧！");exit;
	}
	
	for($i = 0; $i < count($h_harvest); $i++)
	{
	  if($i == 0)
	  {
		$harvest = $h_harvest[$i];
		$land_str = $land[$i];
		$time_str = $time[$i];
	  }
	  else
	  {
		$harvest = $harvest. "," . $h_harvest[$i];
		$land_str = $land_str . "," . $land[$i];
		$time_str = $time_str . "|" . $time[$i];
	  }
    }
	
	$query = "update `h_member_farm` set h_land = '". $land_str ."',h_harvest = '". $harvest ."',h_h_time = '". $time_str ."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";
	$db->query($query);
	
	$query = "update `h_member` set h_point2 = h_point2 - ". $admun ." where h_userName = '{$memberLogged_userName}'";
	$result = $db->query($query);
	if($result){
		detail($UserName,$title,$about,$bonus,);
	}
	
	$query = "insert into `h_log_point2` set h_userName = '{$memberLogged_userName}' , h_price = -". $admun .", h_about = '庄园种植". $admun ."KK', h_addTime = now(), h_actIP = '". getUserIP() ."' , h_type = '种植KK'";
	$db->query($query);
  
  echo("result:".$rstr."-". $land_money_now);
}
?>﻿﻿