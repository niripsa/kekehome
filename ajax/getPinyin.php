<?php
require_once '../include/cntopinyin.php';

$cn = $_POST["cn"];
if($cn == '')
{
	echo '{"success":false,"pinyin":""}';
}
else
{
	echo '{"success":true,"pinyin":"' . Pinyin($cn, 1) . '"}';
}
?>