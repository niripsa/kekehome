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
	case "unlockinfo1":
		unlockinfo1();
		break;
	case "lockinfo1":
		lockinfo1();
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
	global $db,$id,$userName,$passWord,$nickName,$isPass;
	global $h_mobile,$h_level,$h_parentUserName;
	global $passWord2;
	global $h_alipayUserName,$h_alipayFullName,$h_addrAddress,$h_addrPostcode,$h_addrFullName;
	global $h_qq,$h_a1,$h_q1,$h_a2,$h_q2,$h_a3,$h_q3;
	global $h_isLock;
	global $h_passTime;
	
	if(!$isPass){
		$h_passTime = ",h_passTime = NULL";
	}else{
		if(strlen($h_passTime) > 0){
			$h_passTime = ",h_passTime = '$h_passTime'";
		}else{
			$h_passTime = ",h_passTime = '" . date('Y-m-d H:i:s') . "'";
		}
	}
	
	//if($userName == ''){HintAndBack("帐号不能为空！",1);}
	if($nickName == ''){HintAndBack("姓名不能为空！",1);}

	if($passWord != '')
	{
		$passWord = md5($passWord);
		$passWord = "h_passWord = '$passWord',";
	}
	if($passWord2 != '')
	{
		$passWord2 = md5($passWord2);
		$passWord2 = "h_passWordII = '$passWord2',";
	}
	$query = "update `h_member` SET 
			  $passWord
			  $passWord2
			  h_fullName = '$nickName',
			  h_addrTel = '$h_mobile',
			  h_level = '$h_level',
			  h_alipayUserName = '$h_alipayUserName',
			  h_alipayFullName = '$h_alipayFullName',
			  h_addrAddress = '$h_addrAddress',
			  h_addrPostcode = '$h_addrPostcode',
			  h_addrFullName = '$h_addrFullName',
    		  h_parentUserName = '$h_parentUserName',
			  h_qq = '$h_qq',
			  h_a1 = '$h_a1',
			  h_q1 = '$h_q1',
			  h_a2 = '$h_a2',
			  h_q2 = '$h_q2',
			  h_a3 = '$h_a3',
			  h_q3 = '$h_q3',
			  h_isLock = '$h_isLock'
			  where id = $id";

	$rs=$db->query($query);
	if($rs){
		okinfo('?','会员修改成功！');
	}else{
		okinfo('?','会员修改失败！');
	}
	
}

