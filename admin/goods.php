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




function saveeditinfo()
{
	global $db,$id;
	global $h_title,$h_pic,$h_minComMembers,$h_money,$h_minMemberLevel,$h_info,$h_addTime;
	
	$h_money = intval($h_money);
	
	if($h_title == ''){HintAndBack("标题不能为空！",1);}
	if($h_pic == ''){HintAndBack("图片不能为空！",1);}
	if($h_money <= 0){HintAndBack("售价不能为0！",1);}
	
	$query = "update `h_farm_shop` SET 
			  h_title = '$h_title',
			  h_pic = '$h_pic',
			
			  h_money = '$h_money',
			  h_minMemberLevel = '$h_minMemberLevel',
			
			  h_addTime = '$h_addTime'
			  where id = $id";
    
	$db->query($query);
	okinfo('?','修改成功！');
}

function editinfo()
{
	global $db,$id,$LoginEdUserName;

	$rs = $db->get_one("SELECT * FROM `h_farm_shop` where id = $id");
	if(!$rs)
	{
		hintAndBack('未找到该商品!',1);
	}
	else
	{
?>
<form action="?clause=saveeditinfo&id=<?php echo $id; ?>" method="post" name="editinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">修改商品</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">标题</td>
    <td><input name="h_title" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs['h_title']; ?>" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom">
      <td align="center">展示图：</td>
      <td align="left"><input type="text" maxlength="250" class="inputclass2" id="h_pic" name="h_pic" value="<?php echo $rs['h_pic']; ?>"> <font color="#ff0000">*</font> 
      [<a onclick="AdminUpLoadFile('h_pic');" style="cursor:pointer;"><font color="#ff0000">上传图片</font></a>] 
      </td>
  </tr>
  <!-- <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">直荐要求</td>
    <td><input name="h_minComMembers" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs['h_minComMembers']; ?>" /> 人
    <font color="#ff0000">*</font></td>
  </tr> -->
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">售价</td>
    <td><input name="h_money" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs['h_money']; ?>" /> KK
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">会员等级要求</td>
    <td><?php
    echo get_member_level_selector('h_minMemberLevel',$rs['h_minMemberLevel']);
	?>
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">添加时间</td>
    <td><input name="h_addTime" type="text" class="inputclass2" maxlength="25" value="<?php echo $rs['h_addTime']; ?>" /> 
    <font color="#ff0000">*</font></td>
  </tr>
<!--   <tr onmouseout="javascript:this.className='tdbottom';" onmouseover="javascript:this.className='tdbottomover';" class="tdbottom">
      <td align="center">商品介绍</td>
      <td><textarea class="textareaclass4" name="h_info"><?php echo $rs['h_info']; ?></textarea></td>
    </tr> -->
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center" colspan="2"><input type="submit" name="Submit" value=" 确定修改 " class="bttn">&nbsp;&nbsp;<input name="button" type="button" value=" 返回 " class="bttn" onClick="javascript:history.go(-1);"></td>
  </tr>
</table>
</form>
<?php
	}
}

function saveinfo()
{
	global $db,$id;
	global $h_title,$h_pic,$h_minComMembers,$h_money,$h_minMemberLevel,$h_info,$h_addTime;
	
	$h_money = intval($h_money);
	
	if($h_title == ''){HintAndBack("标题不能为空！",1);}
	if($h_pic == ''){HintAndBack("图片不能为空！",1);}
	if($h_money <= 0){HintAndBack("售价不能为0！",1);}

	$query = "insert into `h_farm_shop` SET 
			  h_title = '$h_title',
			  h_pic = '$h_pic',
			  h_minComMembers = '$h_minComMembers',
			  h_money = '$h_money',
			  h_minMemberLevel = '$h_minMemberLevel',
			  h_info = '$h_info',
			  h_addTime = '$h_addTime'";

	$db->query($query);
	
	okinfo('?','添加成功！');
}

