<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = 'KK卖出记录';

require_once 'inc_header.php';
require_once 't.php';
?>
<style>
body{
	font-size:13px
}
</style>
<div class="panel-body">
<strong><span style="color:#F00;">警告:</span></strong><br>
<span style="color:#F00;">1.如果买家已把钱币打到你支付宝，而你超过12小时不确认收款，公司将没收你本次交易KK</span><br>
</div>
   
<table border = "1" style="width:100%;border-color: #00a1e5;" class="table table-striped table-hover">
  
<?php
list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName,$money_sxf;
	$mid = 111;
	$total_count = $db->counter('h_point2_sell', "h_userName = '{$memberLogged_userName}'", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_point2_sell` where h_userName = '{$memberLogged_userName}' order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
		    $money_sxf = intval($val['h_money']) * 0.1;
			echo '  <tr>
				<td rowspan = "4">' , $val['id'] , '</td>
				<td>收款方式:</td>
				<td>支付宝:</td>
				<td>'.$val['h_alipayUserName'].'</td>
				<td>姓名:</td>
				<td>'.$val['h_alipayFullName'].'</td>
				</tr>
				<tr>
				<td>联系方式:</td>
				<td>微信:</td>
				<td>'.$val['h_weixin'].'</td>
				<td>手机:</td>
				<td>'.$val['h_tel'].'</td>
				</tr>
				<tr>
				<td>买家:</td>
				<td colspan="4">';
if(strlen($val['h_buyUserName']) > 0){
	echo $val['h_buyUserName'] , '于';
	echo $val['h_buyTime'] , ' ';
	if($val['h_buyIsPay']){
		echo '<span style="color:#0000ff">已付款</span><br />';
	}else{
		echo '<span style="color:#ff0000">未付款</span><br />';
	}
}else{
	echo '-';
}
				echo '</td>
				<tr>
				<td>' , $val['h_money'] , 'KK</td>
				<td>'.$val['h_state'].'</td>
				<td colspan="3" style="text-align:center">';
				
				if($val['h_state'] == '等待卖家确认收款'){
					echo '<a href="point2_sell_img.php?id='. $val['id'] .'" target= "_blank">打款截图</a><br><button onclick="jinbi_queren(' , $val['id'] , ')" class="btn btn-success guadan_go" type="button">我已收到款</button>';
				}else if($val['h_state'] == '挂单中'){
					echo '<button onclick="jinbi_chedan(' , $val['id'] , ')" class="btn btn-danger" type="button">放弃拍卖</button>';
				}else{
					echo '-';
				}
				
				echo '</td>
			  </tr>
			  <tr style="height:20px;border:none"><tr>
			  ';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99' >{$page_list}</td>
                </tr>";
}
?>
 
</table>


</div>
</div>
<!--MAN End-->
</div></div>

 <script>
	mgo(43);
	var indexdd;
	
	function jinbi_chedan(rid){
	    layer.msg("确认撤回本次交易?.",{time: 20000, btn: ['确定撤单', '我点错了'],btn1: function(){jihuo_chedan2(rid)}});	
		}
		
	function jihuo_chedan2(c){
		tishi2();
		$.get("/mobile/bin.php?act=point2_sell_quit&id="+encodeURI(c),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='修改成功'){
					layer.msg("撤单成功,KK已经返回到您的账户中,3秒后返回",function(){location.reload();});
					}else{
					layer.msg(unescape(e))
					}
				}
			},'html');
		}	
		
		
	function jinbi_queren(rid){
	    layer.msg("请确认买家已经把钱币打到您的支付宝账户.",{time: 20000, btn: ['确定已打款', '我点错了'],btn1: function(){jihuo_queren2(rid)}});	
		}
		
	function jihuo_queren2(c){
		tishi2();
		$.get("/mobile/bin.php?act=point2_sell_confirm&id="+encodeURI(c)+"&num=<?php echo $sxf ?>",function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='修改成功'){
					layer.msg("本次交易成功,KK已经打入买家账户,3秒后返回",function(){location.reload();});
					}else{
					layer.msg(unescape(e))
					}
				}
			},'html');
		}
	
	
   </script>
    
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>