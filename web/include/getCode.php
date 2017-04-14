<?php
session_start();
//error_reporting(E_ERROR | E_PARSE);

$authnum=random(4);
 
Header("Content-type: image/PNG"); 
$im = imagecreate(55,18);
$red = ImageColorAllocate($im, 218,218,218); 
$white = ImageColorAllocate($im, 172,34,50);
$gray = ImageColorAllocate($im, 0,0,0);
imagefill($im,55,18,$red); 
for ($i = 0; $i < strlen($authnum); $i++)
{ 
    imagestring($im, 6, 13*$i+4, 1, substr($authnum,$i,1), $white); 
} 
for($i=0;$i<50;$i++) imagesetpixel($im, rand()%55 , rand()%48 , $gray);
ImagePNG($im);
ImageDestroy($im);
$authnum=strtolower($authnum);

$_SESSION['code']=$authnum;

function random($length) 
 { 
    $hash = ''; 
    $chars = '0123456789ABCDEFGHIJKKKNPQRSTUVWXYZ'; 
    $max = strlen($chars) - 1; 
    mt_srand((double)microtime() * 1000000); 
    for($i = 0; $i < $length; $i++) { 
        $hash .= $chars[mt_rand(0, $max)]; 
  
    } 
    return $hash; 
}
?>