<?php
// Include database connection
require_once '../db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert new admin account
    $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        // Registration successful
        echo "Admin account created successfully.";
    } else {
        // Registration failed
        echo "Error: Admin account registration failed. Please try again.";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to registration page if form is not submitted
    header("Location: admin_register.php");
    exit();
}
?>
