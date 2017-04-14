<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3><?php echo $webInfo['h_webKeyword']; ?> <small> 主页</small></h3>
</div>

<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">生长率</a></li>
</ol>
</div>


<div class="panel">
<?php

$days = array(
                date("m-d",strtotime("-6 day")),
                date("m-d",strtotime("-5 day")),
                date("m-d",strtotime("-4 day")),
                date("m-d",strtotime("-3 day")),
                date("m-d",strtotime("-2 day")),
                date("m-d",strtotime("-1 day")),
                date("m-d",time()),
            );
$days_count = count($days)-1;
$regcount  = array();
foreach ($days as $key => $value) {
    $str = " DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = '".date('Y-',time()).$value."'";
    $rs = $db->get_one("select  *  from h_growth_rate  where ".$str);
    if($rs){
    	$regcount[$key] = $rs['rate'];
    }else{
    	
    	$regcount[$key] = 0;
    }
}

$sql = "select *";
$sql .= ",(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers";
$sql .= ",(select sum(h_price) from `h_log_point2` where h_userName = a.h_userName and h_price > 0) as point2sum";
$sql .= " from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>
<table class="zijitable">
    <tr>
			<center>
				<!--[if IE]>
					<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
				<![endif]-->
					<div class="htmleaf-content">
						<div style="width:50%;height:50%;margin:0 auto;">
						<div>
							<canvas id="canvas" height="450" width="600"></canvas>
						</div>
					</div>
			</center>
			<!-- end Graph HTML -->
			<script src="chart/Chart.js"></script>
				<script>
				var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
					var lineChartData = {
						labels : [<?php 
										foreach ($days as $key => $v) {
											if($key == $days_count){
												echo "'".$v."'";
											}else{
												echo "'".$v."',";
											}
										}  
									?>],
						datasets : [
							{
								label: "My First dataset",
								fillColor : "rgba(47,126,216,0)",
								strokeColor : "rgba(47,126,216,1)",
								pointColor : "rgba(47,126,216,1)",
								pointStrokeColor : "#fff",
								pointHighlightFill : "#fff",
								pointHighlightStroke : "rgba(47,126,216,1)",
								data : [<?php 
										foreach ($regcount as $key => $v) {
											if($key == $days_count){
												echo $v;
											}else{
												echo $v.",";
											}
										} 

									   ?>]
							}
						]
					}
				window.onload = function(){
					var ctx = document.getElementById("canvas").getContext("2d");
					window.myLine = new Chart(ctx).Line(lineChartData, {
						responsive: true
					});
				}
			</script>

    </tr>
</table>


</div>


<div class="panel panel-default">
  <div class="panel-heading">最新系统公告 <a href="/member/news.php">查看全部公告</a></div>
  <table class="table table-striped table-hover">
  <tr>
  <td>标题</td>
  <td>发布时间</td>
  </tr>
<?php
	$query = "select * from `h_article` where h_menuId = 108 order by h_addTime desc,id desc LIMIT 5";
	$result = $db->query($query);
	while($rs_list = $db->fetch_array($result))
	{
			echo '<tr>
			  <td>[系统公告] <a href="/member/news-show.php?id=' , $rs_list['id'] , '">' , $rs_list['h_title'] , '</a></td>
			  <td>' , $rs_list['h_addTime'] , '</td>
			  </tr>';
	}
?>
  </table>
</div>


</div>
<!--MAN End-->
</div></div>

<?php
require_once 'inc_footer.php';
?>