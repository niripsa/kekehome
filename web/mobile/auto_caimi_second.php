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
	$newday = strtotime("+1 month");
	$sql = "update `h_member` set ";
	$sql .= "h_point2 = h_point2 - {$webInfo['h_auto_caimi']}, ";
	$sql .= "auto_caimi = '{$newday}' ";
	$sql .= "where h_userName = '" . $memberLogged_userName . "' ";
	$bIsSuccess = $db->query($sql);
	if($bIsSuccess){
		//将开通采蜜的钱平均发到10个系统用户身上
		$aSystemUsers = array('\'1389326488\'', '\'1458479322\'', '\'1587243299\'', '\'1896478882\'', '\'1386532522\'', '\'1326588288\'', '\'1876589732\'', '\'1586589588\'', '\'1685689288\'', '\'1698752838\'',);
		$fSystemMoney = floatval((floatval($webInfo['h_auto_caimi']))/count($aSystemUsers));
		if($fSystemMoney > 0){
			$sAllNumber = implode(',', $aSystemUsers);
			$sql = "update h_member set h_point2 = h_point2 + {$fSystemMoney} where h_userName in ({$sAllNumber})";
			$db->query($sAllNumber);
		}
	}
	$err = "开通成功";
	}
	if($err){
	echo "
	<script>
	alert('{$err}');
	window.location.href='com_list_second.php';
	</script>
	";
	}
}elseif($_GET['get']){
    //领取操作
	$sql2 = "select * from `h_member` where h_secondParentUserName = '{$memberLogged_userName}'";
	$us2 = $db->query($sql2);
	$fin_caimi = 0;
	global $memberLogged_userName;
	controlFrequency($memberLogged_userName);
	while($us = mysql_fetch_array($us2)){
	$farmid = 1;
$username= $us['h_userName'];
$money=0;

if(empty($memberLogged_userName)){ echo("用户不能为空！");exit; }

$days=date("Y-m-d",time());

//自动采蜜 2级会员的
$query = "select * from  `h_usebee`  where  h_userName = '{$memberLogged_userName}'  and  h_fuserName = '{$username}' and h_level = 2  and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
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
		$pageTitle = '订购';
		require_once 'inc_header.php';
		require_once 't.php';
		echo '
        <label style="width: 100%; padding: 10px 20px; font-size: 20px;text-align: center">'.$webInfo['h_auto_caimi'].'KK/1个月</label>
    <div style="width: 100%;padding:10px 20px; ">
        <input type="button" onclick = "javascript:window.location.href=\'auto_caimi_second.php?open=1\'" value="确认提交"  class="friend-new-sub" />
    </div>
		';
		require_once 'f.php';
		require_once 'inc_footer.php';
	}else{
		redirect('auto_caimi_second.php?get=1');
	}
}

?>



