<?php

// Define the log file path
define('LOG_FILE_PATH', './logs/system_logs.log');

require_once './log_activity.php';
require_once 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library files
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Function to send verification email
function sendVerificationEmail($email, $verification_code) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'transcriptexchangesystem@gmail.com';
        $mail->Password = 'qcbxwbswxcjcurci';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Sender information
        $mail->setFrom('transcriptexchangesystem@gmail.com', 'Transcript Exchange System');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code for Your Registration';
        $mail->Body = '
            <html>
            <head>
                <style>
                    .container {
                        font-family: Arial, sans-serif;
                        background-color: #f2f2f2;
                        padding: 20px;
                        border-radius: 5px;
                    }
                    .verification-code {
                        font-size: 24px;
                        font-weight: bold;
                        color: #007bff;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <p>Dear User,</p>
                    <p>Thank you for registering with our system. Your verification code is:</p>
                    <p class="verification-code">' . $verification_code . '</p>
                    <p>Please use this code to complete your registration.</p>
                    <p>Best regards,<br>Transcript Exchange System</p>
                </div>
            </body>
            </html>
        ';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Function to handle user registration
function registerUser($conn, $name, $email, $matric_no, $hashed_password, $verification_code) {
    $sql = "INSERT INTO users (name, email, matric_no, password, digitcode, verified) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $matric_no, $hashed_password, $verification_code);
    
    if ($stmt->execute()) {
        return $stmt->affected_rows === 1;
    } else {
        return false;
    }
}

// Main signup process
$name = $_POST['name'];
$email = $_POST['email'];
$matric_no = $_POST['matric_no'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Generate a 6-digit verification code
$verification_code = mt_rand(100000, 999999);

try {
    if (sendVerificationEmail($email, $verification_code)) {
        if (registerUser($conn, $name, $email, $matric_no, $hashed_password, $verification_code)) {
            logActivity('User ' . $matric_no . ' registered successfully');
            header("Location: ./students/verify_code.php?email=" . urlencode($email));
        } else {
            header("Location: ./signup.php?error=user_exists");
        }
    } else {
        header("Location: ./signup.php?error=internet_connection");
    }
} catch (mysqli_sql_exception $exception) {
    header("Location: ./signup.php?error=user_exists");
} finally {
    $conn->close();
}
exit();

?>
