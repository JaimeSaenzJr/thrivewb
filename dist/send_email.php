<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $to = "erica@thrivewb.com";
  $subject = "New Form Submission";

  $name = $_POST["name"];
  $organization = $_POST["organization"];
  $from = $_POST["email"];
  $attachment1 = $_FILES["attachments"];
  $attachment2 = $_FILES["attachment2"];

  $boundary = uniqid('np');
  $headers = "From: $from\r\n";
  $headers .= "Reply-To: $from\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=$boundary\r\n";

  $message = "Name: $name\n";
  $message .= "Organization: $organization\n\n";

  if ($attachment1["error"] == UPLOAD_ERR_OK) {
    $content = chunk_split(base64_encode(file_get_contents($attachment1["tmp_name"])));
    $filename = $attachment1["name"];
    $message .= "--$boundary\n";
    $message .= "Content-Type: {\"application/octet-stream\"};\n";
    $message .= " name=\"$filename\"\n";
    $message .= "Content-Disposition: attachment;\n";
    $message .= " filename=\"$filename\"\n";
    $message .= "Content-Transfer-Encoding: base64\n\n";
    $message .= "$content\n";
  }

  if ($attachment2["error"] == UPLOAD_ERR_OK) {
    $content2 = chunk_split(base64_encode(file_get_contents($attachment2["tmp_name"])));
    $filename2 = $attachment2["name"];
    $message .= "--$boundary\n";
    $message .= "Content-Type: {\"application/octet-stream\"};\n";
    $message .= " name=\"$filename2\"\n";
    $message .= "Content-Disposition: attachment;\n";
    $message .= " filename=\"$filename2\"\n";
    $message .= "Content-Transfer-Encoding: base64\n\n";
    $message .= "$content2\n";
  }

  if (mail($to, $subject, $message, $headers)) {
    echo "Thank you for your submission.";
  } else {
    echo "There was a problem sending your submission.";
  }
}
?>
