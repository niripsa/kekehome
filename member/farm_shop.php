<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '宠物商店 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>庄园管理 <small> 宠物商店</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">庄园管理</a></li>
  <li class="active">宠物商店</li>
</ol>
</div>


<div class="panel panel-default">
  <div class="panel-heading">可可商店</div>
   

   
<table class="long_table">
<tr class="tb_top">
<td></td>
<td>庄园</td>
<td align="center">单价(KK)</td>
<td align="center">数量</td>
<td>小计</td>
</tr>

<?php
	$query = "select * from `h_farm_shop` order by h_minMemberLevel asc,id asc";
	$result = $db->query($query);
	while($rs_list = $db->fetch_array($result))
	{
		$lifePoint2 = intval($rs_list['h_point2Day']) * intval($rs_list['h_life']);
			echo '<tr uid="' , $rs_list['id'] , '" vip="' , $rs_list['h_minMemberLevel'] , '">
    <td align="center" valign="middle" width="200"><img src="' , $rs_list['h_pic'] , '" style="height:100px; width:auto;"></td>
    <td><h5><strong>' , $rs_list['h_title'] , '</strong></h5>
    
    </td>
    <td valign="middle" align="center">' , $rs_list['h_money'] , '</td>
    <td valign="middle" align="center">';
    
	if($memberLogged_level == $rs_list['h_minMemberLevel']){
		echo '<div class="input-group" style="width:130px;">
			<span class="input-group-btn"><button class="btn btn-default j_jian" type="button"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></span>
			<input type="text" class="form-control" value="0" maxlength="3" id="j_shuliang" >
			<span class="input-group-btn"><button class="btn btn-default j_jia" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
		</div>';
	}else{
		echo '等级不符';
	}
    
	echo '</td>
    <td valign="middle" align="left" width="100"><span style="font-weight:bold;" id="j_danjia">0</span></td>
  </tr>';
	}
?>
<!--<p>产能:' , $lifePoint2 , 'KK 每天产生' , $rs_list['h_point2Day'] , 'KK,可生存' , $rs_list['h_life'] , '天</p>
    <p>每天限购:' , $rs_list['h_dayBuyMaxNum'] , '只,庄园限养（同时存在）：' , $rs_list['h_alKKaxNum'] , '只</p>
    <p>需要等级: ' , get_member_level_span($rs_list['h_minMemberLevel']) , '</p><p>每天产生' , $rs_list['h_point2Day'] , 'KK</p>-->

    <tr class="tb_bottom"><td colspan='5' align="right">
<?php
$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
$rs = $db->get_one($sql);
?>
    您的当前等级是: <?php echo get_member_level_span($rs['h_level']);?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    您的当前KK余额为:<span style="color:#C30; font-weight:bold;"><span class="glyphicon glyphicon-yen" aria-hidden="true"></span><span id="j_jinbi"><?php echo $rs['h_point2'];?></span></span>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    您已选择<span id="j_zongshu"></span>个商品
    &nbsp;&nbsp;&nbsp;&nbsp;
    总价(KK):<span style="color:#C30; font-weight:bold;"><span class="glyphicon glyphicon-yen" aria-hidden="true"></span><span id="j_zongjia"></span></span>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-danger" id="goumaigo">立即购买</button>
    </td>
    </tr>

</table>
</div>
</div>
<!--MAN End-->
</div></div>

    <script>
	mgo(12);
	var zongjia=0;
	var zongshu=0;
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
/*			var tvip=parseInt($(element).parent().parent().parent().attr("vip"));
			if(myvip<tvip){
				tishi4('您的会员等级不足,无法购买',element)
				$(element).val("0");
				return false;
				}*/
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
		var cpidz = new Array;
		var cpslz = new Array;
		$("[id=j_shuliang]").each(function(index, element) {
			var sl=parseInt($(element).val());
			var tid=parseInt($(element).parent().parent().parent().attr("uid"));
			if(sl>0){
				cpidz.push(tid);
				cpslz.push(sl);
				}	
			});
		var url="/member/bin.php?act=farm_shop_buy&goodsIds="+cpidz.toString()+"&goodsNums="+cpslz.toString();
		tishi2();
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
    });
    </script>

<?php
require_once 'inc_footer.php';
?>