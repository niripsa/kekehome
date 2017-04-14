<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
function listgo(){
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
				$val['h_addTime'] = date("m-d",strtotime($val['h_addTime']));
				echo '</td>
				<td>' , $val['h_addTime'] , '</td>
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
if(!$_GET['clause']){
	$ti  = '站内信';
}elseif($_GET['clause'] == 'in'){
	$ti  = '收件箱';
}elseif($_GET['clause'] == 'out'){
	$ti  = '发件箱';
}
$pageTitle = $ti;

require_once 'inc_header.php';
require_once 't.php';
if(!$_GET['clause']){
?>


        
    <div class="grow-menu " data-url="/mobile/msg.php?clause=in">
        <img src="/mod/index-menu-msg.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">收件箱</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
	<div class="grow-menu " data-url="/mobile/msg.php?clause=out">
        <img src="/mod/index-menu-msg.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">发件箱</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
	<div class="grow-menu " id="xiexinxi" data-url="1">
        <img src="/mod/index-menu-msg.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">写信息</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>

    <script type="text/javascript">
        $(".grow-menu").on('click', function() {
			if(this.dataset.url != 1){
            window.location.href = this.dataset.url;
			}
        });
    </script>
    
    <script type="text/javascript">
        var path = "";
        var href = 'javascript:void(0);';
        var onClick = 'javascript:void(0);';
    </script>
    
        
    
    <script type="text/javascript">
        $(".head-icon-left").on("click", function () {
            window.history.go(-1);
        });

        if (path != undefined && path.length > 0) {
            document.write("<div id='dd' class='float-icon'><a href='"+href+"' onclick='"+onClick+"' /><img src='" + path + "'  class='float-icon-img'></a></div>");
        }
    </script>
<? }elseif($_GET['clause'] == 'in'){ ?>
<div class="content">
        <table style="width: 100%;">
            <thead style="color:red;text-align:center;font-size:12px">
                 <tr>
	<td>发送人</td>
    <td>收件人</td>
    <td>时间</td>
	<td>操作</td>
  </tr>
            </thead>
            <tbody style="background: #ffffff;">
<?php
listgo();
?>
<? }elseif($_GET['clause'] == 'out'){ ?>
<div class="content">
        <table style="width: 100%;">
            <thead style="color:red;text-align:center;font-size:12px">
                 <tr>
	<td>发送人</td>
    <td>收件人</td>
    <td>时间</td>
	<td>操作</td>
  </tr>
            </thead>
            <tbody style="background: #ffffff;">
			<?php
listgo();
?>
<? } ?>

<div class="shouhuodizhi" id="shouhuodizhi" style="display:none;">
<div style="padding:20px 50px;">
<form class="form-horizontal">
   <div class="form-group">
    <label for="x1" class="col-sm-3 control-label">收信人:</label>
    <div class="col-sm-9">
    <input style="width:100%" class="form-control" value = "[管理员]" readonly id="x1" >
    <br>[<a href="javascript:void(0)">发送一次消耗10KK</a>]
    </div>
  </div>
 
   <div class="form-group">
    <label for="x2" class="col-sm-3 control-label">发送内容:</label>
    <div class="col-sm-9">
    <textarea style="width:100%;height:200px" class="form-control" rows="3" id="x2"  placeholder="短信内容"></textarea>
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
		$.post("/mobile/bin.php?act=msg_get",data,function(e){
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
        indexdd=layer.open({type: 1,title:'写信息',area: '90%',skin: 'layui-layer-rim',content: $("#shouhuodizhi")});
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
		$.post("/mobile/bin.php?act=msg_post",data,function(e){
			tishi2close();
			if(e!=""){
					layer.msg(unescape(e),{time: 500,shade: 0.3,end:function(){
						if (unescape(e)=="信件已发出"){window.location.href='/mobile/msg.php?clause=out';}
						}})
				}	
			},'html'
			);	
		return false;
		}
	
    </script>
    
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>