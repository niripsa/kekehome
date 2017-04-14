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
	global $actPwd,$num;
	
	if($actPwd != CC_ACT_PWD){
		HintAndBack("操作密码错误！",1);
	}
	
	$num = intval($num);
	if($num == 0){
		HintAndBack("天数不可以是0！",1);
	}
	
	//
	$sql = "update `h_member_farm` set ";
	$sql .= "h_addTime = timestampadd(day, {$num}, h_addTime) ";
	$sql .= ",h_endTime = timestampadd(day, {$num}, h_endTime) ";
	$sql .= ",h_lastSettleTime = NULL ";
	$db->query($sql);
	
	/*
	$sql = "update `h_member_farm` set ";
	$sql .= "h_lastSettleTime = timestampadd(day, {$num}, h_lastSettleTime) ";
	$sql .= "where not h_lastSettleTime is null ";
	$db->query($sql);
	*/
	
	okinfo('?','调整成功！');
}

function addinfo()
{
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">调整时间</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">说明</td>
    <td>由于庄园的动物是每天生产一次KK。为了测试系统，必须跟踪好几天时间方能测试出结果。<br />
本工具可以使：会员购买的宠物，其购买时间往前或往后增加天数。<br />
请在调整时间后，重新在前台登录需要查看KK产生情况的会员帐号！（也可以在本后台的“会员宠物列表”中点结算！）<br />
<span style="color:#ff0000">注意：本工具仅可用于测试，在网站正式运营的情况下不允许使用！</span></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">KK数值</td>
    <td>
		购买宠物的时间 加 <input name="num" type="text" class="inputclass1" maxlength="3" value="-3" /> 天 （后退请填写负数，一般是填写负数才对哦）
    <font color="#ff0000">*</font> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">操作密码</td>
    <td><input name="actPwd" type="password" class="inputclass1" maxlength="20" value="" /> （危险操作，需要操作密码）
    <font color="#ff0000">*</font> </td>
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