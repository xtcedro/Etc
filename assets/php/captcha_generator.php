<?php
session_start();

function generateCaptcha() {
    // Generate a random CAPTCHA text
    $captcha_text = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);

    // Store the CAPTCHA text in the session for validation
    $_SESSION['captcha_text'] = $captcha_text;

    // Create a CAPTCHA image
    $image = imagecreatetruecolor(150, 50);
    if (!$image) {
        die("Failed to create image.");
    }

    // Define colors
    $background_color = imagecolorallocate($image, 240, 240, 240);
    $text_color = imagecolorallocate($image, 50, 50, 50);
    $line_color = imagecolorallocate($image, 200, 200, 200);

    // Fill the background
    imagefilledrectangle($image, 0, 0, 150, 50, $background_color);

    // Add random lines for noise
    for ($i = 0; $i < 5; $i++) {
        imageline($image, rand(0, 150), rand(0, 50), rand(0, 150), rand(0, 50), $line_color);
    }

    // Add the CAPTCHA text to the image
    $font = __DIR__ . '/DejaVuSans.ttf'; // Ensure this file exists
    if (!file_exists($font)) {
        die("Font file not found.");
    }

    imagettftext($image, 20, rand(-10, 10), rand(10, 60), rand(30, 40), $text_color, $font, $captcha_text);

    // Output the image to the browser
    header('Content-Type: image/png');
    imagepng($image);

    // Clean up the image resource
    imagedestroy($image);
}

// Call the function to display the CAPTCHA
generateCaptcha();
?>