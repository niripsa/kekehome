<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '我的信息 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>站内信 <small> 我的信息</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">站内信</a></li>
  <li class="active">我的信息</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">我的短信息</div>
   
<div class="panel-body">
    <button type="button" class="btn btn-primary" onclick="window.location.href='?clause=in'">收件箱</button>
    <button type="button" class="btn btn-primary" onclick="window.location.href='?clause=out'">发件箱</button>
    
	<button type="button" class="btn btn-primary" id="xiexinxi" style="float:right;">写信息</button>
</div>
   
<table class="table table-striped table-hover">
  <tr>
    <td>发送人</td>
    <td>收件人</td>
    <td>时间</td>
    <td>预览</td>
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
	$clause = $_GET['clause'];
	$mid = 111;
	
	if($clause == 'out'){
		$where = "h_userName = '{$memberLogged_userName}' and h_isDelete = 0";
	}else{
		$where = "(h_toUserName = '{$memberLogged_userName}' or h_toUserName = '[所有会员]') and h_isDelete = 0";
	}
	
	$total_count = $db->counter('h_member_msg', $where, 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_member_msg` where {$where} order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
			echo '  <tr uid="' , ($val['h_userName'] == $memberLogged_userName || $val['h_userName'] ==  '[系统消息]' ? '' : $val['h_userName']) , '">
				<td>';
				if($val['h_toUserName'] != '[所有会员]'){
					$mread = 0;
					if($clause != 'out'){
						//收到的信息，需要阅读后即为看过状态
						$mread = 1;
					}
					
					if($val['h_isRead']){
						echo '<span aria-hidden="true" mread="' , $mread , '" class="glyphicon glyphicon-envelope"></span> ';
					}else{
						echo '<span aria-hidden="true" mread="' , $mread , '" class="glyphicon glyphicon-envelope youjian"></span> ';
					}
				}
				echo $val['h_userName'];
				echo '</td>
				<td>';
				/*
				if($clause == 'out'){
					if($val['h_isRead']){
						echo '<span aria-hidden="true" class="glyphicon glyphicon-envelope"></span> ';
					}else{
						echo '<span aria-hidden="true" class="glyphicon glyphicon-envelope youjian"></span> ';
					}
				}
				*/
				echo $val['h_toUserName'];
				echo '</td>
				<td>' , $val['h_addTime'] , '</td>
				<td>' , shortStringCn($val['h_info'],40) , '</td>
				<td>';
				
				echo '<button cid="' , $val['id'] , '" class="btn btn-success goneirong" type="button">详情</button>';
				
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
}
?>
 
</table>


</div>
</div>
<!--MAN End-->
</div></div>

<div class="shouhuodizhi" id="shouhuodizhi" style="display:none;">
<div style="padding:20px 50px;">
<form class="form-horizontal">
   <div class="form-group">
    <label for="x1" class="col-sm-3 control-label">收信人:</label>
    <div class="col-sm-9">
    <input class="form-control" id="x1" value = "[管理员]" readonly>
    [<a href="javascript:void(0)">发送一次消耗10KK</a>]
    </div>
  </div>
 
   <div class="form-group">
    <label for="x2" class="col-sm-3 control-label">发送内容:</label>
    <div class="col-sm-9">
    <textarea class="form-control" rows="3" id="x2"  placeholder="短信内容"></textarea>
    </div>
  </div>
  <div class="form-group"></div>
   <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-primary btn-block" onClick="xiexxgo(this);return false;">发送信息</button>
    </div>
  </div> 
</form>
</div>
</div>

 <script>
	$("#mlindex").addClass("btn-long16");
	var indexdd;
	$(".goneirong").click(function(e) {
		var ti=$(this);
		var data="id="+encodeURI(ti.attr("cid"));
		var uid=ti.parent().parent().attr('uid');
		var tit=ti.text();
		$.post("/member/bin.php?act=msg_get",data,function(e){
			tishi2close();
			if(e!=""){
				$(ti).parent().parent().find("span[mread='1']").removeClass('youjian');
				if(uid){
					layer.msg(tit+':<br>'+unescape(e),{time: 20000,skin: 'long-class', btn: ['马上回复', '取消'],btn1: function(){
						$("#xiexinxi").trigger('click');
						$('#x1').val(uid);
					}})
				}else{
						
					layer.msg(tit+':<br>'+unescape(e),{time: 20000,skin: 'long-class', btn: ['确定'],btn1: function(){}})	
				}
				}	
			},'html'
			);	
		
		
		return false;
    });
	
	$("#xiexinxi").click(function(e) {
        indexdd=layer.open({type: 1,title:'写信息',area: '600px',skin: 'layui-layer-rim',content: $("#shouhuodizhi")});
    });
	function xiexxgo(t){
		var top=$(t).parent().parent().parent();
		var x1=top.find("#x1").val();
		var x2=top.find("#x2").val();
		if(!checkMobile(x1) && x1 != '[管理员]'){
			tishi4('玩家编号不正确',top.find("#x1"));
			return false;
			}
		if(x2==''){
			tishi4('请填写短信内容',top.find("#x2"));
			return false;
			}
		var data="username="+encodeURI(x1)+"&info="+encodeURI(x2);
		$.post("/member/bin.php?act=msg_post",data,function(e){
			tishi2close();
			if(e!=""){
					layer.msg(unescape(e),{time: 500,shade: 0.3,end:function(){
						if (unescape(e)=="信件已发出"){window.location.href='/member/msg.php?clause=out';}
						}})
				}	
			},'html'
			);	
		return false;
		}
	
    </script>
    
<?php
require_once 'inc_footer.php';
?>