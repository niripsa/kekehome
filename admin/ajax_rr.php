<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';

require_once 'chkLogged.php';

echo '[';

if(strlen($id) <= 0){
	$query = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName) as comMembers from `h_member` a where h_parentUserName = '' or h_parentUserName is null order by h_regTime asc,id asc";
	$lv = -1;
}else{
	$query = "select *,(select count(id) from `h_member` where h_parentUserName = a.h_userName) as comMembers from `h_member` a where h_parentUserName = '{$id}' order by h_regTime asc,id asc";
}
$result = $db->query($query);
$ci = 0;
while($rs_list = $db->fetch_array($result)){
	$ci++;
	if($ci > 1){
		echo ',';
	}
	
	echo '{';
	echo 'id:"' , $rs_list['h_userName'] , '"';
	echo ', pId:"' , $memberLogged_userName , '"';
	echo ', name:"[' , ($lv + 1) , '] ' , $rs_list['h_userName'] , ' "';
	if($rs_list['comMembers'] > 0){
		echo ', isParent:true';
	}else{
		echo ', isParent:false';
	}
	echo ', icon:"/ui/zTree_v3/css/zTreeStyle/img/diy/1_open.png"';
	echo '}';
}

echo ']';