<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot validation (spam protection)
    if (!empty($_POST['honeypot'])) {
        die("Bot detected. Submission rejected.");
    }

    // CAPTCHA validation
    session_start();
    if (empty($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['captcha_text']) {
        die("Invalid CAPTCHA. Please go back and try again.");
    }

    // Sanitize and validate inputs
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    if (!$name || !$email || !$message) {
        die("Invalid input. Please check your entries and try again.");
    }

    // Email setup
    $to = "no-reply@domingueztechsolutions.com";
    $subject = "New Contact Form Submission";
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    // Email content
    $body = "You have received a new message from your contact form:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        header("Location: /contact.html?success=1");
        exit;
    } else {
        die("Failed to send email. Please try again later.");
    }
} else {
    die("Invalid request.");
}
