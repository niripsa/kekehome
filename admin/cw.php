<?php
require_once 'header.php';

require_once '../include/pager.php';

switch($clause)
{
	case "settle":
		settle();
		break;
	case "delinfo":
		delinfo();
		break;
	default:
		menu();
		main();
		break;
}

function settle()
{
	global $username;
	
	settle_farm_day($username);
	
	//HintAndBack("会员编号不能为空！",1);
	FJS_AT('结算成功','?');
}

function main()
{
	global $db,$LoginEdUserName;
	
	global $keyword;
	if(strlen($keyword) > 0){
		$where = " and (h_userName like '%{$keyword}%' or h_title like '%{$keyword}%')";
	}
	
	$linkUrl = '?keyword=' . urlencode($keyword) . '&page=';
	
	global $page;
	$list_num = 15;
	$total_count = $db->counter("`h_member_farm`", "1 = 1 {$where}", 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link($linkUrl);
	$query = "select * from `h_member_farm` where 1 = 1 {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	//$query = "Select * from `h_money_log` order by h_addTime desc";
	//$result = $db->query($query);
	$rs_list = array();
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" colspan="11" align="center" class="tdtitle">会员宠物列表</td>
  </tr>
  <tr align="center"> 
    <td height="23" class="tdtitle-title">会员帐号</td>
    <td class="tdtitle-title">宠物</td>
    <td class="tdtitle-title">购买时间</td>
    <td class="tdtitle-title">寿命</td>
    <td class="tdtitle-title">上次结算</td>
    <td class="tdtitle-title">每天产能</td>
    <td class="tdtitle-title">已结算次数</td>
    <td class="tdtitle-title">是否死亡</td>
    <td class="tdtitle-title">相关操作</td>
  </tr>
<?php
foreach ($rs_list as $key=>$val)
{

?>
  <tr align="center" class="tdbottom" onMouseOver="javascript:this.className='tdbottomover';" onMouseOut="javascript:this.className='tdbottom';"> 
    <td height="25"><?php echo $val['h_userName']; ?></td>
    <td height="25"><?php echo $val['h_title'] , '×' , $val['h_num']; ?></td>
    <td height="25"><?php echo date("Y-m-d",strtotime($val['h_addTime'])); ?></td>
    <td height="25"><?php echo date("Y-m-d",strtotime($val['h_endTime']));; ?></td>
    <td height="25"><?php echo $val['h_lastSettleTime']; ?></td>
    <td height="25"><?php echo $val['h_point2Day'] , '×' , $val['h_num'] , '=' , ($val['h_point2Day'] * $val['h_num']) , 'KK'; ?></td>
    <td height="25"><?php echo $val['h_settleLen'] , '/' , $val['h_life']; ?></td>
    <td height="25"><?php if($val['h_isEnd']){echo '死亡';}else{echo '存活';} ?></td>
    <td>
    <?php if(!$val['h_isEnd']){
			//计算上次结算与今天的时间差（天数）
			//如果上次未结算，默认为购买时便已结算（虚拟）
			if(is_null($val['h_lastSettleTime'])){
				$val['h_lastSettleTime'] = $val['h_addTime'];
			}
			$dateDiffDay = FDateDiff0($val['h_lastSettleTime'],time(),'d');
			
			//需要结算的天数
			//如果超出生存周期，最多是生存周期
			$mustSettleDay = $dateDiffDay - $val['h_settleLen'];
			if($mustSettleDay > $val['h_life']){
				$mustSettleDay = $val['h_life'];
			}
			
			if($mustSettleDay > 0){
		?>
		<a style="cursor:pointer;" onClick="javascript:hintandturn('确认要结算该会员的庄园宠物产币数据吗？','?clause=settle&username=<?php echo urlencode($val['h_userName']); ?>',true);">结算</a> | 
		<?php
			}
	} ?>
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
?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr> 
    <td height="25" class="tdtitle" align="center">相关操作</td>
  </tr>
  <tr> 
    <td height="23" class="tdbottom" align="center">
<form action="" method="get">
搜索：<input name="keyword" value="<?php echo $_GET['keyword'];?>" type="text" />
<input type="submit" class="bttn" value="提交搜索" name="Submit">
</form>
    </td>
  </tr>
</table>
<br />
<?php
}

function delinfo()
{
	global $db,$id;

	$query = "delete from `h_member_farm` where id = $id";
	$db->query($query);
	
	turnToPage('?');
}


footer();
?>