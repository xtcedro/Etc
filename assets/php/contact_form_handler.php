<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Debugging: Check if session is set
    if (!isset($_SESSION['captcha_text'])) {
        die(json_encode(['status' => 'error', 'message' => 'CAPTCHA session not set.']));
    }

    // Honeypot validation
    if (!empty($_POST['honeypot'])) {
        die(json_encode(['status' => 'error', 'message' => 'Bot detected.']));
    }

    // CAPTCHA validation
    if (empty($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['captcha_text']) {
        die(json_encode([
            'status' => 'error',
            'message' => 'Invalid CAPTCHA.',
            'debug' => [
                'session' => $_SESSION['captcha_text'] ?? 'not set',
                'input' => $_POST['captcha'] ?? 'not provided'
            ]
        ]));
    }

    // Sanitize and validate inputs
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    if (!$name || !$email || !$message || strlen($name) > 100 || strlen($message) > 1000) {
        die(json_encode(['status' => 'error', 'message' => 'Invalid input.']));
    }

    // Email setup
    $to = "contact@domingueztechsolutions.com";
    $subject = "New Contact Form Submission";
    $headers = "From: no-reply@domingueztechsolutions.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    $body = "You have received a new message:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
    } else {
        error_log("Email failed to send: " . print_r(error_get_last(), true), 3, '/path/to/error.log');
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
    }
} else {
    die(json_encode(['status' => 'error', 'message' => 'Invalid request method.']));
}