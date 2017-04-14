<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = 'KK购买记录';

require_once 'inc_header.php';
require_once 't.php';
?>
<style>
body{
	font-size:13px
}
</style>
<strong><span style="color:#F00;">警告:</span></strong><br>
<span style="color:#F00; font-weight:bold;">1.请立即向对方支付宝打款,30分钟内未付款 则视为恶意交易,系统会扣除您的违约金 具体为: 主动放弃交易扣除<?php echo $webInfo['h_point2Quit'];?>KK  超过30分钟超时 扣除20KK,没有打款而点确认付款的扣除3倍本次交易总额KK</span><br>
<span style="color:#F00;">2.向对方支付宝账号打款成功后,请把点击后面的'<strong>我已付款</strong>'按钮 确认付款,等待卖家确认,这时候您可以主动通过微信或者电话联系卖家确认收款</span><br>
<span style="color:#F00;">3.如果付款完成,卖家长时间不确认收货,请联系公司出面解决,届时会对卖家做相应惩罚,并给予您补偿</span><br>
</div>
   
<table border = "1" style="width:100%;border-color: #00a1e5;" class="table table-striped table-hover">
  
<?php
list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	$mid = 111;
	$total_count = $db->counter('h_point2_sell', "h_buyUserName = '{$memberLogged_userName}'", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_point2_sell` where h_buyUserName = '{$memberLogged_userName}' order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
	echo '购买时间：' , $val['h_buyTime'] , '<br />';
	if($val['h_buyIsPay']){
		echo '<span style="color:#0000ff">已付款</span><br />';
	}else{
		echo '<span style="color:#ff0000">未付款</span><br />';
	}
				echo '</td>
				<tr>
				<td>' , $val['h_money'] , 'KK</td>
				<td>'.$val['h_state'].'</td>
				<td colspan="3" style="text-align:center">';
				
				if($val['h_state'] == '等待买家付款'){
					echo '<button onclick="jinbi_fukuan(' , $val['id'] , ')" class="btn btn-success guadan_go" type="button">我已付款</button>';
					echo ' &nbsp; <button onclick="jinbi_fukuan2(' , $val['id'] , ')" class="btn btn-danger" type="button">放弃购买</button>';
				}else{
					echo '-';
				}
				
				echo '</td>
			  </tr>
			  <tr style="height:20px;border:none"><tr>';
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

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.wallform.js"></script>
<script type="text/javascript">
/*$(function(){
	$('#photoimg').die('click').live('change', function(){
		var status = $("#up_status");
		var btn = $("#up_btn");
		if(document.getElementById("photoimg").value == '')alert("空");
		$("#imageform").ajaxForm({
			target: '#preview', 
			beforeSubmit:function(){
				status.show();
				btn.hide();
			}, 
			success:function(){
				status.hide();
				btn.show();
			}, 
			error:function(){
				status.hide();
				btn.show();
		} }).submit();
	});
});*/
function upimg(t)
{
  var top = $(t).parent().parent().parent().parent().parent();
  var status = top.find("#up_status");
  var btn = top.find("#up_btn");
  var imageform = top.find("#imageform");
  var photoimg = top.find("#photoimg");
  var preview = top.find("#preview");
  var rid = top.find("#rid");
  var imgurl = top.find("#imgurl");
  rid.val($("#rid").val());
  
  imageform.ajaxForm({
			target: '#preview', 
			beforeSubmit:function(){
			    
				status.show();
				btn.hide();
			}, 
			success:function(){
			    preview.html($("#preview").html());
				var imgurl1 = preview.find(".preview");
				imgurl.val(imgurl.val() + imgurl1.attr("src") + '|');
				status.hide();
				btn.show();
			}, 
			error:function(){
				status.hide();
				btn.show();
		} }).submit();
}

function guajinbi(t){
  var top = $(t).parent().parent().parent().parent().parent();
  var imageform = top.find("#imageform");
  var rid = top.find("#rid").val();
  imageform.attr('action','upload1.php');
  
  imageform.ajaxForm({
			target: '#preview', 
			beforeSubmit:function(){

			}, 
			success:function(){
			   layer.close(indexdd);
			   layer.msg("确认支付宝打款成功,才能确认付款,否则将受严重惩罚.",{time: 20000, btn: ['确定付款', '我点错了'],btn1: function(){jihuo_fuk(rid)}});
			}, 
			error:function(){
				
		} }).submit();
}
</script>
<div class="shouhuodizhi" id="shouhuodizhi" style="display:none;">

<div style="padding:20px 50px;">
<form class="form-horizontal" id="imageform" name="imageform" method="post" enctype="multipart/form-data" action="upload.php">
   <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
   <div id="preview"></div>
   <div id="up_btn" class="btn">
     <span>添加图片</span>
	   <input id="photoimg" type="file" onChange="upimg(this)" name="photoimg" />
	   <input id="rid" name="rid" type="text" style="display:none;" />
	   <input id="imgurl" name="imgurl" type="text" style="display:none;" />
   </div>
  <p>最大100KB，支持jpg，gif，png格式。</p>
  <div class="form-group"></div>
   <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-primary btn-block" onClick="guajinbi(this);return false;">提交打款截图</button>
    </div>
  </div> 
</form>
</div>
</div>
<style type="text/css">
.preview{width:200px;border:solid 1px #dedede; margin:10px;padding:10px;}
.demo p{line-height:26px}
.form-horizontal .btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
</style>

 <script>
	mgo(42);
	var indexdd;
	
	function jinbi_fukuan(rid){
	    $("#rid").val(rid);
	    if(browserWidth<800){
            indexdd=layer.open({type: 1,title:'上传打款截图',skin: 'layui-layer-rim',content: $("#shouhuodizhi").html()});
        }else{
	        indexdd=layer.open({type: 1,title:'上传打款截图',area: '750px',skin: 'layui-layer-rim',content: $("#shouhuodizhi").html()});
        }
	    //layer.msg("确认支付宝打款成功,才能确认付款,否则将受严重惩罚.",{time: 20000, btn: ['确定付款', '我点错了'],btn1: function(){jihuo_fuk(rid)}});	
	}
		
	function jihuo_fuk(c){
		tishi2();
		$.get("/mobile/bin.php?act=point2_buy_payed&id="+encodeURI(c),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='付款成功'){
					layer.msg("付款成功,等待卖家确认,3秒后返回",function(){location.reload();});
					}else{
					layer.msg(unescape(e))
					}
				}
			},'html');
		}
		
	function jinbi_fukuan2(rid){
	    layer.msg("确认放弃本次交易,因为您违约,将会扣除您<?php echo $webInfo['h_point2Quit'];?>KK?",{time: 20000, btn: ['确定放弃', '我点错了'],btn1: function(){jihuo_fuk2(rid)}});	
		}
		
	function jihuo_fuk2(c){
		tishi2();
		$.get("/mobile/bin.php?act=point2_buy_quit&id="+encodeURI(c),function(e){
			tishi2close();
			if(e!=""){
				if(unescape(e)=='放弃成功'){
					layer.msg("已经放弃本次交易,3秒后返回",function(){location.reload();});
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