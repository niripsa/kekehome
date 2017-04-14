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
			case '激活币转账(入)':
				$where .= " and h_type = '激活币转账' and h_price > 0";
				break;
			case '激活币转账(出)':
				$where .= " and h_type = '激活币转账' and h_price < 0";
				break;
			default:
				$where .= " and h_type = '{$stype}'";
				break;
		}
	}
	
	$linkUrl = '?stype=' . urlencode($stype) . '&keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_log_point1`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select * from `h_log_point1` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
    <td height="25" colspan="11" align="center" class="tdtitle">激活币流水明细</td>
  </tr>
  <tr align="center"> 
    <td class="tdtitle-title">类型</td>
    <td height="23" class="tdtitle-title">会员帐号</td>
    <td class="tdtitle-title">激活币</td>
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
<option value="激活币转账" <?php if($stype == '激活币转账'){echo "selected";}?>>激活币转账</option>
<option value="激活币转账(入)" <?php if($stype == '激活币转账(入)'){echo "selected";}?>>激活币转账(入)</option>
<option value="激活币转账(出)" <?php if($stype == '激活币转账(出)'){echo "selected";}?>>激活币转账(出)</option>
<option value="激活玩家" <?php if($stype == '激活玩家'){echo "selected";}?>>激活玩家</option>
<option value="管理员操作" <?php if($stype == '管理员操作'){echo "selected";}?>>管理员操作</option>
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

	$query = "delete from `h_log_point1` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>