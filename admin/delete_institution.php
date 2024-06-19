<?php
// Include database connection
require_once '../db_connection.php';

// Check if institution ID is provided via GET parameter
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the institution ID
    $institution_id = htmlspecialchars($_GET['id']);

    // Prepare SQL statement to delete the institution
    $sql = "DELETE FROM institutions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $institution_id);

    // Execute the delete statement
    if($stmt->execute()) {
        // Institution deletion successful, redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // If deletion fails, display error message
        echo "Error: Unable to delete institution.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If institution ID is not provided, redirect to admin dashboard
    header("Location: admin_dashboard.php");
    exit();
}
?>
