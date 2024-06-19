<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include PHPMailer library files
    
    // Include PHPMailer library files
    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';
    require_once '../db_connection.php';

    // Retrieve form data
    $recipient_email = $_POST['recipient_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'transcriptexchangesystem@gmail.com'; // Replace with your email address
        $mail->Password = 'qcbxwbswxcjcurci'; // Replace with your email password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    

        // Recipients
        $mail->setFrom('your_email@gmail.com', 'Transcript Exchange System');
        $mail->addAddress($recipient_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send email
        $mail->send();
        echo "Email sent successfully.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