function editinfo()
{
	global $db,$id,$LoginEdUserName;

	$rs = $db->get_one("SELECT * FROM `h_member` where id = $id");
	if(!$rs)
	{
		hintAndBack('未找到该会员!',1);
	}
	else
	{
?>
<form action="?clause=saveeditinfo&id=<?php echo $id; ?>" method="post" name="editinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">修改会员</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">会员帐号</td>
    <td><?php echo $rs[h_userName]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">上家编号</td>
    <td><input name="h_parentUserName" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_parentUserName]; ?>" /></td>
  </tr>
 <!--  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">激活状态</td>
    <td><select name="isPass">
      <option value="0" <?php if($rs[h_isPass] == 0) echo 'selected'; ?>>锁定，未激活</option>
	  <option value="1" <?php if($rs[h_isPass] == 1) echo 'selected'; ?>>正常，已激活</option>
    </select></td>
  </tr> -->
 <!--  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">激活时间</td>
    <td><input name="h_passTime" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_passTime]; ?>" /> </td>
  </tr> -->
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">登录状态</td>
    <td><select name="h_isLock">
      <option value="0" <?php if($rs[h_isLock] == 0) echo 'selected'; ?>>正常，能登录</option>
	  <option value="1" <?php if($rs[h_isLock] == 1) echo 'selected'; ?>>锁定，不能登录</option>
    </select></td>
  </tr>
 <!--  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">VIP</td>
    <td><?php
     echo get_member_level_selector('h_level',$rs['h_level']);
	?></td>
  </tr> -->
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">种子</td>
    <td><?php echo $rs[h_point1]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">KK</td>
    <td><?php echo $rs[h_point2]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">一级密码</td>
    <td><input name="passWord" type="passWord" class="inputclass1" maxlength="25" value="" /> 
    <font color="#ff0000">不修改请放空</font> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">二级密码</td>
    <td><input name="passWord2" type="passWord" class="inputclass1" maxlength="25" value="" /> 
    <font color="#ff0000">不修改请放空</font> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">真实姓名</td>
    <td><input name="nickName" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_fullName]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">支付宝账号</td>
    <td><input name="h_alipayUserName" type="text" class="inputclass1" maxlength="250" value="<?php echo $rs[h_alipayUserName]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">支付宝姓名</td>
    <td><input name="h_alipayFullName" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_alipayFullName]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">收货地址</td>
    <td><input name="h_addrAddress" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs[h_addrAddress]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">邮编</td>
    <td><input name="h_addrPostcode" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_addrPostcode]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">收货人</td>
    <td><input name="h_addrFullName" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_addrFullName]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">收货人手机</td>
    <td><input name="h_mobile" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_addrTel]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">QQ号</td>
    <td><input name="h_qq" type="text" class="inputclass1" maxlength="25" value="<?php echo $rs[h_qq]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">密保问题1</td>
    <td><input name="h_a1" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs[h_a1]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">答案1</td>
    <td><input name="h_q1" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs[h_q1]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">密保问题2</td>
    <td><input name="h_a2" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs[h_a2]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">答案2</td>
    <td><input name="h_q2" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs[h_q2]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">密保问题3</td>
    <td><input name="h_a3" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs[h_a3]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">答案3</td>
    <td><input name="h_q3" type="text" class="inputclass2" maxlength="250" value="<?php echo $rs[h_q3]; ?>" /> </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">注册时间</td>
    <td><?php echo $rs[h_regTime]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">注册IP</td>
    <td><?php echo $rs[h_regIP]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">登录次数</td>
    <td><?php echo $rs[h_logins]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">最后登录</td>
    <td><?php echo $rs[h_lastTime]; ?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">最后IP</td>
    <td><?php echo $rs[h_lastIP]; ?></td>
  </tr>
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
	global $db;
	global $comMember,$username,$pwd,$pwdII,$isPass,$h_level;
	
	/*
	if(strlen($comMember) != 11){
		echo '{"state":false,"msg":"推荐人帐号错误，请检查！"}';
		exit;
	}
	
	if(strlen($username) != 11){
		HintAndBack("玩家编号错误，请检查！",1);
	}*/
	if(strlen($pwd) < 6 || strlen($pwd) > 32){
		HintAndBack("一级密码6-32位任意字符，请检查！",1);
	}
	if(strlen($pwdII) < 6 || strlen($pwdII) > 32){
		HintAndBack("二级密码6-32位任意字符，请检查！",1);
	}

	if(strlen($comMember) > 0){
		$rs = $db->get_one("select * from `h_member` where h_userName = '{$comMember}'");
		if(!$rs){
			HintAndBack("您填写的推荐人帐号并不存在，请检查！",1);
		}

		$aParentInfo = $rs;
	}
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$username}'");
	if($rs){
		HintAndBack("您填写的会员帐号（手机号码）已经存在，请换一个！",1);
	}
	
	$pwd = md5($pwd);
	$pwdII = md5($pwdII);
	
	$h_level = intval($h_level);
	
	$passTime = '';
	if($isPass){
		$passTime = "h_passTime = '" . date('Y-m-d H:i:s') . "', ";
	}
	
	//写入..
	$sql = "insert into `h_member` set ";
	$sql .= "h_parentUserName = '" . $comMember . "', ";
	$sql .= "h_secondParentUserName = '" . strval($aParentInfo['h_parentUserName']) . "', ";
	$sql .= "h_userName = '" . $username . "', ";
	$sql .= "h_passWord = '" . $pwd . "', ";
	$sql .= "h_passWordII = '" . $pwdII . "', ";
	$sql .= "h_isPass = '{$isPass}', ";
	$sql .= $passTime;
	$sql .= "h_level = '{$h_level}', ";
	$sql .= "h_regTime = '" . date('Y-m-d H:i:s') . "', ";
	$sql .= "h_regIP = '" . getUserIP() . "' ";
	$db->query($sql);


	//同时写入到 h_member_farm中
	//初始化 112 普通地 10块
	$query = "delete from `h_member_farm` where h_userName = '{$username}'";
	$db->query($query);

	$query = "insert into  `h_member_farm`  set h_land = '0,0,0,0,0,0,0,0,0,0', h_harvest = '0,0,0,0,0,0,0,0,0,0', h_h_time = '0|0|0|0|0|0|0|0|0|0', h_userName = '{$username}',h_pid = '112'";
	$db->query($query);
	//初始化 113 黄金地 5块
	$query = "insert into  `h_member_farm`  set h_land = '0,0,0,0,0', h_harvest = '0,0,0,0,0', h_h_time = '0|0|0|0|0', h_userName = '{$username}',h_pid = '113'";
	$db->query($query);
	
	okinfo('?','会员添加成功！');
}

