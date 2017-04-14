<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	$rid = $_POST['rid'];
	$imgurl = $_POST['imgurl'];
	
	$query = "update `h_point2_sell` set h_img = '". $imgurl ."' where id = '".$rid."'";
    $db->query($query);
	echo '上传成功！';
}
exit;

?>﻿