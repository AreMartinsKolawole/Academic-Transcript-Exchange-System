
<?php
// Define the log file path
define('LOG_FILE_PATH', '../logs/system_logs.log');

require_once '../log_activity.php';
require_once '../db_connection.php';

$email = $_POST['email'];
$verification_code = $_POST['verification_code'];

// SQL query to check if verification code matches
$sql = "SELECT * FROM users WHERE email='$email' AND digitcode='$verification_code'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Verification successful, update verification status
    $sql_update = "UPDATE users SET verified = 1 WHERE email = '$email'";
    $conn->query($sql_update);
    
    // Log successful sign-in
    logActivity('User ' . $email . ' verified account successfully');
    // Redirect the user to login page
    header("Location: ../login.php");
    exit();
} else {
    // If verification code is incorrect, display an error message or redirect to previous page
    header("Location: ./verify_code.php?error=incorrect_code&email= " . urlencode($email)); // Pass email as parameter to verification page
    exit();
}

// Close the database connection
$conn->close();
?>
