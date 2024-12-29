<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    // Rate limiting: Prevent multiple submissions in a short time
    if (isset($_SESSION['last_submission_time']) &&
        time() - $_SESSION['last_submission_time'] < 60) {
        echo "Please wait a moment before submitting again.";
        exit;
    }
    $_SESSION['last_submission_time'] = time();

    // Honeypot field: Check for bot submissions
    if (!empty($_POST['honeypot'])) {
        echo "Invalid form submission.";
        exit;
    }

    // Check CAPTCHA
    if (!isset($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['captcha_code']) {
        echo "Invalid CAPTCHA. Please try again.";
        exit;
    }

    // Validate inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if (!$name || !$email || !$message) {
        echo "Please fill out all fields correctly.";
        exit;
    }

    // Email setup using PHP mail()
    $to = "domingueztechsolutions@gmail.com";
    $subject = "New Contact Form Submission";
    $body = "You have received a new message from your contact form:\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Message:\n$message\n";
    $headers = "From: no-reply@domingueztechsolutions.com\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "Thank you for your message. We will get back to you soon.";
    } else {
        echo "There was an error sending your message. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>