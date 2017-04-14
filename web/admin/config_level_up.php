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
	global $h_levelUpTo0,$h_levelUpTo1,$h_levelUpTo2,$h_levelUpTo3,$h_levelUpTo4;
	global $db;
	
	$h_keyword = replace($h_keyword,"\r\n",'');
	$h_description = replace($h_description,"\r\n",'');

	$query = "update `h_config` SET
				h_levelUpTo0 = '$h_levelUpTo0',
			  h_levelUpTo1 = '$h_levelUpTo1',
			  h_levelUpTo2 = '$h_levelUpTo2',
			  h_levelUpTo3 = '$h_levelUpTo3',
			  h_levelUpTo4 = '$h_levelUpTo4'
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
      <td height="25" colspan="2" align="center" class="tdtitle">直荐升级配置</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td width="15%" align="center">VIP</td>
      <td>需要推荐 <input name="h_levelUpTo0" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_levelUpTo0'] ; ?>" /> 个激活的会员 （VIP只能填写0，注册后默认是VIP）</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">VIP1</td>
      <td>需要推荐 <input name="h_levelUpTo1" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_levelUpTo1'] ; ?>" /> 个激活的会员</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">VIP2</td>
      <td>需要推荐 <input name="h_levelUpTo2" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_levelUpTo2'] ; ?>" /> 个激活的会员</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">VIP3</td>
      <td>需要推荐 <input name="h_levelUpTo3" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_levelUpTo3'] ; ?>" /> 个激活的会员</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">VIP4</td>
      <td>需要推荐 <input name="h_levelUpTo4" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_levelUpTo4'] ; ?>" /> 个激活的会员</td>
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