<?php
session_start();

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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $matric_no = $_SESSION['matric_no'];

    // Update user profile in the database
    $sql = "UPDATE users SET name='$name', email='$email' WHERE matric_no='$matric_no'";
    if ($conn->query($sql) === TRUE) {
        // Log successful sign-in
        logActivity('User ' . $matric_no . ' updated profile successfully');
        echo "<script>alert('Profile Update Successfully'); window.location.href='student_dashboard.php';</script>";
    } else {
        echo "<script>alert('ERROR Updating Profile'); window.location.href='student_dashboard.php';</script>" . $conn->error;
    }
}

// Retrieve user information based on matriculation number
$matric_no = $_SESSION['matric_no'];
$sql = "SELECT * FROM users WHERE matric_no = '$matric_no'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
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
    <title>Update Profile</title>
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

    <header class="navbar navbar-dark sticky-top custom-bg-color flex-md-nowrap p-0 shadow"
        style="background-color: #407bff;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Transcript Exchange System</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input style="background-color: #407bff;" class="form-control form-control-dark w-100" type="text"
            placeholder="Update Profile" aria-label="Search" readonly>
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
                            <a class="nav-link active" href="./update_profile.php">
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
                <h2><br>Update Profile</h2>
                <form id="up" action="" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo $name; ?>"
                            required>
                        <div id="name-error" class="text-danger"></div> <!-- Error message for name -->
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="<?php echo $email; ?>" required>
                        <div id="email-error" class="text-danger"></div> <!-- Error message for email -->
                    </div>
                    <button style="background-color: #407bff;" type="submit"
                        class="btn btn-primary btn-update">Update</button>
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
    // Function to validate name and email
    function validateForm() {
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var nameRegex = /^[a-zA-Z\s]+$/; // Regex for alphabets and spaces only
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email regex

        // Validate name
        if (!nameRegex.test(name)) {
            document.getElementById("name-error").innerHTML = "Name must contain only alphabets and spaces";
            return false;
        } else {
            // Check if the name contains at least two words
            var nameWords = name.split(" ");
            if (nameWords.length < 2) {
                document.getElementById("name-error").innerHTML = "Name must contain at least two words";
                return false;
            } else {
                document.getElementById("name-error").innerHTML = "";
            }
        }

        // Validate email
        if (!emailRegex.test(email)) {
            document.getElementById("email-error").innerHTML = "Enter a valid email address";
            return false;
        } else {
            document.getElementById("email-error").innerHTML = "";
        }

        return true; // Form submission allowed if validation passes
    }
    </script>
</body>

</html>