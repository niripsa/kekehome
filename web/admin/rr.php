<?php
require_once 'header.php';
?>

<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">
  <tr>
    <td height="25" align="center" class="tdtitle">推荐结构</td>
  </tr>
  <tr> 
    <td height="25" align="center" class="tdbottom">
<ul id="wenjianshu" class="ztree"></ul>
    </td>
  </tr>
</table>

<link rel="stylesheet" href="/ui/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="/ui/zTree_v3/js/jquery.ztree.all-3.5.min.js"></script>
<script>
	var setting = {
		view: {
			selectedMulti: false
		},
		async: {
			enable: true,
			url:"ajax_rr.php",
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
footer();
?>