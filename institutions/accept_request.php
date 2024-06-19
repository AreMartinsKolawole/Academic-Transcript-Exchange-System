<?php
// Start the session
session_start();

// Include database connection
require_once '../db_connection.php';

// Check if the institution is logged in
if (!isset($_SESSION['institution_email'])) {
    // Redirect to institution login page if not logged in
    header("Location: institution_login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve matric number and action from the form submission
    $matric_number = $_POST['matric_number'];
    $action = $_POST['action']; // 'accept' or 'reject'

    // Update status column of the transcript request in the database based on the action
    if ($action === 'accept') {
        $status = 'accepted';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    } else {
        // Invalid action, redirect back to the institution dashboard
        header("Location: institution_dashboard.php");
        exit();
    }

    // Update the status of the transcript request in the database
    $update_sql = "UPDATE transcript_requests SET status = '$status' WHERE matric_number = '$matric_number'";
    
    // Debugging: Log the SQL query
    error_log("SQL query: " . $update_sql);

    if ($conn->query($update_sql) === TRUE) {
        // Status updated successfully, redirect back to the institution dashboard
        header("Location: institution_dashboard.php");
        exit();
    } else {
        // Error updating status, redirect back to the institution dashboard with error message
        $error_message = "Error updating status: " . $conn->error;
        error_log($error_message); // Log the error
        header("Location: institution_dashboard.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the institution dashboard
    header("Location: institution_dashboard.php");
    exit();
}
?>