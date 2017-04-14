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
		$where .= " and (h_userName like '%{$keyword}%' or h_about like '%{$keyword}%')";
	}
	if(strlen($stype) > 0){
		switch($stype){
			case 'KK转账(入)':
				$where .= " and h_type = 'KK转账' and h_price > 0";
				break;
			case 'KK转账(出)':
				$where .= " and h_type = 'KK转账' and h_price < 0";
				break;
			case '大转盘抽奖(抽奖)':
				$where .= " and h_type = '大转盘抽奖' and h_price < 0";
				break;
			case '大转盘抽奖(中奖)':
				$where .= " and h_type = '大转盘抽奖' and h_price > 0";
				break;
			case '大转盘抽奖(1、2、3等奖)':
				$where .= " and h_type = '大转盘抽奖' and h_price = 0";
				break;
			default:
				$where .= " and h_type = '{$stype}'";
				break;
		}
	}
	
	$linkUrl = '?stype=' . urlencode($stype) . '&keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_log_point2`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select * from `h_log_point2` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
    <td height="25" colspan="11" align="center" class="tdtitle">KK流水明细</td>
  </tr>
  <tr align="center"> 
    <td class="tdtitle-title">类型</td>
    <td height="23" class="tdtitle-title">会员帐号</td>
    <td class="tdtitle-title">KK</td>
    <td class="tdtitle-title">说明</td>
    <td class="tdtitle-title">时间</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr align="center" class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25"><?php echo $val['h_type']; ?></td>
    <td height="25"><?php echo $val['h_userName']; ?></td>
    <td height="25"><?php echo $val['h_price']; ?></td>
    <td height="25"><?php echo $val['h_about']; ?></td>
    <td><?php echo $val['h_addTime']; ?></td>
    <td>
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
<option value="">-=类型=-</option>
<option value="商城购物" <?php if($stype == '商城购物'){echo "selected";}?>>商城购物</option>
<option value="申请提现" <?php if($stype == '申请提现'){echo "selected";}?>>申请提现</option>
<option value="KK拍卖交易完成" <?php if($stype == 'KK拍卖交易完成'){echo "selected";}?>>KK拍卖交易完成</option>
<option value="取消KK购买" <?php if($stype == '取消KK购买'){echo "selected";}?>>取消KK购买</option>
<option value="KK拍卖" <?php if($stype == 'KK拍卖'){echo "selected";}?>>KK拍卖</option>
<option value="购买宠物" <?php if($stype == '购买宠物'){echo "selected";}?>>购买宠物</option>
<option value="宠物产币" <?php if($stype == '宠物产币'){echo "selected";}?>>宠物产币</option>
<option value="宠物收益分红" <?php if($stype == '宠物收益分红'){echo "selected";}?>>宠物收益分红</option>
<option value="直接推荐奖" <?php if($stype == '直接推荐奖'){echo "selected";}?>>直接推荐奖</option>
<option value="直荐激活奖" <?php if($stype == '直荐激活奖'){echo "selected";}?>>直荐激活奖</option>
<option value="KK转账" <?php if($stype == 'KK转账'){echo "selected";}?>>KK转账</option>
<option value="KK转账(入)" <?php if($stype == 'KK转账(入)'){echo "selected";}?>>KK转账(入)</option>
<option value="KK转账(出)" <?php if($stype == 'KK转账(出)'){echo "selected";}?>>KK转账(出)</option>
<option value="大转盘抽奖" <?php if($stype == '大转盘抽奖'){echo "selected";}?>>大转盘抽奖</option>
<option value="大转盘抽奖(抽奖)" <?php if($stype == '大转盘抽奖(抽奖)'){echo "selected";}?>>大转盘抽奖(抽奖)</option>
<option value="大转盘抽奖(中奖)" <?php if($stype == '大转盘抽奖(中奖)'){echo "selected";}?>>大转盘抽奖(中奖)</option>
<option value="大转盘抽奖(1、2、3等奖)" <?php if($stype == '大转盘抽奖(1、2、3等奖)'){echo "selected";}?>>大转盘抽奖(1、2、3等奖)</option>
</select>
<input name="keyword" placeholder="会员帐号或说明" value="<?php echo $keyword;?>" type="text" />
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

	$query = "delete from `h_log_point2` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>