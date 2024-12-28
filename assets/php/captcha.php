<?php
session_start();

// Generate a random CAPTCHA code
$captcha_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6);

// Store the CAPTCHA code in the session
$_SESSION['captcha_code'] = $captcha_code;

// Create an image
header('Content-Type: image/png');
$image = imagecreate(120, 40);

// Set colors
$background_color = imagecolorallocate($image, 255, 255, 255); // White background
$text_color = imagecolorallocate($image, 0, 0, 0); // Black text

// Add the CAPTCHA code to the image
imagestring($image, 5, 10, 10, $captcha_code, $text_color);

// Output the image as PNG
imagepng($image);

// Free memory
imagedestroy($image);
?>
