<?php
require_once 'header.php';

require_once '../include/pager.php';

switch($clause)
{
	case "saveinfo":
		saveinfo();
		break;
	default:
		addinfo();
		break;
}


function saveinfo()
{
	global $db,$id;
	global $member,$dbs,$actPwd;
	
	$dbs = $_POST['dbs'];

	if($actPwd != CC_ACT_PWD){
		HintAndBack("操作密码错误！",1);
	}
	
	if($member == 1){
		//清空会员
		$sql = "truncate table `h_member`";
		$db->query($sql);
	}else if($member == 2){
		//不清空会员，重置会员激活币和KK为0
		$sql = "update `h_member` set ";
		$sql .= "h_point1 = 0 ";
		$sql .= ",h_point2 = 0 ";
		$db->query($sql);
	}else{
		//不变
	}
	
	foreach($dbs as $dbName){
		$sql = "truncate table `{$dbName}`";
		$db->query($sql);
	}
	
	okinfo('?','清空成功！');
}

function addinfo()
{
	$dbs = array(
		'h_member'=>'清空会员',
		'h_member_farm'=>'清空会员宠物',
		'h_member_msg'=>'清空会员消息',
		'h_member_shop_order'=>'清空会员购买的商城商品(订单)',
		'h_member_shop_cart'=>'清空会员购买的商城商品(购物车)',
		//'h_pay_order'=>'清空会员支付数据',
		'h_point2_sell'=>'清空会员拍卖KK数据',
		'h_withdraw'=>'清空会员提现申请',
		'h_log_login_member'=>'清空会员登录记录',
		'h_log_point1'=>'清空会员激活币明细记录',
		'h_log_point2'=>'清空会员KK明细记录',
	);
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">清空数据</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">说明</td>
    <td>
<?php
/*
foreach($dbs as $key=>$val){
	echo '<input name="dbs[]" type="checkbox" value="' , $key , '" id="' , $key , '" /><label for="' , $key , '">' , $val , "</label><br />\r\n";
}
*/
?>
<input name="member" type="radio" value="1" id="member1" /><label for="member1">清空会员</label><br />
<input name="member" type="radio" value="2" id="member2" /><label for="member2">不清空会员，重置会员激活币和KK为0</label><br />
<input name="member" type="radio" value="3" id="member3" /><label for="member3">保持会员不动</label><br />
<input name="dbs[]" type="checkbox" value="h_member_farm" id="h_member_farm" /><label for="h_member_farm">清空会员购买的宠物</label><br />
<input name="dbs[]" type="checkbox" value="h_member_msg" id="h_member_msg" /><label for="h_member_msg">清空会员消息</label><br />
<input name="dbs[]" type="checkbox" value="h_member_shop_order" id="h_member_shop_order" /><label for="h_member_shop_order">清空会员购买的商城商品(订单)</label><br />
<input name="dbs[]" type="checkbox" value="h_member_shop_cart" id="h_member_shop_cart" /><label for="h_member_shop_cart">清空会员购买的商城商品(购物车)</label><br />
<input name="dbs[]" type="checkbox" value="h_point2_sell" id="h_point2_sell" /><label for="h_point2_sell">清空会员拍卖KK数据</label><br />
<input name="dbs[]" type="checkbox" value="h_withdraw" id="h_withdraw" /><label for="h_withdraw">清空会员提现申请</label><br />
<input name="dbs[]" type="checkbox" value="h_log_login_member" id="t_log_login_member" /><label for="t_log_login_member">清空会员登录记录</label><br />
<input name="dbs[]" type="checkbox" value="h_log_point1" id="h_log_point1" /><label for="h_log_point1">清空会员激活币明细记录</label><br />
<input name="dbs[]" type="checkbox" value="h_log_point2" id="h_log_point2" /><label for="h_log_point2">清空会员KK明细记录</label><br />
    </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">操作密码</td>
    <td><input name="actPwd" type="password" class="inputclass1" maxlength="20" value="" /> （危险操作，需要操作密码）
    <font color="#ff0000">*</font> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center" colspan="2"><input type="submit" name="Submit" value=" 确定提交 " class="bttn"></td>
  </tr>
</table>
</form>
<?php
}


footer();
?>