<?php
//Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

//Create email message
 $to = "nefilimv7@gmail.com"; // Ваша электронная почта
$subject = "New Contact Form Submission";
$body = "Name: $name\nEmail: $email\nMessage: $message";

//Attach uploaded images to email
if(isset($_FILES['images'])) {
  $attachments = array();

  foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['images']['name'][$key];
    $file_size = $_FILES['images']['size'][$key];
    $file_tmp = $_FILES['images']['tmp_name'][$key];
    $file_type = $_FILES['images']['type'][$key];

    $file = fopen($file_tmp, 'r');
    $file_data = fread($file, $file_size);
    fclose($file);

    $attachments[] = array(
      'data' => chunk_split(base64_encode($file_data)),
      'name' => $file_name,
      'type' => $file_type
    );
  }

  $mime_boundary = md5(time());
  $headers = "From: $email\r\n" .
             "MIME-Version: 1.0\r\n" .
             "Content-Type: multipart/mixed; boundary=\"$mime_boundary\"\r\n" .
             "X-Mailer: PHP/" . phpversion();

  $message = "This is a multi-part message in MIME format.\r\n\r\n" .
             "--$mime_boundary\r\n" .
             "Content-Type: text/plain; charset=UTF-8\r\n" .
             "Content-Transfer-Encoding: 8bit\r\n\r\n" .
             "$body\r\n\r\n" .
             "--$mime_boundary\r\n";

  foreach($attachments as $attachment) {
    $message .= "Content-Type: " . $attachment['type'] . "; name=\"" . $attachment['name'] . "\"\r\n" .
                "Content-Transfer-Encoding: base64\r\n" .
                "Content-Disposition: attachment; filename=\"" . $attachment['name'] . "\"\r\n\r\n