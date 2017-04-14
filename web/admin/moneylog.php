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
	case "unvipinfo":
		unvipinfo();
		break;
	case "vipinfo":
		vipinfo();
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
	global $db,$id,$userName,$passWord,$nickName,$isPass;
	
	if($userName == ''){HintAndBack("帐号不能为空！",1);}
	if($nickName == ''){HintAndBack("昵称不能为空！",1);}
	if($passWord == ''){HintAndBack("密码不能为空！",1);}

	$passWord = md5($passWord);
	$passWord = "h_passWord = '$passWord',";	
	
	$query = "insert into `h_money_log` SET 
			  h_userName = '$userName',
			  $passWord
			  h_nickName = '$nickName',
			  h_isPass = $isPass";

	$db->query($query);
	
	okinfo('?','管理员添加成功！');
}


function editinfo()
{
	global $db,$id,$LoginEdUserName;

	$rs = $db->get_one("SELECT * FROM `h_money_log` where id = $id");
	if(!$rs)
	{
		hintAndBack('未找到该管理员!',1);
	}
	else
	{
?>
<form action="?clause=saveeditinfo&id=<?php echo $id; ?>" method="post" name="editinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">修改会员</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">会员帐号</td>
    <td><?php echo $rs[h_userName]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">登录密码</td>
    <td><input name="passWord" type="passWord" class="inputclass2" maxlength="25" value="" /> 
    <font color="#ff0000">不修改请放空</font> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">姓名</td>
    <td><input name="nickName" type="text" class="inputclass2" maxlength="25" value="<?php echo $rs[h_fullName]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">手机号码</td>
    <td><input name="h_mobile" type="text" class="inputclass2" maxlength="25" value="<?php echo $rs[h_mobile]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">状态</td>
    <td><select name="isPass">
      <option value="0" <?php if($rs[h_isPass] == 0) echo 'selected'; ?>>锁定，不可登录</option>
	  <option value="1" <?php if($rs[h_isPass] == 1) echo 'selected'; ?>>正常，可登录</option>
    </select></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">VIP</td>
    <td><select name="h_isVIP">
      <option value="0" <?php if($rs[h_isVIP] == 0) echo 'selected'; ?>>否</option>
	  <option value="1" <?php if($rs[h_isVIP] == 1) echo 'selected'; ?>>是VIP</option>
    </select></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">专卖店</td>
    <td><select name="h_isDian">
      <option value="0" <?php if($rs[h_isDian] == 0) echo 'selected'; ?>>否</option>
	  <option value="1" <?php if($rs[h_isDian] == 1) echo 'selected'; ?>>是专卖店</option>
    </select> 店号：<input name="h_dianNum" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_dianNum]; ?>" /></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">提成余额</td>
    <td><input name="h_tc" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_tc]; ?>" /></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">所属专卖店</td>
    <td><input name="h_parentDianNum" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_parentDianNum]; ?>" /></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center" colspan="2"><input type="submit" name="Submit" value=" 确定修改 " class="bttn">&nbsp;&nbsp;<input name="button" type="button" value=" 返回 " class="bttn" onClick="javascript:history.go(-1);"></td>
  </tr>
</table>
</form>
<?php
	}
}


function addinfo()
{
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">添加管理员</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">管理员帐号</td>
    <td><input name="userName" type="text" class="inputclass2" maxlength="25" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">管理员密码</td>
    <td><input name="passWord" type="passWord" class="inputclass2" maxlength="25" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">管理员昵称</td>
    <td><input name="nickName" type="text" class="inputclass2" maxlength="25" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">管理员状态</td>
    <td><select name="isPass">
      <option value="0">锁定，不可登录</option>
	  <option value="1" selected>正常，可登录</option>
    </select>
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center" colspan="2"><input type="submit" name="Submit" value=" 确定添加 " class="bttn">&nbsp;&nbsp;<input name="button" type="button" value=" 返回 " class="bttn" onClick="javascript:history.go(-1);"></td>
  </tr>
</table>
</form>
<?php
}

function main()
{
	global $db,$LoginEdUserName;
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_money_log`", "", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link('?page=');
	$query = "select * from `h_money_log` order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	//$query = "Select * from `h_money_log` order by h_addTime desc";
	//$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="11" align="center" class="tdtitle">提成记录</td>
  </tr>
  <tr align="center"> 
    <td height="23" class="tdtitle-title">会员帐号</td>
    <td class="tdtitle-title">提成金额</td>
    <td class="tdtitle-title">提成说明</td>
    <td class="tdtitle-title">提成时间</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr align="center" class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
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
	return;
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr> 
    <td height="25" class="tdtitle" align="center">相关操作</td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center"><a href="?clause=addinfo">添加管理员</a> | <a href="?">管理员管理</a></td>
  </tr>
</table>
<br />
<?php
}



function saveeditinfo()
{
	global $db,$id,$userName,$passWord,$nickName,$isPass;
	global $h_mobile,$h_isVIP,$h_isDian,$h_tc,$h_parentDianNum;
	global $h_dianNum;
	
	//if($userName == ''){HintAndBack("帐号不能为空！",1);}
	if($nickName == ''){HintAndBack("姓名不能为空！",1);}

	if($passWord != '')
	{
		$passWord = md5($passWord);
		$passWord = "h_passWord = '$passWord',";
	}
	$query = "update `h_money_log` SET 
			  $passWord
			  h_fullName = '$nickName',
			  h_mobile = '$h_mobile',
			  h_isVIP = '$h_isVIP',
			  h_isDian = '$h_isDian',
			  h_dianNum = '$h_dianNum',
			  h_tc = '$h_tc',
			   h_parentDianNum = '$h_parentDianNum',
			  h_isPass = $isPass
			  where id = $id";

	$db->query($query);
	
	okinfo('?','管理员修改成功！');
}

function unvipinfo()
{
	global $db,$id;

	$query = "update `h_money_log` set h_isVIP = 1 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}

function vipinfo()
{
	global $db,$id;

	$query = "update `h_money_log` set h_isVIP = 0 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


function unlockinfo()
{
	global $db,$id;

	$query = "update `h_money_log` set h_isPass = 1 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}

function lockinfo()
{
	global $db,$id;

	$query = "update `h_money_log` set h_isPass = 0 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


function delinfo()
{
	global $db,$id;

	$query = "delete from `h_money_log` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>