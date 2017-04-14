<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '好友果园';

require_once 'inc_header.php';
require_once 't.php';
?>
<style>
.friends-body {
    margin: 0px 0 5px 0;
    width: 100%;
    height: 50px;
}
body {
	    background: #f5f5f5;
}
.float-icon {
    position: fixed;
    left: 47px;
    bottom: 57px;
    width: 70px;
    height: 70px;
    z-index: 1;
}
.friends-body-head-date {
    font-size: 14px;
}
.friends-body-head-date {
    width: 150px;
}
</style>
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
	$total_count = $db->counter('h_member', "h_parentUserName = '{$memberLogged_userName}'", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_member` where h_parentUserName = '{$memberLogged_userName}' order by h_regTime desc,id desc LIMIT $from_record, $list_num";
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
			$query = "select * from  `h_usebee`  where  h_fuserName = '{$val['h_userName']}'  and h_level = 1 and    DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d')   = '".$days."'";
			$rs =  $db->get_one($query);
			if($rs){ $caimi = 0; }

			/*是否施肥*/
			$days=date("Y-m-d",time());
			$query = "select   sum(h_price) as num   from  `h_log_point2`  where  h_userName = '{$val['h_userName']}' and h_type_id =4 and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
			$rs2 = $db->get_one($query);

			if($rs2['num']){ $caimi = 1; }
			/*会否采蜜*/
			$query = "select * from  `h_usebee`  where  h_fusername = '{$val['h_userName']}'  and h_level = 1 and DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
			$rs3 = $db->get_one($query);
			if($rs3){ $caimi = 2; }


			if($rs2['num'] ){
				$caiminum = round($rs2['num']*0.1,2);
			}else if($rs2 && $caimi==0){
				$caiminum = 0;
			}else{
				$caiminum = 0;
			}
			
			if($caimi==2){
				echo '
				<div class="friends-body" data-url="/mobile/myf_fram.php?username='.$val['h_userName'].'"><div class="friends-body-head"><span class="friends-body-head-date">' , $val['h_userName'] , '('.$val['h_fullName'].')</span><img src="/mod/images/common_select.png" class="friends-body-head-select"><span class="friends-body-head-right">(完成采蜜)进入果园</span></div></div>
				';
			}else{

				/*	<td>' , ($caimi?'<span  color="red" id = '.$val['h_userName'].' class="caimi">一键采蜜</span>':'等待对方施肥') , '</td>*/
				echo '
				<div class="friends-body" data-url="/mobile/myf_fram.php?username='.$val['h_userName'].'"><div class="friends-body-head"><span class="friends-body-head-date">' , $val['h_userName'] , '('.$val['h_fullName'].')</span><img src="/mod/images/common_select.png" class="friends-body-head-select"><span class="friends-body-head-right">(' , ($caimi?'可以采蜜':'等待对方施肥') , ')进入果园</span></div></div>
				';
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
<div id="dd" class="float-icon"><a href="/mobile/auto_caimi.php" onclick="javascript:void(0);"><img src="/mobile/images/zhHoney.png" class="float-icon-img"></a></div>
    <script type="text/javascript">
	    $(".head-icon-left").on("click", function () {
            window.history.go(-1);
        });
        $(".friends-body").on('click', function() {
            window.location.href = this.dataset.url;
        });
    </script>
    <script>
	mgo(22);
    </script>
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>


<script type="text/javascript">
	$(document).ready(function() {

			/*一键采蜜*/

		$(".caimi").click(function(){
			username = $(this).attr("id");
			$.post("caimi.php",{username:username},function(result){
				   alert("采蜜成功,采蜜的数量为"+result.split("-")[1]);
				   $(".caimi").empty().html("完成采蜜");
					window.location.reload();
			} );
		}); 

	}); 


</script>