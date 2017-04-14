<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '公告详情 - ';

require_once 'inc_header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/pager.php';
?>
    <div class="page-body">
        
    <div class="head">
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;">
        <div class="head-title">通知公告</div>
        <a href="index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"></a>
    </div>

    <?php
    news_show();
    function news_show(){
        global $id;
        global $db;
        
        $id = intval($id);
        
        $sql = "select * from `h_article` where h_menuId = 108 and id = '{$id}' LIMIT 1";
        $rs = $db->get_one($sql);
        if($rs){
            echo '<div style="width: 90%;background: #ffffff;font-size: 17px;padding: 0 5%;/* margin-top: 10px; */font-weight: bold;color: #605258;text-align: center;">' , $rs['h_title'] , '</div>';
            echo ' <div style="width: 90%;background: #ffffff;/* margin: 1px 0 0 0; */font-size: 15px;padding: 0 5%;">' , $rs['h_info'] , '</div>';
			echo ' <div style="width: 90%;background: #ffffff;font-size: 14px;padding: 10px 5%;float: right;/* position: absolute; */text-align: right;color: #565656;">' , $rs['h_addTime'] , '</div>';
        }
    }
    ?>
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
<?php
require_once 'inc_footer.php';
?>