<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';

$farmid = "";
$land_money = 0;
$land_money_now = 0;
$pid = "";
$harvest = "";
$h_harvest;
$harvest_time = "";
$rstr = "ok";
$farmid = $_POST["farmID"];
$money_now = 0;
global $memberLogged_userName;


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
		  $name="可可";
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
		  $name="蓝可可";
		  $diname="高级地";
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
  $h_harvest[intval($farmid)-1] = 300;
  $land_money = intval($land_money) - 300;
}
else
{
  $h_harvest[intval($farmid)-11] = 3000;
  $land_money = $land_money - 3000;
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

controlFrequency($memberLogged_userName);
session_start();
if($land_money>0 ){

	if(!isset($_COOKIE['shouhuo'])){
		setcookie('shouhuo','shouhuo', time()+5);
	
		$query = "update `h_member_farm` set h_harvest = '".trim($harvest,',')."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";
		$db->query($query);

		$query = "update `h_member` set h_point2 = h_point2 + ". $land_money ." where h_userName = '{$memberLogged_userName}'";
		$db->query($query);

		$query = "insert into `h_log_point2` set h_userName = '{$memberLogged_userName}' , h_price = ". $land_money .", h_about = '".$diname.$farmid.',收获'. $land_money .$name."KK', h_addTime = now(), h_actIP = '". getUserIP() ."' , h_type = '庄园产KK',h_type_id =5";
		$db->query($query);
		  
		echo("result:".$rstr."-". $land_money);

	}else{
		echo("请求正在处理，请耐心等待...");
	}
}else{
	echo("result:".$rstr."-0");
}

exit;
