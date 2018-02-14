<?php
header("Content-type: image/png");
if(session_status() == 1)
    session_start();
$string = $_SESSION['captcha'];
$im     = imagecreatefrompng("images/captcha.png");
$orange = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
imagettftext($im, 26, 0, 0, 32, $orange, "fonts/cour.ttf",$string);
//imagestring($im, $font, 0, 0, $string, $orange);
imagepng($im);
imagedestroy($im);