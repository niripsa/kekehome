<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KK购买记录 - 超级马里奥 - 超级马里奥</title>
<meta name="keywords" content="超级马里奥复利系统,理财系统,超级马里奥" />
<meta name="description" content="超级马里奥一款复利理财游戏，在这里大家可以更轻松、愉快的进行理财投资！" />
<link rel="stylesheet" href="/ui/css/bootstrap.min.css">
<link href="/ui/css/css.css" rel="stylesheet">
<script type="text/javascript" src="/ui/js/jquery.min.js"></script>
<script type="text/javascript" src="/ui/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/ui/layer/layer.js"></script>
<script type="text/javascript" src="/ui/js/long.js"></script>
<!--[if lt IE 9]>
<script src="/ui/js/html5shiv.min.js"></script>
<script src="/ui/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
var browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
</script>
</head>
<style type="text/css">body{background:#3D3D3D;}</style>

<style type="text/css">
.demo{width:760px; margin:40px auto 0 auto; min-height:150px;}
.preview{width:200px;border:solid 1px #dedede; margin:10px;padding:10px;}
.demo p{line-height:26px}
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
</style>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.wallform.js"></script>
<script type="text/javascript">
$(function(){
	$('#photoimg').die('click').live('change', function(){
	alert($("#photoimg").val());
		var status = $("#up_status");
		var btn = $("#up_btn");
		$("#imageform").ajaxForm({
			target: '#preview', 
			beforeSubmit:function(){
				status.show();
				btn.hide();
			}, 
			success:function(){
				status.hide();
				btn.show();
			}, 
			error:function(){
				status.hide();
				btn.show();
		} }).submit();
	});
});
</script>
</head>

<body>
<div id="header">
   <div id="logo"><h1><a href="http://www.helloweba.com" title="返回helloweba首页">helloweba</a></h1></div>
   <div class="demo_topad"><script src="/js/ad_js/demo_topad.js" type="text/javascript"></script></div>
</div>

<div id="main">
   <h2 class="top_title"><a href="http://www.helloweba.com/view-blog-277.html">PHP+jQuery+Ajax多图片上传</a></h2>
   <div class="demo">
   		<div class="ad_demo"><script src="/js/ad_js/ad_demo.js" type="text/javascript"></script></div>
        
        <form id="imageform" method="post" enctype="multipart/form-data" action="upload.php">
			<div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
			<div id="up_btn" class="btn">
				<span>添加图片</span>
				<input id="photoimg" type="file" name="photoimg">
				<input id="rid" name="rid" type="text" style="display:none;" />
			</div>
		</form>
        <p>最大100KB，支持jpg，gif，png格式。</p>
		<div id="preview"></div>
   </div>
	
  
  <br/>
</div>


<div id="footer">
    <p>Powered by helloweba.com  允许转载、修改和使用本站的DEMO，但请注明出处：<a href="http://www.helloweba.com">www.helloweba.com</a></p>
</div>
<p id="stat"><script type="text/javascript" src="/js/tongji.js"></script></p>
<?php
require_once 'inc_footer.php';
?>