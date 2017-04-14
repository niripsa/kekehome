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
	global $h_userName,$h_price,$h_about;
	
	$h_price = intval($h_price);
	
	if($h_userName == ''){HintAndBack("会员编号不能为空！",1);}
	if($h_price == 0){HintAndBack("数值不能为0！",1);}
	
	$rs = $db->get_one("SELECT * FROM `h_member` where h_userName = '" . $h_userName . "'");
	if(!$rs)
	{
		hintAndBack('未找到该会员，请检查!',1);
	}
	
	//
	$sql = "update `h_member` set ";
	$sql .= "h_point1 = h_point1 + ({$h_price}) ";
	$sql .= "where h_userName = '" . $h_userName . "' ";
	$db->query($sql);
	
	//
	$sql = "insert into `h_log_point1` set ";
	$sql .= "h_userName = '" . $h_userName . "', ";
	$sql .= "h_price = '" . $h_price . "', ";
	$sql .= "h_type = '管理员操作', ";
	$sql .= "h_about = '" . $h_about . "', ";
	$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
	$sql .= "h_actIP = '" . getUserIP() . "' ";
	$db->query($sql);
	
	okinfo('log2.php','提交成功！');
}

function addinfo()
{
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">加减激活币</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">会员编号</td>
    <td><input name="h_userName" type="text" class="inputclass1" maxlength="50" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">种子数值</td>
    <td><input name="h_price" type="text" class="inputclass1" maxlength="25" value="" />
    <font color="#ff0000">*</font> 若扣除请填写负数</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">说明</td>
    <td><input name="h_about" type="text" class="inputclass2" maxlength="250" value="" /> </td>
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