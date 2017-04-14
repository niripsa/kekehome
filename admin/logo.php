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
	global $h_webLogo,$h_webLogoLogin;
	global $db;

	$query = "update `h_config` SET
			  h_webLogo = '$h_webLogo',
			  h_webLogoLogin = '$h_webLogoLogin'";
			   
	$db->query($query);
	
	HintAndTurn('修改成功！',"?");
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
      <td height="25" colspan="2" align="center" class="tdtitle">网站Logo</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td width="15%" align="center">当前平台Logo</td>
      <td><img src="<?php echo $rs['h_webLogo']; ?>" height="61" /></td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">平台Logo</td>
      <td><input name="h_webLogo" type="text" class="inputclass2" maxlength="50" value="<?php echo $rs['h_webLogo']; ?>" />
          <font color="#ff0000">*</font> 
          [<a style="cursor:pointer;" onClick="AdminUpLoadFile('h_picBig');"><font color="#ff0000">上传图片</font></a>] 规格：338×61</td>
    </tr>
    
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">当前登录Logo</td>
      <td><img src="<?php echo $rs['h_webLogoLogin']; ?>" height="80" /></td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">登录Logo</td>
      <td><input name="h_webLogoLogin" type="text" class="inputclass2" maxlength="50" value="<?php echo $rs['h_webLogoLogin']; ?>" />
          <font color="#ff0000">*</font> 
          [<a style="cursor:pointer;" onClick="AdminUpLoadFile('h_webLogoLogin');"><font color="#ff0000">上传图片</font></a>] 规格：260×80</td>
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