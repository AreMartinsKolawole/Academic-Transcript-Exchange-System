<?php
// Start the session
session_start();

if (!isset($_SESSION["institution_email"])) {
    header("Location: institution_login.php");
    exit();
}

// Include database connection
require_once '../db_connection.php';



// Get user's name from session
$institution_name = $_SESSION["institution_name"];
$sql = "SELECT * FROM institutions WHERE name = '$institution_name'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
} else {
    // If user data is not found, log out and redirect to login page
    session_unset();
    session_destroy();
    header("Location: institution_login.php");
    exit();
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
    <title>Home</title>

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
            placeholder="Institution Dashboard" aria-label="Search" readonly>
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
                            <a class="nav-link active" aria-current="page" href="./home.php">
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
                            <a class="nav-link" href="./change_password.php">
                                <span data-feather="key"></span>
                                Change Password
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>


        </div>
    </div>
    <main style="margin: 10px" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h2><br>Welcome, <?php echo $name; ?></h2>
        <p>Transcript Exchange System provides institutions with a secure platform for managing and sharing academic
            transcripts. To ensure the integrity and security of transcript data, institutions are required to adhere to
            the following rules and regulations:</p>
        <h5><br>Rules & Regulations:</h5>
        <ol>
            <li><b>Provide Accurate Institutional Information:</b> Institutions must ensure that all information
                provided during registration is accurate and up-to-date. Misrepresentation of institutional details may
                result in account suspension or termination.</li>
            <li><b>Designate Authorized Personnel:</b> Designate authorized personnel responsible for managing
                transcript requests and approvals. Access to sensitive data should be limited to authorized individuals
                only.</li>
            <li><b>Protect Institutional Data:</b> Safeguard institutional data, including student transcripts and
                academic records, by implementing appropriate security measures. This includes encryption, access
                controls, and regular data backups.</li>
            <li><b>Comply with Privacy Regulations:</b> Institutions must comply with relevant privacy regulations and
                data protection laws when handling student data. Ensure that student privacy rights are respected at all
                times.</li>
            <li><b>Verify Transcript Requests:</b> Verify the authenticity of transcript requests before processing
                them. Ensure that requests are made by authorized individuals and meet the institution's verification
                criteria.</li>
            <li><b>Monitor System Activity:</b> Regularly monitor system activity for any suspicious behavior or
                security breaches. Report any anomalies or unauthorized access to system administrators immediately.
            </li>
            <li><b>Train Staff on Security Protocols:</b> Provide training to staff members responsible for managing
                transcript data on security best practices and protocols. This includes password management, phishing
                awareness, and data handling procedures.</li>
            <li><b>Implement Secure Authentication:</b> Implement secure authentication mechanisms, such as multi-factor
                authentication, to prevent unauthorized access to institutional accounts.</li>
            <li><b>Report Security Incidents:</b> Promptly report any security incidents or data breaches to the
                appropriate authorities and affected individuals as required by law.</li>
            <li><b>Stay Informed:</b> Stay informed about updates to system security measures, policies, and regulations
                related to data privacy and academic records. Regularly review communications from system administrators
                for important announcements and updates.</li>
        </ol>

    </main>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="../js/dashboard.js"></script>
</body>

</html>