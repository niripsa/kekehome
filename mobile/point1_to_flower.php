<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
$pageTitle = '种子转KK';
require_once 'inc_header.php';
require_once 't.php';
?>
<?php
	$sql = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers from `h_member` a where h_userName = '{$memberLogged_userName}' LIMIT 1";
	$rs = $db->get_one($sql);
			?>
<div class="friend-new-item">
        <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label">种子余量</span>
        <label class="friend-new-line-split">:</label>
        <span id="ctl00_body_Textbox1" class="friend-new-line friend-new-line-input" placeholder=""><?php echo $rs['h_point1']; ?></span>
    </div>
<div class="friend-new-item">
        <span id="ctl00_body_Label1" class="friend-new-line friend-new-line-label">KK余量</span>
        <label class="friend-new-line-split">:</label>
        <span id="ctl00_body_Textbox1" class="friend-new-line friend-new-line-input" placeholder=""><?php echo $rs['h_point2']; ?></span>
    </div>
    <div class="friend-new-item">
        <span id="ctl00_body_Label2" class="friend-new-line friend-new-line-label">兑换数量</span>
        <label class="friend-new-line-split">:</label>
        <input name="ctl00$body$Textbox2" type="text" id="x1" class="friend-new-line friend-new-line-input" placeholder="必须100倍数,手续费10%" />
    </div>
    <input type="submit" name="ctl00$body$Sub" id = "go" value="确认提交" id="ctl00_body_Sub" class="friend-new-sub" />

<script src="/ui/layer/extend/layer.ext.js"></script>
    <script>
	mgo(44);

	$("#go").click(function () {
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
require_once 'f.php';
require_once 'inc_footer.php';
?>