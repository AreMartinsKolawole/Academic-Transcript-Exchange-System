<?php

define('LOG_FILE_PATH', '../logs/system_logs.log');

require_once '../log_activity.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require_once '../db_connection.php';

// Function to generate a unique token
function generateToken() {
    return bin2hex(random_bytes(16));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $matric_number = $_POST['matric_number'];
    $full_name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $entry_mode = $_POST['entry_mode'];
    $program_duration = $_POST['program_duration'];
    $course = $_POST['course'];
    $programme_mode = $_POST['programme_mode'];
    $session_admitted = $_POST['session_admitted'];
    $session_graduated = $_POST['session_graduated'];
    $personal_residential_address = $_POST['personal_residential_address'];
    $telephone = $_POST['telephone'];
    $state_of_origin = $_POST['state_of_origin'];
    $prev_institution_name = $_POST['p-ins-name'];
    $prev_institution_email = $_POST['p-ins-email'];
    $prev_vc_email = $_POST['p-vc'];
    $prev_register_email = $_POST['p-r-vc'];
    $current_institution_name = $_POST['c-ins-name'];
    $current_institution_email = $_POST['c-ins-email'];
    $current_vc_email = $_POST['c-vc'];
    $current_register_email = $_POST['c-r-vc'];

    // Generate a unique token
    $verification_token = generateToken();

    // Send email to previous institution
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'transcriptexchangesystem@gmail.com';
        $mail->Password = 'qcbxwbswxcjcurci';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Sender information
        $mail->setFrom('transcriptexchangesystem@gmail.com');

        // Add recipient
        $mail->addAddress($prev_institution_email);

        $mail->isHTML(true);
        $mail->Subject = "Transcript Request Initialization";
        $mail->Body .= "
            <html>
            <head>
                <style>
                    /* Add your CSS styles here */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f2f2f2;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 5px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #007bff;
                    }
                    ul {
                        list-style-type: none;
                        padding: 0;
                    }
                    li {
                        margin-bottom: 10px;
                    }
                    a {
                        color: #007bff;
                        text-decoration: none;
                    }
                    a:hover {
                        text-decoration: underline;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Transcript Request Initialization</h2>
                    <p>Dear $prev_institution_name,</p>
                    <p>$full_name has initiated a transcript request to be sent to $current_institution_name. Please take action by verifying or rejecting the request.</p>
                    <p><strong>Student Information:</strong></p>
                    <ul>
                        <li><strong>Matric Number:</strong> $matric_number</li>
                        <li><strong>Full Name:</strong> $full_name</li>
                        <li><strong>Date of Birth:</strong> $date_of_birth</li>
                        <li><strong>Gender:</strong> $gender</li>
                        <li><strong>Entry Mode:</strong> $entry_mode</li>
                        <li><strong>Program Duration:</strong> $program_duration</li>
                        <li><strong>Course:</strong> $course</li>
                        <li><strong>Programme Mode:</strong> $programme_mode</li>
                        <li><strong>Session Admitted:</strong> $session_admitted</li>
                        <li><strong>Session Expected to Graduate:</strong> $session_graduated</li>
                        <li><strong>Personal Residential Address:</strong> $personal_residential_address</li>
                        <li><strong>Telephone:</strong> $telephone</li>
                        <li><strong>State of Origin:</strong> $state_of_origin</li>
                        <li><strong>Current Institution Name:</strong> $current_institution_name</li>
                        <li><strong>Current Institution Email:</strong> $current_institution_email</li>
                    </ul>
                    <p>Click <a href='http://localhost/tes/institutions/institution_login.php?token=$verification_token'>here</a> to verify or reject the request.</p>
                </div>
            </body>
            </html>
        ";

        // Send email
        $mail->send();

        // Update the user's record with additional information
        $sql = "UPDATE users SET 
            date_of_birth = '$date_of_birth',
            gender = '$gender',
            entry_mode = '$entry_mode',
            program_duration = '$program_duration',
            course = '$course',
            programme_mode = '$programme_mode',
            session_admitted = '$session_admitted',
            session_graduated = '$session_graduated',
            personal_residential_address = '$personal_residential_address',
            telephone = '$telephone',
            state_of_origin = '$state_of_origin',
            prev_institution_name = '$prev_institution_name',
            prev_institution_email = '$prev_institution_email',
            prev_vc_email = '$prev_vc_email',
            prev_register_email = '$prev_register_email',
            current_institution_name = '$current_institution_name',
            current_institution_email = '$current_institution_email',
            current_vc_email = '$current_vc_email',
            current_register_email = '$current_register_email',
            verification_token = '$verification_token'
            WHERE matric_no = '$matric_number'";

        if ($conn->query($sql) === TRUE) {
            // Insert data into transcript_requests table
            $insertSql = "INSERT INTO transcript_requests (matric_number, full_name, prev_institution_email, current_institution_email, verification_token)
            VALUES ('$matric_number', '$full_name', '$prev_institution_email', '$current_institution_email', '$verification_token')";

            if ($conn->query($insertSql) === TRUE) {
                logActivity('User ' . $matric_number . ' requested transcript successfully');
                echo "<script>alert('Transcript Successfully requested'); window.location.href='student_dashboard.php';</script>";
            } else {
                echo "<script>alert('Error inserting data into transcript_requests table: ');</script>" . $conn->error;
            }
        } else {
            echo "<script>alert('Error updating additional information: ');</script>" . $conn->error;
        }
    } catch (Exception $e) {
        echo "<script>alert('No good internet connection'); window.location.href='request_transcript.php';</script>";
    }
} else {
    // If the form is not submitted, redirect back to the form page
    header("Location: request_transcript.php");
    exit();
}
?>