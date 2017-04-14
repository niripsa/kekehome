<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '激活KK收入 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>财务管理 <small> 丘比特收入</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">财务管理</a></li>
  <li class="active">丘比特收入明细</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">丘比特收入明细</div>
    
<div class="panel-body">
    您总共收入: <strong><?php
    $rs = $db->get_one("select count(*) as sumP from `h_log_animal` where h_userName = '{$memberLogged_userName}' and h_type_id=1");
	if(strlen($rs['sumP']) <= 0){
		$rs['sumP'] = 0;
	}
	
	echo $rs['sumP'];
	?></strong>个
  </div>
   
<table class="table table-striped table-hover">
  <tr>
    <td>编号</td>
    <td>类型</td>
    <td>推荐人数量</td>
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
	$total_count = $db->counter('h_log_animal', "h_userName = '{$memberLogged_userName}' and h_type_id = 1", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_animal` where h_userName = '{$memberLogged_userName}' and h_type_id = 1 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
				<td>' , $val['h_type'] , '</td>
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
	mgo(34);
    </script>
    
<?php
require_once 'inc_footer.php';
?>