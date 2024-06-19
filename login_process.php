<?php
session_start();

// Define the log file path
define('LOG_FILE_PATH', './logs/system_logs.log');

require_once './log_activity.php'; 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require_once 'db_connection.php';

    // Get matriculation number and password from form
    $matric_no = $_POST['matric_no'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user based on matriculation number
    $sql = "SELECT * FROM users WHERE matric_no = '$matric_no'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Check if the account is verified
            if ($row['verified'] == 1) {
                // Password is correct and account is verified, set session variables
                $_SESSION['matric_no'] = $matric_no;

                // Log successful sign-in
                logActivity('User ' . $matric_no . ' signed in successfully');

                // Redirect to student_dashboard.php
                header("Location: students/student_dashboard.php");
                exit();
            } else {
                // Account is not verified, redirect to verification page
                header("Location: ./students/verify_code.php?email=" . urlencode($row['email']));
                exit();
            }
        } else {
            // Incorrect password, redirect back to login page
            header("Location: login.php?error=incorrect_password");
            exit();
        }
    } else {
        // User does not exist, redirect back to login page
        header("Location: login.php?error=user_not_found");
        exit();
    }

    // Close database connection
    $conn->close();
} else {
    // Redirect to login page if form is not submitted
    header("Location: login.php");
    exit();
}
?>
