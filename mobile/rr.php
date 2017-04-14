<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '推荐结构 - ';

require_once 'inc_header.php';
?>

<div class="countgo pull-left"><div class="zt">
<!--MAN -->
<div class="remain">
<div class="gao1"></div>
<div class="page-header long-header">
  <h3>账户管理 <small> 推荐结构</small></h3>
</div>
<div>
<ol class="breadcrumb">
  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="/member/">主页</a></li>
  <li><a href="#">账户管理</a></li>
  <li class="active">推荐结构</li>
</ol>
</div>
<div class="panel panel-default">
  <div class="panel-heading">推荐结构树形图</div>
  <div class="panel-body">
  <ul id="wenjianshu" class="ztree"></ul>
  </div>
</div>
</div>
<!--MAN End-->
</div></div>

<link rel="stylesheet" href="/ui/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="/ui/zTree_v3/js/jquery.ztree.all-3.5.min.js"></script>
<script>
mgo(21);


		var setting = {
			view: {
				selectedMulti: false
			},
			async: {
				enable: true,
				url:"/member/bin.php?act=rr",
				autoParam:["id", "name=n", "level=lv","icon"],
				otherParam:{"act":"ax"},
				dataFilter: filter
			}
		};

		function filter(treeId, parentNode, childNodes) {
			if (!childNodes) return null;
			for (var i=0, l=childNodes.length; i<l; i++) {
				childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
			}
			return childNodes;
		}

		$(document).ready(function(){
			$.fn.zTree.init($("#wenjianshu"), setting);
		});	
    </script>

<?php
require_once 'inc_footer.php';
?>