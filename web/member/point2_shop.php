<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '商城购物 - ';

require_once 'inc_header.php';
?>

<?php
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>
<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>购买商品 <small> 商城购物</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">购买商品</a></li>
  <li class="active">商城购物</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">商城购物</div>
   

   
<table class="long_table">
<tr class="tb_top">
<td></td>
<td>商品</td>
<td>单价(KK)</td>
<td>数量</td>
<td>小计</td>
</tr>


<?php
list_();
function list_(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	global $memberLogged_level;
	$mid = 111;
	$total_count = $db->counter('h_point2_shop', "", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_point2_shop` order by h_minMemberLevel asc,h_minComMembers asc,h_money asc,id asc LIMIT $from_record, $list_num";
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
			echo '<tr uid="' , $val['id'] , '" >
    <td align="center" valign="middle" width="10" style="padding-right:10px;"><img src="' , $val['h_pic'] , '" style="height:100px; width:auto;"></td>
    <td width="50%" style="padding-right:10px;"><h5><strong>' , $val['h_title'] , '</strong></h5>
    <p>' , $val['h_info'] , '</p>
    <p>需要直推人数:' , $val['h_minComMembers'] , ' &nbsp;&nbsp; 需要等级: ' , get_member_level_span($val['h_minMemberLevel']) , '</p>
    </td>
    <td valign="middle"> ' , $val['h_money'] , '</td>
    <td valign="middle">';
    
	if($memberLogged_level >= $val['h_minMemberLevel']){
		echo '<div class="input-group" style="width:130px;">
			<span class="input-group-btn"><button class="btn btn-default j_jian" type="button"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></span>
			<input type="text" class="form-control" value="0" maxlength="3" id="j_shuliang" >
			<span class="input-group-btn"><button class="btn btn-default j_jia" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
		</div>';
	}else{
		echo '条件不够';
	}
    
	echo '</td>
    <td valign="middle" width="100" style="padding-left:10px;"><span style="font-weight:bold;" id="j_danjia">0</span></td>
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
  

    <tr class="tb_bottom"><td colspan='5' align="right">
    您的直推人数量为:<?php echo $rs['comMembers']; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    您的当前等级是: <?php echo get_member_level_span($rs['h_level']); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    您的当前KK余额为:
    <span style="color:#C30; font-weight:bold;"><span class="glyphicon glyphicon-yen" aria-hidden="true"></span><span id="j_jinbi"><?php echo $rs['h_point2']; ?></span></span>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    您已选择<span id="j_zongshu"></span>个商品
    &nbsp;&nbsp;&nbsp;&nbsp;
    总价(KK):<span style="color:#C30; font-weight:bold;"><span class="glyphicon glyphicon-yen" aria-hidden="true"></span><span id="j_zongjia"></span></span>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-danger" id="goumaigo">立即购买</button>
    </td></tr>


</table>
</div>
</div>
<!--MAN End-->
</div></div>



<div class="shouhuodizhi" id="shouhuodizhi" style="display:none;">
<div style="padding:20px 50px;">
  
<form class="form-horizontal">
  <div class="form-group">
    <label for="x1" class="col-sm-2 control-label">收货地址:</label>
    <div class="col-sm-10">
      <input class="form-control" id="x1" placeholder="收货人地址" value="<?php echo $rs['h_addrAddress']; ?>">
    </div>
  </div>
    <div class="form-group">
    <label for="x2" class="col-sm-2 control-label">邮政编码:</label>
    <div class="col-sm-10">
      <input class="form-control" id="x2" placeholder="邮政编码" value="<?php echo $rs['h_addrPostcode']; ?>">
    </div>
  </div>  <div class="form-group">
    <label for="x3" class="col-sm-2 control-label">收 货 人:</label>
    <div class="col-sm-10">
      <input class="form-control" id="x3" placeholder="收货人姓名" value="<?php echo $rs['h_addrFullName']; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="x4" class="col-sm-2 control-label">手机号码:</label>
    <div class="col-sm-10">
      <input class="form-control" id="x4" placeholder="收货人手机号码" value="<?php echo $rs['h_addrTel']; ?>">
    </div>
  </div>
 
   <div class="form-group">
    <label for="x6" class="col-sm-2 control-label">备注:</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="3" id="x6" placeholder="订单备注"></textarea>
    </div>
  </div>
   <!--
 <div class="form-group">
    <div class="col-sm-offset-4 col-sm-10">
      <div class="checkbox"><label><input type="checkbox" checked="checked" id="x5"> 设置为默认收货地址 </label></div>
    </div>
  </div>-->

   <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-primary btn-block" onClick="tanchuceshigo(this);return false;">确认提交订单</button>
    </div>
  </div> 
</form>
</div>
</div>

    <script>
	mgo(51);
	var zongjia=0;
	var zongshu=0;
	var cpidz = new Array;
	var cpslz = new Array;
	var myvip=0;
	kongzhi();

	$("[id=j_shuliang]").bind('input propertychange', function() {
		var sl=$(this).val();
		if(parseInt(sl)>=0 && parseInt(sl)<1000){

			}else{
			tishi4('请输入0-999之间的数字',this)
			$(this).val("0");
				}
		kongzhi();
		});
			
	$(".j_jian").click(function(e){
        jbjisuan(this,"-")
    });
	$(".j_jia").click(function(e){
        jbjisuan(this,"+")
    });
	
	function jbjisuan(t,x){
		var shuliang;
		if(x=="-"){
				shuliang=$(t).parent().next("#j_shuliang");
				shuliang.val(parseInt(shuliang.val())-1);
			}else
			{
				shuliang=$(t).parent().prev("#j_shuliang");
				shuliang.val(parseInt(shuliang.val())+1);
				}
		kongzhi();		
		//alert(shuliang.val());
		}
	
	function kongzhi(){
		zongjia=0;
		zongshu=0;
		$("[id=j_shuliang]").each(function(index, element) {
			var sl=parseInt($(element).val());
            if(sl<=0){
				$(element).prev().find(".j_jian").attr("disabled",true);
				$(element).val("0");
				}else{
				$(element).prev().find(".j_jian").attr("disabled",false);
					}
			if(sl>=999){
				$(element).next().find(".j_jia").attr("disabled",true);
				$(element).val("999");
				}else{
				$(element).next().find(".j_jia").attr("disabled",false);	
					}
			var x1=parseInt($(element).val());
			var x2=parseInt($(element).parent().parent().prev().text());
			$(element).parent().parent().next().find("#j_danjia").html(x1*x2);
			zongjia=zongjia+(x1*x2);
			zongshu=zongshu+x1;
			$("#j_zongjia").html(zongjia);
			$("#j_zongshu").html(zongshu);
        });
		}	
		
	$("#goumaigo").click(function(e){
		var mejinbi=parseFloat($("#j_jinbi").text());
		if(zongshu<=0){
			tishi4('您什么都没有购买',this)
			return false;
			}
        if(mejinbi<zongjia){
			tishi4('您的余额不足',this)
			return false;
			}
			
		$("[id=j_shuliang]").each(function(index, element) {
			var sl=parseInt($(element).val());
			var tid=parseInt($(element).parent().parent().parent().attr("uid"));
			if(sl>0){
				cpidz.push(tid);
				cpslz.push(sl);
				}	
			});
		if(browserWidth<800){
			layer.open({type: 1,title:'请确认和修改收货地址',skin: 'layui-layer-rim',content: $("#shouhuodizhi").html()});
		}else{
			layer.open({type: 1,title:'请确认和修改收货地址',area: '750px',skin: 'layui-layer-rim',content: $("#shouhuodizhi").html()});
		}
    });
	
	$("#ceshi22").click(function(e){
		layer.open({type: 1,title:'请确认和修改收货地址',skin: 'layui-layer-rim',content: $("#shouhuodizhi").html()});
	})

	function tanchuceshigo(t){
		var top=$(t).parent().parent().parent();
		var x1=top.find("#x1").val();
		var x2=top.find("#x2").val();
		var x3=top.find("#x3").val();
		var x4=top.find("#x4").val();
		var x5=top.find("#x5").prop('checked');
		var x6=top.find("#x6").val();
		if(x1==""){
			tishi4('请填写您的收货地址',top.find("#x1"));
			return false;
			}
		if(x2==""){
			tishi4('请填写收货邮政编码',top.find("#x2"));
			return false;
			}
		if(x3==""){
			tishi4('请填写收货人姓名',top.find("#x3"));
			return false;
			}
		if(x4==""){
			tishi4('请填写您的取货手机号码',top.find("#x4"));
			return false;
			}
		if(!checkMobile(x4)){
			tishi4('手机号码不正确',top.find("#x4"));
			return false;
			}
		tishi2();
		//if(x5){$.get("/member/bin.php?act=savashdizhi&x1="+encodeURI(x1)+"&x2="+encodeURI(x2)+"&x3="+encodeURI(x3)+"&x4="+encodeURI(x4)+"&x5="+encodeURI(x5),function(e){
				//tishi2close();
				var url="/member/bin.php?act=point2_shop_buy&goodsIds="+cpidz.toString()+"&goodsNums="+cpslz.toString()+"&address="+encodeURI(x1)+"&postcode="+encodeURI(x2)+"&fullname="+encodeURI(x3)+"&tel="+encodeURI(x4)+"&remark="+encodeURI(x6);
				$.get(url,function(e){
				tishi2close();
				if(unescape(e)=="购买成功"){
					layer.msg('恭喜,购买成功',{shade:0.3,end:function(){
							location.reload();
						}});
				}else{
					layer.msg(unescape(e));
					}
				},'html'
				);
			//})};
		}
	
    </script>

    
<?php
require_once 'inc_footer.php';
?>