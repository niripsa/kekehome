<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '玩家公告 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left">
	<div class="zt">
    <!--MAN -->
        <div class="remain">
            <div class="gao1"></div>
            <div class="page-header long-header">
                <h3>玩家公告 <small> 公告列表</small></h3>
            </div>
            <div>
                <ol class="breadcrumb">
                    <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
                    <li><a href="/member/news.php">玩家公告</a></li>
                    <li class="active">公告列表</li>
                </ol>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">公告列表</div>
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

	echo '<table class="table table-striped table-hover">
                <tr>
                <td>标题</td>
                <td>发布时间</td>
                </tr>';

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			echo '<tr>
                <td>[系统公告] <a href="/member/news-show.php?id=' , $val['id'] , '">' , $val['h_title'] , '</a></td>
                <td>' , $val['h_addTime'] , '</td>
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

	//<div class='clearfix'><div class='btn-group pull-left' role='group'><a class='btn btn-default' href='#' role='button'>首页</a><a class='btn btn-default' href='#' role='button'>上一页</a><a class='btn btn-default' href='#' role='button'>下一页</a><a class='btn btn-default' href='#' role='button'>尾页</a></div><div class='pull-right pt1'>&nbsp;页次：<strong><font color=red>1</font>/1</strong>页 &nbsp;共<b><font color='#FF0000'>19</font></b>条记录</div></div>
	
	echo '</table>';
}
?>

                
                
                
            </div>
        </div>
    <!--MAN End-->
    </div>
</div>

<?php
require_once 'inc_footer.php';
?>