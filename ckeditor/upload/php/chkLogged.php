<?php
$LoginEdUserName = $_COOKIE['h_userName'];
$LoginEdPassWord = $_COOKIE['h_passWord'];

//验证是否登录
if($LoginEdUserName == "" || $LoginEdPassWord == "")
{
	echo '<script language="javascript">';
	echo 'UploadedCall(' . $CKEditorFuncNum . ',"","抱歉，请登录后再使用上传功能！");';
	echo '</script>';
	exit();
}
?>