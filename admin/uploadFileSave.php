<?php
require_once 'header.php';

$CONFIG_MAX_SIZE = 380 * 1024;
$CONFIG_FILE_BAD_CHR = array('\\','/',':','*','?','"','<','>','|');
$CONFIG_FILE_MIME = array('image/jpeg','image/pjpeg','image/jpg','image/gif','image/png','image/x-png','application/msword','application/pdf','application/zip','application/x-zip-compressed');
$CONFIG_FILE_EXT = array('.zip','.jpg','.png','.gif','.doc','.pdf');
$CONFIG_UPLOAD_FOLDER = "../upload/";

if(!is_dir($CONFIG_UPLOAD_FOLDER))
{
	mkdir($CONFIG_UPLOAD_FOLDER);
}

$fileRename = (int)$_POST['fileRename'];
$fileCover = (int)$_POST['fileCover'];
$dateNewFolder = (int)$_POST['dateNewFolder'];

$uploadFile = $_FILES['uploadFileName'];
if($uploadFile)
{
	$file_name = $uploadFile['name'];
	$file_ext = substr($file_name,strrpos($file_name,"."));
	$file_temp_name = $uploadFile['tmp_name'];
	
	if($file_name == '')
	{
		echo '<script language="javascript">alert("抱歉，文件名不可为空！");window.parent.close();</script>';
	}
	elseif($file_ext == '')
	{
		echo '<script language="javascript">alert("抱歉，文件必须有扩展名！");window.parent.close();</script>';
	}
	elseif($uploadFile['size'] > $CONFIG_MAX_SIZE)
	{
		echo '<script language="javascript">alert("文件太大不能上传");window.parent.close();</script>';
	}
	elseif(!in_array($uploadFile['type'],$CONFIG_FILE_MIME) && !in_array($file_ext,$CONFIG_FILE_EXT))
	{
		echo '<script language="javascript">alert("对不起你所上传的文件类型不符合规定，不允许上传");window.parent.close();</script>';
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
			echo '<script language="javascript">alert("抱歉，同名文件已经存在，停止上传！");window.parent.close();</script>';
		}
		else
		{
			$result = move_uploaded_file($file_temp_name,$save_file_path);
			
			if(!$result)
				$result = copy($file_temp_name,$save_file_path);
			
			if($result)
			{
				echo '<script language="javascript">alert("文件上传成功");window.parent.returnValue="' . $save_file_path . '";window.parent.close();</script>';
			}
			else
			{
				echo '<script language="javascript">alert("上传失败，请重新上传");window.parent.close();</script>';
			}
		}
	}
}

require_once 'footer.php';
?>