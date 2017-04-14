<?php
if($location == ''){HintAndBack("抱歉，类别错误！",1);}

$mid = (int)$mid;
if($mid <= 0){HintAndBack("抱歉，栏目ID错误！",1);}
$rs = $db->get_one("select * from `h_menu` where id = '$mid' LIMIT 1");
if($rs)
{
	$mTitle = $rs[h_title];
	
	$picBigWidth = $rs['h_picBigWidth'];
	$picBigHeight = $rs['h_picBigHeight'];
	$picSmallWidth = $rs['h_picSmallWidth'];
	$picSmallHeight = $rs['h_picSmallHeight'];
}
else
{
	HintAndBack("抱歉，未找到该栏目ID！",1);
}

$pageParms = 'location=' . urlencode($location) . '&mid=' . $mid
?>