<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/assets/php/vendor/autoload.php';

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

    // Email setup using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'domingueztechsolutions@gmail.com'; // Replace with your Gmail address
        $mail->Password = 'fresaclan'; // Replace with your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('no-reply@domingueztechsolutions.com', 'No Reply');
        $mail->addAddress('domingueztechsolutions@gmail.com');
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(false);
        $mail->Subject = "New Contact Form Submission";
        $mail->Body = "You have received a new message from your contact form:\n\n" .
                      "Name: $name\n" .
                      "Email: $email\n" .
                      "Message:\n$message\n";

        $mail->send();
        echo "Thank you for your message. We will get back to you soon.";
    } catch (Exception $e) {
        echo "There was an error sending your message. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
