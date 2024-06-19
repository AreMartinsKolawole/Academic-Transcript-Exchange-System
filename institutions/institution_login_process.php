<?php
// Start the session
session_start();

// Include the log activity function
require_once '../log_activity.php';

// Include the database connection
require_once '../db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve institution data based on email
    $sql = "SELECT * FROM institutions WHERE email = ?";
    
    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Institution found, verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['institution_email'] = $row['email'];
            $_SESSION['institution_name'] = $row['name'];

            // Log successful sign-in
            logActivity('Institution ' . $email . ' signed in successfully');

            header("Location: institution_dashboard.php");
            exit();
        } else {
            // Password is incorrect, display error message
            header("Location: institution_login.php?error=Incorrect password.");
            exit();
        }
    } else {
        // Institution not found, display error message
        header("Location: institution_login.php?error=User does not exist.");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the login page
    header("Location: institution_login.php");
    exit();
}
?>
