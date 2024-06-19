<?php

define('LOG_FILE_PATH', '../logs/system_logs.log');

require_once '../log_activity.php';
// Include PHPMailer autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Include database connection
require_once '../db_connection.php';

// Function to generate a unique token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get matriculation number from form
    $matric_no = $_POST['matric_no'] ?? '';

    // Prepare SQL statement to retrieve email based on matriculation number
    $sql = "SELECT email FROM users WHERE matric_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Generate a unique token
        $token = generateToken();

        // Store the token and matric number in a database table for verification
        $sql_insert = "INSERT INTO password_reset (matric_no, token) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $matric_no, $token);
        $stmt_insert->execute();

        // Close prepared statement
        $stmt_insert->close();

        // Send email with reset link using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'transcriptexchangesystem@gmail.com';
            $mail->Password = 'qcbxwbswxcjcurci';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('transcriptexchangesystem@gmail.com', 'Transcript Exchange System');
            $mail->addAddress($email);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';

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
                        a {
                            color: #007bff;
                            text-decoration: none;
                        }
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h2>Password Reset Request</h2>
                        <p>Click the following link to reset your password: <a href='http://localhost/tes/students/reset_password_form.php?token=$token'>Reset Password</a></p>
                        <p>If you're unable to click the link, please copy and paste the following URL into your browser:<br>http://localhost/tes/students/reset_password_form.php?token=$token</p>
                    </div>
                </body>
                </html>
            ";

            // Send email
            $mail->send();

            // Provide feedback to the user
            header("Location: ../login.php");

            logActivity('User ' . $matric_no . ' signed in successfully');
            // Redirect to the login page
            header("Location: ../login.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // If matric number does not exist
        header("Location: reset_password.php?error=user_not_found");
        exit();
    }
} else {
    // If form is not submitted
    header("Location: reset_password.php");
    exit();
}
?>
