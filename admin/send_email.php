<?php
// Include the database connection file
require_once '../db_connection.php';

// Check if user is logged in as admin, if not redirect to login page
// Add your authentication logic here


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback</title>
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
            placeholder="Feedbacks" aria-label="Search" readonly>
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
                            <a class="nav-link" aria-current="page" href="./admin_dashboard.php">
                                <span data-feather="home"></span>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./manage_users.php">
                                <span data-feather="file"></span>
                                Manage Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./view_logs.php">
                                <span data-feather="user"></span>
                                System logs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./view_feedback.php">
                                <span data-feather="user"></span>
                                Feedbacks
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    if (isset($_GET['email'])) {
        $recipient_email = $_GET['email'];
        // Form to compose and send email reply
        echo "<div class='mt-4'>";
        echo "<h2>Compose Reply</h2>";
        echo "<form action='send_reply.php' method='post'>";
        echo "<input type='hidden' name='recipient_email' value='" . $recipient_email . "'>";
        echo "<div class='mb-3'>";
        echo "<label for='subject' class='form-label'>Subject:</label>";
        echo "<input type='text' name='subject' class='form-control' id='subject'>";
        echo "</div>";
        echo "<div class='mb-3'>";
        echo "<label for='message' class='form-label'>Message:</label>";
        echo "<textarea name='message' class='form-control' id='message' rows='4' cols='50'></textarea>";
        echo "</div>";
        echo "<button type='submit' class='btn btn-primary'>Send</button>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger mt-4' role='alert'>Invalid recipient email.</div>";
    }
    ?>
    <a href="./view_feedback.php" class="btn btn-secondary mt-3">Back</a>
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
