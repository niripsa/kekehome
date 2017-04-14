<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '种子转KK记录';

require_once 'inc_header.php';
require_once 't.php';
?>
<div class="content">
        <table style="width: 100%;">
            <thead style="color:red;text-align:center;font-size:12px">
                 <tr>
	<td>时间</td>
    <td>类型</td>
    <td>金额</td>
  </tr>
            </thead>
            <tbody style="background: #ffffff;">

  
<?php
list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	$mid = 111;
	$total_count = $db->counter('h_log_point1', "h_userName = '{$memberLogged_userName}' and h_type_id = 2  ", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_point1` where h_userName = '{$memberLogged_userName}' and h_type_id = 2 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
			$val['h_addTime'] = date("Y-m-d",strtotime($val['h_addTime']));
			echo '  <tr>
				<td>' , $val['h_addTime'] , '</td>
				<td>' , $val['h_type'] , '</td>
				<td>' , $val['h_price'] , '</td>
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
</tbody>
</table>


</div>
</div>
<!--MAN End-->
</div></div>
    <script>
	mgo(45);
    </script>
    
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>