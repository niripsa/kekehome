<?php
$memberLogged_userName = $_COOKIE['m_username'];
$memberLogged_passWord = $_COOKIE['m_password'];
$memberLogged_fullName = $_COOKIE['m_fullname'];
$memberLogged_level = $_COOKIE['m_level'];
$memberLogged_isPass = $_COOKIE['m_isPass'];


//为了安全，数据库存的是md5之后的密码

$sql = "SELECT * FROM `h_member` WHERE `h_userName` ='$memberLogged_userName'";
#1.$link = mysqli_connect()	得到连接实例
#2.mysqli_query($link,$sql)	得到对结果进行描述的对象
#3.mysqli_fetch_array()	每次只能得到一行数据

#$result可能有2种情况，空串或数组
$result = $db->fetch_array($db->query_direct($sql));
$memberLogged = false;

if(isset($result['h_passWord']) && $memberLogged_passWord==$result['h_passWord']){
	$memberLogged = true;
	
	if(!$memberLogged_fullName)
		$memberLogged_fullName = $memberLogged_userName;
}