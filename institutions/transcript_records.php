<?php
session_start();

// Check if institution is logged in
if (!isset($_SESSION["institution_email"])) {
    header("Location: institution_login.php");
    exit();
}

// Include database connection
require_once '../db_connection.php';

// Retrieve transcript records for the current institution (both sent and received)
$institution_email = $_SESSION["institution_email"];
$stmt = $conn->prepare("SELECT * FROM transcript_records WHERE sender_email = ? OR receiver_email = ?");
$stmt->bind_param("ss", $institution_email, $institution_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transcript Records</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom styles -->
    <style>
        /* Add your custom styles here */
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>Transcript Records</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Sender Email</th>
                        <th>Receiver Email</th>
                        <th>Date Sent</th>
                        <th>Date Received</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display transcript records
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['record_id'] . "</td>";
                        echo "<td>" . $row['sender_email'] . "</td>";
                        echo "<td>" . $row['receiver_email'] . "</td>";
                        echo "<td>" . $row['date_sent'] . "</td>";
                        echo "<td>" . $row['date_received'] . "</td>";
                        // Add more columns as needed
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
