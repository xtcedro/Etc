<?php
// File: /assets/php/submit_appointment.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot field to prevent bots
    if (!empty($_POST['honeypot'])) {
        exit("Invalid submission detected.");
    }

    // Sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate required fields
    if (empty($name) || !$email || empty($date) || empty($time)) {
        echo "Error: All required fields must be filled out correctly.";
        exit;
    }

    // Email setup
    $to = "no-reply@domingueztechsolutions.com"; // Your no-reply email address
    $subject = "New Appointment Request from $name";
    $body = "
        You have received a new appointment request:\n
        Name: $name\n
        Email: $email\n
        Preferred Date: $date\n
        Preferred Time: $time\n
        Additional Notes:\n$message\n
    ";

    // Email headers
    $headers = "From: no-reply@domingueztechsolutions.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "Your appointment request has been submitted successfully.";
    } else {
        echo "An error occurred while sending your request. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
