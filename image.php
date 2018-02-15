<?php
//Output formatted as image data so can be loaded as a source for an image
header("Content-type: image/png");

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
//Get generated captcha string
$string = $_SESSION['captcha'];
//Get background for captcha
$im     = imagecreatefrompng("images/captcha.png");
//Create orange colour for text
$orange = imagecolorallocate($im, 220, 210, 60);
//Write orange captcha text over background in courier font
imagettftext($im, 26, 0, 0, 32, $orange, "fonts/cour.ttf",$string);
//Output png and cleanup
imagepng($im);
imagedestroy($im);