<?php
require_once 'header.php';

require_once '../include/pager.php';

switch($clause)
{
	case "delinfo":
		delinfo();
		break;
	case "readstate":
		readstate();
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
	if(strlen($keyword) > 0){
		// or h_info like '%{$keyword}%'
		$where = " and (h_userName like '%{$keyword}%' or h_toUserName like '%{$keyword}%')";
	}
	switch($stype){
		case '管理员发出':
			$where .= " and h_userName = '[管理员]'";
			break;
		case '管理员收件':
			$where .= " and h_toUserName = '[管理员]'";
			break;
		case '所有会员收件':
			$where .= " and h_toUserName = '[所有会员]'";
			break;
	}
	
	$linkUrl = '?stype=' . urlencode($stype) . '&keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_member_msg`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select * from `h_member_msg` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
    <td height="25" colspan="11" align="center" class="tdtitle">会员消息列表</td>
  </tr>
  <tr align="center"> 
    <td height="23" class="tdtitle-title">会员编号</td>
    <td class="tdtitle-title">内容</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25">发件：<?php echo $val['h_userName']; ?><br />
收件：<?php echo $val['h_toUserName'];
if($val['h_toUserName'] != '[所有会员]'){
	if($val['h_toUserName'] == '[管理员]'){
		echo '<a href="?clause=readstate&id=' , $val['id'] , '">';
	}
	if($val['h_isRead']){
		echo '<span style="color:#888888">(已阅)</span>';
	}else{
		echo '<span style="color:#ff0000">(未阅)</span>';
	}
	if($val['h_toUserName'] == '[管理员]'){
		echo '</a>';
	}
}
?><br />
时间：<?php echo $val['h_addTime']; ?></td>
    <td height="25"><?php echo $val['h_info']; ?></td>
    <td align="center">
    <?php
    if($val['h_userName'] != '[管理员]'){
		if($val['h_toUserName'] == '[管理员]'){
			echo '<a href="msg_send.php?toUserName=' , urlencode($val['h_userName']) , '">回复</a> | ';
		}else{
			//echo '<a href="msg_send.php?toUserName=' , urlencode($val['h_userName']) , '">发消息</a> | ';
		}
	}
	?>
	<a style="cursor:pointer;" onClick="javascript:hintandturn('确定要删除吗？数据将不可恢复！','?clause=delinfo&id=<?php echo $val['id']; ?>',true);">删除</a>
    </td>
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
<option value="管理员发出" <?php if($stype == '管理员发出'){echo "selected";}?>>管理员发出</option>
<option value="管理员收件" <?php if($stype == '管理员收件'){echo "selected";}?>>管理员收件</option>
<option value="所有会员收件" <?php if($stype == '所有会员收件'){echo "selected";}?>>所有会员收件</option>
</select>
<input name="keyword" value="<?php echo $keyword;?>" placeholder="会员编号" type="text" />
<input type="submit" class="bttn" value="提交搜索" name="Submit">
</form>
    </td>
  </tr>
</table>
<br />
<?php
}

function readstate()
{
	global $db,$id;

	$query = "update `h_member_msg` set h_isRead = (not h_isRead) where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}

function delinfo()
{
	global $db,$id;

	$query = "delete from `h_member_msg` where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}


footer();
?>