<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/function_item.php';
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
$farmid = intval($_POST["kid"]);
$admun = abs(floatval($_POST["addou"]));
$land = "";
$land_str = "";
$num = 0;
$num_now = 0;
$time;
$time_str;
$rs2;
global $memberLogged_userName;





if($_POST["adtype"] == "ad")
{


	/*判断是否有KK*/
/*	if(!havejinbi($memberLogged_userName,$admun)){
		echo("您没有这么多KK了！快去充值吧~~！");exit;
	}*/


	if($admun < 0 || $admun == null)
	{
	  echo("请输入正确的数量！");exit;
	}

	$query = "select * from `h_member` where h_userName = '{$memberLogged_userName}' ";
	$result = $db->get_one($query);
	$num = $result['h_point2'];
	if($admun > $result['h_point2'])
	{
	    echo("您没有这么多KK了！快去充值吧~~！");exit;
	}else{
		$money_now = $result['h_point2'];
	}

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
			  $diname="普通地";
			  
			}
		  }
		  else
		  {
			if(intval($farmid) == 11 || intval($farmid) > 11)
			{
			  $h_harvest = explode(",",$val['h_harvest']);
			  $land_money = $h_harvest[intval($farmid)-11];
			  $pid = "113";
			  $diname="高基地";
			  
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
	
	$sHarvest = implode(',', $h_harvest);
	controlFrequency($memberLogged_userName);
	session_start();
	if(!isset($_COOKIE['shouhuo'])){
			setcookie('shouhuo','shouhuo', time()+5);


			$h_point2 = $num - $admun;
			if($h_point2 >= 0){
				//首先尝试更新用户的余额 更新失败直接退出
				$query = "update `h_member` set h_point2 = h_point2 - ". $admun  ." where h_userName = '{$memberLogged_userName}' and h_point2 >= " . $admun;
				$db->query($query);
				$iAffectedRows = $db->affected_rows();
				if(empty($iAffectedRows)){
					writeLog("mobile attack:" . $query);
					exit;
				}

				$query = "update `h_member_farm` set h_harvest = '". $sHarvest ."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";
				$db->query($query);
				
				$query = "insert into `h_log_point2` set h_userName = '{$memberLogged_userName}' , h_price = -". $admun .", h_about = '".$diname.$farmid.",增加播种". $admun ."KK', h_addTime = now(), h_actIP = '". getUserIP() ."' , h_type = '增加播种', h_type_id = 3,h_account =".getaccount($memberLogged_userName);
				$db->query($query);
			  
			    echo("result:".$rstr."-". $land_money_now);
			}else{
				echo("您没有这么多KK了！快去充值吧~~！");exit;

			}

	}else{
		echo("正在处理,请稍后重试...");exit;
	}
}
elseif($_POST["adtype"] == "new")
{
	$sql  = "select * from  `h_member`  where  h_userName = '{$memberLogged_userName}' ";
	$result=$db ->get_one($sql,1);
	$num = $result['h_point2'];

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
			  $diname="普通地";
			  $i = 0;
			  for($a = 0; $a < count($land); $a++)
			  {
			    if($land[$a] == "1")
			    {
			      $i++;
			    }
			  }
			  $num_now = 300;
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
			  $diname="高基地";
			  $i = 0;
			  for($a = 0; $a < count($land); $a++)
			  {
			    if($land[$a] == "1")
			    {
			      $i++;
			    }
			  }
			  $num_now = 3000;
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
		
	  $land_money_now = 300;

	  if($num < 300){  echo("您没有这么多KK了！快去充值吧~~！");exit; }

	  if($land[intval($farmid)-1] == '1'){
	  		exit('不可重复种地！');
	  }

	  $h_harvest[intval($farmid)-1] = $land_money_now;
	  $land[intval($farmid)-1] = "1";
	}
	else
	{
	  $land_money_now = 3000;

	  if($num < 3000){  echo("您没有这么多KK了！快去充值吧~~！");exit; }

	  if($land[intval($farmid)-11] == '1'){
	  		exit('不可重复种地！');
	  }

	  $h_harvest[intval($farmid)-11] = $land_money_now;
	  $land[intval($farmid)-11] = "1";
	}

	for($i = 0; $i < count($h_harvest); $i++)
	{
	  if($i == 0)
	  {
		$land_str = $land[$i];
		$time_str = $time[$i];
	  }
	  else
	  {
		$land_str = $land_str . "," . $land[$i];
		$time_str = $time_str . "|" . $time[$i];
	  }
    }
	
	$sHarvest = implode(',', $h_harvest);
	controlFrequency($memberLogged_userName);
    session_start();
	if(!isset($_COOKIE['shouhuo'])){
			setcookie('shouhuo','shouhuo', time()+5);

			$h_point2 = $num - $land_money_now;
			if($h_point2 >= 0){
				$query = "update `h_member` set h_point2 = h_point2 - ". $land_money_now ." where h_userName = '{$memberLogged_userName}' and h_point2 >= " . $land_money_now;
				$result = $db->query($query);
				$iAffectedRows = $db->affected_rows();
				if(empty($iAffectedRows)){
					writeLog("mobile new attack:" . $query);
					exit;
				}


				$query = "update  `h_member_farm`  set h_land = '". trim($land_str,',') ."',h_harvest = '". $sHarvest ."',h_h_time = '". trim($time_str,'|') ."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";

				$db->query($query);

				$query = "insert into `h_log_point2` set h_userName = '{$memberLogged_userName}' , h_price = -". $land_money_now .", h_about = '".$diname.$farmid.",增加播种KK', h_addTime = now(), h_actIP = '". getUserIP() ."' , h_type = '开垦', h_type_id = 2,h_account =".getaccount($memberLogged_userName);
				$db->query($query);
			    echo("result:".$rstr."-". $land_money_now);
			}else{
				echo("您没有这么多KK了！快去充值吧~~！");exit;
			}
	}else{
		echo("正在处理,请稍后重试...");exit;
	}
	
}
?>﻿﻿