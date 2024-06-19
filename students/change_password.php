<?php
session_start();

define('LOG_FILE_PATH', '../logs/system_logs.log');

require_once '../log_activity.php';

// Check if the user is logged in
if (!isset($_SESSION['matric_no'])) {
    // If not logged in, redirect to the login page
    header("Location: ../login.php");
    exit();
}

// Include database connection
require_once '../db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $matric_no = $_SESSION['matric_no'];

    // Retrieve current password from the database
    $sql = "SELECT password FROM users WHERE matric_no='$matric_no'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify if the current password matches the one stored in the database
        if (password_verify($current_password, $hashed_password)) {
            // Validate new password and confirm password
            if ($new_password !== $confirm_password) {
                echo "<script>alert('New password and confirm password do not match');</script>";
            } else {
                // Hash the new password before updating in the database
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                // Update user password in the database
                $update_sql = "UPDATE users SET password='$hashed_new_password' WHERE matric_no='$matric_no'";
                if ($conn->query($update_sql) === TRUE) {

                                    // Log successful sign-in
                     logActivity('User ' . $matric_no . ' change password successfully');

                    echo "<script>alert('Password changed successfully'); window.location.href='student_dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error changing password');</script>" . $conn->error;
                }
            }
        } else {
            echo "<script>alert('Current password is incorrect');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Change Password</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link rel="icon" href="../img/Logo.png" type="image/x-icon" />



    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>


    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-dark sticky-top custom-bg-color flex-md-nowrap p-0 shadow"
        style="background-color: #407bff;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Transcript Exchange System</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input style="background-color: #407bff;" class="form-control form-control-dark w-100" type="text"
            placeholder="Change Password" aria-label="Search" readonly>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="./logout.php">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./student_dashboard.php">
                                <span data-feather="home"></span>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./request_transcript.php">
                                <span data-feather="file"></span>
                                Request Transcript
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./update_profile.php">
                                <span data-feather="user"></span>
                                Update Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./change_password.php">
                                <span data-feather="key"></span>
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./records.php">
                                <span data-feather="file-text"></span> <!-- Updated icon -->
                                Request Records
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2><br>Change Password</h2>
                <form id="cp" action="" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password:</label>
                        <input type="password" id="current_password" name="current_password" class="form-control"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                        <div id="new-password-error" class="text-danger"></div> <!-- Error message for new password -->
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                            required>
                    </div>

                    <button style="background-color: #407bff;" type="submit" class="btn btn-primary btn-update">Change
                        Password</button>
                </form>
            </main>

        </div>
    </div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="../js/dashboard.js"></script>
    <script>
    // Function to validate form
    function validateForm() {
        var currentPassword = document.getElementById("current_password").value;
        var newPassword = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var newPasswordRegex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-zA-Z]).{8,}$/; // Regex for password requirements

        // Validate new password
        if (!newPasswordRegex.test(newPassword)) {
            document.getElementById("new-password-error").innerHTML = "New password must contain at least one number, one special character, and be at least 8 characters long";
            return false;
        } else {
            document.getElementById("new-password-error").innerHTML = "";
        }

        // Check if new password matches the confirm password
        if (newPassword !== confirmPassword) {
            document.getElementById("new-password-error").innerHTML = "New password and confirm password do not match";
            return false;
        } else {
            document.getElementById("new-password-error").innerHTML = "";
        }

        return true; // Form submission allowed if validation passes
    }
</script>
</body>

</html>