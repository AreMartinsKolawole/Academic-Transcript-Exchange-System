<?php
session_start();

if (!isset($_SESSION["institution_email"])) {
    header("Location: institution_login.php");
    exit();
}

// Include the PHPMailer library
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Database connection parameters
require_once '../db_connection.php';

// Retrieve transcript requests for the institution along with user details
$stmt = $conn->prepare("SELECT tr.*, u.name, u.course AS program, u.prev_institution_name AS former_university
                        FROM transcript_requests tr
                        INNER JOIN users u ON tr.matric_number = u.matric_no
                        WHERE tr.prev_institution_email = ?");
$stmt->bind_param("s", $_SESSION["institution_email"]);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institution Dashboard</title>
</head>

<body>
    <h2>Transcript Requests</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Matric Number</th>
                <th>Student Name</th>
                <th>Program</th>
                <th>Former University</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['matric_number']); ?></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['program']); ?></td>
                <td><?php echo htmlspecialchars($row['former_university']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending') { ?>
                    <form action="process_request.php" method="post">
                        <input type="hidden" name="token"
                            value="<?php echo htmlspecialchars($row['verification_token']); ?>">
                        <input type="hidden" name="action" value="accept">
                        <button type="submit">Accept</button>
                    </form>
                    <form action="process_request.php" method="post">
                        <input type="hidden" name="token"
                            value="<?php echo htmlspecialchars($row['verification_token']); ?>">
                        <input type="hidden" name="action" value="reject">
                        <button type="submit">Reject</button>
                    </form>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="./institution_dashboard.php">Back to Dashboard</a>
</body>

</html>