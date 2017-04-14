<?php
require_once 'header.php';

require_once '../include/pager.php';

switch($clause)
{
	case "addinfo":
		menu();
		addinfo();
		break;
	case "saveinfo":
		saveinfo();
		break;
	case "editinfo":
		menu();
		editinfo();
		break;
	case "saveeditinfo":
		saveeditinfo();
		break;
	case "unlockinfo":
		unlockinfo();
		break;
	case "lockinfo":
		lockinfo();
		break;
	case "delinfo":
		delinfo();
		break;
	default:
		menu();
		main();
		break;
}

function saveinfo()
{
	global $db,$id,$h_state,$h_reply;
	
	$query = "update `h_member_shop_order` SET h_state = '$h_state',h_reply = '$h_reply' where id = $id";
	$db->query($query);
	
	if($h_state == '拒绝发货'){
		$rs = $db->get_one("SELECT * FROM `h_member_shop_order` where id = $id");
		if($rs){
			if($rs['h_isReturn'] == 0){
				$num = $rs['h_money'];
				
				//返款
				$sql = "update `h_member` set ";
				$sql .= "h_point2 = h_point2 + {$num} ";
				$sql .= "where h_userName = '" . $rs['h_userName'] . "' ";
				$db->query($sql);
				
				//记录扣钱
				$sql = "insert into `h_log_point2` set ";
				$sql .= "h_userName = '" . $rs['h_userName'] . "', ";
				$sql .= "h_price = '" . $num . "', ";
				$sql .= "h_type = '商城购物', ";
				$sql .= "h_about = '订单失败，原因：{$h_reply}', ";
				$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
				$sql .= "h_actIP = '" . getUserIP() . "' ";
				$db->query($sql);
		
				$query = "update `h_member_shop_order` SET h_isReturn = '1' where id = $id";
				$db->query($query);
			}
		}
	}
	
	FJS_PAC('保存成功');
}


function main()
{
	global $db,$LoginEdUserName;
	
	global $stype,$keyword;
	$where = "";
	if(strlen($keyword) > 0){
		$where .= " and (h_userName like '%{$keyword}%')";
	}
	if(strlen($stype) > 0){
		$where .= " and h_state = '{$stype}'";
	}
	
	$linkUrl = '?stype=' . urlencode($stype) . '&keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_member_shop_order`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select * from `h_member_shop_order` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	//$query = "Select * from `h_member_shop_order` order by h_addTime desc";
	//$result = $db->query($query);
	$rs_list = array();
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
?>
<iframe style="display: none" name="iframe_qpost" id="iframe_qpost"></iframe>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="11" align="center" class="tdtitle">商城订单列表</td>
  </tr>
  <tr align="center"> 
    <td height="23" class="tdtitle-title">订单</td>
    <td class="tdtitle-title">商品</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$rs)
{
?>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
		<td>订单号：<?php echo $rs['h_oid']; ?><br />
会员：<?php echo $rs['h_userName']; ?><br />
订单总额：<?php echo $rs['h_money']; ?>元<br />
下单时间：<?php echo $rs['h_addTime']; ?><br />
<form action="?clause=saveinfo&id=<?php echo $rs['id']; ?>" method="post" name="addinfo" target="iframe_qpost">
<select name="h_state">
<option value="待发货" <?php if($rs['h_state'] == '待发货'){echo 'selected';} ?>>待发货</option>
<option value="已发货" <?php if($rs['h_state'] == '已发货'){echo 'selected';} ?>>已发货</option>
<option value="拒绝发货" <?php if($rs['h_state'] == '拒绝发货'){echo 'selected';} ?>>拒绝发货（还款）</option>
</select>
<input name="h_reply" size="30" value="<?php echo $rs['h_reply']; ?>" placeholder="回复或快递单号信息，250个字以内" type="text" />
<input name="" type="submit" value="提交" />
</form>
<?php if($rs['h_isReturn']){echo '<span style="color:#ff0000">注意：该订单已经打还KK给会员！</span>';} ?>
</td>
		<td>
<?php
$query1 = "select * from `h_member_shop_cart` where h_oid = '{$rs['h_oid']}' order by h_addTime desc,id desc";
$result1 = $db->query($query1);
$cj = 0;
while($rs1 = $db->fetch_array($result1))
{
	$cj++;
	echo $cj , '、' , $rs1['h_title'] , '×' , $rs1['h_num'] , '<br />';
}

echo '<span style="color:#ff0000">地址：</span>' , $rs['h_addrAddress'] , '<br />邮编：' , $rs['h_addrPostcode'] , '<br />收货人：' ,$rs['h_addrFullName'] , '（' , $rs['h_addrTel'] , '）';
?>
        </td>
    <td align="center"><!--<a href="?clause=editinfo&id=<?php echo $rs[id]; ?>">修改</a> | -->
	<a style="cursor:pointer;" onClick="javascript:hintandturn('确定要删除吗？数据将不可恢复！','?clause=delinfo&id=<?php echo $rs['id']; ?>',true);">删除</a></td>
  </tr>
<?php
}
?>
</table>
<?php
	if(count($rs_list) > 0) echo "<div style='text-align:center;'>$page_list</div>";
}



function menu()
{
	global $stype,$keyword;
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr> 
    <td height="25" class="tdtitle" align="center">相关操作</td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center">
<form action="" method="get">
搜索：
<select name="stype">
<option value="">-=状态=-</option>
<option value="待发货" <?php if($stype == '待发货'){echo "selected";}?>>待发货</option>
<option value="已发货" <?php if($stype == '已发货'){echo "selected";}?>>已发货</option>
<option value="拒绝发货" <?php if($stype == '拒绝发货'){echo "selected";}?>>拒绝发货</option>
</select>
<input name="keyword" placeholder="会员编号" value="<?php echo $keyword;?>" type="text" />
<input type="submit" class="bttn" value="提交搜索" name="Submit">
</form>
    </td>
  </tr>
</table>
<br />
<?php
}




function unlockinfo()
{
	global $db,$id;

	$query = "update `h_member_shop_order` set h_isPay = 1 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}

function lockinfo()
{
	global $db,$id;

	$query = "update `h_member_shop_order` set h_isPay = 0 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


function delinfo()
{
	global $db,$id;

	$query = "delete from `h_member_shop_order` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>