function addinfo()
{
?>
<form action="?clause=saveinfo" method="post" name="addinfo">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="2" align="center" class="tdtitle">添加会员</td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td width="20%" align="center">上家编号</td>
    <td><input name="comMember" type="text" class="inputclass2" maxlength="11" value="" /> 
    </td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">会员编号</td>
    <td><input name="username" type="text" class="inputclass2" maxlength="11" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">一级密码</td>
    <td><input name="pwd" type="text" class="inputclass2" maxlength="25" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">二级密码</td>
    <td><input name="pwdII" type="text" class="inputclass2" maxlength="25" value="" /> 
    <font color="#ff0000">*</font></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">VIP</td>
    <td><?php
     echo get_member_level_selector('h_level',-1);
	?></td>
  </tr>
  <tr class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';">
    <td align="center">激活状态</td>
    <td><select name="isPass">
      <option value="0" selected>锁定，未激活</option>
	  <option value="1">正常，已激活</option>
    </select>
    <font color="#ff0000">*</font></td>
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
	
	global $levelIndex,$stype,$keyword;
	$where = "";
	if(strlen($keyword) > 0){
		$where .= " and (h_userName like '%{$keyword}%' or h_fullName like '%{$keyword}%' or h_parentUserName like '%{$keyword}%')";
	}
	if(strlen($levelIndex) > 0 && $levelIndex >= 0){
		$where .= " and h_level = '{$levelIndex}'";
	}
	switch($stype){
		case '已激活':
			$where .= " and h_isPass = 1";
			break;
		case '未激活':
			$where .= " and h_isPass = 0";
			break;
		case '激活后30天内未推荐过会员':
			$where .= " and h_isPass = 1 and datediff(sysdate(),h_passTime) >= 30 and (select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) <= 0";
			break;
	}
	
	$linkUrl = '?levelIndex=' . urlencode($levelIndex) . '&stype=' . urlencode($stype) . '&keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 20;
	if($stype = '激活后30天内未推荐过会员'){
		$total_count = $db->get_one("select count(id) as countIds from `h_member` a where 1 = 1 {$where}");
		if($total_count){
			$total_count = intval($total_count['countIds']);
		}else{
			$total_count = 0;
		}
	}else{
		$total_count = $db->counter("`h_member`", "1 = 1 {$where}", 'id');
	}
	$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select *,(select count(id) from `h_member` where h_parentUserName = b.h_userName and h_isPass = 1) as comMembers from (select * from `h_member` a where 1 = 1 {$where} order by h_regTime desc,id desc LIMIT $from_record, $list_num) b";
	//echo $query;
	$result = $db->query($query);
	//$query = "Select * from `h_member` order by h_regTime desc";
	//$result = $db->query($query);
	$rs_list = array();
	if($db->num_rows($result) > 0){
		while($list = $db->fetch_array($result))
		{
			$rs_list[]=$list;
		}
	}
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="12" align="center" class="tdtitle">会员列表</td>
  </tr>
  <tr align="center"> 
    <td height="23" class="tdtitle-title">会员编号</td>
    <td class="tdtitle-title">真实姓名</td>
    <td class="tdtitle-title">推荐人编号</td>
    <td class="tdtitle-title">种子</td>
    <td class="tdtitle-title">KK</td>
    <td class="tdtitle-title">播种</td>
    <td class="tdtitle-title">总量</td>
    <td class="tdtitle-title">采蜜量</td>
    <td class="tdtitle-title">生长量</td>
    <td class="tdtitle-title">直荐人数</td>
    <td class="tdtitle-title">注册时间</td>
    <td class="tdtitle-title">登录状态</td>
    <td class="tdtitle-title">最后登录</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{
?>
  <tr align="center" class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25"><?php 
	/*echo get_member_level_span($val['h_level']);*/
	echo ' ', $val['h_userName']; ?></td>
    <td><?php echo $val['h_fullName']; ?></td>
    <td><?php echo $val['h_parentUserName']; ?></td>
    <td><?php echo $val['h_point1']; ?></td>
    <td><?php echo $val['h_point2']; ?></td>
    <td><?php echo getlandmoney($val['h_userName']);  ?></td>
    <td><?php echo (getlandmoney($val['h_userName'])+$val['h_point2']);  ?></td>
    <td><?php echo getallbee($val['h_userName']);  ?></td>
    <td><?php echo getallgrowth($val['h_userName']);  ?></td>
    <td><?php echo $val['comMembers']; ?></td>
    <td><?php echo $val['h_regTime']; ?></td>
    
    <td><?php if($val['h_isLock'] == 1)
		{
			echo '<a href="?clause=unlockinfo1&id=' . $val[id] . '" style="color:#ff0000;">×锁定</a>';
		}
		else
		{
			echo '<a href="?clause=lockinfo1&id=' . $val[id] . '">√正常</a>';
		}?></td>
    <td><?php echo $val['h_lastTime']; ?></td>
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
	global $levelIndex,$stype,$keyword;
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr> 
    <td height="25" class="tdtitle" align="center">相关操作</td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center"><a href="?clause=addinfo">添加会员</a> | <a href="?">会员管理</a></td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center">
<form action="" method="get">
搜索：
<?php
	// if(strlen($levelIndex) <= 0){
	// 	$levelIndex = -1;
	// }
 //    echo get_member_level_selector('levelIndex',$levelIndex);
	?>
<!--  <select name="stype">
<option value="">-=状态=-</option>
<option value="已激活" <?php if($stype == '已激活'){echo "selected";}?>>已激活</option>
<option value="未激活" <?php if($stype == '未激活'){echo "selected";}?>>未激活</option>
<option value="激活后30天内未推荐过会员" <?php if($stype == '激活后30天内未推荐过会员'){echo "selected";}?>>激活后30天内未推荐过会员</option>
</select> -->
<input name="keyword" placeholder="会员帐号等模糊搜索" value="<?php echo $keyword;?>" type="text" />
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

	$query = "update `h_member` set h_isVIP = 1 where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}

function vipinfo()
{
	global $db,$id;

	$query = "update `h_member` set h_isVIP = 0 where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}


function unlockinfo()
{
	global $db,$id;

	$query = "update `h_member` set h_isPass = 1,h_passTime = '" . date('Y-m-d H:i:s') . "' where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}

function lockinfo()
{
	global $db,$id;

	$query = "update `h_member` set h_isPass = 0,h_passTime = NULL where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}

function unlockinfo1()
{
	global $db,$id;

	$query = "update `h_member` set h_isLock = 0 where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}

function lockinfo1()
{
	global $db,$id;

	$query = "update `h_member` set h_isLock = 1 where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}


function delinfo()
{
	global $db,$id;

	$query = "delete from `h_member` where id = $id";
	$db->query($query);
	
	turnToPage(FPrevUrl());
}


footer();
?>