<?php
require_once '../include/conn.php';
require_once '../include/webConfig.php';
?>
<html>
<head>
<title>后台管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../css/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="../js/plugin.js"></script>
<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<script language="javascript" type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>
<body>
<br>
<?php

switch($clause)
{
	case "settle":
		settle();
		break;
	default:
		main_();
		break;
}

function settle_farm_20160224($userName){
	global $db;
	
	$bonusAll = 0;
	$now = date('Y-m-d H:i:s');
	
	$sql = "select *,DATEDIFF(sysdate(),h_lastSettleTime) as diffDaysS,DATEDIFF(sysdate(),h_addTime) as diffDaysA from `h_member_farm` where h_userName = '{$userName}' and h_isEnd = 0 and DATEDIFF(sysdate(),h_addTime) > 0 and (DATEDIFF(sysdate(),h_lastSettleTime) <> 0 or h_lastSettleTime is null)";
	$query = $db->query($sql);
	//遍历宠物
	while($rs = $db->fetch_array($query)){
		//上次结算与今天的时间差（天数）
		$dateDiffDay = intval($rs['diffDaysS']);
		//如果<=0，说明未结算过，则是第一次结算：购买时间与今天的时间差（天数）
		if($dateDiffDay <= 0){
			$dateDiffDay = intval($rs['diffDaysA']);
		}
		//如果仍然<=0，不必结算，跳过
		if($dateDiffDay <= 0){
			continue;
		}
		
		//需要结算的天数
		$mustSettleDay = $dateDiffDay;
		//如果超出生存周期，最多是生存周期
		if(($mustSettleDay + $rs['h_settleLen']) > $rs['h_life']){
			$mustSettleDay = $rs['h_life'] - $rs['h_settleLen'];
		}
				
		if($mustSettleDay > 0){
			//是否死亡
			if(($mustSettleDay + $rs['h_settleLen']) >= $rs['h_life']){
				$isEnd = 1;
			}else{
				$isEnd = 0;
			}
			
			//需要结算的KK
			$mustSettleMoney = $mustSettleDay * intval($rs['h_point2Day']) * intval($rs['h_num']);
			echo "结算KK=".$mustSettleDay."*".intval($rs['h_point2Day'])."*".intval($rs['h_num']);
			//累加，最后一次性发放
			$bonusAll += $mustSettleMoney;
			
			//更新为已发放
			$sql = "update `h_member_farm` set h_settleLen = h_settleLen + ({$mustSettleDay}),h_lastSettleTime = '{$now}',h_isEnd = '{$isEnd}' where id = '{$rs['id']}'";
			$db->query($sql);
			
			//加款统一在后面一次性加，节省资源
			
			$settleId = CC_FARM_CN + $rs['id'];
			
			//记录
			$sql = "insert into `h_log_point2` set ";
			$sql .= "h_userName = '" . $userName . "', ";
			$sql .= "h_price = '" . $mustSettleMoney . "', ";
			$sql .= "h_type = '宠物收益', ";
			$sql .= "h_about = '宠物收益ID：{$settleId}', ";
			$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
			$sql .= "h_actIP = '" . getUserIP() . "' ";
			$db->query($sql);
		}
			
		echo $rs['h_lastSettleTime'] . '|';
		echo $dateDiffDay . '|';
		echo $mustSettleDay . '|';
		echo $mustSettleMoney . '|';
		echo $isEnd . '|';
		echo '<br />';
	}
	
	echo '总额：';
    echo $bonusAll . '|';
	echo '<br />';
	
	//一次性发放
	if($bonusAll > 0){
		//加款
		$sql = "update `h_member` set ";
		$sql .= "h_point2 = h_point2 + ({$bonusAll}) ";
		$sql .= "where h_userName = '" . $userName . "' ";
		$db->query($sql);
		
		//发放上级奖金
		bonus_log_20160224($userName,$bonusAll,$userName);
	}
	
	return $bonusAll;
}

//上级奖金
function bonus_log_20160224($buyUserName,$bonusAll,$currUserName,$floorIndex = 1){
	global $db;
	global $webInfo;
	
	if($floorIndex > 5){
		return;
	}
	
	//奖金
	$bonus = floatval($bonusAll) * floatval($webInfo['h_point2Com' . $floorIndex]);
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$currUserName}'");
	//会员存在
	if($rs){
		//推荐人存在，结算给推荐人
		if(strlen($rs['h_parentUserName']) > 0){
			//奖金 > 0 才记录
			if($bonus > 0){
				$rsBD = $db->get_one("select * from `h_log_bonus_day` where h_userName = '{$rs['h_parentUserName']}' and h_addDate = '" . date('Y-m-d') . "'");
				if($rsBD){
					$sql = "update `h_log_bonus_day` set ";
					$sql .= "h_price = h_price + (" . $bonus . ") ";
					$sql .= "where id = '" . $rsBD['id'] . "' ";
				}else{
					$sql = "insert into `h_log_bonus_day` set ";
					$sql .= "h_userName = '" . $rs['h_parentUserName'] . "', ";
					$sql .= "h_price = '" . $bonus . "', ";
					$sql .= "h_addDate = '" . date('Y-m-d') . "' ";
				}
				
				$db->query($sql);
				//echo $sql . '<br />';
			}
			
			//下一轮
			bonus_log_20160224($buyUserName,$bonusAll,$rs['h_parentUserName'],$floorIndex + 1);
		}
	}
}

