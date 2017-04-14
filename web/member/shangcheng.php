<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '商城转账 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>交易管理 <small> KK转账</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">交易管理</a></li>
  <li class="active">KK转账</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">KK转账</div>
  <div class="panel-body">
   <!--主-->

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <span style="color:#F00">
 
	<?php
	$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
	$rs = $db->get_one($sql);
	?>
    您好! <strong><?php echo $rs['h_fullName']; ?></strong> (<?php echo $rs['h_userName']; ?>). 您的可转出KK为:<span id="mejihuobi"><?php echo $rs['h_point2']; ?>。转入商城后不可退回</span>
  
  
      </span>
    </div>
  </div>
 
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">转入商城</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x1" placeholder="请输入要转入商城的金额" value="" maxlength="11">
    </div>
  </div>

 


  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10" id="x4-cos"></div>
  </div> 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning zhuanjihuobi_go">马上转账</button>
    </div>
  </div>
    <!--End-->
  </div>

</div>
</div>
<!--MAN End-->


</div></div>

    <script src="/ui/layer/extend/layer.ext.js"></script>
    <script>
	mgo(47);
$(".zhuanjihuobi_go").bind("click",function(){
		    $(this).unbind("click");
		    
			zhuanjihuobi_go();
			return false;
		});	
		


	function zhuanjihuobi_go(){
		if($("#x1").val()==""){
			tishi4("请输入填写你转入的金额",'#x1');
			return false;
			}
		/*if(!checkMobile($("#x3").val())){
			tishi4("请输入正确的玩家编号",'#x3');
			return false;
		}*/
			$.get("/member/bin.php?act=shangcheng&num="+$("#x1").val(),function(e){
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
			});
		}	
    </script>
    
<?php
require_once 'inc_footer.php';
?>