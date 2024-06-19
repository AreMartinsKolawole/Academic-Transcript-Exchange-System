<?php
session_start();

// Include database connection
require_once 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    // Prepare SQL statement to insert feedback into the database
    $sql = "INSERT INTO feedback (name, email, feedback) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $feedback);

    // Execute the statement
    if ($stmt->execute()) {
        // Feedback successfully inserted
        header("Location: index.php");
        exit(); // Ensure no further code is executed after redirection
    } else {
        // Error occurred
        echo "Error submitting feedback. Please try again.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If form is not submitted, redirect to an error page or home page
    header("Location: error.php");
    exit();
}
?>
