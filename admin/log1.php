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
	
	global $keyword;
	if(strlen($keyword) > 0){
		$where = " and h_userName like '%{$keyword}%'";
	}
	
	$linkUrl = '?keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_log_login_member`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select * from `h_log_login_member` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
    <td height="25" colspan="11" align="center" class="tdtitle">会员登录记录</td>
  </tr>
  <tr align="center"> 
    <td height="23" class="tdtitle-title">会员帐号</td>
    <td class="tdtitle-title">登录时间</td>
    <td class="tdtitle-title">登录IP</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr align="center" class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25"><?php echo $val['h_userName']; ?></td>
    <td height="25"><?php echo $val['h_addTime']; ?></td>
    <td height="25"><?php echo $val['h_ip']; ?></td>
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
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr> 
    <td height="25" class="tdtitle" align="center">相关操作</td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center">
<form action="" method="get">
搜索：<input name="keyword" value="<?php echo $_GET['keyword'];?>" type="text" />
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

	$query = "delete from `h_log_login_member` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>