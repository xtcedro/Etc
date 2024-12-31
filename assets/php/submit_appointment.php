<?php
// File: /assets/php/submit_appointment.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Honeypot field to prevent bots
    if (!empty($_POST['appointment_check'])) {
        exit("Invalid submission detected.");
    }

    // Sanitize and validate input data
    $name = strip_tags(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate required fields
    if (empty($name) || !$email || empty($date) || empty($time)) {
        echo "Error: Please fill in all required fields correctly.";
        exit;
    }

    // Validate date and time format (YYYY-MM-DD and HH:MM)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        echo "Error: Invalid date format. Please use YYYY-MM-DD.";
        exit;
    }

    if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
        echo "Error: Invalid time format. Please use HH:MM.";
        exit;
    }

    // Email setup
    $to = "contact@domingueztechsolutions.com"; // Your domain email
    $subject = "New Appointment Request from $name";
    $body = "
        You have received a new appointment request:

        Name: $name
        Email: $email
        Preferred Date: $date
        Preferred Time: $time
        Additional Notes:
        $message
    ";

    // Email headers
    $headers = "From: $email\r\n"; // Use the user's email as the sender
    $headers .= "Reply-To: $email\r\n"; // Allow replying to the user's email
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