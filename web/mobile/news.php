<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '玩家公告 - ';

require_once 'inc_header.php';
?>

    <div class="page-body">
        
    <div class="head">
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;">
        <div class="head-title">通知公告</div>
        <a href="index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"></a>
    </div>
<?php
news_list();
function news_list(){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	$mid = 111;
	$total_count = $db->counter('h_article', "h_menuId = 108", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_article` where h_menuId = 108 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
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
			$time = date("Y/m/d",strtotime($val['h_addTime']));
			echo "
		<div class=\"message-body\" data-id=\"{$val['id']}\"><span class=\"message-body-head-date\">{$time}</span><span class=\"message-body-head-content\">{$val['h_title']}</span><img src=\"/mod/images/common_select.png\" class=\"message-body-select\"></div>
			";
		}
	}
	else
	{
		echo '<center>暂无记录</center>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";

	//<div class='clearfix'><div class='btn-group pull-left' role='group'><a class='btn btn-default' href='#' role='button'>首页</a><a class='btn btn-default' href='#' role='button'>上一页</a><a class='btn btn-default' href='#' role='button'>下一页</a><a class='btn btn-default' href='#' role='button'>尾页</a></div><div class='pull-right pt1'>&nbsp;页次：<strong><font color=red>1</font>/1</strong>页 &nbsp;共<b><font color='#FF0000'>19</font></b>条记录</div></div>
	

}
?>
</div>
    
    <script type="text/javascript">
        var path = "";
        var href = 'javascript:void(0);';
        var onClick = 'javascript:void(0);';
    </script>
    
    
    <script type="text/javascript">
        $('.message-body').on('click', function() {
            var id = this.dataset.id;
            window.location.href = "/mobile/news-show.php?id=" + id;
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

<?php
require_once 'inc_footer.php';
?>