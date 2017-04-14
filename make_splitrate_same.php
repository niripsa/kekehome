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
$sql = "select  *  from h_growth_rate where DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = '".$days."'";

$result = mysql_query($sql, $link); //查询

while($row = mysql_fetch_array($result))
{
	if(!empty($row['rate'])){
		$rate = $row['rate'];
		$query = "insert into  `h_growth_rate` SET rate = '$rate', update_time = ".time().",create_time = ".time(); 

		mysql_query($query, $link);
		exit('insert success!');
	}
}

exit('make splitscript run end time:' . date('Y-m-d H:i:s'));