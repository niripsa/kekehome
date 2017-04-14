<?php
require_once 'header.php';

$CONFIG_FILE_EXT = array('.jpg','.png','.gif');

$file_name = $big;
$width = (int)$width;if($width <= 0)$width = 160;
$height = (int)$height;if($height <= 0)$height = 120;

if($file_name == '')
{
	echo '<script language="javascript">alert("抱歉，大图文件名不可为空！");window.close();</script>';
}
else
{
	if(substr($file_name,0,1) == '/')
	{
		$file_name = $_SERVER["DOCUMENT_ROOT"] . $file_name;
	}

	$file_ext = substr($file_name,strrpos($file_name,"."));

	if($file_ext == '')
	{
		echo '<script language="javascript">alert("抱歉，文件必须有扩展名！");window.close();</script>';
	}
	elseif(!in_array($file_ext,$CONFIG_FILE_EXT))
	{
		echo '<script language="javascript">alert("抱歉，只允许自动缩略jpg、png和gif图片！");window.close();</script>';
	}
	elseif (!is_file($file_name))
	{
		echo '<script language="javascript">alert("抱歉，大图文件并不存在！");window.close();</script>';
	}
	else
	{
		$save_file_path = substr($file_name,0,strrpos($file_name,".")) . '_thumb' . $file_ext;
		
		$thumbPath = PicAutoThumb($file_name, $save_file_path, $width, $height);
		
		if($thumbPath == '')
			echo '<script language="javascript">alert("自动缩略失败，请重试");window.close();</script>';
		else
			echo '<script language="javascript">alert("自动缩略成功！");window.returnValue="' . $thumbPath . '";window.close();</script>';
	}
}

function PicAutoThumb($picpath, $savepath,$maxWidth, $maxHeight){
    $imgInfo = getimagesize($picpath);
    $imgW = $imgInfo[0];
    $imgH = $imgInfo[1];

	if ($imgW > 0 && $imgH > 0) {
		$newWidth = 0;
		$newHeight = 0;
	
		//等比缩放
		if ($imgW / $imgH >= $maxWidth / $maxHeight) {
			if ($imgW > $maxWidth) {
				$newWidth = $maxWidth;
				$newHeight = round(($imgH * $maxWidth) / $imgW);
			} else {
				$newWidth = $imgW;
				$newHeight = $imgH;
			}
		} else {
			if ($imgH > $maxHeight) {
				$newHeight = $maxHeight;
				$newWidth = round(($imgW * $maxHeight) / $imgH);
			} else {
				$newWidth = $imgW;
				$newHeight = $imgH;
			}
		}

		//创建画布
		$temp_canvas = imagecreatetruecolor($newWidth,$newHeight);
		
		switch($imgInfo[2])     
		{
			case 1:
				$temp_create = imagecreatefromgif($picpath);
				imagecopyresampled($temp_canvas,$temp_create,0,0,0,0,$newWidth,$newHeight,$imgW,$imgH);
				imagegif($temp_canvas,$savepath);
				break;
			case 2:
				$temp_create = imagecreatefromjpeg($picpath);
				imagecopyresampled($temp_canvas,$temp_create,0,0,0,0,$newWidth,$newHeight,$imgW,$imgH);
				imagejpeg($temp_canvas,$savepath, 80);
				break;
			case 3:
				$temp_create = imagecreatefrompng($picpath);
				imagecopyresampled($temp_canvas,$temp_create,0,0,0,0,$newWidth,$newHeight,$imgW,$imgH);
				imagepng($temp_canvas,$savepath);
				break;
		}
		imagedestroy($temp_create);
		 
		$savepath = str_replace($_SERVER["DOCUMENT_ROOT"],'',$savepath);
		
		return $savepath;
	}
	
	return '';
}

require_once 'footer.php';
?>