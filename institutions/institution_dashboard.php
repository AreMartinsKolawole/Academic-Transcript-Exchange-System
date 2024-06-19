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

// Include the PHPMailer library
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Retrieve transcript requests for the institution along with user details
$stmt = $conn->prepare("SELECT tr.*, u.name, u.email, u.matric_no, u.date_of_birth, u.gender, 
                                u.entry_mode, u.program_duration, u.course AS program, 
                                u.programme_mode, u.session_admitted, u.session_graduated, 
                                u.personal_residential_address AS address, u.telephone, 
                                u.state_of_origin, u.prev_institution_name, 
                                u.current_institution_name
                        FROM transcript_requests tr
                        INNER JOIN users u ON tr.matric_number = u.matric_no
                        WHERE tr.prev_institution_email = ?");
$stmt->bind_param("s", $_SESSION["institution_email"]);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Transcript Requests</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* Adjusted margin for centering */
            padding: 20px;
            border: 1px solid #888;
            width: 90%; /* Adjusted width for almost full screen */
            max-width: 800px; /* Added maximum width */
            height: 90%; /* Adjusted height for almost full screen */
            max-height: 90%; /* Added maximum height */
            overflow-y: auto; /* Added vertical scrollbar if content exceeds the height */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* User details styles */
        #userDetails p {
            margin-bottom: 10px;
        }

        #userDetails p strong {
            margin-right: 10px;
        }
    </style>

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
    <link rel="icon" href="../img/Logo.png" type="image/x-icon" />
</head>

<body>

<header class="navbar navbar-dark sticky-top custom-bg-color flex-md-nowrap p-0 shadow" style="background-color: #407bff;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Transcript Exchange System</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input style="background-color: #407bff;" class="form-control form-control-dark w-100" type="text" placeholder="Transcript Requests" aria-label="Search" readonly>
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
                            <a class="nav-link active" aria-current="page" href="./institution_dashboard.php">
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
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Transcript Requests</h2>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Matric Number</th>
                <th>Student Name</th>
                <th>Program</th>
                <th>Former University</th>
                <th>Status</th>
                <th>Action</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['matric_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['program']); ?></td>
                    <td><?php echo htmlspecialchars($row['prev_institution_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form action="process_request.php" method="post">
                                <input type="hidden" name="token"
                                       value="<?php echo htmlspecialchars($row['verification_token']); ?>">
                                <input type="hidden" name="action" value="accept">
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                            <form action="process_request.php" method="post">
                                <input type="hidden" name="token"
                                       value="<?php echo htmlspecialchars($row['verification_token']); ?>">
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        <?php } ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary"
                                onclick="openModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">View
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>User Details</h3>
        <div id="userDetails"></div>
    </div>
</div>
</main>
</div>
</div>
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
        // Function to open modal and display user details
        function openModal(user) {
            var modal = document.getElementById('myModal');
            var userDetails = document.getElementById('userDetails');
            userDetails.innerHTML = '<p><strong>Matric Number:</strong> ' + user.matric_number + '</p>' +
                '<p><strong>Student Name:</strong> ' + user.name + '</p>' +
                '<p><strong>Email:</strong> ' + user.email + '</p>' +
                '<p><strong>Date of Birth:</strong> ' + user.date_of_birth + '</p>' +
                '<p><strong>Gender:</strong> ' + user.gender + '</p>' +
                '<p><strong>Entry Mode:</strong> ' + user.entry_mode + '</p>' +
                '<p><strong>Program Duration:</strong> ' + user.program_duration + '</p>' +
                '<p><strong>Program:</strong> ' + user.program + '</p>' +
                '<p><strong>Programme Mode:</strong> ' + user.programme_mode + '</p>' +
                '<p><strong>Session Admitted:</strong> ' + user.session_admitted + '</p>' +
                '<p><strong>Session Graduated:</strong> ' + user.session_graduated + '</p>' +
                '<p><strong>Address:</strong> ' + user.address + '</p>' +
                '<p><strong>Telephone:</strong> ' + user.telephone + '</p>' +
                '<p><strong>State of Origin:</strong> ' + user.state_of_origin + '</p>' +
                '<p><strong>Previous Institution:</strong> ' + user.prev_institution_name + '</p>' +
                '<p><strong>Current Institution:</strong> ' + user.current_institution_name + '</p>' +
                '<p><strong>Status:</strong> ' + user.status + '</p>';
            modal.style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }
    </script>
</body>

</html>
