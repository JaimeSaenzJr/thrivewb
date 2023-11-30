<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = test_input($_POST["user_email"]);

    // Email validation regex
    $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';

    if (preg_match($emailRegex, $user_email)) {
        // Valid email address, send email to erica@thrivewb.com
        $to = "erica@thrivewb.com";
        $subject = "New Form Submission";
        $message = "User email: $user_email";

        $headers = 'From: webmaster@example.com'; // Replace with a valid "from" address

        if (mail($to, $subject, $message, $headers)) {
            echo "Thank you for your submission!";
        } else {
            echo "Failed to send email. Please try again later.";
        }
    } else {
        echo "Invalid email address. Please enter a valid email.";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>