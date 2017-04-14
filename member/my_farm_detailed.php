<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '我的可可(种子) - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>庄园管理 <small> 我的可可(种子)</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">庄园管理</a></li>
  <li class="active">我的可可(种子)</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">我的可可(种子)</div>

<div class="panel-body">
<?php
	$query = "select max(h_title) as title,sum(h_num) as num from `h_member_farm` where h_userName = '{$memberLogged_userName}' and h_isEnd = 0 group by h_pid";
	$result = $db->query($query);
	$ci = 0;
	while($rs = $db->fetch_array($result))
	{
		$ci++;
		if($ci <= 1){
			echo '共有：';
		}else{
			echo '、';
		}
		echo $rs['title'] , '×' , $rs['num'];
	}	
?>
<!--<div class="row"></div>-->
</div>
  
<?php
list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	$mid = 111;
	$total_count = $db->counter('h_member_farm', "h_userName = '{$memberLogged_userName}' and h_isEnd = 0", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_member_farm` where h_userName = '{$memberLogged_userName}' and h_isEnd = 0 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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

	echo '<table class="table table-striped table-hover">
                <tr>
                <td>可可</td>
                <td>种子</td>
                <td>时间</td>
                </tr>';

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			
			$buytime=date("Y-m-d",strtotime($val['h_addTime']));

			echo  ' <tr>
					<td align="center" valign="middle" width="200"><img src="' , $val['h_pic'] , '" style="height:100px; width:auto;"></td>
					<td>
					<b>' , $val['h_title'] , '</b><br />
					数量：' , $val['h_num'] , '<br />

					</td>
					<td>
					购买时间：' , $buytime , '<br />

					</td>
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

	//<div class='clearfix'><div class='btn-group pull-left' role='group'><a class='btn btn-default' href='#' role='button'>首页</a><a class='btn btn-default' href='#' role='button'>上一页</a><a class='btn btn-default' href='#' role='button'>下一页</a><a class='btn btn-default' href='#' role='button'>尾页</a></div><div class='pull-right pt1'>&nbsp;页次：<strong><font color=red>1</font>/1</strong>页 &nbsp;共<b><font color='#FF0000'>19</font></b>条记录</div></div>
	
	echo '</table>';
}
?>
  <!--宠物寿命：' , date('Y-m-d',strtotime($val['h_endTime'])) , '<br />
已生产KK：' , $val['h_settleLen'] , '天，共' , ($val['h_point2Day'] * $val['h_num'] * $val['h_settleLen']) , 'KK<br />
还可生产KK：' , ($val['h_life'] - $val['h_settleLen']) , '天，共' , ($val['h_point2Day'] * $val['h_num'] * ($val['h_life'] - $val['h_settleLen'])) , 'KK<br />每只每天产生' , $val['h_point2Day'] , 'KK<br />
每天总共可以产生：' , ($val['h_point2Day'] * $val['h_num']) , 'KK<br />-->
  
</div>
</div>
<!--MAN End-->
</div></div>

    <script>
	$(function(){
		mgo(13);
	});
    </script>

<?php
require_once 'inc_footer.php';
?>