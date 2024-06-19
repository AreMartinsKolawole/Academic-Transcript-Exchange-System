<?php
session_start();

require_once '../log_activity.php'; 
// Check if user is logged in
if (!isset($_SESSION["institution_email"])) {
    header("Location: institution_login.php");
    exit();
}

// Include database connection
require_once '../db_connection.php';

// Get institution's email from session
$institution_email = $_SESSION["institution_email"];

// Initialize variables
$current_password_err = $new_password_err = $confirm_password_err = "";
$current_password = $new_password = $confirm_password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate current password
    if (empty(trim($_POST["current_password"]))) {
        $current_password_err = "Please enter your current password.";
    } else {
        $current_password = trim($_POST["current_password"]);
    }
    
    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter a new password.";     
    } else {
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm your password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before updating the database
    if (empty($current_password_err) && empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare a select statement
        $sql = "SELECT password FROM institutions WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $institution_email;
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if email exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($current_password, $hashed_password)) {
                            // Password is correct, proceed to change the password
                            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                            $sql = "UPDATE institutions SET password = ? WHERE email = ?";
                            
                            if ($stmt = $conn->prepare($sql)) {
                                // Bind variables to the prepared statement as parameters
                                $stmt->bind_param("ss", $param_password, $param_email);
                                
                                // Set parameters
                                $param_password = $hashed_new_password;
                                $param_email = $institution_email;
                                
                                // Attempt to execute the prepared statement
                                if ($stmt->execute()) {
                                    logActivity('Institution ' . $email . ' changes password successfully');
                                    // Password updated successfully. Redirect to dashboard
                                    header("location: institution_dashboard.php");
                                    exit();
                                } else {
                                    echo "<script>alert('Oops! Something went wrong. Please try again later.'); </script>";
                                }
                            }
                        } else {
                            // Display an error message if password is not valid
                            $current_password_err = "The password you entered is not valid.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    echo "<script>alert('Oops! Something went wrong. Please try again later.'); </script>";
                    
                }
            } else {
                echo "<script>alert('Oops! Something went wrong. Please try again later.'); </script>";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $conn->close();
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

<header class="navbar navbar-dark sticky-top custom-bg-color flex-md-nowrap p-0 shadow" style="background-color: #407bff;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Transcript Exchange System</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input style="background-color: #407bff;" class="form-control form-control-dark w-100" type="text" placeholder="Change Password" aria-label="Search" readonly>
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
                            <a class="nav-link" aria-current="page" href="./home.php">
                                <span data-feather="home"></span>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./institution_dashboard.php">
                                <span data-feather="file"></span>
                                Transcript Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./upload_transcripts.php">
                                <span data-feather="file"></span>
                                Upload Transcripts
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./received_transcripts.php">
                                <span data-feather="file"></span>
                                Received Transcript
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
                    </ul>
                </div>
            </nav>


        </div>
    </div>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h2><br>Change Password</h2>
        <form id="up" onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
                <span><?php echo $current_password_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
                <span><?php echo $new_password_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                <span><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-update">Change Password</button>
            </div>
        </form>
    </main>

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