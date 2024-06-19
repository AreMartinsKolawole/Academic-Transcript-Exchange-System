<?php
session_start();

// Include database connection
require_once '../db_connection.php';

// Check if token is provided in the POST data
if (!isset($_POST['token']) || empty(trim($_POST['token']))) {
    // Redirect to a page showing an error message or to the login page
    header("Location: ../login.php?error=invalid_token");
    exit();
}

// Get the token from the POST data
$token = trim($_POST['token']);

// Debugging: Log the token value
error_log("Received token: " . $token);

// Retrieve matriculation number associated with the token
$sql_select = "SELECT matric_no, used FROM password_reset WHERE token = ?";
$stmt_select = $conn->prepare($sql_select);
if ($stmt_select === false) {
    error_log("Error preparing statement: " . $conn->error);
    header("Location: ../login.php?error=db_error");
    exit();
}

$stmt_select->bind_param("s", $token);
$stmt_select->execute();
$result_select = $stmt_select->get_result();

if ($result_select->num_rows == 0) {
    // Token not found in password_reset table
    error_log("Token not found in the database");
    header("Location: ../login.php?error=invalid_token");
    exit();
}

// Fetch the data
$row = $result_select->fetch_assoc();
$matric_no = $row['matric_no'];
$used = $row['used'];

// Debugging: Log the retrieved values
error_log("Matric No: " . $matric_no);
error_log("Used: " . $used);

// Check if the token has already been used
if ($used == 1) {
    // Token has already been used, consider it invalid
    error_log("Token has already been used");
    header("Location: ../login.php?error=token_used");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password
    if ($password != $confirm_password) {
        // Passwords do not match
        header("Location: reset_password_form.php?error=password_mismatch&token=$token");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password in the database based on matriculation number
    $sql_update = "UPDATE users SET password = ? WHERE matric_no = ?";
    $stmt_update = $conn->prepare($sql_update);
    if ($stmt_update === false) {
        error_log("Error preparing update statement: " . $conn->error);
        header("Location: reset_password_form.php?error=reset_failed&token=$token");
        exit();
    }

    $stmt_update->bind_param("ss", $hashed_password, $matric_no);
    $stmt_update->execute();

    // Check if any row was affected
    if ($stmt_update->affected_rows > 0) {
        // Password reset successful, update token status and redirect to login page
        $sql_update_token = "UPDATE password_reset SET used = 1 WHERE token = ?";
        $stmt_update_token = $conn->prepare($sql_update_token);
        if ($stmt_update_token === false) {
            error_log("Error preparing token update statement: " . $conn->error);
            header("Location: reset_password_form.php?error=reset_failed&token=$token");
            exit();
        }

        $stmt_update_token->bind_param("s", $token);
        $stmt_update_token->execute();

        header("Location: ../login.php?success=password_reset");
        exit();
    } else {
        // Something went wrong
        header("Location: reset_password_form.php?error=reset_failed&token=$token");
        exit();
    }
}
?>