function bonus_farm_20160224(){
	global $db;

	$sql = "select * from `h_log_bonus_day` where h_addDate = '" . date('Y-m-d') . "' and h_isSettled = 0";
	$query = $db->query($sql);
	$rowsNum = $db->num_rows($query);
	if($rowsNum > 0){
		while($rs = $db->fetch_array($query)){
			$bonus = $rs['h_price'];
			
			//加款
			$sql = "update `h_member` set ";
			$sql .= "h_point2 = h_point2 + ({$bonus}) ";
			$sql .= "where h_userName = '" . $rs['h_userName'] . "' ";
			$db->query($sql);
			
			//记录
			$sql = "insert into `h_log_point2` set ";
			$sql .= "h_userName = '" . $rs['h_userName'] . "', ";
			$sql .= "h_price = '" . $bonus . "', ";
			$sql .= "h_type = '宠物收益分红', ";
			$sql .= "h_about = '宠物管理奖', ";
			$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
			$sql .= "h_actIP = '" . getUserIP() . "' ";
			$db->query($sql);
			
			//更新为已发放
			$sql = "update `h_log_bonus_day` set ";
			$sql .= "h_isSettled = 1 ";
			$sql .= "where id = '" . $rs['id'] . "' ";
			$db->query($sql);
		}
	}
	return $rowsNum;
}

function settle(){
	global $db;
	
	//一次结算5个会员
	$sql = "select * from `h_member` where h_settleDate <> '" . date('Y-m-d') . "' or h_settleDate is null LIMIT 5";
	$query = $db->query($sql);
	if($db->num_rows($query) > 0){
		while($rs = $db->fetch_array($query)){
			settle_farm_20160224($rs['h_userName']);
			
			$sql = "update `h_member` set h_settleDate = '" . date('Y-m-d') . "' where h_userName = '" . $rs['h_userName'] . "'";
			$db->query($sql);
			
			echo '当前已结算会员：' , $rs['h_userName'] , '的宠物KK！<br />';
			echo '等待下一次刷新结算下一位会员...<br /><br />';
		}
	}else{
		echo '今天所有会员的KK已经结算完毕！<br />';
		
		$bonusFarm = bonus_farm_20160224();
		if($bonusFarm > 0){
			echo '今天所有会员的提成也已经结算完毕！<br />';
			echo '可以再刷新最后一次看看！<br />';
		}else{
			echo '今天所有会员的提成也已经结算完毕！<br />';
			echo '今天可以停止刷新了！<br />';
		}
	}
}

function main_()
{
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">结算KK</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td style="line-height:25px;">
1、前台已经关闭会员登录时自动进行结算的功能，如果不使用本KK结算功能，将不发放KK；<br />
2、结算是以“天”来计算。比如昨天购买的宠物，今天则发放第1次KK，即使是昨天23:59:59购买的，今天00:00:01进行结算，也将发放；<br />
所以结算时，不一定非要熬夜在晚上12:00之后马上进行结算，可以早晨6点或8点进行结算也一样；<br />
3、操作方式：使用刷网页点击量的软件刷结算页，每刷一次结算1个会员的KK，请重复刷，直到提示发放完成；<br />
4、发放完成后，继续刷不会有任何效果，也没有副作用；<br />
5、也可以手工模拟刷，就是比如5秒刷一次结算页，一直刷到提示发放完成；<br />
6、如果软件刷，请每次时间间隔设置为10秒或以上，保障有充足的时间让程序计算奖金并发放；<br />
7、如果手工刷，请在每次刷完页面，看到提示奖金发放情况后，再刷第二次，防止上一次的结算未计算完成就刷下一次结算，造成上次结算未发放完毕。<br />
<br />
刷开奖页的网址：<br />
<?php
$url = GetUrl(6) . '?clause=settle';

echo '<a href="' , $url , '" target="_blank">' , $url , '</a>';
?>
    </td>
  </tr>
</table>
</form>
<?php
}


footer();
?>