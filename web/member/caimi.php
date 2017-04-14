<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';

$farmid = 0;
$username= 0;
$money=0;
$farmid = $_POST["farmID"];
if(empty($farmid)){ 
	echo("请选择庄园地！");
	exit; 
}
$username = $_POST["username"];
if(empty($username)){ 
	echo("好友账户不能为空！");
	exit; 
}

global $memberLogged_userName;
if(empty($memberLogged_userName)){ 
	echo("用户不能为空！");
	exit; 
}


//判断好友是一级还是二级
$aFriendInfo = $db->get_one("select * from h_member where h_userName = '{$username}'");
if(empty($aFriendInfo)){
	echo("好友账户不能为空！");
	exit;
}

if(strval($aFriendInfo['h_parentUserName']) == $memberLogged_userName){
	$level = 1;
}elseif(strval($aFriendInfo['h_secondParentUserName']) == $memberLogged_userName){
	$level = 2;
}else{
	exit;
}


$days=date("Y-m-d",time());
$query = "select * from  `h_usebee`  where  h_userName = '{$memberLogged_userName}'  and  h_fuserName = '{$username}' and h_level = {$level}  and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
$result = $db->get_one($query);

controlFrequency($memberLogged_userName);
session_start();

if(!$result){
	if(!isset($_COOKIE['shouhuo'])){

		setcookie('shouhuo','shouhuo', time()+5);

		$query = "select   sum(h_price) as num   from  `h_log_point2`  where  h_userName = '{$username}' and h_type_id =4 and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
		
		$result = $db->get_one($query);
		if($result['num']){
				$shifei = $result['num'];
				if($level == 1){
					$money = round($shifei*0.1,2);
				}elseif($level == 2){
					$money = round($shifei*0.05,2);
				}else{
					$money = 0;
				}
				

				if($money>0){
					//好友采蜜奖励
					$sql  = "update `h_member` set ";
					$sql .= "h_point2 = h_point2 +  ".$money;
					$sql .= " where h_userName = '" . $memberLogged_userName . "' ";
					$result = $db->query($sql);
					if($result){
						getusebee($username,$memberLogged_userName,$money, $level);
					}
					/*判断KK每达到5w 和 15w 获取一条花仙子*/
					isflowerfairy2($memberLogged_userName);	
					
					echo("result:-".$money);exit;
				}else{
					echo("result:-0");exit;
				}	
		}else{
			echo("result:-0");exit;
		}
		
	}else{
		echo("result:-0");exit;
	}
}





