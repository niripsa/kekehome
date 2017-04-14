<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '';

require_once 'inc_header.php';
if($_GET['t'] == 1){ 
$query = "select h_title from `h_article` where h_menuId = 108 order by h_addTime desc,id desc LIMIT 1";
	$result = $db->query($query);
	$list = $db->fetch_array($result);

?>
	    <div class="page-body">
        
    <div class="head">
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;">
        <div class="head-title">果园管理</div>
        <a href="/mobile/index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"></a>
    </div>

        
    <div class="grow-menu" data-url="/mobile/news.php">
        
            <img src="/mod/images/icon-notice.png" class="grow-menu-icon">
        
        <div>
            <span style="position: absolute; margin: 10px 20px; font-size: 20px">通知公告</span>
            <span style="width: 70%;overflow: hidden; text-overflow: ellipsis; white-space: nowrap;position: absolute; margin: 36px 20px; font-size: 16px; color: #565656;"><?php echo $list['h_title'] ?></span>
        </div>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
        
    </div>
    <div class="grow-menu" data-url="/mobile/shengzhang.php">
        <img src="/mod/images/manage-game.png" class="grow-menu-icon">
        <span class="grow-menu-label">生长走势</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
    </div>
    <div class="grow-menu" data-url="/mobile/my_farm.php">
        <img src="/mod/images/manage-my.png" class="grow-menu-icon">
        <span class="grow-menu-label">我的果园</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
    </div>
    <div class="grow-menu" data-url="/mobile/com_list.php">
        <img src="/mod/images/manage-friend.png" class="grow-menu-icon">
        <span class="grow-menu-label">好友果园(一级)</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
    </div>
    <div class="grow-menu" data-url="/mobile/com_list_second.php">
        <img src="/mod/images/manage-friend.png" class="grow-menu-icon">
        <span class="grow-menu-label">好友果园(二级)</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
    </div>
    <div class="grow-menu" data-url="/mobile/act_mer.php">
        <img src="/mod/images/manage-new.png" class="grow-menu-icon">
        <span class="grow-menu-label">开通新玩家</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
    </div>
    
   
     

    <script type="text/javascript">
	    $(".head-icon-left").on("click", function () {
            window.history.go(-1);
        });
        $(".grow-menu").on('click', function() {
            window.location.href = this.dataset.url;
        });
    </script>


    </div>
    
    <script type="text/javascript">
        var path = "";
        var href = 'javascript:void(0);';
        var onClick = 'javascript:void(0);';
    </script>
    
        
    
    <script type="text/javascript">
        if (path != undefined && path.length > 0) {
            document.write("<div id='dd' class='float-icon'><a href='"+href+"' onclick='"+onClick+"' /><img src='" + path + "'  class='float-icon-img'></a></div>");
        }
    </script>
<?php }elseif($_GET['t'] == 2){ ?>
 <div class="page-body" >
        
    <div class="head" >
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;" />
        <div class="head-title" >生长记录</div>
        <a href="/mobile/index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"  /></a>
    </div>

        
    <!--<div class="grow-menu" data-type="0">
        <img src="/mod/images/grow-apple.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">BF生长记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>-->
    <div class="grow-menu" data-type="1">
        
        <img src="/mod/images/grow-reward.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">种子奖励记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-type="2">
        <img src="/mod/images/grow-apple.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">丘比特奖励记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-type="3">
        <img src="/mod/images/grow-bee.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">花仙子奖励记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-type="4">
        <img src="/mod/images/grow-hf.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">施肥记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-type="5">
        
        <img src="/mod/images/grow-hf-use.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">播种记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-type="6">
        <img src="/mod/images/grow-shg-log.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">收获记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>

    </div>
    
    <script type="text/javascript">
        var path = "";
        var href = 'javascript:void(0);';
        var onClick = 'javascript:void(0);';
    </script>
    
    <script type="text/javascript">
        $('.grow-menu').on('click', function() {
            var type = this.dataset.type;
            window.location.href = "/mobile/point1_log_in.php?type=" + type;
        })
    </script>

    <script type="text/javascript">
        $(".head-icon-left").on("click", function () {
            window.history.go(-1);
        });

        if (path != undefined && path.length > 0) {
            document.write("<div id='dd' class='float-icon'><a href='"+href+"' onclick='"+onClick+"' /><img src='" + path + "'  class='float-icon-img'></a></div>");
        }
    </script>

<?php }elseif($_GET['t'] == 3){ ?>
<div class="page-body" >
        
    <div class="head" >
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;" />
        <div class="head-title" >交易中心</div>
        <a href="/mobile/index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"  /></a>
    </div>
    <div class="grow-menu" data-url="/mobile/point2_sell_list.php">
        <img src="/mod/images/change-sold-apple.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">挂单出售</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-url="/mobile/point2_sell_log.php">
        <img src="/mod/images/change-sold-apple-log.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">出售记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-url="/mobile/point2_buy_log.php">
        <img src="/mod/images/change-bug-log.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">购买记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
	
    <div class="grow-menu" data-url="/mobile/point2_transfer.php">
        <img src="/mod/images/change-to-apple.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">KK转账</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
	 <div class="grow-menu" data-url="/mobile/point1_to_flower.php">
        <img src="/mod/images/change-zz.png" class="grow-menu-icon">
        <span class="grow-menu-label">种子转KK</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
    </div>
    
    <div class="grow-menu" data-url="/mobile/point1_flower_list.php">
        <img src="/mod/images/change-zz-log.png" class="grow-menu-icon">
        <span class="grow-menu-label">种子转KK记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select">
    </div>
    <!--<div class="grow-menu" data-type="12">
        <img src="/mod/images/change-apple-to.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">种子转BF记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>-->
<!--     <div class="grow-menu" data-url="/mobile/shangcheng.php">
    <img src="/mod/images/change-zz.png" class="grow-menu-icon"/>
    <span class="grow-menu-label">商城转账</span>
    <img src="/mod/images/common_select.png" class="grow-menu-select"/>
</div>
 <div class="grow-menu" data-url="/mobile/shangcheng_log.php">
    <img src="/mod/images/change-zz-log.png" class="grow-menu-icon"/>
    <span class="grow-menu-label">商城转账记录</span>
    <img src="/mod/images/common_select.png" class="grow-menu-select"/>
</div> -->
	<div class="grow-menu" data-url="/mobile/UseBeeLogs.php">
        <img src="/mod/images/grow-bee.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">采蜜记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>

    
    <!--<div class="grow-menu" data-url="/mobile/ppg2ddz.aspx">
        <img src="/mod/images/change-zz.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">BF兑换英伦豆</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>

    <div class="grow-menu" data-url="/mobile/ddz2ppg.aspx">
        <img src="/mod/images/change-zz.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">英伦豆兑换BF</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    
    <div class="grow-menu" data-type="15">
        <img src="/mod/images/change-zz-log.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">兑换记录</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>-->

    

    </div>
    
    <script type="text/javascript">
        var path = "";
        var href = 'javascript:void(0);';
        var onClick = 'javascript:void(0);';
    </script>
    
    <script type="text/javascript">
        $('.grow-menu').on('click', function() {
            var type = this.dataset.type;
            if (type) {
                window.location.href = "/mod/Logs.aspx?type=" + type;
            } else {
                window.location.href = this.dataset.url;
            }
        })
    </script>

    <script type="text/javascript">
        $(".head-icon-left").on("click", function () {
            window.history.go(-1);
        });

        if (path != undefined && path.length > 0) {
            document.write("<div id='dd' class='float-icon'><a href='"+href+"' onclick='"+onClick+"' /><img src='" + path + "'  class='float-icon-img'></a></div>");
        }
    </script>

<?php }elseif($_GET['t'] == 4){?>
<div class="page-body" >
        
    <div class="head" >
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;" />
        <div class="head-title" >个人中心</div>
        <a href="/mobile/index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"  /></a>
    </div>

        
    <div class="grow-menu " data-url="/mobile/pi.php?type=1">
        <img src="/mod/images/personal-message.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">个人资料</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    <div class="grow-menu" data-url="/mobile/pi.php?type=2">
        <img src="/mod/images/personal-pwd.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">修改登录密码</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
	<div class="grow-menu" data-url="/mobile/pi.php?type=3">
        <img src="/mod/images/personal-pwd.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">修改安全密码</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
	<div class="grow-menu" data-url="/mobile/pa.php?type=1">
        <img src="/mod/images/personal-pwd.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">密码问题保护</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
	<div class="grow-menu" data-url="/mobile/pa.php?type=2">
        <img src="/mod/images/personal-pwd.png" class="grow-menu-icon"/>
        <span class="grow-menu-label">密码QQ保护</span>
        <img src="/mod/images/common_select.png" class="grow-menu-select"/>
    </div>
    
    
    <script type="text/javascript">
        $(".grow-menu").on('click', function() {
            window.location.href = this.dataset.url;
        });
    </script>

    </div>
    
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
<?php }else{ ?>
    <div class="index-background">
        <div id="head" class="index-head">
            
            <img src="<?php echo $webInfo['h_webLogo'];?>" class="index-logo-background">
            
        </div>

        <div class="index-menu-area">
            <div class="index-menu-area-left" data-url="/mobile/index.php?t=1">
                <img src="/mod/index-menu-manager.png" class="index-menu-item-left">
                <span class="index-menu-item-span-left">果园管理</span>
            </div>
            <div class="index-menu-area-rigrt" data-url="/mobile/index.php?t=2">
                <img src="/mod/index-menu-grow.png" class="index-menu-item-rigrt">
                <span class="index-menu-item-span-right">生长记录</span>
            </div>
        </div>


        <div class="index-menu-area">
            <div class="index-menu-area-left" data-url="/mobile/index.php?t=3">
                <img src="/mod/index-menu-change.png" class="index-menu-item-left">
                <span class="index-menu-item-span-left">交易中心</span>
            </div>
             <div class="index-menu-area-rigrt" data-url="/mobile/index.php?t=4">
                <img src="/mod/index-menu-personal.png" class="index-menu-item-rigrt">
                <span class="index-menu-item-span-right">个人中心</span>
            </div>
           
        </div>
        <div class="index-menu-area">
            <div class="index-menu-area-left" data-url="">
                <img src="/mod/index-menu-up.png" class="index-menu-item-left">
                <span class="index-menu-item-span-left">商城入口</span>
            </div>
            <div class="index-menu-area-rigrt" data-url="/mobile/msg.php">
                <img src="/mod/index-menu-msg.png" class="index-menu-item-rigrt">
                <span class="index-menu-item-span-right">站 内 信</span>
            </div>
        </div>
    <input type="submit" name="Quit" value="退出" onclick="logout();" id="Quit" class="friend-new-sub">
    </div>
    <script type="text/javascript">
        $(".index-menu-area div").on('click', function() {
            window.location.href = this.dataset.url;
        });
        function logout()
        {
           window.location.href='/member/logout.php';
        }
    </script>
<?php }?>
<?php
require_once 'inc_footer.php';
?>