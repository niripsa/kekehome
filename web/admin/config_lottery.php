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
	global $h_point2Lottery,$h_lottery1,$h_lottery2,$h_lottery3,$h_lottery4,$h_lottery5,$h_lottery6;
	global $db;
	
	$h_withdrawFee = $h_withdrawFee / 100;
	
	$h_keyword = replace($h_keyword,"\r\n",'');
	$h_description = replace($h_description,"\r\n",'');

	$query = "update `h_config` SET
				h_point2Lottery = '$h_point2Lottery',
			  h_lottery1 = '$h_lottery1',
			  h_lottery2 = '$h_lottery2',
			  h_lottery3 = '$h_lottery3',
			  h_lottery4 = '$h_lottery4',
			  h_lottery5 = '$h_lottery5',
			   h_lottery6 = '$h_lottery6'
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
      <td height="25" colspan="2" align="center" class="tdtitle">抽奖配置</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td width="15%" align="center">抽奖扣除</td>
      <td>每一次 <input name="h_point2Lottery" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_point2Lottery']; ?>" /> KK</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">一等奖中奖概率</td>
      <td>万分之 <input name="h_lottery1" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_lottery1']; ?>" /> （iphone6 plus）注意：所有概率加起来应当=万分之万</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">二等奖中奖概率</td>
      <td>万分之 <input name="h_lottery2" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_lottery2']; ?>" /> （TCL么么哒3S）</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">三等奖中奖概率</td>
      <td>万分之 <input name="h_lottery3" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_lottery3']; ?>" /> （男款毛衫）</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">四等奖中奖概率</td>
      <td>万分之 <input name="h_lottery4" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_lottery4']; ?>" /> （20KK）</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">五等奖中奖概率</td>
      <td>万分之 <input name="h_lottery5" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_lottery5']; ?>" /> （8KK）</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">六等奖中奖概率</td>
      <td>万分之 <input name="h_lottery6" type="text" class="inputclass1" maxlength="8" value="<?php echo $rs['h_lottery6']; ?>" /> （谢谢参与）</td>
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