<?php
require_once 'header.php';

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

function qx($rs){
	global $qxArr;
	
	$qx = '';
	if(is_array($rs)){
		if(count($rs) > 0){
			$qx = $rs['h_permissions'];
		}
	}else{
		$qx = $rs;
	}
	
	echo '  <tr class="tdbottom" onMouseOver="javascript:this.className=\'tdbottomover\';" onMouseOut="javascript:this.className=\'tdbottom\';">
    <td align="center">权限</td>
    <td>';

$ck = 0;
foreach($qxArr as $key=>$arr){
	$ck++;
	
	echo '<table width="95%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="20%" height="20"><span style="font-weight: bold">' , $key , '</span></td>
		<td width="20%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
	  </tr>';
	  
	 echo '<tr>';
	 $ci = 0;
	 foreach($arr as $key1=>$val1){
		if($ci % 4 == 0 && $ci > 0){
			echo '</tr><tr>';
		}
		
	 	echo '<td height="20" align="left" width="25%"><input id="h_permissions_' . $ck . '_' . $ci . '" type="checkbox" name="h_permissions[]" value="' , $key1 , '"';
		if(stripos($qx,',' . $key1 . ',') !== false){
			echo ' checked';
		}
		echo '><label for="h_permissions_' . $ck . '_' . $ci . '">' , $key1 , '</label></td>';
		
		$ci++;
	 }
	 if($ci % 4 > 0){
	 	for($cj = ($ci % 4);$cj <= 4;$cj++){
			echo '<td height="20" align="left" width="25%">&nbsp;</td>';
		}
	 }
	 echo '</tr>';
	  
	 echo '</table>';
}
	
	echo '</td>
  </tr>';
}

function saveinfo()
{
	global $db,$id,$userName,$passWord,$nickName,$isPass;
	
	if($userName == ''){HintAndBack("帐号不能为空！",1);}
	if($nickName == ''){HintAndBack("昵称不能为空！",1);}
	if($passWord == ''){HintAndBack("密码不能为空！",1);}

	$passWord = md5($passWord);
	$passWord = "h_passWord = '$passWord',";
	
	$h_permissions = $_POST['h_permissions'];
	$h_permissions = ',' . implode(',',$h_permissions) . ',';
	
	$query = "insert into `h_admin` SET 
			  h_userName = '$userName',
			  $passWord
			  h_nickName = '$nickName',
			  h_permissions = '$h_permissions',
			  h_isPass = $isPass";

	$db->query($query);
	
	okinfo('?','管理员添加成功！');
}


function editinfo()
{
	global $db,$id,$LoginEdUserName;

	$rs = $db->get_one("SELECT * FROM `h_admin` where id = $id");
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
    <td height="25" colspan="2" align="center" class="tdtitle">修改管理员</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">管理员帐号</td>
    <td><input name="userName" type="text" class="inputclass2" maxlength="25" value="<?php echo $rs[h_userName]; ?>" /> <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">管理员密码</td>
    <td><input name="passWord" type="passWord" class="inputclass2" maxlength="25" value="" /> 
    <font color="#ff0000">不修改请放空</font> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">管理员昵称</td>
    <td><input name="nickName" type="text" class="inputclass2" maxlength="25" value="<?php echo $rs[h_nickName]; ?>" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">管理员状态</td>
    <td><?php if($rs[h_userName] == $LoginEdUserName)
	{
		echo '√正常<input name="isPass" type="hidden" value="1" />';
	}
	else
	{
		?><select name="isPass">
      <option value="0" <?php if($rs[h_isPass] == 0) echo 'selected'; ?>>锁定，不可登录</option>
	  <option value="1" <?php if($rs[h_isPass] == 1) echo 'selected'; ?>>正常，可登录</option>
    </select>
    <font color="#ff0000">*</font><?php
	}?></td>
  </tr>
  <?php
  qx($rs);
  ?>
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
  <?php
  qx(array());
  ?>
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
	$query = "Select * from `h_admin` order by h_addTime desc";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="6" align="center" class="tdtitle">所有管理员</td>
  </tr>
  <tr align="center"> 
    <td height="23" class="tdtitle-title">帐号</td>
    <td width="25%" class="tdtitle-title">昵称</td>
    <td width="15%" class="tdtitle-title">状态</td>
    <td width="15%" class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr align="center" class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25"><?php echo $val[h_userName]; ?></td>
    <td><?php echo $val[h_nickName]; ?></td>
    <td><?php if($val[h_isPass] == 1)
		{
			if($val[h_userName] == $LoginEdUserName)
			{
				echo '√正常';
			}
			else
			{
				echo '<a href="?clause=lockinfo&id=' . $val[id] . '" style="color#ff0000;">√正常</a>';
			}
		}
		else
		{
			echo '<a href="?clause=unlockinfo&id=' . $val[id] . '">×锁定</a>';
		}?></td>
    <td><a href="?clause=editinfo&id=<?php echo $val[id]; ?>">修改</a> | 
	<a style="cursor:pointer;" onClick="javascript:hintandturn('确定要删除吗？数据将不可恢复！','?clause=delinfo&id=<?php echo $val[id]; ?>',true);">删除</a></td>
  </tr>
<?php
}
?>
</table>
<?php
}



function menu()
{
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
	
	if($userName == ''){HintAndBack("帐号不能为空！",1);}
	if($nickName == ''){HintAndBack("昵称不能为空！",1);}

	if($passWord != '')
	{
		$passWord = md5($passWord);
		$passWord = "h_passWord = '$passWord',";
	}
	
	$h_permissions = $_POST['h_permissions'];
	$h_permissions = ',' . implode(',',$h_permissions) . ',';
	
	$query = "update `h_admin` SET 
			  h_userName = '$userName',
			  $passWord
			  h_nickName = '$nickName',
			  h_permissions = '$h_permissions',
			  h_isPass = $isPass
			  where id = $id";

	$db->query($query);
	
	okinfo('?','管理员修改成功！');
}


function unlockinfo()
{
	global $db,$id;

	$query = "update `h_admin` set h_isPass = 1 where id = $id";
	$db->query($query);
	
	okinfo('?','该管理员审核成功！');
}

function lockinfo()
{
	global $db,$id;

	$query = "update `h_admin` set h_isPass = 0 where id = $id";
	$db->query($query);
	
	okinfo('?','该管理员锁定成功！');
}


function delinfo()
{
	global $db,$id;

	$query = "delete from `h_admin` where id = $id";
	$db->query($query);
	
	okinfo('?','管理员删除成功！');
}


footer();
?>