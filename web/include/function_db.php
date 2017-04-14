<?php
function footer(){	
	global $db;
	$db->close();
}

function chkAdminLoginEd($chkUserName,$chkPassWord)
{
	global $db;
	$tmp = 0;
	if($chkUserName != '' && $chkPassWord != '')
	{
		$tempRs = $db->get_one("SELECT id FROM `h_admin` where h_userName = '$chkUserName' and h_passWord = '$chkPassWord'");
		if($tempRs)
		{
			$tmp = 1;
		}
	}
	return $tmp;
}

function get_db_table_field_value($field,$table,$where)
{
	global $db;
	$temp = '';
	
	$rs = $db->get_one("SELECT $field FROM `$table` where $where LIMIT 1");
	if($rs)
	{
		$temp = $rs[$field];
	}
	
	return $temp;
}

function create_payId_from_order($oid){
	global $db;
	
	//商品订单
	$rsO = $db->get_one("SELECT * FROM `h_order` where h_orderId = '{$oid}' LIMIT 1");
	if(!$rsO){
		return '';
	}
	if($rsO['h_isPay']){
		return '';
	}
	
	$payId = date('YmdHis') . rndNum(3);
	
	$now = date('Y-m-d H:i:s');

	$sql = "insert into `h_pay_order` set h_payId = '{$payId}',h_orderId = '{$oid}',h_payWay = '微信',h_payType = 'JsApiPay',h_payPrice = '{$rsO['h_orderPrice']}',h_addTime = '{$now}'";
	$db->query($sql);
	
	return $payId;
}

function update_order_paid($payId){
	global $db;
	
	//支付数据
	$rsP = $db->get_one("SELECT * FROM `h_pay_order` where h_payId = '{$payId}' LIMIT 1");
	if(!$rsP){
		return false;
	}
	if($rsP['h_payState'] == '已支付'){
		return false;
	}
	
	//商品订单
	$rsO = $db->get_one("SELECT * FROM `h_order` where h_orderId = '{$rsP['h_orderId']}' LIMIT 1");
	if(!$rsO){
		return false;
	}
	if($rsO['h_isPay']){
		return false;
	}
	
	//买家
	$rsU = $db->get_one("SELECT * FROM `h_member` where h_userName = '{$rsO['h_userName']}' LIMIT 1");
	if(!$rsU){
		return false;
	}
	
	$now = date('Y-m-d H:i:s');
	
	//更新 支付数据
	$sql = "update `h_pay_order` set h_payState = '已支付',h_payTime = '{$now}' where h_payId = '{$payId}'";
	$db->query($sql);
	
	//更新商品订单
	$sql = "update `h_order` set h_isPay = '1',h_payOrderId = '{$payId}',h_payTime = '{$now}' where h_orderId = '{$rsP['h_orderId']}'";
	$db->query($sql);
	
	//分销钱给上家
	if(strlen($rsU['h_parentDianNum']) > 0){
		$rsD = $db->get_one("SELECT * FROM `h_member` where h_dianNum = '{$rsU['h_parentDianNum']}' LIMIT 1");
		if(!$rsD){
			return true;
		}
		
		$sql = "update `h_member` set h_tc = h_tc + '{$rsO['h_tc1']}' where h_dianNum = '{$rsU['h_parentDianNum']}'";
		$db->query($sql);
		
		$sql = "insert into `h_money_log` set h_userName = '{$rsD['h_userName']}',h_price = '{$rsO['h_tc1']}',h_addTime = '{$now}',h_about = '会员 {$rsU['h_userName']} 购买商品 {$rsO['h_goodsTitle']}'";
		$db->query($sql);
	}
	
	return true;
}
?>