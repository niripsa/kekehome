<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '安全密码 - ';
$go = $_GET['go'];
require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>安全管理 <small> 安全密码</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">安全管理</a></li>
  <li class="active">安全密码</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">安全密码</div>
  <div class="panel-body">
   <!--主-->
   <form class="form-horizontal">
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">安全密码</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x1" placeholder="请输入安全密码" type = "password" value="" maxlength="18">
    </div>
  </div>

 


  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10" id="x4-cos"></div>
  </div> 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning zhuanjihuobi_go">确认提交</button>
    </div>
  </div>
</form>
    <!--End-->
  </div>

</div>
</div>
<!--MAN End-->


</div></div>

    <script src="/ui/layer/extend/layer.ext.js"></script>
   <script>
	
	console.log('yes');
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
	


	$(".zhuanjihuobi_go").bind("click",function(){
		    $(this).unbind("click");
		    
			zhuanjihuobi_go();
			return false;
		});	

	function zhuanjihuobi_go(){
		if($("#x1").val()==""){
			tishi4("请输入安全密码",'#x1');
			return false;
			}

			console.log("<?php echo $go; ?>");
			
			$.get("/mobile/bin.php?act=pwd2&pwd2="+$("#x1").val()+"&go=" + "<?php echo $go; ?>",function(e){
			if(e!=""){
				//$("#x4-cos").html(unescape(e));
				if(unescape(e)=="success"){
					layer.msg("输入正确，正在跳转",{time: 2000, btn: ['确定'],end:function(){window.location.href = "<?php echo $go; ?>";}
						});
					}else{
						//layer.msg($("#x4-cos").text(),{time: 3000, btn: ['确定'],end:function(){$("#x4-cos").html("");$("#x2").val("");}});
						layer.msg(unescape(e),{time: 2000, btn: ['确定'],end:function(){location.reload(); }
						});
					}	
				}	
			},'html');
		}	
    </script>
    
<?php
require_once 'inc_footer.php';
?>