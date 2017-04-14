<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = 'KK转账';

require_once 'inc_header.php';
require_once 't.php';
	$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
	$rs = $db->get_one($sql);

	//取出转账人目前田地上的钱
	$fLandNow = get_farm_money($memberLogged_userName);
	$fAllMoney = $fLandNow + floatval($rs['h_point2']);
	//转账上限为总额的20%
	if($fAllMoney > 0){
		$webInfo['h_sell_max'] = intval($fAllMoney * 0.2/10)*10;
	}
?>
  <br><center><strong style="font-size:20px">提示：每日最多提交转账<font style="color:red"><? echo $webInfo['h_sell_max'] ?></font>KK</strong></center><br>
<div class="friend-new-item">
        <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label">可用KK数量</span>
        <label class="friend-new-line-split">:</label>
        <span id="ctl00_body_Textbox1" class="friend-new-line friend-new-line-input" placeholder=""><?php echo $rs['h_point2']; ?></span>
    </div>
	<div class="friend-new-item">
        <span id="ctl00_body_Label2" class="friend-new-line friend-new-line-label">目标用户</span>
        <label class="friend-new-line-split">:</label>
        <input name="ctl00$body$Textbox2" id = "x3" type="text" id="ctl00_body_Textbox2" class="friend-new-line friend-new-line-input" placeholder="对方的账号" />
    </div>
	<div class="friend-new-item">
        <span id="ctl00_body_Label2" class="friend-new-line friend-new-line-label">目标姓名</span>
        <label class="friend-new-line-split">:</label>
        <input name="ctl00$body$Textbox2" id = "x2" type="text" id="ctl00_body_Textbox2" class="friend-new-line friend-new-line-input"/>
    </div>
    <div class="friend-new-item">
        <span id="ctl00_body_Label2" class="friend-new-line friend-new-line-label">转账数量</span>
        <label class="friend-new-line-split">:</label>
        <input name="ctl00$body$Textbox2" id = "x1" type="text" id="ctl00_body_Textbox2" class="friend-new-line friend-new-line-input" placeholder="手续费：<?php echo $webInfo['h_to_flower'];  ?>%" />
    </div>
    <input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub" />
	
<table style="width: 100%;font-size: 14px;">
     <thead style="color:red;text-align:center;font-size:12px">
  <tr>
    <td>类型</td>
    <td>金额</td>
    <td>时间</td>
	<td>状态</td>
	<td>操作</td>
  </tr>
  </thead>
<?php

