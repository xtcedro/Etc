<?php
session_start();
header('Content-Type: image/png');
require_once __DIR__ . '/captcha_generator.php';

// Generate the CAPTCHA image
$image = generateCaptcha();

// Output the image
imagepng($image);
imagedestroy($image);