<?php
require_once 'header.php';

require_once '../include/pager.php';

switch($clause)
{
	case "delinfo":
		delinfo();
		break;
	default:
		menu();
		main();
		break;
}


function main()
{
	global $db,$LoginEdUserName;
	
	global $stype,$keyword;
	$where = "";
	if(strlen($keyword) > 0){
		$where .= " and (h_userName like '%{$keyword}%' or h_buyUserName like '%{$keyword}%')";
	}
	if(strlen($stype) > 0){
		$where .= " and h_state = '{$stype}'";
	}
	/*
	switch($stype){
		case '激活币转账':
		case '激活玩家':
			$where .= " and h_type = '{$stype}'";
			break;
		case '激活币转账(入)':
			$where .= " and h_type = '激活币转账' and h_price > 0";
			break;
		case '激活币转账(出)':
			$where .= " and h_type = '激活币转账' and h_price < 0";
			break;
	}
	*/
	
	$linkUrl = '?stype=' . urlencode($stype) . '&keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_point2_sell`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select * from `h_point2_sell` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	//$query = "Select * from `h_money_log` order by h_addTime desc";
	//$result = $db->query($query);
	$rs_list = array();
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="11" align="center" class="tdtitle">KK拍卖列表</td>
  </tr>
  <tr align="center"> 
    <td class="tdtitle-title">拍卖信息</td>
    <td height="23" class="tdtitle-title">状态</td>
    <td class="tdtitle-title">买家信息</td>
    <td class="tdtitle-title">卖家确认时间</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25">卖家：<?php echo $val['h_userName']; ?><br />
    拍卖KK：<?php echo $val['h_money']; ?><br />
    支付宝帐号：<?php echo $val['h_alipayUserName']; ?><br />
    支付宝户名：<?php echo $val['h_alipayFullName']; ?><br />
    微信：<?php echo $val['h_weixin']; ?><br />
    电话：<?php echo $val['h_tel']; ?><br />
    发布时间：<?php echo $val['h_addTime']; ?><br /></td>
    <td align="center"><?php echo $val['h_state']; ?></td>
    <td>
    <?php if(strlen($val['h_buyUserName']) > 0){
        echo '买家：' , $val['h_buyUserName'] , '<br />';
        echo '拍下时间：' , $val['h_buyTime'] , '<br />';
        echo '拍下距离现在：' , timediffStr(strtotime($val['h_buyTime']),time()) , '<br />';
        echo '支付状态：' , $val['h_buyIsPay'] ? '<span style="color:#0000ff">已付款</span>' : '<span style="color:#ff0000">未付款</span>' , '<br />';
		if($val['h_buyIsPay']){
        	echo '支付时间：' , $val['h_payTime'] , '<br />';
			echo '支付距离现在：' , timediffStr(strtotime($val['h_payTime']),time()) , '<br />';
		}
    }else{
    	echo '-';
    }
    ?>
    </td>
    <td align="center"><?php
	echo $val['h_confirmTime'] , '<br />';
	?></td>
    <td align="center">
	<a style="cursor:pointer;" onClick="javascript:hintandturn('确定要删除吗？数据将不可恢复！','?clause=delinfo&id=<?php echo $val['id']; ?>',true);">删除</a></td>
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
<option value="挂单中" <?php if($stype == '挂单中'){echo "selected";}?>>挂单中</option>
<option value="等待买家付款" <?php if($stype == '等待买家付款'){echo "selected";}?>>等待买家付款</option>
<option value="买家放弃" <?php if($stype == '买家放弃'){echo "selected";}?>>买家放弃</option>
<option value="卖家放弃" <?php if($stype == '卖家放弃'){echo "selected";}?>>卖家放弃</option>
<option value="等待卖家确认收款" <?php if($stype == '等待卖家确认收款'){echo "selected";}?>>等待卖家确认收款</option>
<option value="交易完成" <?php if($stype == '交易完成'){echo "selected";}?>>交易完成</option>
</select>
<input name="keyword" placeholder="买家或卖家编号" value="<?php echo $keyword;?>" type="text" />
<input type="submit" class="bttn" value="提交搜索" name="Submit">
</form>
    </td>
  </tr>
</table>
<br />
<?php
}



function delinfo()
{
	global $db,$id;

	$query = "delete from `h_point2_sell` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>