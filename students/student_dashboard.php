<?php
// Start the session
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["matric_no"])) {
  header("Location: ../login.php");
  exit();
}

// Include database connection
require_once '../db_connection.php';

// Retrieve user information based on matriculation number
$matric_no = $_SESSION['matric_no'];
$sql = "SELECT * FROM users WHERE matric_no = '$matric_no'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
} else {
    // If user data is not found, log out and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
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
        <input style="background-color: #407bff;" class="form-control form-control-dark w-100" type="text" placeholder="Student Dashboard" aria-label="Search" readonly>
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
                            <a class="nav-link active" aria-current="page" href="./student_dashboard.php">
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
                            <a class="nav-link" href="./records.php">
                                <span data-feather="file-text"></span> <!-- Updated icon -->
                                Request Records
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2><br>Welcome, <?php echo $name; ?></h2>
                <p>Transcript Exchange System provides you ease and secure means of requesting and sharing transcript.
                    Follow
                    the rules and regulations belows to help us secure your transcript</p>
                <h5><br>Rules & Regulations:</h5>
                <ol>
                    <li><b>Provide Accurate Information:</b> Ensure all information provided during registration is
                        accurate and
                        up-to-date. Misrepresentation of personal or institutional details may lead to account
                        suspension or
                        termination.</li>
                    <li><b>Keep Login Credentials Confidential:</b> Safeguard your account by keeping login credentials,
                        including passwords and institution email addresses, confidential. Sharing account details with
                        others
                        compromises security and may result in unauthorized access to sensitive information.</li>
                    <li><b>Follow Password Policy:</b> Choose strong passwords that meet the system's password policy
                        requirements. Passwords should be at least eight characters long and include a combination of
                        uppercase
                        and lowercase letters, numbers, and special characters.</li>
                    <li><b>Respect Data Privacy:</b> Understand and respect the privacy of personal and academic data
                        shared
                        within the system. Avoid sharing sensitive information with unauthorized individuals or
                        entities.</li>
                    <li><b>Adhere to Terms of Service:</b> Agree to the system's terms of service or user agreement,
                        which
                        outline the rules and guidelines for usage. Violation of these terms may lead to account
                        suspension or
                        legal consequences.</li>
                    <li><b>Avoid Spamming and Abuse:</b> Refrain from engaging in spamming activities or abusive
                        behavior within
                        the system, including sending unsolicited messages or uploading inappropriate content. Such
                        actions may
                        result in account suspension or banning.</li>
                    <li><b>Report Suspicious Activity:</b> Report any suspicious activity, security breaches, or
                        unauthorized
                        access to system administrators immediately. Prompt reporting helps maintain the integrity and
                        security
                        of the system.</li>
                    <li><b>Comply with Regulations:</b> Adhere to relevant laws, regulations, and policies governing
                        data
                        protection, academic integrity, and online conduct. Non-compliance may result in legal
                        consequences or
                        disciplinary actions.</li>
                    <li><b>Use System Responsibly:</b> Use the system responsibly and for its intended purpose, which
                        includes
                        academic transcript exchange and verification. Any misuse or unauthorized use of the system may
                        lead to
                        account suspension or termination.</li>
                    <li><b>Stay Informed:</b> Stay informed about system updates, security measures, and changes in
                        policies or
                        regulations related to data privacy and academic records. Regularly check for announcements and
                        updates
                        from system administrators.</li>
                </ol>
            </main>
            <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
                integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
                crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
                integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
                crossorigin="anonymous">
            </script>
            <script src="../js/dashboard.js"></script>
</body>

</html>