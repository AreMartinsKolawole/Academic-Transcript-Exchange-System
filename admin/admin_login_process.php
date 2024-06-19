<?php
// Start session
session_start();

// Include database connection
require_once '../db_connection.php'; // Adjust the path as needed

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to retrieve user with given username
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variable and redirect to dashboard
            $_SESSION["username"] = $username;
            header("Location: admin_dashboard.php"); // Adjust the path as needed
            exit();
        } else {
            // Incorrect password
            $login_error = "Invalid username or password.";
        }
    } else {
        // User not found
        $login_error = "Invalid username or password.";
    }
}
?>