<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';

$farmid = "";
$land_money = 0;
$land_money_now = 0;
$pid = "";
$land = "";
$land1 = "";
$harvest = "";
$h_harvest1;
$h_harvest2;
$time1;
$time2;
$time_str1;
$time_str2;
$h_harvest;
$harvest_time = "";
$rstr = "ok";
if($_POST["act"] == "shifei")
{
  
}
$farmid = $_POST["farmID"];

global $memberLogged_userName;

$money_now = 0;

$query = "select * from `h_member_farm` where h_userName = '{$memberLogged_userName}' and h_isEnd = 0";
$result = $db->query($query);

$rs2 = [];
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
		       
		        if($days>=1){
		        	$days=1;
		          	$money_now = $money_now + $harvest1[$a];
		       
		        }
		        $time1[$a] = date('Y-m-d')." 00:00:00";
		        

			  }
			}

			if(intval($farmid) < 11)
			{
			  $h_harvest = explode(",",$val['h_harvest']);
		      $land_money = $h_harvest[intval($farmid)-1];
			  $pid = "112";
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
				
			   if($days>=1){
		        	$days=1;
		        	$money_now = $money_now + $harvest2[$a];
		        /* echo "<br>";*/
		        }
		        $time2[$a] = date('Y-m-d')." 00:00:00";			  
		      }
			}

			if(intval($farmid) == 11 || intval($farmid) > 11)
			{
			  $h_harvest = explode(",",$val['h_harvest']);
		      $land_money = $h_harvest[intval($farmid)-11];
			  $pid = "113";
			}

			
		  }
		}


		$money_now = round($money_now*get_growth_rate($memberLogged_userName),2);
		writeLog('member shifei money_now:' . $money_now);
}
else
{
  $rstr = "wrong";
}

//如果land_money 已经满额了 返回失败
if(intval($farmid) < 11){
	if(abs($land_money - 3000) < 1e-6){
		exit('已经满额了！无须再施肥!');
	}
}else{
	if(abs($land_money - 30000) < 1e-6){
		exit('已经满额了！无须再施肥!');
	}
}

$bIsDisplayHuafei = false;

 /*库存的化肥*/
if(abs($money_now) < 1e-6){
	$days=date("Y-m-d",time());
	$query = "select  *  from  `h_huafei_stock` where  h_userName = '{$memberLogged_userName}' and status=0 and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(create_time)),'%Y-%m-%d') = '".$days."'";
	writeLog('member query sql:' . $query);
	$rs5 = $db->get_one($query);

	if($rs5){
		 $money_now = $rs5['h_price'];
		 $id=$rs5['id'];
	}

	
	$query = "update `h_huafei_stock` set status = 1 where  id = '".$id."'";
	$db->query($query);
}


$land_money_now = $land_money + $money_now;
writeLog('member each data land_money_now:' . $land_money_now . '|land_money:' . $land_money . '|farmid:' . $farmid . '|shifeiren:' . $memberLogged_userName);
if(intval($farmid) < 11)
{
          if($land_money_now>3000){
		  		
		  		/*保存多余化肥*/
		  		$huifei = $land_money_now-3000;
		  		$query = "insert into `h_huafei_stock` set h_userName = '{$memberLogged_userName}' , h_price = ". $huifei .", create_time ='".date('Y-m-d',time())."'";
			    $result = $db->query($query);

			    $land_money_now = 3000;
			    $money_now = $money_now - $huifei;
			    $h_harvest[intval($farmid)-1] = floatval($land_money_now);

			    $bIsDisplayHuafei = true;
		  }else{
		  		$h_harvest[intval($farmid)-1] = floatval($land_money_now);
		  		$huifei=0;
		  }
} 
else
{
  		   if($land_money_now>30000){
			  		
			  		/*保存多余化肥*/
			  		$huifei = $land_money_now-30000;
			  		$query = "insert into `h_huafei_stock` set h_userName = '{$memberLogged_userName}' , h_price = ". $huifei .", create_time ='".date('Y-m-d',time())."'";
				    $result = $db->query($query);

				    $land_money_now = 30000;
				    $money_now = $money_now - $huifei;
				    $h_harvest[intval($farmid)-11] = floatval($land_money_now);

				    $bIsDisplayHuafei = true;
			}else{
			  		$h_harvest[intval($farmid)-11] = floatval($land_money_now);
			  		$huifei=0;
			}
}

$sHarvest = implode(',', $h_harvest);

for($a = 0; $a < count($time1); $a++)
{
	if($a == 0)
	{
	  $time_str1 = $time1[$a];
	}
	else
	{
	  $time_str1 = $time_str1. "|" .$time1[$a];
	}
}

for($a = 0; $a < count($time2); $a++)
{
    if($a == 0)
	{
	  $time_str2 = $time2[$a];
	}
	else
	{
	  $time_str2 = $time_str2. "|" .$time2[$a];
	}
}


/*session_start();
if(!isset($_COOKIE['shifei'])){

		setcookie('shifei','shifei', time()+5);*/

		if(!empty($sHarvest)){
			$query = "update `h_member_farm` set h_harvest = '". $sHarvest ."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";
			$db->query($query);
			writeLog('member h_harvest update:' . $query . '|shifeiren:' . $memberLogged_userName);
		}

		if(!empty($time_str1) && !$bIsDisplayHuafei){
			$query = "update `h_member_farm` set h_h_time = '". trim($time_str1,'|') ."' where h_userName = '{$memberLogged_userName}' and h_pid = '112'";
			$db->query($query);
		}

		if(!empty($time_str2) && !$bIsDisplayHuafei){
			$query = "update `h_member_farm` set h_h_time = '". trim($time_str2,'|') ."' where h_userName = '{$memberLogged_userName}' and h_pid = '113'";
			$db->query($query);
		}


		if($money_now>0){
			$query = "insert into `h_log_point2` set h_userName = '{$memberLogged_userName}' , h_price = ". $money_now .", h_about = '庄园地".$farmid."收获". $money_now ."KK', h_addTime = now(), h_actIP = '". getUserIP() ."' , h_type = '施肥' , h_type_id = 4, h_farmid =".$farmid.",h_account =".getaccount($memberLogged_userName);
			$result = $db->query($query);
		}

		/*判断KK每达到5w 和 15w 获取一条花仙子*/
		isflowerfairy2($memberLogged_userName);	


		echo("result:".$rstr."-".$huifei."-". $land_money_now ."-".$money_now);


		writeLog("member shifei result:".$rstr."-".$huifei."-". $land_money_now ."-".$money_now . '|shifeiren:' . $memberLogged_userName);
		
/*}else{
		echo("正在处理,请稍后重试...");exit;
}*/

?>﻿