<?php
// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Generate PDF file
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('times', 'B', 16);
$pdf->Cell(0, 10, 'Form Data', 0, 1);
$pdf->SetFont('times', '', 12);
$pdf->Cell(0, 10, "Name: $name", 0, 1);
$pdf->Cell(0, 10, "Email: $email", 0, 1);
$pdf->Cell(0, 10, "Message: $message", 0, 1);
$pdfData = $pdf->Output('', 'S');

// Send email with PDF attachment
require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->setFrom('sender@example.com', 'Sender Name');
$mail->addAddress('recipient@example.com', 'Recipient Name');
$mail->addStringAttachment($pdfData, 'form_data.pdf');
$mail->Subject = 'Form Data';
$mail->Body = 'Attached is the form data in PDF format.';
if ($mail->send()) {
  echo 'Email sent.';
} else {
  echo 'Error: ' . $mail->ErrorInfo;
}
?>
