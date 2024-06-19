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

// Handle form submission to upload transcripts
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload"])) {
    // Check if the uploaded file is a PDF
    $file_name = $_FILES['transcript']['name'];
    $file_temp = $_FILES['transcript']['tmp_name'];
    $file_type = $_FILES['transcript']['type'];
    $file_size = $_FILES['transcript']['size'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = array("pdf");

    if (in_array($file_ext, $allowed_ext)) {
        // Get form data
        $matric_number = $_POST['matric_number'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $current_institution_name = $_POST['current_institution_name'];

        // Rename uploaded file to student's matric number
        $upload_dir = "../uploads/";
        $new_file_name = $matric_number . "." . $file_ext;
        $upload_file = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_temp, $upload_file)) {
            // Insert uploaded file details into database
            $stmt = $conn->prepare("INSERT INTO transcripts (matric_number, file_name) VALUES (?, ?)");
            $stmt->bind_param("ss", $matric_number, $new_file_name);
            if ($stmt->execute()) {
                logActivity('Uploaded ' . $matric_number . ' transcript successfully');
                echo "<script>alert('Transcript uploaded successfully!');</script>";
            } else {
                echo "<script>alert('Failed to upload transcript to database. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Failed to upload transcript. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Only PDF files are allowed.');</script>";
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
    <title>Upload Transcript</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



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
        <input style="background-color: #407bff;" class="form-control form-control-dark w-100" type="text" placeholder="Upload Transcripts" aria-label="Search" readonly>
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
                            <a class="nav-link active" href="./upload_transcripts.php">
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
    <h2>Upload Transcripts</h2>
    <div class="table-responsive">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
            enctype="multipart/form-data">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Matric Number</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve transcript requests with status 'Accepted' and where previous institution email matches current institution email
                    $current_institution_email = $_SESSION["institution_email"];
                    $stmt = $conn->prepare("SELECT u.name, u.matric_no, u.email, u.prev_institution_name, u.current_institution_name, tr.current_institution_email FROM transcript_requests tr JOIN users u ON tr.matric_number = u.matric_no WHERE tr.status = 'Accepted' AND tr.prev_institution_email = ?");
                    $stmt->bind_param("s", $current_institution_email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['matric_no'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        if (file_exists("../uploads/" . $row['matric_no'] . ".pdf")) {
                            echo "<td>Transcript Already Sent</td>";
                            echo "<td>&nbsp;</td>";
                        } else {
                            echo "<td><input type='file' class='form-control' name='transcript' accept='application/pdf' required></td>";
                            echo "<td>";
                            echo "<input type='hidden' name='user_name' value='" . $row['name'] . "'>";
                            echo "<input type='hidden' name='matric_number' value='" . $row['matric_no'] . "'>";
                            echo "<input type='hidden' name='user_email' value='" . $row['email'] . "'>";
                            echo "<input type='hidden' name='current_institution_name' value='" . $row['current_institution_name'] . "'>";
                            echo "<input type='hidden' name='current_institution_email' value='" . $row['current_institution_email'] . "'>";
                            echo "<input type='hidden' name='prev_institution_name' value='" . $row['prev_institution_name'] . "'>";
                            echo "<input type='submit' class='btn btn-primary' name='upload' value='Upload'>";
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
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
</body>

</html>