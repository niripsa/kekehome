<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/member/logged_data.php';
$sql = "select * from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
	$rs = $db->get_one($sql);
$day = strtotime('now');
if($_GET['open']){
	//开通操作
	if(!$memberLogged){
		echo '您没有登录，请登录后再操作！';
		exit;
	}
	if($rs['auto_caimi'] != "" && $rs['auto_caimi'] > strtotime('now')){
	$err = "已经开通了，不用再次开通";
	}
	if($rs['h_point2'] < $webInfo['h_auto_caimi']){
	if(!$err)$err = "可用可可不足";
	}
	//扣钱
	if(!$err){
	$newday = strtotime("+1 year");
	$sql = "update `h_member` set ";
	$sql .= "h_point2 = h_point2 - {$webInfo['h_auto_caimi']}, ";
	$sql .= "auto_caimi = '{$newday}' ";
	$sql .= "where h_userName = '" . $memberLogged_userName . "' ";
	$db->query($sql);
	$err = "开通成功";
	}
}elseif($_GET['get']){
    //领取操作
	$sql2 = "select * from `h_member` where h_secondParentUserName = '{$memberLogged_userName}'";
	$us2 = $db->query($sql2);
	$fin_caimi = 0;
	while($us = mysql_fetch_array($us2)){
	$farmid = 1;
$username= $us['h_userName'];
$money=0;
global $memberLogged_userName;
if(empty($memberLogged_userName)){ echo("用户不能为空！");exit; }

$days=date("Y-m-d",time());

//自动采蜜 2级会员的
$query = "select * from  `h_usebee`  where  h_userName = '{$memberLogged_userName}'  and  h_fuserName = '{$username}' and h_level = 2 and DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
$result = $db->get_one($query);

session_start();

if(!$result){
	if(!isset($_COOKIE['shouhuo'])){

		setcookie('shouhuo','shouhuo', time()+5);

		$query = "select   sum(h_price) as num   from  `h_log_point2`  where  h_userName = '{$username}' and h_type_id =4 and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
		
		$result = $db->get_one($query);
		if($result['num']){
				$shifei = $result['num'];
				$money = round($shifei*0.05,2);

				if($money>0){
					//好友采蜜奖励
					$sql  = "update `h_member` set ";
					$sql .= "h_point2 = h_point2 +  ".$money;
					$sql .= "where h_userName = '" . $memberLogged_userName . "' ";
					$result = $db->query($sql);
					if($result){
						getusebee($username,$memberLogged_userName,$money,2);
					}
					/*判断KK每达到5w 和 15w 获取一条花仙子*/
					isflowerfairy2($memberLogged_userName);	
					$fin_caimi += $money;
				}	
		}
		
	}
}//end of if
	}//end of while
	echo "
	<script>
	alert('总计收获了{$fin_caimi}蜂蜜！');
	window.location.href='com_list_second.php';
	</script>
	";
}else{
        if($rs['auto_caimi'] == "" || $rs['auto_caimi'] < $day){
		//显示开通页面
		echo "
	<script>
	 if(confirm('确定要花费{$webInfo['h_auto_caimi']}KK开通一年自动采蜜吗？'))
 {
 window.location.href='auto_caimi_second.php?open=1';
 }else{
	window.location.href='com_list_second.php'; 
 }
	</script>
	";
	}else{
		redirect('auto_caimi_second.php?get=1');
	}
}

?>



