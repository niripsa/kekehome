<?php
#为什么每个文件都需要conn.php?
#比如$$ extract 连接$db

#1.通过$_GET/$_POST/$_COOKIE/$_SESSION拿到用户输入的数据
#2.服务器拿到数据处理 计算 到数据库查一下...balabala...
#3.通知浏览器/app 处理结果(html/ajax(json))
#errno (0代表无错误)  errmsg(错误原因)  data
#php:	json_encode()  json_decode()
#js:	JSON.stringify JSON.parse
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
#intval()  floatval() 类似于js中的parseInt,parseFloat
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
	#h_points2:余额
	if($admun > $result['h_point2'])
	{
	    echo("您没有这么多KK了！快去充值吧~~！");exit;
	}else{
		$money_now = $result['h_point2'];
	}

	$query = "select * from `h_member_farm` where h_userName = '{$memberLogged_userName}' and h_isEnd = 0";
	$result = $db->query($query);
	
	//当数据都搬下来之后，再次调用fetch_array则返回NULL
	while($list = $db->fetch_array($result))
		//$list是储存着搬下来数据的数组
	{
		$rs2[]=$list;
		//$rs2是一个多维数组,元素个数是2
		//第一个元素是储存普通地数据的数组
		//第二个元素是储存金地数据的数组
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
	
	//现在的地里面的kk=之前的kk+播种的kk
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
	
	session_start();
	//这里没有用到session,只是cookie
	if(!isset($_COOKIE['shouhuo'])){
			setcookie('shouhuo','shouhuo', time()+5);


			$h_point2 = $num - $admun;
			if($h_point2 >= 0){
				$query = "update `h_member` set h_point2 = h_point2 - ". $admun ." where h_userName = '{$memberLogged_userName}' and h_point2 >= " . $admun;
				$db->query($query);
				$iAffectedRows = $db->affected_rows();
				if(empty($iAffectedRows)){
					writeLog("member attack:" . $query);
					exit;
				}

				$query = "update `h_member_farm` set h_harvest = '". $sHarvest ."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";

				//$query = "insert into  `h_member_farm`  set h_land = '". trim($land_str,',') ."',h_harvest = '". trim($harvest,',') ."',h_h_time = '". trim($time_str,'|') ."',h_userName = '{$memberLogged_userName}',h_pid = '".$pid."'";
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
	//↓取出每个人的地的数据
	while($list = $db->fetch_array($result))
	{
		$rs2[]=$list;
	}
	//$rs2里面存着那两块地(普通地112，金地113)的信息
	//↓确认有金地
	if(count($rs2) > 0)
	{
		foreach ($rs2 as $key=>$val)
		{
		  if($val['h_pid'] == "112")
		  {
			if(intval($farmid) < 11)
			//大于10的不是普通地
			{
			  $h_harvest = explode(",",$val['h_harvest']);
			  //explode(),根据分隔符把字符串拆成数组
			  //js :split   join
			  //php:explode implode
			  $land_money = $h_harvest[intval($farmid)-1];
			  //intval()强制保证是整数
			  //$farmid是第几块地的编号,减1得到数组的索引
			  $land = explode(",",$val['h_land']);
			  $time = explode("|",$val['h_h_time']);
			  $time[intval($farmid)-1] = date('Y-m-d')." 00:00:00";
			  
			  $pid = "112";
			  $diname="普通地";
			  $i = 0;
			  //统计一下种过的地的数目
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
			//if(intval($farmid)>=11)
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
	
	$land_str = implode(",",$land);
	$time_str = implode("|",$time);
	//把数组拼成字符串
	/*for($i = 0; $i < count($h_harvest); $i++)
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
    }*/

    $sHarvest = implode(',', $h_harvest);
	

    session_start();
    //下面是为了防止用户连续刷新导致扣kk过多，第一次请求会setcookie，后面的请求则带有cookie，判断后不再重复扣kk
	if(!isset($_COOKIE['shouhuo'])){
			setcookie('shouhuo','shouhuo', time()+5);

			$h_point2 = $num - $land_money_now;
			if($h_point2 >= 0){
				//原子性atom
				//下面更新的时候，数据库中仍然是计算之前的值
				//减去$land_money_now，是为了防止并发情况
				$query = "update `h_member` set h_point2 = h_point2 - ". $land_money_now ." where h_userName = '{$memberLogged_userName}' and h_point2 >= " . $land_money_now;
				$result = $db->query($query);
				$iAffectedRows = $db->affected_rows();
				if(empty($iAffectedRows)){
					writeLog("member new attack:" . $query);
					exit;
				}

				$query = "update  `h_member_farm`  set h_land = '". trim($land_str,',') ."',h_harvest = '". $sHarvest ."',h_h_time = '". trim($time_str,'|') ."' where h_userName = '{$memberLogged_userName}' and h_pid = '".$pid."'";

				//$query = "insert into  `h_member_farm`  set h_land = '". trim($land_str,',') ."',h_harvest = '". trim($harvest,',') ."',h_h_time = '". trim($time_str,'|') ."',h_userName = '{$memberLogged_userName}',h_pid = '".$pid."'";
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