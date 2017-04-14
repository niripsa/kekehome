<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '我的订单 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>购买商品 <small> 我的订单</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">购买商品</a></li>
  <li class="active">我的订单</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">我的订单</div>
   
<table class="table table-striped table-hover">
  <tr>
    <td>订单编号</td>
    <td>订单商品</td>
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
	$total_count = $db->counter('h_member_shop_order', "h_userName = '{$memberLogged_userName}' ", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_member_shop_order` where h_userName = '{$memberLogged_userName}' order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
			echo '<tr>
				<td>' , $val['h_oid'] , '<br />订单总额：' , $val['h_money'] , '<br />下单时间：' , $val['h_addTime'] , '<br />订单状态：' , $val['h_state'];
				
				
				
				echo '</td>
				<td>';
				
$query1 = "select * from `h_member_shop_cart` where h_oid = '{$val['h_oid']}' order by h_addTime desc,id desc";
$result1 = $db->query($query1);
$cj = 0;
while($rs1 = $db->fetch_array($result1))
{
	$cj++;
	echo $cj , '、' , $rs1['h_title'] , '×' , $rs1['h_num'] , '<br />';
}

echo '<hr />地址：' , $val['h_addrAddress'] , '<br />邮编：' , $val['h_addrPostcode'] , '<br />收货人：' ,$val['h_addrFullName'] , '（' , $val['h_addrTel'] , '）';
				
			echo '</td>
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
	

}
?>

</table>

</div>
</div>
<!--MAN End-->
</div></div>

    <script>
	mgo(52);
    </script>
    
<?php
require_once 'inc_footer.php';
?>