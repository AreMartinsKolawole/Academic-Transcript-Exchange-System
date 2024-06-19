<?php
session_start();

require_once '../log_activity.php'; 
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the action and token are set
    if (isset($_POST["action"], $_POST["token"])) {
        // Validate the action
        $action = $_POST["action"];
        if ($action != "accept" && $action != "reject") {
            // Handle invalid action
            echo "Invalid action!";
            exit();
        }
        
        // Validate the token
        $token = $_POST["token"];
        if (empty($token)) {
            // Handle missing token
            echo "Token is missing!";
            exit();
        }
        
        // Perform database operations
        require_once '../db_connection.php';

        // Update the status based on the action
        $new_status = ($action == "accept") ? "Accepted" : "Rejected";

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE transcript_requests SET status = ? WHERE verification_token = ?");
        $stmt->bind_param("ss", $new_status, $token);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            // Retrieve current institution email and user details from the database
            $stmt_email = $conn->prepare("SELECT tr.current_institution_email, u.email, u.name, u.current_institution_name FROM transcript_requests tr JOIN users u ON tr.matric_number = u.matric_no WHERE tr.verification_token = ?");
            $stmt_email->bind_param("s", $token);
            $stmt_email->execute();
            $stmt_email->store_result();
            if ($stmt_email->num_rows > 0) {
                $stmt_email->bind_result($current_institution_email, $user_email, $user_name, $current_institution_name);
                $stmt_email->fetch();

                // Sending email based on action
                require '../phpmailer/src/Exception.php';
                require '../phpmailer/src/PHPMailer.php';
                require '../phpmailer/src/SMTP.php';

                // SMTP configuration
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'transcriptexchangesystem@gmail.com';
                $mail->Password = 'qcbxwbswxcjcurci';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Email content
                $mail->setFrom('transcriptexchangesystem@gmail.com', 'Transcript Exchange System');
                $mail->isHTML(true);

                if ($action == "accept") {
                    // Email to user
                    $mail->addAddress($user_email);
                    $mail->Subject = 'Transcript Request Accepted';
                    $mail->Body = "Dear $user_name,<br><br>Your transcript request has been accepted. Your transcript will be sent soon.<br><br>Regards,<br>Transcript Exchange System";
                    $mail->send();

                    // Email to current institution
                    $mail->clearAddresses();
                    $mail->addAddress($current_institution_email);
                    $mail->Subject = 'Transcript Request Initialized';
                    $mail->Body = "Dear $current_institution_name,<br><br>A transcript request has been initialized and will be sent to your institution soon.<br><br>Regards,<br>Transcript Exchange System";
                    $mail->send();

                    logActivity('Uploaded ' . $user_name . ' transcript successfully');
                    echo "<script>alert('Request Accepted'); window.location.href='institution_dashboard.php';</script>";
                } else {
                    // Email to user
                    $mail->addAddress($user_email);
                    $mail->Subject = 'Transcript Request Rejected';
                    $mail->Body = "Dear $user_name,<br><br>Your transcript request has been rejected. Please contact the institution for further information.<br><br>Regards,<br>Transcript Exchange System";
                    $mail->send();
                    logActivity('' . $user_name . 'initialization of transcript is successfully');
                    logActivity('' . $user_name . 'initialization of transcript is was rejected');
                    echo "<script>alert('Request Rejected Successfully'); window.location.href='institution_dashboard.php';</script>";
                }

                // Close the statement
                $stmt_email->close();
            } else {
                // Handle error: token not found
                echo "Error: Token not found!";
                exit();
            }
        } else {
            echo "Failed to update status!";
            exit();
        }

        // Close database connection
        $conn->close();
    } else {
        // Handle missing action or token
        echo "Action or token is missing!";
        exit();
    }
} else {
    // Handle non-POST requests
    echo "Invalid request method!";
    exit();
}
?>