function addinfo()
{
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">添加商品</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">标题</td>
    <td><input name="h_title" type="text" class="inputclass2" maxlength="250" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom">
      <td align="center">展示图：</td>
      <td align="left"><input type="text" maxlength="250" class="inputclass2" id="h_pic" name="h_pic"> <font color="#ff0000">*</font> 
      [<a onclick="AdminUpLoadFile('h_pic');" style="cursor:pointer;"><font color="#ff0000">上传图片</font></a>] 
      </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">直荐要求</td>
    <td><input name="h_minComMembers" type="text" class="inputclass1" maxlength="25" value="" /> 人
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">售价</td>
    <td><input name="h_money" type="text" class="inputclass1" maxlength="25" value="" /> KK
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">会员等级要求</td>
    <td><?php
    echo get_member_level_selector('h_minMemberLevel',-1);
	?>
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">添加时间</td>
    <td><input name="h_addTime" type="text" class="inputclass2" maxlength="25" value="<?php echo date('Y-m-d H:i:s');?>" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr onmouseout="javascript:this.className='tdbottom';" onmouseover="javascript:this.className='tdbottomover';" class="tdbottom">
      <td align="center">商品介绍</td>
      <td><textarea class="textareaclass4" name="h_info"></textarea></td>
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
	
	global $stype,$keyword;
	$where = "";
	if(strlen($keyword) > 0){
		$where .= " and (h_title like '%{$keyword}%')";
	}
	if(strlen($stype) > 0 && $stype >= 0){
		$where .= " and h_minMemberLevel = '{$stype}'";
	}
	
	$linkUrl = '?stype=' . urlencode($stype) . '&keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_farm_shop`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	 /*$query = "select * from (select * from `h_farm_shop` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num) a";*/
	 $query = "select * from (select * from `h_farm_shop` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num) a";
	$result = $db->query($query);
	//$query = "Select * from `h_farm_shop` order by h_addTime desc";
	//$result = $db->query($query);
	$rs_list = array();
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="11" align="center" class="tdtitle">商城商品管理</td>
  </tr>
  <tr align="center"> 
    <td width="20%" height="23" class="tdtitle-title">商品图片</td>
    <td class="tdtitle-title">属性</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr align="center" class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25"><?php echo '<img src="' , $val['h_pic'] , '" width="100" height="100">'; ?></td>
    <td align="left"><?php echo $val['h_title']; ?><br />
直荐要求：<?php echo $val['h_minComMembers']; ?>人<br />
售价：<?php echo $val['h_money']; ?><br />
会员等级要求：<?php echo get_member_level_span($val['h_minMemberLevel']); ?><br />
添加时间：<?php echo $val['h_addTime']; ?><br /></td>
    <td><a href="?clause=editinfo&id=<?php echo $val[id]; ?>">修改</a> | 
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
	global $stype,$keyword;
	if(strlen($stype) <= 0){
		$stype = -1;
	}
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr> 
    <td height="25" class="tdtitle" align="center">相关操作</td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center"><a href="?clause=addinfo">添加商品</a> | <a href="?">商品管理</a></td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center">
<form action="" method="get">
搜索：
<?php
    echo get_member_level_selector('stype',$stype);
	?>
<input name="keyword" placeholder="商品标题" value="<?php echo $keyword;?>" type="text" />
<input type="submit" class="bttn" value="提交搜索" name="Submit">
</form>
    </td>
  </tr>
</table>
<br />
<?php
}





function unvipinfo()
{
	global $db,$id;

	$query = "update `h_farm_shop` set h_isVIP = 1 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}

function vipinfo()
{
	global $db,$id;

	$query = "update `h_farm_shop` set h_isVIP = 0 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


function unlockinfo()
{
	global $db,$id;

	$query = "update `h_farm_shop` set h_isPass = 1 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}

function lockinfo()
{
	global $db,$id;

	$query = "update `h_farm_shop` set h_isPass = 0 where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


function delinfo()
{
	global $db,$id;

	$query = "delete from `h_farm_shop` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>