list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	$mid = 111;
	$total_count = $db->counter('h_log_point2', "h_userName = '{$memberLogged_userName}' and h_type_id=9 ", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_point2` where h_userName = '{$memberLogged_userName}' and h_type_id=9  order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
		     $val['h_addTime'] = date("m-d",strtotime($val['h_addTime']));
			 $out ='  <tr>
				<td>' . $val['h_type'] . '</td>
				<td>' . $val['h_price'] . '</td>
				<td>' . $val['h_addTime'] . '</td>';
			if($val['h_state'] == "0")
			{
			  if(intval($val['h_price']) < 0)
			  {
			    $out = $out . '<td>等待对方确认</td><td>-</td>';
			  }
			  else
			  {
			        $h_remarks = $val['h_remarks'];
				    $rs = $db->get_one("select * from h_log_point2 where h_price<0 and h_remarks = '".$h_remarks."'");
				    
				    if($rs['h_state'] == "0"){
			            $out = $out . '<td>等待您的确认</td><td><a href="javascript:void()" onClick = "jinbi_fukuan('. $val['id'] .')">我已打米</a></td>';
			        }else if($rs['h_state'] == "3"){
			       		$out = $out . '<td>取消交易</td><td></td>';
			        }else if($rs['h_state'] == "2"){
			       		$out = $out . '<td>等待对方确认收米</td><td></td>';
			        }
			  }
			}else if($val['h_state'] == "2"){
				if(intval($val['h_price']) < 0)
				  {
				    $out = $out . '<td>--</td><td><a href="javascript:void()" onClick = "jinbi_ok('. $val['id'] .')">我已转KK</a>&nbsp;&nbsp;<a href="javascript:void()" onClick = "jinbi_off('. $val['id'] .')">取消交易</a></td>';
				  }
				  else
				  {
				    $out = $out . '<td>等待对方确认转账</td><td>--</td>';
				  }
			}else if($val['h_state'] == "3"){
				if(intval($val['h_price']) < 0)
				  {
				    $out = $out . '<td>取消交易</td><td>--</td>';
				  }
				  else
				  {
				    $out = $out . '<td>取消交易</td><td>--</td>';
				  }
			}else if($val['h_state'] == "4"){
				if(intval($val['h_price']) < 0)
				  {
				    $out = $out . '<td>--</td><td><a href="javascript:void()" onClick = "jinbi_shoumi('. $val['id'] .')">确认收米</a></td>';
				  }
				  else
				  {
				    $out = $out . '<td>等待对方确认收米</td><td>--</td>';
				  }
			}
			else
			{
			  if(intval($val['h_price']) < 0)
			  {
			    $out = $out . '<td>交易成功</td><td>-</td>';
			  }
			  else
			  {
			    $out = $out . '<td>交易成功</td><td>-</td>';
			  }
			}
			echo $out;
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

    <script src="/ui/layer/extend/layer.ext.js"></script>
    <script>
	mgo(46);
	
	
	$('#x3').change('input propertychange', function() { 
		if($(this)){
			tishi2();
			$.get("/mobile/bin.php?act=chkun&username="+$(this).val(),function(e){
			tishi2close();
			if(e!=""){
				$("#x2").empty().val(unescape(e));
				}
			},'html');
				
			}
		});	
	


	$("#ctl00_body_Sub").bind("click",function(){
		    $(this).unbind("click");
		    
			zhuanjihuobi_go();
			return false;
		});	
		
	function jinbi_fukuan(rid){
	    layer.msg("是否确认打米.",{time: 20000, btn: ['确定打米', '我点错了'],btn1: function(){jihuo_fuk(rid)}});	
	}
	
	function jihuo_fuk(c){
		tishi2();
		$.get("/mobile/bin.php?act=querenshoukuan&id="+encodeURI(c),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='打米成功'){
					layer.msg("打米成功,3秒后返回",function(){location.reload();});
					}else{
					layer.msg(unescape(e))
					}
				}
			},'html');
	}
	
	function jinbi_ok(rid){
	    layer.msg("是否确认转账.",{time: 20000, btn: ['确认转账', '我点错了'],btn1: function(){jinbi_ok2(rid)}});	
	}
	
	function jinbi_ok2(c){
		tishi2();
		$.get("/mobile/bin.php?act=jinbi_ok&id="+encodeURI(c),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='提交成功'){
					layer.msg("提交成功,3秒后返回",function(){location.reload();});
					}else{
					layer.msg(unescape(e))
					}
				}
			},'html');
	}

	function jinbi_off(rid){
		
	    layer.msg("是否确认.",{time: 20000, btn: ['确定', '我点错了'],btn1: function(){jinbi_off2(rid)}});	
	}
	
	function jinbi_off2(c){
		tishi2();
		$.get("/mobile/bin.php?act=jinbi_off&id="+encodeURI(c),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='取消成功'){
					layer.msg("取消成功,3秒后返回",function(){location.reload();});
					}else{
					layer.msg(unescape(e))
					}
				}
			},'html');
	}

	function jinbi_shoumi(rid){
		
	    layer.msg("是否确认收款.",{time: 20000, btn: ['确定收款', '我点错了'],btn1: function(){jinbi_shoumi2(rid)}});	
	}
	
	function jinbi_shoumi2(c){
		tishi2();
		$.get("/mobile/bin.php?act=jinbi_shoumi&id="+encodeURI(c),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='收米成功'){
					layer.msg("收米成功,3秒后返回",function(){location.reload();});
					}else{
					layer.msg(unescape(e), function(){location.reload();});
					}
				}
			},'html');
	}



	function zhuanjihuobi_go(){
		if($("#x1").val()==""){
			tishi4("请输入填写你充值KK的金额",'#x1');
			return false;
			}
			
		if(!checkNum($("#x1").val())){
			tishi4("请输入正确的金额 至少转1激活KK",'#x1');
			return false;
			}

		$("#x1").val(parseInt(parseFloat($("#x1").val())/10)*10);
		
		if(parseFloat($("#x1").val())>parseFloat($("#mejihuobi").text())){
			tishi4("你的KK余额不足",'#x1');
			return false;			
			}
		/*if(!checkMobile($("#x3").val())){
			tishi4("请输入正确的玩家编号",'#x3');
			return false;
		}*/
		if($("#x2").val()==""){
			tishi4("请输入填写真实姓名",'#x1');
			return false;
			}			

		var lcindex_ = layer.prompt({title: '请输入安全密码，并确认转账',formType: 1}, function(pass){
			if(pass==""){
				layer.msg("请输入您的密码")
				return false;
				}
			tishi2();
			$.get("/mobile/bin.php?act=point2_transfer&num="+$("#x1").val()+"&username="+$("#x3").val()+"&pwdII="+pass,function(e){
			tishi2close();
			layer.close(lcindex_);
			if(e!=""){
				//$("#x4-cos").html(unescape(e));
				if(unescape(e)=="转账成功"){
						layer.msg("成功,2秒后返回",{time: 2000, btn: ['确定'],end:function(){location.reload(); }
						});
					}else{
						//layer.msg($("#x4-cos").text(),{time: 3000, btn: ['确定'],end:function(){$("#x4-cos").html("");$("#x2").val("");}});
						layer.alert(unescape(e));
					}	
				}	
			},'html');
			});
		}	
    </script>
    
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>