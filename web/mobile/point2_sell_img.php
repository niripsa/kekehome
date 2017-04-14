<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/webConfig.php';

//point2_sell_img
$id = $_GET['id'];

$sql = "select * from `h_point2_sell` where id = ".$id;
$rs = $db->get_one($sql);
$imgurl = explode("|",$rs['h_img']);

for($i = 0; $i < count($imgurl) - 1; $i++)
{
  echo "<img src='". $imgurl[$i] ."' />";
}
exit;
?>