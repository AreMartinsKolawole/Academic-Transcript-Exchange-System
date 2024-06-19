<?php
session_start();

require_once '../db_connection.php'; // Include your database connection file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Get the email address from the form submission
$email = $_POST['email'];

// SQL query to check if the email exists in the database
$sql_check_email = "SELECT * FROM users WHERE email = ?";
$stmt_check_email = $conn->prepare($sql_check_email);
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$result_check_email = $stmt_check_email->get_result();

if ($result_check_email->num_rows === 0) {
    // If no user found with the provided email, redirect with error message
    header("Location: ./verification_error.php?error=no_user_found");
    exit();
}

// Generate a new 6-digit verification code
$new_verification_code = mt_rand(100000, 999999);

// SQL query to update the digitcode in the database with the new verification code
$sql_update_code = "UPDATE users SET digitcode = ? WHERE email = ?";

try {
    // Prepare and execute the query to update the code
    $stmt_update_code = $conn->prepare($sql_update_code);
    $stmt_update_code->bind_param("ss", $new_verification_code, $email);
    $stmt_update_code->execute();

    // Attempt to send verification email with the new code
    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'transcriptexchangesystem@gmail.com'; // Replace with your email address
    $mail->Password = 'qcbxwbswxcjcurci'; // Replace with your email password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Sender information
    $mail->setFrom('transcriptexchangesystem@gmail.com', 'Transcript Exchange System');
    $mail->addAddress($email); // Add a recipient

    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'New Verification Code';

    // Constructing the HTML email body
    $mail->Body = "
        <html>
        <head>
            <style>
                /* Add your CSS styles here */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h2 {
                    color: #007bff;
                }
                p {
                    margin-bottom: 10px;
                }
                .verification-code {
                    font-size: 24px;
                    font-weight: bold;
                    color: #007bff;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>New Verification Code</h2>
                <p>Your new verification code is: <span class='verification-code'>$new_verification_code</span></p>
            </div>
        </body>
        </html>
    ";

    // Send email
    $mail->send();

    // Redirect to success page
    header("Location: ./verify_code.php?email=" . urlencode($email)); // Pass email as parameter to verification page
    exit();
} catch (Exception $e) {
    // If email sending fails or database error occurs, redirect with error message
    header("Location: ./verify_code?error=email_sending_failed?email=" . urlencode($email)); // Pass email as parameter to verification page
    exit();
} finally {
    // Close the prepared statements
    $stmt_check_email->close();
    $stmt_update_code->close();
    // Close the database connection
    $conn->close();
}
?>
