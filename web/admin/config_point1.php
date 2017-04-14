<?php
require_once 'header.php';

switch($clause)
{
	case "saveeditinfo":
		saveeditinfo();
		break;
	default:
		editinfo();
		break;
}

function saveeditinfo()
{
	global $h_point1Member,$h_point1MemberPoint2;
	global $db;
	
	$h_keyword = replace($h_keyword,"\r\n",'');
	$h_description = replace($h_description,"\r\n",'');

	$query = "update `h_config` SET
			  h_point1Member = '$h_point1Member',
			   h_point1MemberPoint2 = '$h_point1MemberPoint2'
			  ";
			   
	$db->query($query);
	
	HintAndTurn('配置修改成功！',"?");
}



function editinfo()
{
	global $db;
	global $ckeditor_mc_id,$ckeditor_mc_val,$ckeditor_mc_lang,$ckeditor_mc_toolbar,$ckeditor_mc_height;
	$rs = $db->get_one("SELECT * FROM `h_config`");
	if(!$rs)
	{
		//
	}
	else
	{
?>
<form action="?clause=saveeditinfo" method="post" name="addinfo">
  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
    <tr>
      <td height="25" colspan="2" align="center" class="tdtitle">激活会员配置</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td width="15%" align="center">激活会员</td>
      <td>需要 <input name="h_point1Member" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_point1Member']; ?>" /> KK</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">被激活会员</td>
      <td>赠送 <input name="h_point1MemberPoint2" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_point1MemberPoint2']; ?>" /> KK</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center" colspan="2"><input type="submit" name="Submit" value=" 保存 " class="bttn"></td>
    </tr>
  </table>
</form>

<?php
	}
}

footer();
?>