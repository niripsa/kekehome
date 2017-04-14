<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文件上传</title>
<script language="javascript" type="text/javascript">
function chkUpload(){
	if(document.getElementById("uploadFileName").value != ""){
		window.parent.document.getElementById("uploading").style.display = "";
		window.parent.document.getElementById("uploadIframe").style.display = "none";
		return true;
	}else{
		alert("请选择文件再上传！");
		return false;
	}
}
</script>
</head>
<body>
<div style="text-align:center;font-size:12px;">
<br>
<form name="uploadFile" enctype="multipart/form-data" method="post" action="uploadFileSave.php" onSubmit="return chkUpload();">
	<input type="file" name="uploadFileName" id="uploadFileName">
	<input type="submit" name="Submit" value=" 上 传 "><br>
	建日期文件夹：<input name="dateNewFolder" type="radio" value="0" id="dateNewFolder0"><label for="dateNewFolder0">不建日期文件夹</label> &nbsp; <input name="dateNewFolder" type="radio" value="1" checked="checked" id="dateNewFolder1"><label for="dateNewFolder1">新建日期文件夹</label><br>
	上传后文件名：<input name="fileRename" type="radio" value="0" id="fileRename0"><label for="fileRename0">保持原件名不变</label> &nbsp; <input name="fileRename" type="radio" value="1" checked="checked" id="fileRename1"><label for="fileRename1">日期自动重命名</label><br>
	存在同名文件：<input name="fileCover" type="radio" value="1" id="fileCover1"><label for="fileCover1">文件直接覆盖掉</label> &nbsp; <input name="fileCover" type="radio" value="0" checked="checked" id="fileCover0"><label for="fileCover0">停止上传并提醒</label>
</form>
</div>
</body>
</html>