<?php
$memberLogged_userName = $_COOKIE['m_username'];
$memberLogged_passWord = $_COOKIE['m_password'];
$memberLogged_fullName = $_COOKIE['m_fullname'];
$memberLogged_level = $_COOKIE['m_level'];
$memberLogged_isPass = $_COOKIE['m_isPass'];

$memberLogged = false;
if(strlen($memberLogged_userName) > 0 && strlen($memberLogged_passWord) > 0){
	$memberLogged = true;
	
	if(!$memberLogged_fullName)
		$memberLogged_fullName = $memberLogged_userName;
}