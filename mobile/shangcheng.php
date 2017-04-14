<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '商城转账';

require_once 'inc_header.php';
require_once 't.php';
	$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
	$rs = $db->get_one($sql);
?>
<div class="friend-new-item">
        <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label">可用KK数量</span>
        <label class="friend-new-line-split">:</label>
        <span id="ctl00_body_Textbox1" class="friend-new-line friend-new-line-input" placeholder=""><?php echo $rs['h_point2']; ?></span>
    </div>
    <div class="friend-new-item">
        <span id="ctl00_body_Label2" class="friend-new-line friend-new-line-label">转账数量</span>
        <label class="friend-new-line-split">:</label>
        <input name="ctl00$body$Textbox2" id = "x1" type="text" id="ctl00_body_Textbox2" class="friend-new-line friend-new-line-input" placeholder="转入后不可退回" />
    </div>
    <input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub" />
	

</div>
</div>
<!--MAN End-->


</div></div>

    <script src="/ui/layer/extend/layer.ext.js"></script>
    <script>
	mgo(46);

	$("#ctl00_body_Sub").bind("click",function(){
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
			$.get("/mobile/bin.php?act=shangcheng&num="+$("#x1").val(),function(e){
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
require_once 'f.php';
require_once 'inc_footer.php';
?>