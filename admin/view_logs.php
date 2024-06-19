<?php 
    require_once '../log_activity.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activity Logs</title>
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
            placeholder="Activity Logs" aria-label="Search" readonly>
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
                            <a class="nav-link active" href="./view_logs.php">
                                <span data-feather="user"></span>
                                System logs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./view_feedback.php">
                                <span data-feather="user"></span>
                                Feedbacks
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1 class="mt-4">Activity Logs</h1>

                <div class="row">
                    <div class="col-md-6">
                        <h2>Student Activities</h2>
                        <div class="log-content">
                            <?php
                                $logFilePath = '../system_logs.log';
                                $logFilePath2 = '../students/system_logs.log';
                                if (file_exists($logFilePath)) {
                                    $logContents = file_get_contents($logFilePath);
                                    echo "<pre class='pre-scrollable'>" . htmlspecialchars($logContents) . "</pre>";
                                }if (file_exists($logFilePath2)) {
                                    $logContents = file_get_contents($logFilePath2);
                                    echo "<pre class='pre-scrollable'>" . htmlspecialchars($logContents) . "</pre>";
                                } else {
                                    echo "<p>Log file not found.</p>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2>Institution Activities</h2>
                        <div class="log-content">
                            <?php
                $logFilePath = '../institutions/system_logs.log';
                if (file_exists($logFilePath)) {
                    $logContents = file_get_contents($logFilePath);
                    echo "<pre class='pre-scrollable'>" . htmlspecialchars($logContents) . "</pre>";
                } else {
                    echo "<p>Log file not found.</p>";
                }
                ?>
                        </div>
                    </div>
                </div>
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