<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '二级会员 - ';

require_once 'inc_header.php';
$sql = "select * from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
	$rs = $db->get_one($sql);
if($rs['auto_caimi'] != "" && $rs['auto_caimi'] > strtotime('now')){
	$open = 1;
	}else{
		$open = 0;
	}
?>
<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>账户管理 <small> 二级会员</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">账户管理</a></li>
  <li class="active">二级会员列表</li>
</ol>
</div>
<? if($open){ ?>
<button type="button" class="btn btn-primary btn-block" style="width:150px" onclick="javascript:window.location.href='auto_caimi_second.php?get=1'">一键采蜜</button>
<? }else{ ?>
<button type="button" class="btn btn-primary btn-block" style="width:150px" onclick="javascript:window.location.href='auto_caimi_second.php'">订购一键采蜜</button>
<? } ?>
<div class="panel panel-default">
  <div class="panel-heading">二级会员列表</div>
   

   
<table class="table table-striped table-hover">
  <tr>
    <td>玩家编号</td>
    <td>玩家姓名</td>
    <td>能否采蜜</td>
    <td>可以采蜜的数量</td>
    <td>操作</td>
  </tr>
<?php
list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	
	$caimi = 0;

	$mid = 111;
	$total_count = $db->counter('h_member', "h_secondParentUserName = '{$memberLogged_userName}'", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_member` where h_secondParentUserName = '{$memberLogged_userName}' order by h_regTime desc,id desc LIMIT $from_record, $list_num";
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
			$caimi =0;
			$days=date("Y-m-d",time());
			$query = "select * from  `h_usebee`  where  h_fuserName = '{$val['h_userName']}'  and  h_level = 2 and DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d')   = '".$days."'";
			$rs =  $db->get_one($query);
			if($rs){ $caimi = 0; }

			/*是否施肥*/
			$days=date("Y-m-d",time());
			$query = "select   sum(h_price) as num   from  `h_log_point2`  where  h_userName = '{$val['h_userName']}' and h_type_id =4 and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
			$rs2 = $db->get_one($query);

			if($rs2['num']){ $caimi = 1; }
			/*会否采蜜*/
			$query = "select * from  `h_usebee`  where  h_fusername = '{$val['h_userName']}'  and  h_level = 2 and DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
			$rs3 = $db->get_one($query);
			if($rs3){ $caimi = 2; }


			if($rs2['num'] ){
				$caiminum = round($rs2['num']*0.05,2);
			}else if($rs2 && $caimi==0){
				$caiminum = 0;
			}else{
				$caiminum = 0;
			}
			
			if($caimi==2){
				echo '  <tr>
						<td>' , $val['h_userName'] , '</td>
						<td>' , $val['h_fullName'] , '</td>
						<td>完成采蜜</td>
						<td>' , $caiminum , '</td>
						<td><a href="/member/myf_fram_second.php?level=2&username='.$val['h_userName'].'" >进入庄园</a></td>
					</tr>';
			}else{
				echo '  <tr>
						<td>' , $val['h_userName'] , '</td>
						<td>' , $val['h_fullName'] , '</td>
						<td>' , ($caimi?'可以采蜜':'等待对方施肥') , '</td>
						<td>' , $caiminum , '</td>
						<td><a href="/member/myf_fram_second.php?level=2&username='.$val['h_userName'].'" >进入庄园</a></td>
					</tr>';

				/*	<td>' , ($caimi?'<span  color="red" id = '.$val['h_userName'].' class="caimi">一键采蜜</span>':'等待对方施肥') , '</td>*/
			}
			
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) 
				echo "<tr>
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
	mgo(24);
    </script>
<?php
require_once 'inc_footer.php';
?>


<script type="text/javascript">
	$(document).ready(function() {

			/*一键采蜜*/

		$(".caimi").click(function(){
			username = $(this).attr("id");
			$.post("caimi.php",{username:username, level:2},function(result){
				   alert("采蜜成功,采蜜的数量为"+result.split("-")[1]);
				   $(".caimi").empty().html("完成采蜜");
					window.location.reload();
			} );
		}); 

	}); 


</script>