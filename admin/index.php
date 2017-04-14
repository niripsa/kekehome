<?php
require_once '../include/conn.php';

require_once 'chkLogged.php';

footer();
?>
<HTML>
<HEAD>
<TITLE>管理后台</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
</HEAD>
<FRAMESET id="frame" border="false" frameSpacing="0" rows="*" frameBorder="0" cols="200,*" scrolling="yes">
  <FRAME name="leftFrame" marginWidth="0" marginHeight="0" src="index_left.php" scrolling="yes">
  <FRAMESET border="false" frameSpacing="0" rows="53,*" frameBorder="0" cols="*" scrolling="yes">
    <FRAME name="top" src="index_top.php" scrolling="no">
    <FRAME name="main" src="config.php">
  </FRAMESET>
</FRAMESET>
<noframes></noframes>
</HTML>