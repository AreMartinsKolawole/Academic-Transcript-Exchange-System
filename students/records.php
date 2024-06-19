<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['matric_no'])) {
    // If not logged in, redirect to the login page
    header("Location: ../login.php");
    exit();
}

// Include database connection
require_once '../db_connection.php';

// Retrieve user's matriculation number
$matric_no = $_SESSION['matric_no'];

// Query to retrieve transcript requests made by the user
$sql = "SELECT prev_institution_email, current_institution_email, request_date, status FROM transcript_requests WHERE matric_number = '$matric_no'";
$result = $conn->query($sql);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Request Records</title>

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
            placeholder="Request Records" aria-label="Search" readonly>
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
                            <a class="nav-link" href="./change_password.php">
                                <span data-feather="key"></span>
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./records.php">
                                <span data-feather="file-text"></span> <!-- Updated icon -->
                                Request Records
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <br><h2>Transcript Request Records</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Previous Institution Email</th>
                            <th>Current Institution Email</th>
                            <th>Request Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Check if any transcript requests are found
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row["prev_institution_email"]."</td>";
                                    echo "<td>".$row["current_institution_email"]."</td>";
                                    echo "<td>".$row["request_date"]."</td>";
                                    echo "<td>".$row["status"]."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No transcript requests found</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
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
            document.getElementById("new-password-error").innerHTML =
                "New password must contain at least one number, one special character, and be at least 8 characters long";
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