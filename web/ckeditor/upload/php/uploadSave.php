<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Save</title>
<script language="javascript" type="text/javascript" src="../js/uploadSave.js"></script>
</head>
<body>
<?php
$CKEditorFuncNum = (int)$_GET['CKEditorFuncNum'];

$ut = $_GET['ut'];

require_once 'chkLogged.php';

$CONFIG_MAX_SIZE = 380 * 1024;
$CONFIG_FILE_BAD_CHR = array('\\','/',':','*','?','"','<','>','|');
$CONFIG_FILE_MIME = array('image/jpeg','image/pjpeg','image/jpg','image/gif','image/png','image/x-png','application/msword','application/pdf','application/zip','application/x-zip-compressed');
$CONFIG_FILE_EXT = array('.zip','.jpg','.png','.gif','.doc','.pdf');

$CONFIG_UPLOAD_FOLDER = "../../../upload/";
if(!is_dir($CONFIG_UPLOAD_FOLDER))
{
	mkdir($CONFIG_UPLOAD_FOLDER);
}
$CONFIG_UPLOAD_FOLDER .= "ckeditor/";
if(!is_dir($CONFIG_UPLOAD_FOLDER))
{
	mkdir($CONFIG_UPLOAD_FOLDER);
}

$fileRename = 1;//1=date file name
$fileCover = 0;//0=not cover
$dateNewFolder = 1;//1=date folder

$saveFileName = '';
$saveFileError = '';

$uploadFile = $_FILES["upload"];
if($uploadFile)
{
	$file_name = $uploadFile['name'];
	$file_ext = substr($file_name,strrpos($file_name,"."));
	$file_temp_name = $uploadFile['tmp_name'];
	
	if($file_name == '')
	{
		$saveFileError = '抱歉，文件名不可为空！';
	}
	elseif($file_ext == '')
	{
		$saveFileError = '抱歉，文件必须有扩展名！';
	}
	elseif($uploadFile['size'] > $CONFIG_MAX_SIZE)
	{
		$saveFileError = '抱歉，文件太大不能上传！';
	}
	elseif(!in_array($uploadFile['type'],$CONFIG_FILE_MIME) && !in_array($file_ext,$CONFIG_FILE_EXT))
	{
		$saveFileError = '抱歉，上传的文件类型不符合规定，不允许上传！';
	}
	else
	{
		$new_file_name = $file_name;
		if($fileRename == 1)
		{
			$new_file_name = date("YmdHis") . rand(10000,99999) . $file_ext;
		}
		
		$save_file_path = $CONFIG_UPLOAD_FOLDER;
		if($dateNewFolder == 1)
		{
			$save_file_path .= date("Y") . '/';
			if(!is_dir($save_file_path))
			{
				mkdir($save_file_path);
			}
			
			$save_file_path .= date("m") . '/';
			if(!is_dir($save_file_path))
			{
				mkdir($save_file_path);
			}
			
			$save_file_path .= date("d") . '/';
			if(!is_dir($save_file_path))
			{
				mkdir($save_file_path);
			}
		}
		$save_file_path .= $new_file_name;
		
		if (file_exists($save_file_path) == 1 && $fileCover == 0)
		{
			$saveFileError = '抱歉，同名文件已经存在，停止上传！';
		}
		else
		{
			$result = move_uploaded_file($file_temp_name,$save_file_path);
			
			if(!$result)
				$result = copy($file_temp_name,$save_file_path);
			
			if($result)
			{
				$saveFileName = $save_file_path;
			}
			else
			{
				$saveFileError = '抱歉，上传失败，请重新上传！';
			}
		}
	}
}

echo 'Status:Uploaded';
echo '<script language="javascript">';
if ($saveFileName == '')
{
	echo 'UploadedCall(' . $CKEditorFuncNum . ',"","上传失败，请重试。\r\n参考原因：' . $saveFileError . '");';
}
else
{
	$saveFileName = str_replace('../../../','/',$saveFileName);
	if($ut == 'file')
	{
		echo 'UploadedCall(' . $CKEditorFuncNum . ',"' . $saveFileName . '","");';
	}
	else if ($ut == 'image' )
	{
		echo 'UploadedCall(' . $CKEditorFuncNum . ',"' . $saveFileName . '","");';
	}
	else if ($ut == 'flash' )
	{
		echo 'UploadedCall(' . $CKEditorFuncNum . ',"' . $saveFileName . '","");';
	}
}
echo '</script>';
?>