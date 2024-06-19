<?php
// Include database connection
require_once 'db_connection.php';

// Check if user ID is provided via GET parameter
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the user ID
    $user_id = htmlspecialchars($_GET['id']);

    // Prepare SQL statement to delete the user
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    // Execute the delete statement
    if($stmt->execute()) {
        // User deletion successful, redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // If deletion fails, display error message
        echo "Error: Unable to delete user.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If user ID is not provided, redirect to admin dashboard
    header("Location: admin_dashboard.php");
    exit();
}
?>
