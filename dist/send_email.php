<?php
$to = 'erica@thrivewb.com';
$subject = 'New form submission';
$message = "Name: {$_POST['name']}\n";
$message .= "Email: {$_POST['email']}\n";
$message .= "Organization: {$_POST['organization']}\n";


// Attachments handling
if (isset($_FILES['attachments']) && $_FILES['attachments']['error'] == UPLOAD_ERR_OK) {
    $attachment_path = $_FILES['attachments']['tmp_name'];
    $attachment_name = $_FILES['attachments']['name'];
    $attachment_type = $_FILES['attachments']['type'];
    $attachment_size = $_FILES['attachments']['size'];
    
    // Add attachment to message
    $attachment = file_get_contents($attachment_path);
    $attachment_encoded = chunk_split(base64_encode($attachment));
    $message .= "Attachment: {$attachment_name}\n";
    $message .= "Content-Type: {$attachment_type}\n";
    $message .= "Content-Transfer-Encoding: base64\n\n";
    $message .= "{$attachment_encoded}\n";
}

$headers = 'From: webmaster@example.com' . "\r\n" .
           'Reply-To: ' . $_POST['email'] . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>
