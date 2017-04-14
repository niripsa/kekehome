<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '施肥KK收入 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>财务管理 <small> 施肥KK收入</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">财务管理</a></li>
  <li class="active">施肥KK收入明细</li>
</ol>
</div>


<!-- <div class="panel panel-default">
  <div class="panel-heading">施肥KK收入明细</div>
    
<div class="panel-body">
<?php
$sql = "select *";
$sql .= ",(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers";
$sql .= ",(select sum(h_price) from `h_log_point2` where h_userName = a.h_userName and h_price > 0) as point2sum";
$sql .= " from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>
	KK余额: <strong><?php echo $rs['h_point2'];?></strong>KK
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	
    您总共收入: <strong><?php
    $rs = $db->get_one("select sum(h_price) as sumP from `h_log_point2` where h_userName = '{$memberLogged_userName}' and h_price > 0");
	if(strlen($rs['sumP']) <= 0){
		$rs['sumP'] = 0;
	}
	
	echo $rs['sumP'];
	?></strong>KK
	
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	庄园产KK: <strong><?php
    $rs = $db->get_one("select sum(h_price) as sumP from `h_log_point2` where h_userName = '{$memberLogged_userName}' and h_type = '宠物产币'");
	if(strlen($rs['sumP']) <= 0){
		$rs['sumP'] = 0;
	}
	echo $rs['sumP'];
	?></strong>KK
	
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	直推奖: <strong><?php
    $rs = $db->get_one("select sum(h_price) as sumP from `h_log_point1` where h_userName = '{$memberLogged_userName}' and h_type = '直推奖'");
	if(strlen($rs['sumP']) <= 0){
		$rs['sumP'] = 0;
	}
	echo $rs['sumP'];
	?></strong>种子
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	下级产KK分红: <strong><?php
    $rs = $db->get_one("select sum(h_price) as sumP from `h_log_point2` where h_userName = '{$memberLogged_userName}' and h_type ='宠物收益分红'");
	if(strlen($rs['sumP']) <= 0){
		$rs['sumP'] = 0;
	}
	echo $rs['sumP'];
	?></strong>KK
  </div>
  </div> -->
   
<table class="table table-striped table-hover">
  <tr>
    <td>编号</td>
    <td>类型</td>
    <td>KK</td>
    <td>说明</td>
    <td>时间</td>
  </tr>
  
<?php
list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	$mid = 111;
	$total_count = $db->counter('h_log_point2', "h_userName = '{$memberLogged_userName}' and h_type_id = 4", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_point2` where h_userName = '{$memberLogged_userName}' and h_type_id = 4 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	if($rewriteOpen == 1)
	{
		$page_list = $rowset->link("/$mPageKey/page",".html");
	}
	else
	{
		$page_list = $rowset->link(GetUrl(2) . "?page=");
	}

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			echo '  <tr>
				<td>' , $val['id'] , '</td>
				<td>' , str_replace("宠物","可可",$val['h_type']) , '</td>
				<td>' , $val['h_price'] , '</td>
				<td>' , $val['h_about'] , '</td>
				<td>' , $val['h_addTime'] , '</td>
			  </tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";
}
?>
</table>

    
    

   


</div>
</div>
<!--MAN End-->
</div></div>
    <script>
	mgo(37);
    </script>
    
<?php
require_once 'inc_footer.php';
?>