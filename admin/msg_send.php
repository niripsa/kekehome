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
	global $h_toUserName,$h_info;
	
	$h_price = intval($h_price);
	
	if($h_toUserName == ''){HintAndBack("会员编号不能为空！",1);}
	
	if($h_toUserName != '[所有会员]'){
		$rs = $db->get_one("SELECT * FROM `h_member` where h_userName = '" . $h_toUserName . "'");
		if(!$rs)
		{
			hintAndBack('未找到该会员，请检查!',1);
		}
	}
	
	$sql = "insert into `h_member_msg` set ";
	$sql .= "h_userName = '[管理员]', ";
	$sql .= "h_toUserName = '" . $h_toUserName . "', ";
	$sql .= "h_info = '" . $h_info . "', ";
	$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
	$sql .= "h_actIP = '" . getUserIP() . "' ";
	$db->query($sql);
	
	okinfo('log4.php','发送成功！');
}

function addinfo()
{
	global $toUserName;
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">发送消息给会员</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">会员编号</td>
    <td><input name="h_toUserName" id="h_toUserName" type="text" class="inputclass1" maxlength="50" value="<?php echo $toUserName;?>" /> 
    <font color="#ff0000">*</font>
    [<a href="javascript:void(0)" onclick="document.getElementById('h_toUserName').value='[所有会员]'">所有会员</a>]
    [<a href="javascript:void(0)" onclick="document.getElementById('h_toUserName').value=''">清空</a>]
    </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">说明</td>
    <td><textarea class="textareaclass6" name="h_info"></textarea></td>
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