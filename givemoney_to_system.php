<?php
sleep(1);

if(php_sapi_name() != 'cli'){
	exit('wrong source!');
}

date_default_timezone_set('Asia/Shanghai');
$sIp = "127.0.0.1";
$sUserName   = "kkh";		 
$sPass = "qd645C146B3jNZtx4BtH";	 
$sDataName = "kekehome";	 

if(!$link = @mysql_connect($sIp, $sUserName, $sPass)) {
	exit('Can not connect to MySQL server');
}

@mysql_select_db($sDataName, $link);

mysql_query("SET NAMES UTF8");

$days=date("Y-m-d", time() - 86400);

$aSystemUsers = array('1389326488', '1458479322', '1587243299', '1896478882', '1386532522', '1326588288', '1876589732', '1586589588', '1685689288', '1698752838',);

$iSystemUserCount = count($aSystemUsers);

//求出昨天一天系统获得费用的总和 = 转账手续费 + 提现手续费
//先求昨日转账手续费的和
$sql = "select  sum(h_price) as sum_price from `h_log_point2_system` where DATE_FORMAT(modify_time,'%Y-%m-%d') = '".$days."'" . " and h_about = '转账手续费归系统' and h_type_id = 2 and h_state='转账成功确认'";
echo $sql . PHP_EOL;
$result = mysql_query($sql, $link); //查询
$row = mysql_fetch_array($result);
if(!empty($row['sum_price'])){
	$fTransferSum = floatval($row['sum_price']);	
}else{
	$fTransferSum = 0.0;
}

//再求出昨日提现手续费的和
$sql = "select  sum(h_price) as sum_price from `h_log_point2_system` where DATE_FORMAT(modify_time,'%Y-%m-%d') = '".$days."'" . " and h_about = '提现手续费归系统' and h_type_id = 1 and h_ref_id <> 0 and h_state='已打款'";
echo $sql . PHP_EOL;
$result = mysql_query($sql, $link); //查询
$row = mysql_fetch_array($result);
if(!empty($row['sum_price'])){
	$fWithDrawSum = floatval($row['sum_price']);
}else{
	$fWithDrawSum = 0.0;
}

$fSum = $fTransferSum + $fWithDrawSum;

echo 'sum_money:' . $fSum . PHP_EOL;

if(abs($fSum) > 1e-6 && !empty($iSystemUserCount)){
    //如果总量非零 则平均分配到十个账户上
    $fEachMoney = $fSum/$iSystemUserCount;

    foreach ($aSystemUsers as $sSystemUser) {
    	$sql = "update `h_member` set h_point2 = h_point2 + {$fEachMoney} where h_userName = '{$sSystemUser}'";
    	mysql_query($sql);
    }
}

exit('givemoney to system end time:' . date('Y-m-d H:i:s'));