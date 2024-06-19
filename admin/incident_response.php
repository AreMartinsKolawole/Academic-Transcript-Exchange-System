<?php
// Notify stakeholders of security incident
$incidentMessage = 'Security incident detected. Take immediate action!';
$adminEmail = 'transcriptexchangesystem@gmail.com';

// Send email notification
if (mail($adminEmail, 'Security Incident Alert', $incidentMessage)) {
    echo "Email notification sent successfully.";
} else {
    echo "Failed to send email notification.";
}
?>
