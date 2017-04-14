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
	global $rate,$update_time,$create_time;
	global $db;
	$rate = $_POST['rate'];	   

	$days=date("Y-m-d",time());
	$result = $db->get_one("select  *  from h_growth_rate where DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = '".$days."'");
	if($result){
		$query = "update `h_growth_rate` SET
				  rate = '$rate',
				  update_time = '".time()."'  where DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = '".$days."' ";
		$db->query($query);
	}else{
		$query = "insert into  `h_growth_rate` SET 
			  rate = '$rate',
			  update_time = ".time().",
			  create_time = ".time();   
		$db->query($query);
	}


	HintAndTurn('拆分率修改成功！',"?");
}



function editinfo()
{
	global $db;
	global $ckeditor_mc_id,$ckeditor_mc_val,$ckeditor_mc_lang,$ckeditor_mc_toolbar,$ckeditor_mc_height;
	$rs = $db->get_one("SELECT * FROM `h_growth_rate` order by id desc limit 1");

?>
<form action="?clause=saveeditinfo" method="post" name="addinfo">
  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  	<tr>
      <td height="25" colspan="2" align="center" class="tdtitle">设置拆分率</td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center">拆分率</td>
      <td><input name="rate" type="text" class="inputclass2" maxlength="50" value="<?php echo $rs[rate]; ?>" />%
          <font color="#ff0000">*</font></td>
    </tr>
    <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
      <td align="center" colspan="2"><input type="submit" name="Submit" value=" 保存 " class="bttn"></td>
    </tr>
  </table>
</form>

<?php
	
}

footer();
?>