<HTML>
<HEAD>
<TITLE>顶部管理导航菜单</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<STYLE type=text/css>
A:link {
	COLOR: #ffffff; TEXT-DECORATION: none
}
A:hover {
	COLOR: #ffffff
}
A:visited {
	COLOR: #f0f0f0; TEXT-DECORATION: none
}
.spa {
	FONT-SIZE: 9pt; FILTER: Glow(Color=#0F42A6, Strength=2) dropshadow(Color=#0F42A6, OffX=2, OffY=1,); COLOR: #8aade9; FONT-FAMILY: '宋体'
}
IMG {
	FILTER: Alpha(opacity:100); chroma: #FFFFFF)
}
</STYLE>
<SCRIPT language=JavaScript type=text/JavaScript>
function preloadImg(src) {
  var img=new Image();
  img.src=src
}
preloadImg('../images/admin/admin_top_open.gif');

var displayBar=true;
function switchBar(obj) {
  if (displayBar) {
    parent.frame.cols='0,*';
    displayBar=false;
    obj.src='../images/admin/admin_top_open.gif';
    obj.title='打开左边管理导航菜单';
  } else {
    parent.frame.cols='200,*';
    displayBar=true;
    obj.src='../images/admin/admin_top_close.gif';
    obj.title='关闭左边管理导航菜单';
  }
}
</SCRIPT>
</HEAD>
<BODY leftMargin="0" background="../images/admin/admin_top_bg.gif" topMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR vAlign=center>
      <TD width=60><img title="关闭左边管理导航菜单" style="CURSOR: pointer" onclick="switchBar(this)" src="../images/admin/admin_top_close.gif"></TD>
      <TD width=92><a href="../" target="_blank">网站首页</a></TD>
      <TD width=92>&nbsp;</TD>
      <TD width=104>&nbsp;</TD>
      <TD width=92>&nbsp;</TD>
      <TD width=92>&nbsp;</TD>
      <TD class=spa align=right>&nbsp; </TD>
    </TR>
  </TBODY>
</TABLE>

</body>
</HTML>