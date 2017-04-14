<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '安全密码';
$go = $_GET['go'];
require_once 'inc_header.php';
require_once 't.php';
?>
    <div class="friend-new-item">
        <span id="ctl00_body_Label2" class="friend-new-line friend-new-line-label">安全密码</span>
        <label class="friend-new-line-split">:</label>
        <input name="ctl00$body$Textbox2" id = "x1" type="password" id="ctl00_body_Textbox2" class="friend-new-line friend-new-line-input" placeholder="请输入安全密码" />
    </div>
    <input type="submit" name="ctl00$body$Sub" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub" />

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

	function zhuanjihuobi_go(){
		if($("#x1").val()==""){
			tishi4("请输入安全密码",'#x1');
			return false;
			}
			$.get("/mobile/bin.php?act=pwd2&pwd2="+$("#x1").val()+"&go=<? echo $go ?>",function(e){
			if(e!=""){
				//$("#x4-cos").html(unescape(e));
				if(unescape(e)=="success"){
					layer.msg("输入正确，正在跳转",{time: 2000, btn: ['确定'],end:function(){window.location.href = '<? echo $go ?>';}
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
require_once 'f.php';
require_once 'inc_footer.php';
?>