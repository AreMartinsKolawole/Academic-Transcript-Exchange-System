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

// Retrieve matric_number from session
$matric_number = $_SESSION['matric_no'];

// Fetch user's information from the database
$sql = "SELECT name FROM users WHERE matric_no = '$matric_number'";
$result = $conn->query($sql);

// Check if the user's information exists
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $full_name = $row['name'];
} else {
    // If user data is not found, redirect or display an error
    // For simplicity, let's redirect to a generic error page
    header("Location: error.php");
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
    <title>Request Transcript</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/Logo.png" type="image/x-icon" />

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
        <input style="background-color: #407bff;" class="form-control form-control-dark w-100" type="text" placeholder="Request Transcript" aria-label="Search" readonly>
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
                            <a class="nav-link active" href="./request_transcript.php">
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

            <div class="container-fluid">
                <h2 class="mt-4">Additional Information</h2>
                <div class="additional-info-form">
                    <form action="additional_information_process.php" method="post">
                        <div class="mb-3">
                            <h5>Personal Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="matric_number" class="form-label">Matric Number:</label>
                                    <input type="text" class="form-control" id="matric_number" name="matric_number"
                                        value="<?php echo $matric_number; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="<?php echo $full_name; ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">Date of Birth:</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="personal_residential_address" class="form-label">Personal Residential
                                    Address:</label>
                                <textarea class="form-control" id="personal_residential_address"
                                    name="personal_residential_address" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Telephone:</label>
                                    <input type="tel" class="form-control" id="telephone" name="telephone" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="state_of_origin" class="form-label">State of Origin:</label>
                                    <select class="form-select" id="state_of_origin" name="state_of_origin" required>
                                        <option value="Abia">Abia</option>
                                        <option value="Adamawa">Adamawa</option>
                                        <option value="Akwa Ibom">Akwa Ibom</option>
                                        <option value="Anambra">Anambra</option>
                                        <option value="Bauchi">Bauchi</option>
                                        <option value="Bayelsa">Bayelsa</option>
                                        <option value="Benue">Benue</option>
                                        <option value="Borno">Borno</option>
                                        <option value="Cross River">Cross River</option>
                                        <option value="Delta">Delta</option>
                                        <option value="Ebonyi">Ebonyi</option>
                                        <option value="Edo">Edo</option>
                                        <option value="Ekiti">Ekiti</option>
                                        <option value="Enugu">Enugu</option>
                                        <option value="FCT - Abuja">FCT - Abuja</option>
                                        <option value="Gombe">Gombe</option>
                                        <option value="Imo">Imo</option>
                                        <option value="Jigawa">Jigawa</option>
                                        <option value="Kaduna">Kaduna</option>
                                        <option value="Kano">Kano</option>
                                        <option value="Katsina">Katsina</option>
                                        <option value="Kebbi">Kebbi</option>
                                        <option value="Kogi">Kogi</option>
                                        <option value="Kwara">Kwara</option>
                                        <option value="Lagos">Lagos</option>
                                        <option value="Nasarawa">Nasarawa</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Ogun">Ogun</option>
                                        <option value="Ondo">Ondo</option>
                                        <option value="Osun">Osun</option>
                                        <option value="Oyo">Oyo</option>
                                        <option value="Plateau">Plateau</option>
                                        <option value="Rivers">Rivers</option>
                                        <option value="Sokoto">Sokoto</option>
                                        <option value="Taraba">Taraba</option>
                                        <option value="Yobe">Yobe</option>
                                        <option value="Zamfara">Zamfara</option>
                                    </select><br>
                                </div>
                                    <div class="mb-3">
                                        <h5 class="mt-4">Education Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="entry_mode" class="form-label">Entry Mode:</label>
                                                <select class="form-select" id="entry_mode" name="entry_mode" required>
                                                    <option value="UTME">UTME</option>
                                                    <option value="direct_entry">Direct Entry</option>
                                                    <option value="transfer">Transfer</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="program_duration" class="form-label">Program
                                                    Duration:</label>
                                                <select class="form-select" id="program_duration"
                                                    name="program_duration" required>
                                                    <option value="4 years">4 years</option>
                                                    <option value="5 years">5 years</option>
                                                    <option value="6 years">6 years</option>
                                                    <option value="7 years">7 years</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="course" class="form-label">Course:</label>
                                                <input type="text" class="form-control" id="course" name="course"
                                                    required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="programme_mode" class="form-label">Programme Mode:</label>
                                                <select class="form-select" id="programme_mode" name="programme_mode"
                                                    required>
                                                    <option value="Full Time">Full Time</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="session_admitted" class="form-label">Session
                                                    Admitted:</label>
                                                <select class="form-select" id="session_admitted"
                                                    name="session_admitted" required>
                                                    <?php
                                                    // Generate options for session admitted
                                                    for ($year = 1982; $year <= date("Y"); $year++) {
                                                        $nextYear = $year + 1;
                                                        echo "<option value='$year/$nextYear'>$year/$nextYear</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="session_graduated" class="form-label">Session Expected to
                                                    Graduate:</label>
                                                <select class="form-select" id="session_graduated"
                                                    name="session_graduated" required>
                                                    <?php
                                                    // Generate options for session graduated
                                                    for ($year = 1982; $year <= date("Y"); $year++) {
                                                        $nextYear = $year + 1;
                                                        echo "<option value='$year/$nextYear'>$year/$nextYear</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="mt-4">Previous Institution Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="p-ins-name" class="form-label">Institution Name:</label>
                                                <input type="text" class="form-control" id="p-ins-name"
                                                    name="p-ins-name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="p-ins-email" class="form-label">Institution Email:</label>
                                                <input type="email" class="form-control" id="p-ins-email"
                                                    name="p-ins-email" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="p-vc" class="form-label">Vice-chancellor email:</label>
                                                <input type="email" class="form-control" id="p-vc" name="p-vc" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="p-r-vc" class="form-label">Registrar email:</label>
                                                <input type="email" class="form-control" id="p-r-vc" name="p-r-vc"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Current Institution Information -->
                                    <div class="mb-3">
                                        <h5 class="mt-4">Current Institution Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="c-ins-name" class="form-label">Institution Name:</label>
                                                <input type="text" class="form-control" id="c-ins-name"
                                                    name="c-ins-name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="c-ins-email" class="form-label">Institution Email:</label>
                                                <input type="email" class="form-control" id="c-ins-email"
                                                    name="c-ins-email" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="c-vc" class="form-label">Vice-chancellor email:</label>
                                                <input type="email" class="form-control" id="c-vc" name="c-vc" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="c-r-vc" class="form-label">Registrar email:</label>
                                                <input type="email" class="form-control" id="c-r-vc" name="c-r-vc"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button style="background-color: #407bff;" type="submit" class="btn btn-primary">Request Transcript</button>
                                    </div>
                    </form>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>
</body>

</html>