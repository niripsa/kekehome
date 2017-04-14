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

//时间函数 date()生成字符串 strtotime()生成时间戳
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
	//sql也有函数 select count(id) from h_member;数一共有多少行
	
	//from_unixtime(时间戳，[格式]) 相当于php当中的date()
	//from_unixtime(1461556800,'%Y-%m-%d %H:%i:%s');
	//若省略第二个参数相当于____________↑
	//from_unixtime()第一个参数不能省略
	//
	//unix_timestamp()相当于php当中的strtotime()
	//unix_timestamp('2016-04-25 12:00:00') 
	//↑相当于time() 用于获取时间戳
	//若无参数则返回当前时间戳
	//
	//date_formate(时间戳/其他字符串,[格式]) 对日期进行格式化
	
	//注册时间在最近三天的人数个数 表h_member 列h_regTime
	//select count(id) from h_member where unix_timestamp(h_regTime) > (unix_timestamp()-259200);
	//select count(id) from h_member where h_regTime > from_unixtime(unix_timestamp()-259200);
    $str = " DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = '".date('Y-',time()).$value."'";
    //select * from h_member where concat(h_userName,"456")="123456456";
    //select * from h_member where h_point2 + 10 > 9\G;
    $rs = $db->get_one("select  *  from h_growth_rate  where ".$str);
    if($rs){
    	$regcount[$key] = $rs['rate'];
    }else{
    	
    	$regcount[$key] = 0;
    }
}

//↑simple sql statement
//↓complax sql statement
//复杂的sql语句 连表查询 select嵌套
//select h_passTime from h_member limit 1;	//普通的查询
//select h_passTime as a from h_member limit 1;
//↑上面显示新列名
//select 列名 [as] 新列名 from 表名;	表名也可以使用as

//实际上select语句是一个简写，完整如下↓
//select h_member.h_passTime from h_member limit 1;
//select b.h_passTime from h_member as b limit 1;

//连表查询
//left join /right join /inner join /outer join
//select * from h_member,h_member_farm limit 1;
//select h_member.id,h_member.h_userName,h_passWord from h_member,h_member_farm limit 1;
//select 表[简].列，表[简].列 from 表1[as 表1简]，表2[as 表2简] where 表1.列1=表2.列2;

//left join 左连接		 表1 left join 表2
//会从左表 (table_name1) 那里返回所有的行，即使在右表 (table_name2) 中没有匹配的行 
//RIGHT JOIN 关键字会右表 (table_name2) 那里返回所有的行，即使在左表 (table_name1) 中没有匹配的行。

$sql = "select *";
$sql .= ",(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers";
//↑查一查推荐人是某个人的人数是多少(即某个人推荐了多少人)
$sql .= ",(select sum(h_price) from `h_log_point2` where h_userName = a.h_userName and h_price > 0) as point2sum";
//加起来看看余额多少h_log_points2对应钱
$sql .= " from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
//查一查你输入的用户名推荐了多少人，同时账户余额还有多少
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