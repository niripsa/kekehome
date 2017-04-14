<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
require_once 'inc_header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/pager.php';
?>
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
?>
 <div class="page-body">
        
    <div class="head">
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;">
        <div class="head-title">生长走势</div>
        <a href="index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"></a>
    </div>
	<div style="width:90%;margin:0 auto;">
						<div>
						<center style="font-size:14px">果园增长走势图</center>
							<canvas id="canvas" height="700px" width="700px"></canvas>
						</div>
					</div>
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
				$(".head-icon-left").on("click", function () {
            window.history.go(-1);
        });

        if (path != undefined && path.length > 0) {
            document.write("<div id='dd' class='float-icon'><a href='"+href+"' onclick='"+onClick+"' /><img src='" + path + "'  class='float-icon-img'></a></div>");
        }
			</script>
    </div>