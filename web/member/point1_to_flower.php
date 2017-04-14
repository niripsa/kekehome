<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
$pageTitle = '种子转换KK - ';
require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>交易管理 <small> 种子转换KK</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">交易管理</a></li>
  <li class="active">种子转换KK</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">种子转换KK</div>
   

  <div class="panel-body">
   <!--主-->
   <form class="form-horizontal">

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <span >
			<?php
				$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
				$rs = $db->get_one($sql);
			?>
		  您好! <strong><?php echo $rs['h_fullName']; ?></strong> - (<?php echo $rs['h_userName']; ?>). 您的可转换种子为:<span id="mejihuobi"><?php echo $rs['h_point1']; ?></span>  
      </span>
    </div>
  </div>

  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">种子</label>
    <div class="col-sm-10">
      <input class="form-control form-long-w1" id="x1" placeholder="请输入要转换的种子" value="" maxlength="11">
      <br/>
      <font color="red" >注：转换种子的数量是100的倍数，才能转。(转换手续费10%)</font>
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
</form>
    <!--End-->
  </div>
   


</div>
</div>
<!--MAN End-->
</div></div>

<script src="/ui/layer/extend/layer.ext.js"></script>
    <script>
	mgo(44);

	$(".zhuanjihuobi_go").click(function () {
			zhuanjihuobi_go();
			return false;
		});	
	function zhuanjihuobi_go(){
		if($("#x1").val()==""){
			tishi4("请输入填写你种子的数量",'#x1');
			return false;
			}
		
		if(!checkNum($("#x1").val())  ||　$("#x1").val()<100){
			tishi4("请输入正确的种子个数，至少转100种子",'#x1');
			return false;
			}
		if(!isNumberBy100($("#x1").val())){
			tishi4("请输入正确的种子个数，必须是 100的倍数。",'#x1');
			return false;
		}
		if(parseFloat($("#x1").val())>parseFloat($("#mejihuobi").text())){
			tishi4("你的种子余额不足",'#x1');
			return false;			
			}
						
		
			tishi4($("#x4-cos").text(),'#x2');
			
		var lcindex_ = layer.prompt({title: '请输入安全密码，并确认转换',formType: 1}, function(pass){
			if(pass==""){
				layer.msg("请输入您的密码")
				return false;
				}
			tishi2();
			$.get("/member/bin.php?act=point1_to_flower&num="+$("#x1").val()+"&pwdII="+pass,function(e){
			tishi2close();
			layer.close(lcindex_);
			if(e!=""){
				//$("#x4-cos").html(unescape(e));

				if(!isNaN(unescape(e))){
					layer.msg("转账成功,2秒后返回",{time: 2000, btn: ['确定'],end:function(){
						    $('#mejihuobi').empty().html(unescape(e));
							location.reload(); 
						}});
					}else{
						layer.alert(unescape(e));
					}
				}
			},'html');
			});
	}	

	function isNumberBy100(ssn) {
		 var re = /^[0-9]*[0-9]$/i;       //校验是否为数字
		 if(re.test(ssn) && ssn%100===0) {
		  return true;
		 }else {
		  return false;
		 }
	}
    </script>



<?php
require_once 'inc_footer.php';
?>